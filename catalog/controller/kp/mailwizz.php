<?
	
	class ControllerKPMailWizz extends Controller {	
		
		private $listConfigs = [
		'config_mailwizz_mapping_newsletter',
		'config_mailwizz_mapping_newsletter_news',
		'config_mailwizz_mapping_newsletter_personal'
		];
		
		private $fieldsToConfigs = [
		'newsletter' 			=> 'config_mailwizz_mapping_newsletter',
		'newsletter_news' 		=> 'config_mailwizz_mapping_newsletter_news',
		'newsletter_personal' 	=> 'config_mailwizz_mapping_newsletter_personal'
		];
		
		private $limit = 500;
		private $countries = [];				
		
		
		public function __construct($registry){
			
			parent::__construct($registry);
			
			$this->db->query("UPDATE customer SET email = TRIM(email) WHERE 1");
			$this->db->query("UPDATE customer SET utoken = md5(md5(concat(email,email))) WHERE 1");
			$this->db->query("UPDATE customer c SET country_id = 176 WHERE store_id = 0");
			$this->db->query("UPDATE customer c SET country_id = 220 WHERE store_id = 1");
			$this->db->query("UPDATE customer c SET country_id = 109 WHERE store_id = 2");
			$this->db->query("UPDATE customer c SET country_id = 20 WHERE store_id = 5");
			$this->db->query("UPDATE customer c SET mail_status = 'not_mail' WHERE NOT (email LIKE '%@%')");
			
			if ($this->config->get('config_mailwizz_enable')){
				
				$config = new \EmsApi\Config([
				'apiUrl'    => $this->config->get('config_mailwizz_api_uri'),
				'apiKey'    => $this->config->get('config_mailwizz_api_key'),
				'components' => ['cache' => [
				'class'     => \EmsApi\Cache\File::class,
				'filesPath' => DIR_CACHE
				]]]);
				
				\EmsApi\Base::setConfig($config);
				
			}
			
			echoLine('INIT: Настройка MailWizz ' . $this->config->get('config_mailwizz_enable'));
			
			
			$endpoint = new EmsApi\Endpoint\Lists();
			foreach ($this->listConfigs as $listConfig){
				echoLine("INIT: Лист $listConfig: " . $this->config->get($listConfig));
				$response = $endpoint->getList($this->config->get($listConfig));								
				
				if ($response->body['status'] == 'error'){
					throw new \Exception ("INIT FAIL: $listConfig NOT FOUND IN EMA");
					die();
					} else {
					echoLine('OK');
				}
			}		
			
			$this->load->model('localisation/country');
			$countries = $this->model_localisation_country->getCountries();
			
			foreach ($countries as $country){
				$this->countries[$country['country_id']] = $country['name'];
			}
			
			return $this;
		}
		
		private function getCustomers($customerIDS){

			if (!$customerIDS){
				return [];
			}

			return $this->db->ncquery("SELECT c.*, 
			(SELECT MAX(date_added) FROM customer_ip ci WHERE (ci.customer_id = c.customer_id)) AS last_date, 
			(SELECT SUM(points) AS total FROM customer_reward cr WHERE (cr.customer_id = c.customer_id)) as total_reward,
			(SELECT GROUP_CONCAT(text) as search_history FROM customer_search_history csh WHERE (csh.customer_id = c.customer_id) GROUP BY csh.customer_id) as search_history 
			FROM customer c WHERE customer_id IN (" . implode(',', $customerIDS) . ")")->rows;									
		}
		
		private function prepareCustomerArray($customer){
			
			if (!trim($customer['firstname'])){
				$customer['firstname'] = substr($customer['email'], 0, strrpos($customer['email'], '@'));
			}
			
			
			$data = [
			
			//Базовая информация
			'EMAIL' 			=> trim($customer['email']),
			'FIRSTNAME' 		=> trim($customer['firstname']),
			'LASTNAME' 			=> trim($customer['lastname']),
			'COUNTRY' 			=> $this->countries[$customer['country_id']],
			'CITY' 				=> trim($customer['city']),
			'BIRTHDAY_MONTH' 	=> $customer['birthday_month'],
			'BIRTHDAY_DATE' 	=> $customer['birthday_date'],
			
			//Сегментация по заказам
			'ORDER_GOOD_COUNT' 			=> $customer['order_good_count'],
			'ORDER_BAD_COUNT' 			=> $customer['order_bad_count'],
			'ORDER_GOOD_FIRST_DATE' 	=> $customer['order_good_first_date'],
			'ORDER_GOOD_LAST_DATE' 		=> $customer['order_good_last_date'],
			'ORDER_FIRST_DATE' 			=> $customer['order_first_date'],
			'ORDER_LAST_DATE' 			=> $customer['order_last_date'],
			'HAS_ORDERS_IN_DAYS'		=> (int)($customer['order_last_date'] >= date('Y-m-d', strtotime('-' . $this->config->get('config_mailwizz_noorder_days') . ' day'))),
			'HAS_ORDERS_GOOD_IN_DAYS'	=> (int)($customer['order_good_last_date'] >= date('Y-m-d', strtotime('-' . $this->config->get('config_mailwizz_noorder_days') . ' day'))),
			'AVG_CHEQUE' 				=> $customer['avg_cheque'],
			'TOTAL_CHEQUE' 				=> $customer['total_cheque'],
			'CSI_AVERAGE' 				=> $customer['csi_average'],
			
			//Дата последнего захода
			'LAST_SITE_ACTION' 			=> (date('Y-m-d', strtotime($customer['last_date']))),
			
			//Бонусов на счету
			'TOTAL_REWARD' 				=> (int)($customer['total_reward']),
			'HAS_REWARD_POINTS' 		=> (int)((int)$customer['total_reward'] > 0),
			
			//История поиска
			'SEARCH_HISTORY' 			=> $customer['search_history']
			];								
			
			return $data;
		}				
		
		
		private function updateUID($customer, $field, $uid){
			$this->db->query("UPDATE customer SET `" . $field . '_ema_uid' . "` = '" . $this->db->escape($uid) . "' WHERE customer_id = '" . $customer['customer_id'] . "'");				
		}
		
		private function updateCustomerInList($customer, $field){
			$customer_info = $this->prepareCustomerArray($customer);
			
			//Да, так неправильно, нада вынести в инит, но так влом
			$endpoint = new EmsApi\Endpoint\ListSubscribers();	
			if ($customer[$field . '_ema_uid']){
				
				$response = $endpoint->update($this->config->get($this->fieldsToConfigs[$field]), $customer[$field . '_ema_uid'], $customer_info);
				
				} else {
				
				$response = $endpoint->createUpdate($this->config->get($this->fieldsToConfigs[$field]), $customer_info);
				
				if ($response->body['status'] == 'success'){
					$uid = $response->body['data']['record']['subscriber_uid'];
					
					$this->updateUID($customer, $field, $uid);
				}
			}
		}
		
		private function deleteCustomerFromList($customer, $field){
			$endpoint = new EmsApi\Endpoint\ListSubscribers();
			
			if ($customer[$field . '_ema_uid']){
				$response = $endpoint->delete($this->config->get($this->fieldsToConfigs[$field]), $customer[$field . '_ema_uid']);
				$this->updateUID($customer, $field, '');
			}
		}
		
		public function updateTempList(){
			$listID = 'qj4666v3mt465';
			
			$query = $this->db->query("SELECT customer_id FROM customer_reward WHERE date_added = '2021-11-04' AND reason_code = 'INITIAL_REWARD_ADD'");
			
			$endpoint = new EmsApi\Endpoint\ListSubscribers();	
			
			foreach ($query->rows as $row){
				
				foreach ($this->getCustomers(array($row['customer_id'])) as $customer){
					
					if ($this->emailBlackList->check($customer['email'])){
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' валидна stage-1, продолжаем');
						
						$continue = $this->emailBlackList->whitelist_check($customer['email']);
						if ($continue){
							echoLine('MAILWIZZ: почта ' . $customer['email'] . ' в вайт-листе');
						}
						
						if (!$continue){
							$continue = $this->emailBlackList->checkfull($customer['email']);
							echoLine('MAILWIZZ: почта ' . $customer['email'] . ' невалидна');
						}						
					}
					
					if ($continue){
						$customer_info = $this->prepareCustomerArray($customer);							
						$response = $endpoint->createUpdate($listID, $customer_info);
					}
					
				}
			}
		}
		
		public function cron(){
			
			if(php_sapi_name()!=="cli"){
				die('cli only');	
			}
			
			ini_set('memory_limit', '5G');
			
			$queue = $this->db->ncquery("SELECT * FROM mailwizz_queue ORDER BY RAND() LIMIT " . (int)$this->limit);
			
			$customerIDS = [];
			foreach ($queue->rows as $row){
				$customerIDS[] = $row['customer_id'];
			}						
			
			foreach ($this->getCustomers($customerIDS) as $customer){
				//Валидация почты вообще, если она невалидна, то пропускаем в принципе
				if ($this->emailBlackList->check($customer['email'])){
					echoLine('MAILWIZZ: почта ' . $customer['email'] . ' валидна stage-1, продолжаем');
					
					$continue = $this->emailBlackList->whitelist_check($customer['email']);
					if ($continue){
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' в вайт-листе');
					}
					
					if (!$continue){
						$continue = $this->emailBlackList->checkfull($customer['email']);
					}
					
					if ($continue){
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' валидна stage-2, продолжаем');
						
						foreach ($this->fieldsToConfigs as $field => $config){
							
							if ($customer[$field]){
								$this->updateCustomerInList($customer, $field);
								echoLine('		Включена настройка ' . $field . ', добавляем или обновляем');
								
								} else {							
								$this->deleteCustomerFromList($customer, $field);
								echoLine('		Отключена настройка ' . $field . ', удаляем');
							}
							
						}
						} else {
						
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' невалидна stage-2, заносим в блеклист, продолжаем');
						
					}
					
					
					} else {
					
					//Находится в блеклисте
					if ($this->emailBlackList->blacklist_check($customer['email'])){
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' в блек-листе, продолжаем');
						foreach ($this->fieldsToConfigs as $field => $config){
							$this->deleteCustomerFromList($customer, $field);
							echoLine('		Блеклистед ' . $field . ', удаляем');
						}
						} else {
						echoLine('MAILWIZZ: почта ' . $customer['email'] . ' не валидна, пропускаем');
					}
					
				}
				
				$this->db->query("DELETE FROM mailwizz_queue WHERE customer_id = '" . (int)$customer['customer_id'] . "'");
				
			}
			

			if ($customerIDS){
				$this->db->query("DELETE FROM mailwizz_queue WHERE customer_id IN (" . implode(',', $customerIDS) . ")");
			}
		}
	}																