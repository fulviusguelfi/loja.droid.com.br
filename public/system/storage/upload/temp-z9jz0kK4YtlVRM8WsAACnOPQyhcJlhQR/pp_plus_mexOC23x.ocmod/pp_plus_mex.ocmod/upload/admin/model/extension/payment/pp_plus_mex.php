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
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pp_plus_mex_order` (
			  `pp_plus_mex_order_id` int(11) NOT NULL AUTO_INCREMENT,
			  `order_id` int(11) NOT NULL,
			  `date_added` DATETIME NOT NULL,
			  `date_modified` DATETIME NOT NULL,
			  `capture_status` ENUM('SANDBOX','LIVE') DEFAULT NULL,
			  `currency_code` CHAR(3) NOT NULL,
			  `authorization_id` VARCHAR(30) NOT NULL,
			  `total` DECIMAL( 10, 2 ) NOT NULL,
			  PRIMARY KEY (`pp_plus_mex_order_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pp_plus_mex_order_transaction` (
			  `pp_plus_mex_order_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
			  `pp_plus_mex_order_id` int(11) NOT NULL,
			  `transaction_id` CHAR(20) NOT NULL,
			  `parent_id` CHAR(20) NOT NULL,
			  `date_added` DATETIME NOT NULL,
			  `note` VARCHAR(255) NOT NULL,
			  `msgsubid` CHAR(38) NOT NULL,
			  `receipt_id` CHAR(20) NOT NULL,
			  `payment_type` ENUM('INSTANT_TRANSFER','MANUAL_BANK_TRANSFER','DELAYED_TRANSFER', 'ECHECK') DEFAULT NULL,
			  `payment_status` CHAR(20) NOT NULL,
			  `pending_reason` CHAR(50) NOT NULL,
			  `transaction_entity` CHAR(50) NOT NULL,
			  `amount` DECIMAL( 10, 2 ) NOT NULL,
			  `debug_data` TEXT NOT NULL,
			  `call_data` TEXT NOT NULL,
			  PRIMARY KEY (`pp_plus_mex_order_transaction_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}
	
	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pp_plus_mex_order_transaction`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pp_plus_mex_order`;");
	}
	
	private function getTransactions($pp_plus_mex_order_id) {
		$qry = $this->db->query("SELECT `ot`.*,
									( SELECT count(`ot2`.`pp_plus_mex_order_id`)
										FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction` `ot2`
										WHERE `ot2`.`parent_id` = `ot`.`transaction_id`
									) AS `children`
								FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction` `ot`
								WHERE `pp_plus_mex_order_id` = '" . (int)$pp_plus_mex_order_id . "'");
		if ($qry->num_rows) {
			return $qry->rows;
		} else {
			return false;
		}
	}
	
	public function getTotalCaptured($pp_plus_mex_order_id) {
		$qry = $this->db->query("SELECT SUM(`amount`) AS `amount`
								FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction`
								WHERE `pp_plus_mex_order_id` = '" . (int)$pp_plus_mex_order_id . "'
									AND `pending_reason` != 'authorization'
									AND (`payment_status` = 'Partially-Refunded'
										OR `payment_status` = 'Completed'
										OR `payment_status` = 'Pending')
									AND `transaction_entity` = 'payment'"
								);
		return $qry->row['amount'];
	}
	
	public function getTotalRefunded($pp_plus_mex_order_id) {
		$qry = $this->db->query("SELECT SUM(`amount`) AS `amount`
								FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction`
								WHERE `pp_plus_mex_order_id` = '" . (int)$pp_plus_mex_order_id . "'
									AND `payment_status` = 'Refunded'");
		return $qry->row['amount'];
	}
	
	public function getTotalRefundedTransaction($transaction_id) {
		$qry = $this->db->query("SELECT SUM(`amount`) AS `amount`
								FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction`
								WHERE `parent_id` = '" . $this->db->escape($transaction_id) . "'
									AND `payment_type` = 'refund'");
		return $qry->row['amount'];
	}
	
	public function getOrder($order_id) {
		$qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pp_plus_mex_order`
								WHERE `order_id` = '" . (int)$order_id . "' LIMIT 1");
		if ($qry->num_rows) {
			$order = $qry->row;
			$order['transactions'] = $this->getTransactions($order['pp_plus_mex_order_id']);
			$order['captured'] = $this->getTotalCaptured($order['pp_plus_mex_order_id']);
			return $order;
		} else {
			return false;
		}
	}
	
	public function updateOrder($capture_status, $order_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "pp_plus_mex_order`
						 SET `date_modified` = now(),
							`capture_status` = '" . $this->db->escape($capture_status) . "'
						 WHERE `order_id` = '" . (int)$order_id . "'");
	}
	
	public function updateTransaction($transaction) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "pp_plus_mex_order_transaction
			SET pp_plus_mex_order_id = " . (int)$transaction['pp_plus_mex_order_id'] . ",
				transaction_id = '" . $this->db->escape($transaction['transaction_id']) . "',
				parent_id = '" . $this->db->escape($transaction['parent_id']) . "',
				date_added = '" . $this->db->escape($transaction['date_added']) . "',
				note = '" . $this->db->escape($transaction['note']) . "',
				msgsubid = '" . $this->db->escape($transaction['msgsubid']) . "',
				receipt_id = '" . $this->db->escape($transaction['receipt_id']) . "',
				payment_type = '" . $this->db->escape($transaction['payment_type']) . "',
				payment_status = '" . $this->db->escape($transaction['payment_status']) . "',
				pending_reason = '',
				transaction_entity = '" . $this->db->escape($transaction['transaction_entity']) . "',
				amount = '" . $this->db->escape($transaction['amount']) . "',
				debug_data = '" . $this->db->escape($transaction['debug_data']) . "',
				call_data = '" . $this->db->escape($transaction['call_data']) . "'
			WHERE pp_plus_mex_order_transaction_id = " . (int)$transaction['pp_plus_mex_order_transaction_id'] . "
		");
	}
	
	public function addTransaction($transaction_data, $request_data = array()) {
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
							 `transaction_entity` = '" . $this->db->escape($transaction_data['transaction_entity'])."',
							 `amount` = '" . (float)$transaction_data['amount'] . "',
							 `debug_data` = '" . $this->db->escape($transaction_data['debug_data']) . "'"
						);
		$pp_plus_mex_order_transaction_id = $this->db->getLastId();
		if ($request_data) {
			$serialized_data = json_encode($request_data);
			$this->db->query("
				UPDATE " . DB_PREFIX . "pp_plus_mex_order_transaction
				SET call_data = '" . $this->db->escape($serialized_data) . "'
				WHERE pp_plus_mex_order_transaction_id = " . (int)$pp_plus_mex_order_transaction_id . "
				LIMIT 1
			");
		}
		return $pp_plus_mex_order_transaction_id;
	}
	
	public function log($data, $title = null) {
		if ($this->config->get('pp_plus_mex_debug')) {
			$log = new Log('pp_plus_mex.log');
			$log->write($title . ': ' . json_encode($data));
		}
	}

	public function getOrderId($transaction_id) {
		$qry = $this->db->query("SELECT `o`.`order_id`
								FROM `" . DB_PREFIX . "pp_plus_mex_order_transaction` `ot`
									LEFT JOIN `" . DB_PREFIX . "pp_plus_mex_order` `o`
										ON `o`.`pp_plus_mex_order_id` = `ot`.`pp_plus_mex_order_id`
								WHERE `ot`.`transaction_id` = '" . $this->db->escape($transaction_id) . "'
								LIMIT 1");
		if ($qry->num_rows) {
			return $qry->row['order_id'];
		} else {
			return false;
		}
	}
	
	public function updateAuthorizationId($pp_plus_mex_order_id, $authorization_id) {
		$this->db->query("
			UPDATE `" . DB_PREFIX . "pp_plus_mex_order`
			SET `authorization_id` = '" . $this->db->escape($authorization_id) . "'
			WHERE `pp_plus_mex_order_id` = '" . $this->db->escape($pp_plus_mex_order_id) . "'
		");
	}
	
	public function updateRefundTransaction($transaction_id, $transaction_type) {
		$this->db->query("UPDATE `" . DB_PREFIX . "pp_plus_mex_order_transaction`
						 SET `payment_status` = '" . $this->db->escape($transaction_type) . "'
						 WHERE `transaction_id` = '" . $this->db->escape($transaction_id) . "'
						 LIMIT 1");
	}
	
	public function getFailedTransaction($paypalplus_mex_order_transaction_id) {
		$result = $this->db->query("
			SELECT *
			FROM " . DB_PREFIX . "pp_plus_mex_order_transaction
			WHERE pp_plus_mex_order_transaction_id = " . (int)$paypalplus_mex_order_transaction_id . "
		")->row;
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	
	public function getLocalTransaction($transaction_id) {
		$result = $this->db->query("
			SELECT *
		FROM " . DB_PREFIX . "pp_plus_mex_order_transaction
			WHERE transaction_id = '" . $this->db->escape($transaction_id) . "'
		")->row;
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	
	protected function cleanReturn($data) {
		$data = explode('&', $data);
		$arr = array();
		foreach ($data as $k => $v) {
			$tmp = explode('=', $v);
			$arr[$tmp[0]] = urldecode($tmp[1]);
		}
		return $arr;
	}
}
?>