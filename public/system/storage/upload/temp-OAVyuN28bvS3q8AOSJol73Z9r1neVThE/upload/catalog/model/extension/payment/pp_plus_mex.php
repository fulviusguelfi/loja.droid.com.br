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

class ModelExtensionPaymentPPPlusMex extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/pp_plus_mex');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pp_plus_mex_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		if ($this->config->get('pp_plus_mex_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('pp_plus_mex_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		$currencies = array(
			'MXN'
		);
		if (!in_array(strtoupper($this->session->data['currency']), $currencies)) {
			$status = false;
		}
		$method_data = array();
		if ($status) {
			$method_data = array(
				'code'       => 'pp_plus_mex',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'image'		 => 'catalog/view/theme/default/template/extension/payment/pp_plus_mex_cc.png',
				'sort_order' => $this->config->get('pp_plus_mex_sort_order')
			);
		}
		return $method_data;
	}
	public function addOrder($order_data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "pp_plus_mex_order`
						 SET `order_id` = '" . (int)$order_data['order_id'] . "',
							 `date_added` = NOW(),
							 `date_modified` = NOW(),
							 `capture_status` = '" . $this->db->escape($order_data['capture_status']) . "',
							 `currency_code` = '" . $this->db->escape($order_data['currency_code']) . "',
							 `total` = '" . (float)$order_data['total'] . "',
							 `authorization_id` = '" . $this->db->escape($order_data['authorization_id']) . "'"
						);
		return $this->db->getLastId();
	}
	public function addTransaction($transaction_data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "pp_plus_mex_order_transaction`
						 SET `pp_plus_mex_order_id` = '" . (int)$transaction_data['pp_plus_mex_order_id'] . "',
						     `transaction_id` = '" . $this->db->escape($transaction_data['transaction_id']) . "',
							 `parent_id` = '" . $this->db->escape($transaction_data['parent_id']) . "',
							 `date_added` = NOW(),
							 `note` = '" . $this->db->escape($transaction_data['note']) . "',
							 `msgsubid` = '" . $this->db->escape($transaction_data['msgsubid']) . "',
							 `receipt_id` = '" . $this->db->escape($transaction_data['receipt_id']) . "',
							 `payment_type` = '" . $this->db->escape($transaction_data['payment_type']) . "',
							 `payment_status` = '" . $this->db->escape($transaction_data['payment_status']) . "',
							 `pending_reason` = '',
							 `amount` = '" . (float)$transaction_data['amount'] . "',
							 `debug_data` = '" . $this->db->escape($transaction_data['debug_data']) . "'"
						);
	}
}
?>