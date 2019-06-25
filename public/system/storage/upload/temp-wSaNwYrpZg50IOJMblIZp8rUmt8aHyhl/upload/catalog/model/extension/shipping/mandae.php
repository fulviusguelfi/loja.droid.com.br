<?php

class ModelExtensionShippingMandae extends Model
{
    const CODE = 'mandae';
    const URL_API = 'https://api.mandae.com.br/v2/';
    const SANDBOX_URL_API = 'https://sandbox.api.mandae.com.br/v2/';
    const WEIGHT_TYPE = '1';
    const LENGTH_TYPE = '1';

    protected $quote_data = array();

    public function getQuote($address)
    {
        $method_data = array();
        $quote_data = array();
        $error = '';

        $this->load->language('extension/shipping/mandae');

        $query = $this->db->query(
            "SELECT * 
             FROM " . DB_PREFIX . "zone_to_geo_zone 
             WHERE geo_zone_id = '" . (int)$this->config->get('mandae_geo_zone_id') . "' 
             AND country_id = '" . (int)$address['country_id'] . "' 
             AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );

        if (!$this->config->get('mandae_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }


        if ($status) {

            $handling_type = $this->config->get('mandae_handling_type');
            $fee = (float) $this->config->get('mandae_handling_fee');
            $handlingTime = (int) $this->config->get('mandae_handling_time');
            $deadlineText = $this->config->get('mandae_deadline_text');
            $taxClassId = $this->config->get('mandae_tax_class_id');

            $data = array(
                'weight' => $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), self::WEIGHT_TYPE),
                'width' => $this->getDimension('width'),
                'height' => $this->getDimension('height'),
                'length' => $this->getDimension('length'),
                'postcode' => preg_replace("/[^0-9]/", '', $address['postcode'])
            );

            $shipping_rate = $this->getShippingRate($data);

            if (property_exists($shipping_rate, 'shippingServices')) {

                foreach ($shipping_rate->shippingServices as $shippingService) {

                    $code = $this->slugify($shippingService->name);

                    $label = $shippingService->name;
                    $cost = $shippingService->price;
                    $days = $shippingService->days;

                    if ($handling_type != 'none' && $fee) {
                        $feeAmount = ($handling_type == 'fixed') ? $fee : $cost * ($fee / 100);
                        $cost += $feeAmount;
                    }

                    if ($handlingTime) {
                        $days += $handlingTime;
                    }

                    $title = $shippingService->name;
                    if ($deadlineText) {
                        $title = $title . ' - ' . sprintf($deadlineText, $days);
                    }

                    if (version_compare(VERSION, '2.2') < 0) {
                        $text = $this->currency->format($this->tax->calculate($cost, $taxClassId, $this->config->get('config_tax')));
                    } else {
                        $text = $this->currency->format($this->tax->calculate($cost, $taxClassId, $this->config->get('config_tax')), $this->session->data['currency']);
                    }

                    $quote_data[$code] = array(
                        'code' => 'mandae.' . $code,
                        'title' => $title,
                        'cost' => $cost,
                        'tax_class_id' => $taxClassId,
                        'text' => $text
                    );

                }
            } else {
                $error = '';
                if (property_exists($shipping_rate, 'error')) {
                    if (property_exists($shipping_rate->error, 'message')) {
                        $error = $shipping_rate->error->message;
                    }
                }
            }
        }


        if ($quote_data || $error) {
            $title = $this->config->get('mandae_method_title');

            $method_data = array(
                'code'       => 'fedex',
                'title'      => $title,
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('mandae_sort_order'),
                'error'      => $error
            );

        }
        return $method_data;
    }

    /**
     * @param $data
     * @return string
     */
    public function getShippingRate($data)
    {
        $result = null;

        $postcode = $data['postcode'];
        $url = $this->_getUrl() . 'postalcodes/' . $postcode . '/rates';

        $declaredValue = $this->config->get('mandae_declared_value') ? $this->cart->getSubTotal() : '0.00';

        // e.g. { "declaredValue": 20.00, "weight" : 2, "height" : 100, "width" : 10,"length": 10 }
        $args = array(
            'declaredValue' => $declaredValue,
            'weight' => $data['weight'],
            'height' => $data['height'],
            'width' => $data['width'],
            'length' => $data['length'],
        );
        $data = json_encode($args);
        $result = json_decode($this->_request($url, 'POST', $data));

        $this->log('E: ' . $url . '. DATA:' . $data);
        $this->log('R:' . json_encode($result));

        return $result;
    }

    /**
     * @return string
     */
    public function tracking($trackingCode)
    {
        $result = null;

        $url = $this->_getUrl() . 'trackings/' . $trackingCode;
        $result = json_decode($this->_request($url));

        $this->log('TRACKING E: '. $url);
        $this->log('TRACKING R:' . json_encode($result));

        return $result;

    }

    /**
     * @param $url
     * @param string $method
     * @param string $data
     *
     * @return string
     */
    protected function _request($url, $method = 'GET', $data = '')
    {
        $headers = array(
            'Content-Type: application/json',
            'Authorization: '  . $this->config->get('mandae_token')
        );

        $curl = curl_init($url);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
        }

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

    protected function _getUrl()
    {
        return ($this->config->get('mandae_environment') == 'test') ? self::SANDBOX_URL_API : self::URL_API;
    }

    /**
     * Get lenght converted
     * @param string $type
     * @return int
     */
    protected function getDimension($type = 'width')
    {
        $dimension = 0;

        foreach ($this->cart->getProducts() as $product) {
            if ($product['shipping']) {
                $dimension += $this->length->convert($product[$type], $product['length_class_id'], self::LENGTH_TYPE);
            }
        }

        if ($this->config->get('mandae_use_default_dimensions') && $dimension == 0) {
            $dimension = $this->config->get('mandae_default_' . $type);
        }

        return $dimension;
    }

    /**
     * @param $data
     * @param int $step
     */
    public function log($data, $step = 6)
    {
        if ($this->config->get(self::CODE . '_logging')) {
            $backtrace = debug_backtrace();
            $log = new Log(self::CODE . '.log');
            $log->write('(' . $backtrace[$step]['class'] . '::' . $backtrace[$step]['function'] . ') - ' . $data);
        }
    }

    /**
     * Slugify string
     *
     * @param string $phrase
     * @return string
     */
    public function slugify($str)
    {
        // Clean Currency Symbol
        $str = $this->removeAccents($str);
        $str = preg_replace('#[^0-9a-z+]+#i', '-', $str);
        $str = strtolower($str);
        $str = trim($str, '-');
        return $str;
    }


    public function removeAccents($string, $german = false)
    {
        static $replacements;

        if (empty($replacements[$german])) {
            $subst = array(
                // single ISO-8859-1 letters
                192=>'A', 193=>'A', 194=>'A', 195=>'A', 196=>'A', 197=>'A', 199=>'C',
                208=>'D', 200=>'E', 201=>'E', 202=>'E', 203=>'E', 204=>'I', 205=>'I',
                206=>'I', 207=>'I', 209=>'N', 210=>'O', 211=>'O', 212=>'O', 213=>'O',
                214=>'O', 216=>'O', 138=>'S', 217=>'U', 218=>'U', 219=>'U', 220=>'U',
                221=>'Y', 142=>'Z', 224=>'a', 225=>'a', 226=>'a', 227=>'a', 228=>'a',
                229=>'a', 231=>'c', 232=>'e', 233=>'e', 234=>'e', 235=>'e', 236=>'i',
                237=>'i', 238=>'i', 239=>'i', 241=>'n', 240=>'o', 242=>'o', 243=>'o',
                244=>'o', 245=>'o', 246=>'o', 248=>'o', 154=>'s', 249=>'u', 250=>'u',
                251=>'u', 252=>'u', 253=>'y', 255=>'y', 158=>'z',
                // HTML entities
                258=>'A', 260=>'A', 262=>'C', 268=>'C', 270=>'D', 272=>'D', 280=>'E',
                282=>'E', 286=>'G', 304=>'I', 313=>'L', 317=>'L', 321=>'L', 323=>'N',
                327=>'N', 336=>'O', 340=>'R', 344=>'R', 346=>'S', 350=>'S', 354=>'T',
                356=>'T', 366=>'U', 368=>'U', 377=>'Z', 379=>'Z', 259=>'a', 261=>'a',
                263=>'c', 269=>'c', 271=>'d', 273=>'d', 281=>'e', 283=>'e', 287=>'g',
                305=>'i', 322=>'l', 314=>'l', 318=>'l', 324=>'n', 328=>'n', 337=>'o',
                341=>'r', 345=>'r', 347=>'s', 351=>'s', 357=>'t', 355=>'t', 367=>'u',
                369=>'u', 378=>'z', 380=>'z',
                // ligatures
                198=>'Ae', 230=>'ae', 140=>'Oe', 156=>'oe', 223=>'ss',
            );

            if ($german) {
                // umlauts
                $subst = array_merge($subst, array(
                    196=>'Ae', 228=>'ae', 214=>'Oe', 246=>'oe', 220=>'Ue', 252=>'ue'
                ));
            }

            $replacements[$german] = array();
            foreach ($subst as $k=>$v) {
                $replacements[$german][$k<256 ? chr($k) : '&#'.$k.';'] = $v;
            }
        }

        // convert string from default database format (UTF-8)
        // to encoding which replacement arrays made with (ISO-8859-1)
        if ($s = @iconv('UTF-8', 'ISO-8859-1', $string)) {
            $string = $s;
        }

        // Replace
        $string = strtr($string, $replacements[$german]);

        return $string;
    }
}
