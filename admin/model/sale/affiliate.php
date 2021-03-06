<?php
class ModelSaleAffiliate extends Model {
	public function addAffiliate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', code = '" . $this->db->escape($data['code']) . "', commission = '" . (float)$data['commission'] . "', tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	}
	
	public function editAffiliate($affiliate_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', code = '" . $this->db->escape($data['code']) . "', commission = '" . (float)$data['commission'] . "', tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "', status = '" . (int)$data['status'] . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		
		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		}
	}
	
	public function deleteAffiliate($affiliate_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "'");
	}
	
	public function getAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		
		if ($query->num_rows){
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function getAffiliateByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
	
	public function getAffiliates($data = array()) {
		$sql = "SELECT *, CONCAT(a.firstname, ' ', a.lastname) AS name, a.code, (SELECT SUM(at.amount) FROM " . DB_PREFIX . "affiliate_transaction at WHERE at.affiliate_id = a.affiliate_id GROUP BY at.affiliate_id) AS balance FROM " . DB_PREFIX . "affiliate a";
			
			$implode = array();
			
			if (!empty($data['filter_name'])) {
				$implode[] = "CONCAT(a.firstname, ' ', a.lastname) LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}
			
			if (!empty($data['filter_email'])) {
				$implode[] = "LCASE(a.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
			}
			
			if (!empty($data['filter_code'])) {
				$implode[] = "a.code = '" . $this->db->escape($data['filter_code']) . "'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$implode[] = "a.status = '" . (int)$data['filter_status'] . "'";
			}	
			
			if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
				$implode[] = "a.approved = '" . (int)$data['filter_approved'] . "'";
			}		
			
			if (!empty($data['filter_date_added'])) {
				$implode[] = "DATE(a.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
			}
			
			if (isset($data['filter_request_payment']) && !is_null($data['filter_request_payment'])) {
				if ((int) $data['filter_request_payment'] == 0) {
					$implode[] = "a.request_payment = '" . (int) $data['filter_request_payment'] . "'";
				} else {
					$implode[] = "a.request_payment > '" . 0 . "'";
				}
			}
			
			if ($implode) {
				$sql .= " WHERE " . implode(" AND ", $implode);
			}
			
			$sort_data = array(
				'name',
				'a.email',
				'a.code',
				'a.status',
				'a.request_payment',
				'a.approved',
				'a.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}			
				
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}		
			
			$query = $this->db->query($sql);
			
			return $query->rows;	
		}
		
		public function approve($affiliate_id) {
			$affiliate_info = $this->getAffiliate($affiliate_id);
			
			if ($affiliate_info) {
				$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET approved = '1' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
				
				$this->language->load('mail/affiliate');
				
				$message  = sprintf($this->language->get('text_approve_welcome'), $this->config->get('config_name')) . "\n\n";
				$message .= $this->language->get('text_approve_login') . "\n";
				$message .= HTTP_CATALOG . 'index.php?route=affiliate/login' . "\n\n";
				$message .= $this->language->get('text_approve_services') . "\n\n";
				$message .= $this->language->get('text_approve_thanks') . "\n";
				$message .= $this->config->get('config_name');
				
				$template = new EmailTemplate($this->request, $this->registry);
				
				$template->addData($affiliate_info);                      
				$template->data['text_welcome'] = sprintf($this->language->get('text_approve_welcome'), $this->config->get('config_name'));
				$template->data['affiliate_login'] = HTTP_CATALOG . 'index.php?route=affiliate/login';
				$template->data['affiliate_login_tracking'] =  $template->getTracking($template->data['affiliate_login']);

				$mail = new Mail($this->registry); 					
				$mail->setTo($affiliate_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_mail_trigger_name_from'));
				$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_approve_subject'), $this->config->get('config_mail_trigger_name_from')), ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$template->load(array(
					'key' => 'admin.affiliate_approve'
				));			
				$mail = $template->hook($mail);
				$mail->send();
				$template->sent();
			}
		}
		
		public function getAffiliatesByNewsletter() {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE newsletter = '1' ORDER BY firstname, lastname, email");
			
			return $query->rows;
		}
		
		public function getTotalAffiliates($data = array()) {
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate";
			
			$implode = array();
			
			if (!empty($data['filter_name'])) {
				$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}
			
			if (!empty($data['filter_email'])) {
				$implode[] = "LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
			}	
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$implode[] = "status = '" . (int)$data['filter_status'] . "'";
			}			
			
			if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
				$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
			}		
			
			if (!empty($data['filter_date_added'])) {
				$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
			}
			
			if (isset($data['filter_request_payment']) && !is_null($data['filter_request_payment'])) {
				if (((int) $data['filter_request_payment']) == 0) {
					$implode[] = "request_payment = '" . (int) $data['filter_request_payment'] . "'";
				} else {
					$implode[] = "request_payment > '" . 0 . "'";
				}
			}
			
			if ($implode) {
				$sql .= " WHERE " . implode(" AND ", $implode);
			}
			
			$query = $this->db->query($sql);
			
			return $query->row['total'];
		}
		
		public function getTotalAffiliatesAwaitingApproval() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE status = '0' OR approved = '0'");
			
			return $query->row['total'];
		}
		
		public function getTotalAffiliatesByCountryId($country_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE country_id = '" . (int)$country_id . "'");
			
			return $query->row['total'];
		}	
		
		public function getTotalAffiliatesByZoneId($zone_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE zone_id = '" . (int)$zone_id . "'");
			
			return $query->row['total'];
		}
		
		public function addTransaction($affiliate_id, $description = '', $amount = '', $order_id = 0) {
			$affiliate_info = $this->getAffiliate($affiliate_id);
			
			if ($affiliate_info) { 
				$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_transaction SET affiliate_id = '" . (int)$affiliate_id . "', order_id = '" . (float)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
				
				$this->language->load('mail/affiliate');
				
				$this->load->model('module/affiliate');
				$message  = '';
				if ((float)$amount < 0) {
					$query_request_payment = $this->db->query("SELECT request_payment AS total FROM `" . DB_PREFIX . "affiliate` WHERE affiliate_id = '" . (int) $affiliate_id . "'");
					$request_payment_value = $query_request_payment->row['total'] + $amount;
					if ($request_payment_value < 0) {
						$request_payment_value = 0.00;
					}
					$this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET request_payment = '" . $request_payment_value . "' WHERE affiliate_id = '" . (int) $affiliate_id . "'");
					$message = sprintf($this->language->get('text_transaction_paid'), $this->currency->format($amount * (-1)), $this->model_module_affiliate->valuePlayment($affiliate_info)) . "\n\n";
				}
				else {
					$message = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
				} 
				$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($affiliate_id), $this->config->get('config_currency')));
				
				$mail = new Mail($this->registry); 
				$mail->setTo($affiliate_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_mail_trigger_name_from'));
				$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_mail_trigger_name_from')), ENT_QUOTES, 'UTF-8'));

				$template = new EmailTemplate($this->request, $this->registry);                        
				$template->data['text_received'] = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency')));
				$template->data['text_total'] = sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($affiliate_id), $this->config->get('config_currency')));

				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$template->load('admin.affiliate_transaction');
				$mail = $template->hook($mail);
				$mail->send();
				$template->sent();
			}
		}
		
		public function deleteTransaction($order_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
		}
		
		public function getTransactions($affiliate_id, $start = 0, $limit = 10) {
			if ($start < 0) {
				$start = 0;
			}
			
			if ($limit < 1) {
				$limit = 10;
			}	
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
			
			return $query->rows;
		}
		
		public function getTotalTransactions($affiliate_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTransactionTotal($affiliate_id) {
			$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			
			return $query->row['total'];
		}	
		
		public function getTotalTransactionsByOrderId($order_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
			
			return $query->row['total'];
		}		
	}