<?php
class ModelCheckoutVoucher extends Model {
	public function addVoucher($order_id, $data) {
		$this->db->non_cached_query("INSERT INTO voucher SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($data['code']) . "', from_name = '" . $this->db->escape($data['from_name']) . "', from_email = '" . $this->db->escape($data['from_email']) . "', to_name = '" . $this->db->escape($data['to_name']) . "', to_email = '" . $this->db->escape($data['to_email']) . "', voucher_theme_id = '" . (int)$data['voucher_theme_id'] . "', message = '" . $this->db->escape($data['message']) . "', amount = '" . (float)$data['amount'] . "', status = '1', date_added = NOW()");
	
		return $this->db->getLastId();
	}
	
	public function getVoucher($code) {
	
		$code = str_replace('+',' ',$code);
	
		$status = true;
		
		$voucher_query = $this->db->non_cached_query("SELECT *, vtd.name AS theme FROM voucher v LEFT JOIN voucher_theme vt ON (v.voucher_theme_id = vt.voucher_theme_id) LEFT JOIN voucher_theme_description vtd ON (vt.voucher_theme_id = vtd.voucher_theme_id) WHERE v.code = '" . $this->db->escape($code) . "' AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND v.status = '1'");
		
		if ($voucher_query->num_rows) {
			if ($voucher_query->row['order_id']) {
				$order_query = $this->db->non_cached_query("SELECT * FROM `order` WHERE order_id = '" . (int)$voucher_query->row['order_id'] . "' AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'");
			
				if (!$order_query->num_rows) {
					$status = false;
				}
				
				$order_voucher_query = $this->db->non_cached_query("SELECT * FROM `order_voucher` WHERE order_id = '" . (int)$voucher_query->row['order_id'] . "' AND voucher_id = '" . (int)$voucher_query->row['voucher_id'] . "'");
			
				if (!$order_voucher_query->num_rows) {
					$status = false;
				}				
			}
			
			$voucher_history_query = $this->db->non_cached_query("SELECT SUM(amount) AS total FROM `voucher_history` vh WHERE vh.voucher_id = '" . (int)$voucher_query->row['voucher_id'] . "' GROUP BY vh.voucher_id");
	
			if ($voucher_history_query->num_rows) {
				$amount = $voucher_query->row['amount'] + $voucher_history_query->row['total'];
			} else {
				$amount = $voucher_query->row['amount'];
			}
			
			if ($amount <= 0) {
				$status = false;
			}

			//used_in_totals
			$totals_history_query = $this->db->non_cached_query("SELECT * FROM `order_total` ot LEFT JOIN `order` o ON o.order_id = ot.order_id WHERE `title` LIKE '%(" . $this->db->escape($code) . ")%' AND o.order_status_id > 0");
			if ($totals_history_query->num_rows){
				$status = false;
			}
			
		} else {
			$status = false;
		}
		
		if ($status) {
			return array(
				'voucher_id'       => $voucher_query->row['voucher_id'],
				'code'             => $voucher_query->row['code'],
				'curr'             => $voucher_query->row['curr'],
				'from_name'        => $voucher_query->row['from_name'],
				'from_email'       => $voucher_query->row['from_email'],
				'to_name'          => $voucher_query->row['to_name'],
				'to_email'         => $voucher_query->row['to_email'],
				'voucher_theme_id' => $voucher_query->row['voucher_theme_id'],
				'theme'            => $voucher_query->row['theme'],
				'message'          => $voucher_query->row['message'],
				'image'            => $voucher_query->row['image'],
				'amount'           => $amount,
				'status'           => $voucher_query->row['status'],
				'date_added'       => $voucher_query->row['date_added']
			);
		}
	}
	
	public function confirm($order_id) {
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		if ($order_info) {
			$this->load->model('localisation/language');
			
			$language = new Language($order_info['language_directory']);
			$language->load($order_info['language_filename']);	
			$language->load('mail/voucher');
			
			$voucher_query = $this->db->non_cached_query("SELECT *, vtd.name AS theme FROM `voucher` v LEFT JOIN voucher_theme vt ON (v.voucher_theme_id = vt.voucher_theme_id) LEFT JOIN voucher_theme_description vtd ON (vt.voucher_theme_id = vtd.voucher_theme_id) AND vtd.language_id = '" . (int)$order_info['language_id'] . "' WHERE v.order_id = '" . (int)$order_id . "'");
			
			foreach ($voucher_query->rows as $voucher) {
				// HTML Mail
				$this->load->model('tool/image');
            	$template = new EmailTemplate($this->request, $this->registry);
				
				$template->data['title'] = sprintf($language->get('text_subject'), $voucher['from_name']);
				
				$template->data['text_greeting'] = sprintf($language->get('text_greeting'), $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']));
				$template->data['text_from'] = sprintf($language->get('text_from'), $voucher['from_name']);
				$template->data['text_message'] = $language->get('text_message');
				$template->data['text_redeem'] = sprintf($language->get('text_redeem'), $voucher['code']);
				$template->data['text_footer'] = $language->get('text_footer');
				
				if (file_exists(DIR_IMAGE . $voucher['image'])) {
					$template->data['image'] = $this->config->get('config_url') . 'image/' . $voucher['image'];
				} else {
					$template->data['image'] = '';
				}
				
				$template->data['store_name'] = $order_info['store_name'];
				$template->data['store_url'] = $order_info['store_url'];
				$template->data['message'] = nl2br($voucher['message']);
			
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/voucher.tpl')) {
					//$html = $template->fetch($this->config->get('config_template') . '/template/mail/voucher.tpl');
				} else {
					//$html = $template->fetch('default/template/mail/voucher.tpl');
				}
					
				$mail = new Mail($this->registry); 			
				$mail->setTo($voucher['to_email']);
				$mail->setSubject(html_entity_decode(sprintf($language->get('text_subject'), $voucher['from_name']), ENT_QUOTES, 'UTF-8'));
				//$mail->setHtml($html);				
				$template->load('order.voucher');
				$mail = $template->hook($mail);
				$mail->send();		
				$template->sent();
			}
		}
	}
	
	public function redeem($voucher_id, $order_id, $amount) {
		$this->db->non_cached_query("INSERT INTO `voucher_history` SET voucher_id = '" . (int)$voucher_id . "', order_id = '" . (int)$order_id . "', amount = '" . (float)$amount . "', date_added = NOW()");
	}
}