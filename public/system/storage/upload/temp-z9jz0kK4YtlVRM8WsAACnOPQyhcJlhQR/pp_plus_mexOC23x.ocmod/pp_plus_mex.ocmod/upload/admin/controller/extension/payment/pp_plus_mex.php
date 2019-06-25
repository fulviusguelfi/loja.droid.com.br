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
	private $error = array();
	
	public function index() {
		$this->load->language('extension/payment/pp_plus_mex');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_plus_mex', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		} else {
			$data['error'] = @$this->error;
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['text_iframe'] = $this->language->get('text_iframe');
		$data['text_redirect'] = $this->language->get('text_redirect');
		$data['entry_clientid'] = $this->language->get('entry_clientid');
		$data['entry_secret'] = $this->language->get('entry_secret');
		$data['entry_experience_profile_id'] = $this->language->get('entry_experience_profile_id');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_debug'] = $this->language->get('entry_debug');

		$data['entry_completed_status'] = $this->language->get('entry_completed_status');

		$data['help_test'] = $this->language->get('help_test');
		$data['help_total'] = $this->language->get('help_total');

		$data['help_debug'] = $this->language->get('help_debug');
		$data['tab_settings'] = $this->language->get('tab_settings');
		$data['tab_order_status'] = $this->language->get('tab_order_status');
		$data['tab_checkout_customisation'] = $this->language->get('tab_checkout_customisation');
		$data['tab_important_message'] = $this->language->get('tab_important_message');
		$data['tab_instrucciones'] = $this->language->get('tab_instrucciones');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/pp_plus_mex', 'token=' . $this->session->data['token'], true)
		);
		$data['action'] = $this->url->link('extension/payment/pp_plus_mex', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);
		if (isset($this->request->post['pp_plus_mex_experience_profile_id'])) {
			$data['pp_plus_mex_experience_profile_id'] = $this->request->post['pp_plus_mex_experience_profile_id'];
		} else {
			$data['pp_plus_mex_experience_profile_id'] = $this->config->get('pp_plus_mex_experience_profile_id');
		}
		if (isset($this->request->post['pp_plus_mex_clientid'])) {
			$data['pp_plus_mex_clientid'] = $this->request->post['pp_plus_mex_clientid'];
		} else {
			$data['pp_plus_mex_clientid'] = $this->config->get('pp_plus_mex_clientid');
		}
		if (isset($this->request->post['pp_plus_mex_secret'])) {
			$data['pp_plus_mex_secret'] = $this->request->post['pp_plus_mex_secret'];
		} else {
			$data['pp_plus_mex_secret'] = $this->config->get('pp_plus_mex_secret');
		}
		if (isset($this->request->post['pp_plus_mex_test'])) {
			$data['pp_plus_mex_test'] = $this->request->post['pp_plus_mex_test'];
		} else {
			$data['pp_plus_mex_test'] = $this->config->get('pp_plus_mex_test');
		}
		if (isset($this->request->post['pp_plus_mex_total'])) {
			$data['pp_plus_mex_total'] = $this->request->post['pp_plus_mex_total'];
		} else {
			$data['pp_plus_mex_total'] = $this->config->get('pp_plus_mex_total');
		}
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['pp_plus_mex_completed_status_id'])) {
			$data['pp_plus_mex_completed_status_id'] = $this->request->post['pp_plus_mex_completed_status_id'];
		} else {
			$data['pp_plus_mex_completed_status_id'] = $this->config->get('pp_plus_mex_completed_status_id');
		}

		if (isset($this->request->post['pp_plus_mex_geo_zone_id'])) {
			$data['pp_plus_mex_geo_zone_id'] = $this->request->post['pp_plus_mex_geo_zone_id'];
		} else {
			$data['pp_plus_mex_geo_zone_id'] = $this->config->get('pp_plus_mex_geo_zone_id');
		}
		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		if (isset($this->request->post['pp_plus_mex_status'])) {
			$data['pp_plus_mex_status'] = $this->request->post['pp_plus_mex_status'];
		} else {
			$data['pp_plus_mex_status'] = $this->config->get('pp_plus_mex_status');
		}
		if (isset($this->request->post['pp_plus_mex_sort_order'])) {
			$data['pp_plus_mex_sort_order'] = $this->request->post['pp_plus_mex_sort_order'];
		} else {
			$data['pp_plus_mex_sort_order'] = $this->config->get('pp_plus_mex_sort_order');
		}
		if (isset($this->request->post['pp_plus_mex_debug'])) {
			$data['pp_plus_mex_debug'] = $this->request->post['pp_plus_mex_debug'];
		} else {
			$data['pp_plus_mex_debug'] = $this->config->get('pp_plus_mex_debug');
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/payment/pp_plus_mex', $data));
	}
	public function install() {
		$this->load->model('extension/payment/pp_plus_mex');
		$this->model_extension_payment_pp_plus_mex->install();
	}
	public function uninstall() {
		$this->load->model('extension/payment/pp_plus_mex');
		$this->model_extension_payment_pp_plus_mex->uninstall();
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/pp_plus_mex')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['pp_plus_mex_experience_profile_id']) {
			$this->error['experience_profile_id'] = $this->language->get('error_experience_profile_id');
		}
		if (!$this->request->post['pp_plus_mex_clientid']) {
			$this->error['clientid'] = $this->language->get('error_clientid');
		}
		if (!$this->request->post['pp_plus_mex_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}
		return !$this->error;
	}
	
	public function order() {
		$this->load->model('extension/payment/pp_plus_mex');
		$this->load->language('extension/payment/pp_plus_mex');
		$paypal_order = $this->model_extension_payment_pp_plus_mex->getOrder($this->request->get['order_id']);
		if ($paypal_order) {
			$data['text_payment_info'] = $this->language->get('text_payment_info');
			$data['text_capture_status'] = $this->language->get('text_capture_status');
			$data['text_amount_auth'] = $this->language->get('text_amount_auth');

			$data['text_transactions'] = $this->language->get('text_transactions');
			$data['text_complete'] = $this->language->get('text_complete');

			$data['text_view'] = $this->language->get('text_view');

			$data['column_trans_id'] = $this->language->get('column_trans_id');
			$data['column_amount'] = $this->language->get('column_amount');
			$data['column_type'] = $this->language->get('column_type');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_action'] = $this->language->get('column_action');
			$data['paypal_order'] = $paypal_order;
			$data['token'] = $this->session->data['token'];
			$data['order_id'] = $this->request->get['order_id'];

			$data['transactions'] = array();
			$data['view_link'] = $this->url->link('extension/payment/pp_plus_mex/info', 'token=' . $this->session->data['token'], true);

			$data['paypal_order'] = $paypal_order;

			foreach ($paypal_order['transactions'] as $transaction) {
				$data['transactions'][] = array(
					'pp_plus_mex_order_transaction_id' => $transaction['pp_plus_mex_order_transaction_id'],
					'transaction_id' => $transaction['transaction_id'],
					'amount' => $transaction['amount'],
					'date_added' => $transaction['date_added'],
					'payment_type' => $transaction['payment_type'],
					'payment_status' => $transaction['payment_status'],
				);
			}
			$data['reauthorise_link'] = $this->url->link('extension/payment/pp_plus_mex/reauthorise', 'token=' . $this->session->data['token'], true);
			return $this->load->view('extension/payment/pp_plus_mex_order', $data);
		}
	}
}