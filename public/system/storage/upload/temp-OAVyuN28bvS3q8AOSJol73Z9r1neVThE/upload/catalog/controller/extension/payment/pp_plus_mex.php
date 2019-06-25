<?php
/*
Payment Method PayPalPlus México by Treebes
Author: Juan Lanzagorta FV
www.treebes.com
Ver 1.0 
15 November 2017

Code is distributed as is.
It is not permited to re-distribute this code.

Support only available for buyers in our database,
via email soporte@treebes.com and having available
support hours in the included support contract.

NOTES:
+ Only available for Mexican Pesos (MXN)
+ Only available for Mexican Credit Cards
+ Only one status of payment is managed (no cancelation, no refund, no resend, no re-authorise, etc.)

Treebes nor the Authors ARE NOT responsible for the use or consecuences of the use of this code.
*/
class ControllerExtensionPaymentPPPlusMex extends Controller {
	var $clientId='';
	var $secret='';
	var $access_token='';
	var $experience_profile_id;
	
	public function index() {
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/pp_plus_mex');
		$this->load->language('extension/payment/pp_plus_mex');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		if (!$this->customer->isLogged() || empty($order_info['shipping_iso_code_2'])){
			$verifica_campos='
			<div class="buttons hidden">
			  <div class="pull-right">
				<a href="'.$this->url->link('checkout/checkout', '', true).'" class="btn btn-primary" id="button-confirm" data-loading-text="Cargando">
				'.$this->language->get('btn_continue').'
				</a>
			  </div>
			</div>
			<script type="text/javascript"><!--
			$("#button-confirm").on("click", function() {
				$("#button-confirm").button("loading");
			});
			//--></script>
			<script>
			$( document ).ready(function() {
				$("#confirm_view").show();
			});
			</script>
			<p id="letrerostest">
			'.$this->language->get('note_to_continue').'
			</p>
			';
			
			$regresa='
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<span class="icon">
								<i class="fa fa-credit-card"></i>
							</span> 
							<span class="text">'.$this->language->get('text_title').'</span>
						</h4>
					</div>
					<div class="panel-body">
					'.$verifica_campos.'
					</div>
				</div>';
			return $regresa;
		}
	  
		$creacion_pago_ppplus_id = $this->constructPagoPPPlusMEX($order_info);
		if ($creacion_pago_ppplus_id) {
			$data['code'] = $creacion_pago_ppplus_id;
			$data['error_connection'] = '';
		} else {
			$data['error_connection'] = 'T0_'.$this->language->get('error_connection');
		}
		return $this->load->view('extension/payment/pp_plus_mex', $data);
	}
	
	public function create() {
		$this->load->language('extension/payment/pp_plus_mex');
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/pp_plus_mex');
		$data['text_secure_connection'] = $this->language->get('text_secure_connection');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$creacion_pago_ppplus_id = $this->constructPagoPPPlusMEX($order_info);
		if ($creacion_pago_ppplus_id) {
			$data['code'] = $creacion_pago_ppplus_id;
			if ($this->config->get('pp_plus_mex_test')) {
				$data['url'] = 'https://api.sandbox.paypal.com';
			} else {
				$data['url'] = 'https://api.paypal.com';
			}
			$data['error_connection'] = '';
		} else {
			$data['error_connection'] = 'T1_'.$this->language->get('error_connection');
		}
		if (file_exists(DIR_APPLICATION . 'view/theme/' . $this->config->get('config_template') . '/stylesheet/stylesheet.css')) {
			$data['stylesheet'] = '/catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/stylesheet.css';
		} else {
			$data['stylesheet'] = 'catalog/view/theme/default/stylesheet/stylesheet.css';
		}
		return $data;
	}
	
	public function guarda_pago(){
		$this->load->model('extension/payment/pp_plus_mex');
		$order_id = $this->session->data['order_id'];
		$response=$this->request->post['resultado'];

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$order_status_id = $this->config->get('pp_plus_mex_completed_status_id');
		
		if ($order_info) {
			$order_id=$order_info['order_id'];
			if ($this->config->get('pp_plus_mex_test')) {
				$capture_status = 'SANDBOX';
			} else {
				$capture_status = 'LIVE';
			}			
			$paypal_order_data = array(
				'order_id'         => $order_id,
				'capture_status'   => $capture_status,
				'currency_code'    => $response['transactions'][0]['amount']['currency'],
				'authorization_id' => $response['id'],
				'total'            => $response['transactions'][0]['amount']['total']
			);
			$pp_plus_mex_order_id = $this->model_extension_payment_pp_plus_mex->addOrder($paypal_order_data);
			$paypal_transaction_data = array(
				'pp_plus_mex_order_id' => $pp_plus_mex_order_id,
				'transaction_id'         => $response['id'],
				'parent_id'  			 => $response['id'],
				'note'                   => $response['transactions'][0]['custom'],
				'msgsubid'               => $response['transactions'][0]['related_resources'][0]['sale']['id'],
				'receipt_id'             => $response['transactions'][0]['related_resources'][0]['sale']['receipt_id'],
				'payment_type'           => $response['transactions'][0]['related_resources'][0]['sale']['payment_mode'],
				'payment_status'         => $response['transactions'][0]['related_resources'][0]['sale']['state'],
				'pending_reason'         => '',
				'amount'                 => $response['transactions'][0]['amount']['total'],
				'debug_data'             => json_encode($response),
			);
			$this->model_extension_payment_pp_plus_mex->addTransaction($paypal_transaction_data);
			$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
			echo json_encode(array("success"=>"OK"));
		}else{
			echo json_encode(array("ERROR TPPPMX (al guardar pago):"=>$order_info));
		}

	}
	
	private function constructPagoPPPlusMEX($order_info) {
		$this->load->language('extension/payment/pp_plus_mex');
		$products = $this->cart->getProducts();
		$taxes = $this->cart->getTaxes();
		
		$items=array();
		$subtotal=0;
		$tax=0;
		# Get form data
		foreach ($products as $product){
			$articulo["name"]= $product["name"];
			$articulo["quantity"]= $product["quantity"];
			$articulo["price"]= number_format(round($product["price"],2),2);
			$articulo["sku"]= $product["model"];
			$articulo["currency"]= $order_info["currency_code"];
			$items[]=$articulo;
			$subtotal+=(round($product["price"],2)*$product["quantity"]);
		}
		foreach ($taxes as $taxmonto){
			$tax+=round($taxmonto,2);
		}
		$payerEmail=$order_info['email'];
		$payerPhone=preg_replace('/[^0-9]/','',$order_info['telephone']);
		$payerFirstName=$order_info['payment_firstname'];
		$payerLastName=$order_info['payment_lastname'];
		$shippingAddressRecipient=$order_info['shipping_firstname'].' '.$order_info['shipping_lastname'].' '.$order_info['shipping_company'];
		$shippingAddressStreet1=$order_info['shipping_address_1'];
		$shippingAddressStreet2=$order_info['shipping_address_2'];
		$shippingAddressPostal=$order_info['shipping_postcode'];
		$shippingAddressCity=$order_info['shipping_city'];
		$shippingAddressCountry=$order_info['shipping_iso_code_2'];
		$shippingAddressState=$order_info['shipping_zone'];
		$disallowRememberedCards=1;
		$rememberedCards='';
		if ($this->config->get('pp_plus_mex_test')) {
			$paypalMode='sandbox';
		} else {
			$paypalMode='live';
		}
		$this->clientId=$this->config->get('pp_plus_mex_clientid');
		$this->secret=$this->config->get('pp_plus_mex_secret');		
		$this->experience_profile_id=$this->config->get('pp_plus_mex_experience_profile_id');
		$returnUrl='http://www.paypal.com';
		$cancelUrl='http://www.paypal.com';
		$ppplusJsLibraryLang='es_MX';
		$currency=$order_info['currency_code'];
		$iframeHeight='450px';
		$merchantInstallmentSelection='1'; // esto es para pago a meses
		$merchantInstallmentSelectionOptional=true; // esto es para pago a meses
		
		$total = round($order_info['total'],2);
		
		if ($paypalMode=="sandbox") {
			$host = 'https://api.sandbox.paypal.com';
		}
		if ($paypalMode=="live") {
			$host = 'https://api.paypal.com';
		}
		$url = $host.'/v1/oauth2/token'; 
		$postArgs = 'grant_type=client_credentials';
		$this->access_token= $this->get_access_token($url,$postArgs);

		$url = $host.'/v1/payments/payment';
		$payment = '{
		  "intent": "sale",
		  "experience_profile_id": "'.$this->experience_profile_id.'",
		  "payer": {
			"payment_method": "paypal"
		  },
		  "transactions": [
			{
			  "amount": {
				"currency": "'.$currency.'",
				"total": "'.number_format($total,2).'",
				"details": {
					"subtotal": "'.number_format($subtotal,2).'",
					"tax": "'.number_format($tax,2).'",
					"shipping": "'.number_format($total-$subtotal-$tax,2).'"
				}
			  },
			  "description": "'.$order_info['store_name'].' ('.$order_info['store_url'].')",
			  "custom": "TPPPMX Order: '.$order_info['order_id'].'",
			  "payment_options": {
				"allowed_payment_method": "IMMEDIATE_PAY"
			  },
			  "item_list": {
				"items": [';
		foreach($items as $item){
			$payment .='{';
			foreach ($item as $col => $val){
				$payment .='"'.$col.'": "'.$val.'",';
			}
			$payment=substr($payment,0,-1).'},';
		}
		$payment=substr($payment,0,-1);
		$payment .='],
				"shipping_address": {
					"recipient_name": "'.$shippingAddressRecipient.'",
					"line1": "'.$shippingAddressStreet1.'",
					"line2": "'.$shippingAddressStreet2.'",
					"city": "'.$shippingAddressCity.'",
					"country_code": "'.$shippingAddressCountry.'",
					"postal_code": "'.$shippingAddressPostal.'",
					"state": "'.$shippingAddressState.'",
					"phone": "'.$payerPhone.'"
				}
			  }
			}
		  ],
		  "redirect_urls": {
			"return_url": "'.$returnUrl.'",
			"cancel_url": "'.$cancelUrl.'"
		  }
		}
		';
		$json_resp = $this->make_post_call($url, $payment);
		$approval_url = $json_resp['links']['1']['href'];
		$token = substr($approval_url,-20);
		$paymentID = ($json_resp['id']);
		$json_resp = stripslashes($this->json_format($json_resp));
		$regresa='
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="icon">
							<i class="fa fa-credit-card"></i>
						</span> 
						<span class="text">'.$this->language->get('text_title').'</span>
					</h4>
				</div>
				<div class="panel-body">
					<!--<link rel="stylesheet" type="text/css" href="catalog/view/theme/porto/css/bootstrap.css"/>-->
					<form method="post" class="horizontal-form" action="?action=inline"
						id="checkout-form" onSubmit="return false;"
						data-checkout="inline">
						<div class="col-sm-6">
							<div class="form-group" id="psp-group">
								<div class="panel">
									<div class="panel-body">
										<div id="pppDiv" style="width:300px;"> <!-- AQUI VA EL IFRAME DE PAYPALPLUSMEX -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<button type="submit" id="continueButton" style="display:inline !important;"
									class="btn btn-lg btn-primary btn-block infamous-continue-button"
									onclick="regenerapaypaplus(); return false;">
								'.$this->language->get('btn_pay').'
							</button>
							<img id="realizandopago" style="display:none;" src="catalog/view/theme/default/template/extension/payment/pp_plus_mex_loading.gif"/>
						</div>
					</form>
				</div>
			</div>		
			<script>
				var ppp;
				if ($("#qc_confirm_order").length){
					jQuery("#payment_view").hide();
				}else{
					regenerapaypaplus();
				}
				function regenerapaypaplus(){
					jQuery("#payment_view").show();
					jQuery("#qc_confirm_order").addClass("hidden");					
					ppp = PAYPAL.apps.PPP({
						approvalUrl: "'. $approval_url.'",
						buttonLocation: "outside",
						placeholder: "pppDiv",
						disableContinue: "continueButton",
						enableContinue: "continueButton",
						onLoad: function(){
							jQuery("#continueButton").prop( "disabled", false );
							jQuery("#qc_confirm_order").addClass("hidden");
							jQuery("#continueButton").attr("onclick","ppp.doContinue();");
						},
						onContinue: function (rememberedCards, payerId, token, term) {
							var access_token = "'. $this->access_token.'";
							var paymentID = "'. $paymentID.'";
							var paypalMode = "'. $paypalMode.'";
							jQuery("#continueButton").hide();
							jQuery("#realizandopago").show();
							verifica_pago(access_token,payerId,paymentID,paypalMode);
							return false;
						},
						onError: function (err) {
							var msg = jQuery("#responseOnError").html()  + "<BR />" + JSON.stringify(err);
							jQuery("#responseOnError").html(msg);
							jQuery("#continueButton").show();
							jQuery("#realizandopago").hide();
						},
						language: "'. $ppplusJsLibraryLang.'",
						country: "'. $shippingAddressCountry.'",
						disallowRememberedCards: "'. $disallowRememberedCards.'",
						rememberedCards: "'. $rememberedCards.'",
						mode: "'. $paypalMode.'",
						useraction: "continue",
						payerEmail: "'. $payerEmail.'",
						payerPhone: "'. $payerPhone.'",
						payerFirstName: "'. $payerFirstName.'",
						payerLastName: "'. $payerLastName.'",
						payerTaxId: "",
						payerTaxIdType: "",
						merchantInstallmentSelection: "'. $merchantInstallmentSelection.'",
						merchantInstallmentSelectionOptional:"'. $merchantInstallmentSelectionOptional.'",
						hideMxDebitCards: false,
						iframeHeight: "'. $iframeHeight.'"
					});						
				}

                function verifica_pago(access_token,payerId,paymentID,paypalMode){
					jQuery("#continueButton").hide();
					jQuery("#realizandopago").show();
					$.ajax({
						url: "catalog/view/theme/default/template/extension/payment/pp_plus_mex_executePayment.php",
						type: "POST",
						dataType: "json",
						data: {
							access_token: access_token,
							payerId: payerId,
							paymentID: paymentID,
							paypalMode: paypalMode
						},
						success: function(result){
							console.log("PAGO REALIZADO");
							console.log(JSON.stringify(result, null, 4));
							jQuery("#realizandopago").hide();
							if (result["state"]!="approved"){
								console.log("ERROR");
								console.log(JSON.stringify(result, null, 4));
								jQuery("#continueButton").show();
								jQuery("#realizandopago").hide();							
								if (result["failure_reason"]) alert("PayPal ERROR: "+result["failure_reason"]);
								alert("PayPal ERROR (state "+result["state"]+"): '.$this->language->get('error_payment').'");
							}else{
								guarda_pago(result);
							}
						},
						error: function(error){
							console.log("ERROR");
							console.log(JSON.stringify(error, null, 4));
							jQuery("#continueButton").show();
							jQuery("#realizandopago").hide();							
							alert("PayPal ERROR: '.$this->language->get('error_payment').'");
						}
					});
                }
				
				function guarda_pago(result){
					$.ajax({
						url: "index.php?route=extension/payment/pp_plus_mex/guarda_pago",
						type: "POST",
						dataType: "json",
						data: {
							resultado: result
						},
						success: function(result){
							console.log("PAGO GUARDADO??");
							console.log(JSON.stringify(result, null, 4));
							if (result["success"]=="OK") window.location.replace("'.$this->url->link('checkout/success', '', true).'")
							else alert("PayPal ERROR: "+JSON.stringify(result, null, 4));
						},
						error: function(error){
							console.log("ERROR");
							console.log(JSON.stringify(error, null, 4));
							alert("PayPal ERROR: "+JSON.stringify(error, null, 4));
						}
					});					
				}
				$("#debug").on("click", function (e) {
					$(\'.open\').toggleClass(\'open closed\');
				});
				$("#sessionInfo").on("click", function (e) {
					e.stopPropagation();
				});
				$("#sessionInfoDrawer").on("click", function (e) {
					e.stopPropagation();
					$(this).toggleClass(\'closed open\');
				});
			</script>
			<style>
				.hidden {display:none;}
			</style>
		';
		return $regresa;
	}


	private function json_format($json) {
	  if (!is_string($json)) {
		if (phpversion() && phpversion() >= 5.4) {
		  return json_encode($json, JSON_PRETTY_PRINT);
		}
		$json = json_encode($json);
	  }
	  $result      = '';
	  $pos         = 0;          
	  $strLen      = strlen($json);
	  $indentStr   = "\t";
	  $newLine     = "\n";
	  $prevChar    = '';
	  $outOfQuotes = true;
	  for ($i = 0; $i < $strLen; $i++) {
		$copyLen = strcspn($json, $outOfQuotes ? " \t\r\n\",:[{}]" : "\\\"", $i);
		if ($copyLen >= 1) {
		  $copyStr = substr($json, $i, $copyLen);
		  $prevChar = '';
		  $result .= $copyStr;
		  $i += $copyLen - 1;
		  continue;
		}
		$char = substr($json, $i, 1);
		if (!$outOfQuotes && $prevChar === '\\') {
		  $result .= $char;
		  $prevChar = '';
		  continue;
		}
		if ($char === '"' && $prevChar !== '\\') {
		  $outOfQuotes = !$outOfQuotes;
		}else if ($outOfQuotes && ($char === '}' || $char === ']')) {
		  $result .= $newLine;
		  $pos--;
		  for ($j = 0; $j < $pos; $j++) {
			$result .= $indentStr;
		  }
		}else if ($outOfQuotes && false !== strpos(" \t\r\n", $char)) {
		  continue;
		}
		$result .= $char;
		if ($outOfQuotes && $char === ':') {
		  $result .= ' ';
		}else if ($outOfQuotes && ($char === ',' || $char === '{' || $char === '[')) {
		  $result .= $newLine;
		  if ($char === '{' || $char === '[') {
			$pos++;
		  }
		  for ($j = 0; $j < $pos; $j++) {
			$result .= $indentStr;
		  }
		}
		$prevChar = $char;
	  }
	  return $result;
	}
	
	private function get_access_token($url, $postdata) {
		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_POST, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST,'TLSv1');
		curl_setopt($curl, CURLOPT_USERPWD, $this->clientId . ":" . $this->secret);
		curl_setopt($curl, CURLOPT_HEADER, false); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$response = curl_exec( $curl );
		if (empty($response)) {
			die(curl_error($curl));
			curl_close($curl); 
		} else {
			$info = curl_getinfo($curl);
			curl_close($curl); 
		  if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo 'TOKEN ERROR: '.$response;
			die();
			}
		}
		$jsonResponse = json_decode( $response );
		return $jsonResponse->access_token;
	}
	private function make_post_call($url, $postdata) {
		global $access_token;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST,'TLSv1');
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer '.$this->access_token,
					'Accept: application/json',
					'Content-Type: application/json'
					));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$response = curl_exec( $curl );
		if (empty($response)) {
			die(curl_error($curl));
			curl_close($curl);
		} else {
			$info = curl_getinfo($curl);
			curl_close($curl); 
			if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "POST ERROR:".$response;
				die();
			}
		}
		$jsonResponse = json_decode($response, TRUE);
		return $jsonResponse;
	}
}
?>