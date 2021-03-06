<?php
	class ControllerCommonHoboSeo extends Controller {		
		private function checkBadURIParams(){
			$new_page = '';			
			$badGetParams = [
			'categoryID'
			];
			
			foreach ($badGetParams as $badGetParam){
				if (isset($this->request->get[$badGetParam])){
					$new_page = str_replace('&amp;' . $badGetParam . '=' . $this->request->get[$badGetParam], '', $this->request->server['REQUEST_URI']);
					$new_page = str_replace('&' . $badGetParam . '=' . $this->request->get[$badGetParam], '', $new_page);
					$new_page = str_replace('?' . $badGetParam . '=' . $this->request->get[$badGetParam], '', $new_page);
					$new_page = str_replace('' . $badGetParam . '=' . $this->request->get[$badGetParam], '', $new_page);
				}			
			}
			
			
			if (isset($this->request->get['utm_term']) && filter_var($this->request->get['utm_term'], FILTER_VALIDATE_EMAIL)){
				$new_page = str_replace('&utm_term=' . $this->request->get['utm_term'], '', $this->request->server['REQUEST_URI']);
				$new_page = str_replace('?utm_term=' . $this->request->get['utm_term'], '', $new_page);
				$new_page = str_replace('utm_term=' . $this->request->get['utm_term'], '', $new_page);
			}
			
			if (isset($this->request->get['page']) && (int)$this->request->get['page'] <= 1){
				$new_page = str_replace('&amp;page=' . (int)$this->request->get['page'], '', $this->request->server['REQUEST_URI']);
				$new_page = str_replace('&page=' . (int)$this->request->get['page'], '', $new_page);
				$new_page = str_replace('?page=' . (int)$this->request->get['page'], '', $new_page);						
			}

			$new_page = trim($new_page);
			
			if ($new_page && trim($new_page)){
				header('Location: ' . str_replace('&amp;', '&', $new_page), true, 301);
				exit();
			}

			return $this;
		}

		private function shortAliasImplementation(){
			//ЛОГИКА КОРОТКИХ УРЛОВ
			$request_query = $this->request->server['REQUEST_URI'];
			if (strpos($request_query, '?')){
				$query_string = substr($request_query, (strpos($request_query, '?')+1));						
			}
			
			//удаляем query_string
			if (isset($query_string) && strlen($query_string)>0){
				$request_query = substr($request_query, 0, -1*(strlen($query_string)+1));						
			}
			
			//удаляем первый и последний слэш, если он есть	
			if (substr($request_query, -1) == '/') {
				$request_query = substr($request_query, 0, -1);
			}
			
			if (strlen($request_query)>0 && $request_query[0] == '/') {						
				$request_query = substr($request_query, 1);
			}
			
			if (mb_strlen($request_query) > 3){								
				if ($alias = $this->shortAlias->getURL($request_query, true)) {																		
					header('Location: ' . str_replace('&amp;', '&', $alias), true, 301);
					exit();
				}
			}

			return $this;
		}

		private function redirectManagerImplementation(){
			if ($this->config->get('redirect_manager_status')) {
				
				$request_query = $this->request->server['REQUEST_URI'];
				$http_server = $this->request->server['HTTP_HOST'];
				
				if (strpos($request_query, '?')){
					$query_string = substr($request_query, (strpos($request_query, '?')+1));						
				}
				
				//удаляем query_string
				if (isset($query_string) && strlen($query_string)>0){
					$request_query = substr($request_query, 0, -1*(strlen($query_string)+1));						
				}
				
				//удаляем первый и последний слэш, если он есть	
				if (substr($request_query, -1) == '/') {
					$request_query = substr($request_query, 0, -1);
				}
				
				if (strlen($request_query)>0 && $request_query[0] == '/') {						
					$request_query = substr($request_query, 1);
				}
				
				$search_query = $this->db->query(
				"SELECT * FROM `redirect` 
				WHERE (
				from_url LIKE ('" . $this->db->escape($request_query) . "') OR 
				from_url LIKE ('" . $this->db->escape($request_query) . "/') OR 
				from_url LIKE ('/" . $this->db->escape($request_query) ."') OR 
				from_url LIKE ('/" . $this->db->escape($request_query) ."/'))
				AND (active = 1)"
				);	
				
				if ($search_query->num_rows) {																		
					$this->db->query("UPDATE `redirect` SET times_used = times_used+1 WHERE redirect_id = " . (int)$search_query->row['redirect_id']);
					
					$to_url = $search_query->row['to_url'];
					
					if (substr($to_url, -1) == '/') {
						$to_url = substr($to_url, 0, -1);
					}
					
					if (strlen($to_url)>0 && $to_url[0] == '/') {
						$to_url = substr($to_url, 1);
					}
					
					if (isset($query_string) && strlen($query_string)>0){
						if (strpos($to_url, '?')){
							$to = '/' . $to_url . '&' . $query_string;							
							} else {
							$to = '/' . $to_url . '?' . $query_string;								
						}										
						} else {
						$to = '/' . $to_url;							
					}
					header('Location: ' . str_replace('&amp;', '&', $to), true, $search_query->row['response_code']);
					exit();
				}						
			}		

			return $this;			
		}

		public function switcher(){
			$language = $this->request->post['language'];
			$redirect = $this->request->post['redirect'];

			if ($language && array_key_exists($language, $this->registry->get('languages'))){				
				$registry->get('session')->data['language'] = $language;
				setcookie('language', $language, time() + 60 * 60 * 24 * 30, '/', $registry->get('request')->server['HTTP_HOST']);
			}
		}

		public function index(){			
			$this->checkBadURIParams()->shortAliasImplementation()->redirectManagerImplementation();
			return false;
		}

	}