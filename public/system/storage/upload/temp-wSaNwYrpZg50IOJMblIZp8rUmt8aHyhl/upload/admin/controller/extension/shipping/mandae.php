<?php
/**
 * Mandaê
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 */

/**
 * Mandaê Shipping Method
 *
 * @package    Mandaê
 * @author     Mandaê
 * @copyright  Copyright (c) 2018 BizCommerce
 *
 * @property ModelShippingMandae model_shipping_mandae
 * @property ModelCheckoutOrder model_checkout_order
 * @property Url url
 * @property Request request
 * @property Config config
 * @property DB db
 */
class ControllerExtensionShippingMandae extends Controller
{
    const CODE = 'mandae';

    protected $_mandae;

    private $error = array();

    protected $fields = array(
        'status' => 0,
        'token' => '',
        'method_title' => 'Mandaê',
        'deadline_text' => 'Prazo de Entrega: %d dias úteis',
        'sender_postcode' => '',
        'environment' => 'test',
        'declared_value' => '0',
        'handling_time' => '0',
        'handling_type' => 'none',
        'handling_fee' => '0',
        'geo_zone_id' => '',
        'tax_class_id' => '',
        'sort_order' => '1',
        //Metrics
        'use_default_dimensions' => '0',
        'default_width' => '11',
        'default_height' => '2',
        'default_length' => '16',
        //LOG
        'logging' => '0'
    );

    public function index()
    {
        $this->load->language('extension/shipping/mandae');

        $this->document->setTitle($this->language->get('heading_title'));

        /* Load Models */
        $this->load->model('localisation/order_status');
        $this->load->model('localisation/geo_zone');
        $this->load->model('localisation/tax_class');
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('mandae', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/shipping/mandae', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }

        $data = $this->breadcrumbs($data);
        $data = $this->errors($data);
        $data = $this->translate($data);

        $data['action'] = $this->url->link('extension/shipping/mandae', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

        //GENERAL FIELDS
        foreach ($this->fields as $field => $defaultValue) {
            if (isset($this->request->post[self::CODE . '_' . $field])) {
                $data[self::CODE . '_' . $field] = $this->request->post[self::CODE . '_' . $field];
            } else {
                $value = ($this->config->get(self::CODE . '_' . $field)) ? $this->config->get(self::CODE . '_' . $field) : $defaultValue;
                $data[self::CODE . '_' . $field] = $value;
            }
        }

        /* Custom Field */
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/mandae', $data));
    }

    /**
     * Validate Admin Data
     * @return bool
     */
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/shipping/mandae')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post[self::CODE . '_token']) {
            $this->error['token'] = $this->language->get('error_token');
        }

        return !$this->error;
    }

    /**
     * Errors
     * @param $data
     * @return mixed
     */
    protected function errors($data)
    {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        //Errors
        if (isset($this->error['token'])) {
            $data['error_token'] = $this->error['token'];
        } else {
            $data['error_token'] = '';
        }

        return $data;
    }

    /**
     * Breadcrumbs to admin page
     * @param $data
     * @return mixed
     */
    protected function breadcrumbs($data)
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/mandae', 'token=' . $this->session->data['token'], 'SSL')
        );


        return $data;
    }

    /**
     * Translate items
     * @param $data
     * @return array
     */
    protected function translate($data)
    {
        $textFields = array(
            'text_edit',
            'text_enabled',
            'text_disabled',
            'text_all_zones',
            'text_none',
            'text_yes',
            'text_no',
            'text_percent',
            'text_fixed',
            'text_select',
            'text_kilogram',
            'text_gram',
            'text_meter',
            'text_centimeter',

            'tab_general',
            'tab_units',

            //General
            'entry_token',
            'help_token',

            'entry_method_title',
            'help_method_title',

            'entry_deadline_text',
            'help_deadline_text',

            'entry_sender_postcode',
            'help_sender_postcode',

            'entry_declared_value',
            'help_declared_value',

            'entry_handling_time',
            'help_handling_time',

            'entry_handling_type',
            'help_handling_type',

            'entry_handling_fee',
            'help_handling_fee',

            'entry_logging',

            'entry_environment',
            'help_environment',

            'entry_test',
            'entry_production',

            'entry_geo_zone',
            'entry_tax_class',
            'entry_status',
            'entry_sort_order',

            //Units
            'entry_use_default_dimensions',
            'help_use_default_dimensions',

            'entry_default_width',
            'help_default_width',

            'entry_default_height',
            'help_default_height',

            'entry_default_length',
            'help_default_length',

            'button_save',
            'button_cancel',
        );

        foreach ($textFields as $field) {
            $data[$field] = $this->language->get($field);
        }

        return $data;
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

}
