<?php   
class ControllerCommonSeogen extends Controller {   
	public function index() {
    	$this->language->load('common/seogen');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_1'] = $this->language->get('text_1');	
		$this->data['text_2'] = $this->language->get('text_2');	
		$this->data['text_3'] = $this->language->get('text_3');	

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$ende = ".html";

		$this->data['heading_products'] = $this->language->get('heading_products');
		$this->data['heading_categ'] = $this->language->get('heading_categ');
		$this->data['heading_manuf'] = $this->language->get('heading_manuf');
		$this->data['heading_info'] = $this->language->get('heading_info');
		
		$this->data['text_generate'] = $this->language->get('text_generate');
		
		$this->data['text_h1'] = $this->language->get('text_h1');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_meta_kw'] = $this->language->get('text_meta_kw');
		$this->data['text_meta_desc'] = $this->language->get('text_meta_desc');
		$this->data['text_pattern_pro'] = $this->language->get('text_pattern_pro');
		$this->data['text_pattern_cat'] = $this->language->get('text_pattern_cat');
		$this->data['text_pattern_manuf'] = $this->language->get('text_pattern_manuf');
		$this->data['text_pattern_info'] = $this->language->get('text_pattern_info');
		$this->data['text_seo_rewr'] = $this->language->get('text_seo_rewr');
		$this->data['text_seo_warn'] = $this->language->get('text_seo_warn');
										
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_seogen'),
			'href'      => $this->url->link('common/seogen', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

		$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'common/seogen.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
	
	public function seo($name) {
		$seo_data = $this->toAscii(html_entity_decode($name));
			return $seo_data;
	}

	public function toAscii($string) {
			// ua
			$source[] = '/??/'; $replace[] = 'a';
			$source[] = '/??/'; $replace[] = 'b';
			$source[] = '/??/'; $replace[] = 'v';
			$source[] = '/??/'; $replace[] = 'g';
			$source[] = '/??/'; $replace[] = 'g';
			$source[] = '/??/'; $replace[] = 'd';
			$source[] = '/??/'; $replace[] = 'e';
			$source[] = '/??/'; $replace[] = 'ye';
			$source[] = '/??/'; $replace[] = 'zh';
			$source[] = '/??/'; $replace[] = 'z';
			$source[] = '/??/'; $replace[] = 'i';
			$source[] = '/??/'; $replace[] = 'i';
			$source[] = '/??/'; $replace[] = 'yi';
			$source[] = '/??/'; $replace[] = 'j';
			$source[] = '/??/'; $replace[] = 'k';
			$source[] = '/??/'; $replace[] = 'l';
			$source[] = '/??/'; $replace[] = 'm';
			$source[] = '/??/'; $replace[] = 'n';
			$source[] = '/??/'; $replace[] = 'o';
			$source[] = '/??/'; $replace[] = 'p';
			$source[] = '/??/'; $replace[] = 'r';
			$source[] = '/??/'; $replace[] = 's';
			$source[] = '/??/'; $replace[] = 't';
			$source[] = '/??/'; $replace[] = 'y';
			$source[] = '/??/'; $replace[] = 'f';
			$source[] = '/??/'; $replace[] = 'h';
			$source[] = '/??/'; $replace[] = 'c';
			$source[] = '/??/'; $replace[] = 'ch';
			$source[] = '/??/'; $replace[] = 'sh';
			$source[] = '/??/'; $replace[] = 'shh';
			$source[] = '/??/'; $replace[] = '';
			$source[] = '/??/'; $replace[] = 'yu';
			$source[] = '/??/'; $replace[] = 'ya';
			$source[] = '/??/'; $replace[] = 'e';
			$source[] = '/??/'; $replace[] = 'u';

			// UA
			$source[] = '/??/'; $replace[] = 'a';
			$source[] = '/??/'; $replace[] = 'b';
			$source[] = '/??/'; $replace[] = 'v';
			$source[] = '/??/'; $replace[] = 'g';
			$source[] = '/??/'; $replace[] = 'g';
			$source[] = '/??/'; $replace[] = 'd';
			$source[] = '/??/'; $replace[] = 'e';
			$source[] = '/??/'; $replace[] = 'ye';
			$source[] = '/??/'; $replace[] = 'zh';
			$source[] = '/??/'; $replace[] = 'z';
			$source[] = '/??/'; $replace[] = 'i';
			$source[] = '/??/'; $replace[] = 'i';
			$source[] = '/??/'; $replace[] = 'yi';
			$source[] = '/??/'; $replace[] = 'j';
			$source[] = '/??/'; $replace[] = 'k';
			$source[] = '/??/'; $replace[] = 'l';
			$source[] = '/??/'; $replace[] = 'm';
			$source[] = '/??/'; $replace[] = 'n';
			$source[] = '/??/'; $replace[] = 'o';
			$source[] = '/??/'; $replace[] = 'p';
			$source[] = '/??/'; $replace[] = 'r';
			$source[] = '/??/'; $replace[] = 's';
			$source[] = '/??/'; $replace[] = 't';
			$source[] = '/??/'; $replace[] = 'y';
			$source[] = '/??/'; $replace[] = 'f';
			$source[] = '/??/'; $replace[] = 'h';
			$source[] = '/??/'; $replace[] = 'c';
			$source[] = '/??/'; $replace[] = 'ch';
			$source[] = '/??/'; $replace[] = 'sh';
			$source[] = '/??/'; $replace[] = 'shh';
			$source[] = '/??/'; $replace[] = '';
			$source[] = '/??/'; $replace[] = 'yu';
			$source[] = '/??/'; $replace[] = 'ya';
			$source[] = '/??/'; $replace[] = 'e';
			$source[] = '/??/'; $replace[] = 'u';
			$source[] = '/??/'; $replace[] = 'yo';

			$string = preg_replace($source, $replace, $string);

			for ($i=0; $i<strlen($string); $i++) {
				if ($string[$i] >= 'a' && $string[$i] <= 'z') continue;
				if ($string[$i] >= 'A' && $string[$i] <= 'Z') continue;
				if ($string[$i] >= '0' && $string[$i] <= '9') continue;
				$string[$i] = '-';
			}
			$string = str_replace("--","-",$string);
			
			$new_string = strtolower($string);
			
		return $new_string;
	}
		
	
	public function cat() {
			
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$this->language->load('common/seogen');
		
			$this->load->model('catalog/seogen');
		
			$start = microtime(true);
				
			if (isset($this->request->post['cat_id'])) {	
				
				$lang = $this->request->post['lang'];
		 
				$haystack = $this->request->post['cat_id'];
						
				$this->model_catalog_seogen->title($haystack, $lang);	
				
				$end = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
			} 
			if (isset($this->request->post['catdesc_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackdesc = $this->request->post['catdesc_id'];
				
				$this->model_catalog_seogen->desc($haystackdesc, $lang);	
				
				$end2 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end2 - $start), 2) . $this->language->get('text_2');
			}
			if (isset($this->request->post['catkey_id'])) {	
			
				$lang = $this->request->post['lang'];
				
				$haystackkey = $this->request->post['catkey_id'];
				
				$this->model_catalog_seogen->keyw($haystackkey, $lang);
				
				$end3 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end3 - $start), 2) . $this->language->get('text_2');
			}
			
			if (isset($this->request->post['cath1_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackh1 = $this->request->post['cath1_id'];
				
				$this->model_catalog_seogen->h1($haystackh1, $lang);
				
				$end4 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end4 - $start), 2) . $this->language->get('text_2');
			}
					
			$this->response->setOutput(json_encode($json));	
		}
	}
	
	public function manuf() {
			
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$this->language->load('common/seogen');
		
			$this->load->model('catalog/seogen');
		
			$start = microtime(true);
				
			if (isset($this->request->post['manuf_id'])) {	
				
				$lang = $this->request->post['lang'];
		 
				$haystack = $this->request->post['manuf_id'];
						
				$this->model_catalog_seogen->titleMan($haystack, $lang);
				
				$end = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
			} 
			if (isset($this->request->post['manufdesc_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackdesc = $this->request->post['manufdesc_id'];
				
				$this->model_catalog_seogen->descMan($haystackdesc, $lang);
				
				$end2 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end2 - $start), 2) . $this->language->get('text_2');
			}
			if (isset($this->request->post['manufkey_id'])) {	
			
				$lang = $this->request->post['lang'];
				
				$haystackkey = $this->request->post['manufkey_id'];
				
				$this->model_catalog_seogen->keywMan($haystackkey, $lang);
				
				$end3 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end3 - $start), 2) . $this->language->get('text_2');
			}
			
			if (isset($this->request->post['manufh1_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackh1 = $this->request->post['manufh1_id'];
				
				$this->model_catalog_seogen->h1Man($haystackh1, $lang); 
				
				$end4 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end4 - $start), 2) . $this->language->get('text_2');
			}
					
			$this->response->setOutput(json_encode($json));	
		}
	}
	
	public function seomanuf() {
				
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
		$this->language->load('common/seogen');
		
		$start = microtime(true);
		
		$prosto = $this->request->post['keyw_id'];
		
		if ($prosto == '1') {
		
			$query = $this->db->query("SELECT `manufacturer_id`, `name` FROM `" . DB_PREFIX . "manufacturer`");

			foreach ($query->rows as $row) {
				$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'manufacturer_id=".((int)$row['manufacturer_id'])."'");

				if ($query_alias->num_rows) {
					$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = '".$this->db->escape($this->seo($row['name']))."' WHERE query = 'manufacturer_id=".((int)$row['manufacturer_id'])."';");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('manufacturer_id=".((int)$row['manufacturer_id'])."','".$this->db->escape($this->seo($row['name']))."');");
				}
			}		
		
		} elseif ($prosto == '0') {
		
			$query = $this->db->query("SELECT `manufacturer_id`, `name` FROM `" . DB_PREFIX . "manufacturer`");

			foreach ($query->rows as $row) {
				$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'manufacturer_id=".((int)$row['manufacturer_id'])."'");

				if ($query_alias->num_rows) {
					
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('manufacturer_id=".((int)$row['manufacturer_id'])."','".$this->db->escape($this->seo($row['name']))."');");
				}
			}
		}
		
		$end = microtime(true);
		
		$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
		
		$this->cache->delete('seo_bro');
		$this->cache->delete('manufacturer');
		
		$this->response->setOutput(json_encode($json));	
		
		}
	}
	
	public function info() {
			
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$this->language->load('common/seogen');
		
			$this->load->model('catalog/seogen');
		
			$start = microtime(true);
				
			if (isset($this->request->post['info_id'])) {	
				
				$lang = $this->request->post['lang'];
		 
				$haystack = $this->request->post['info_id'];
						
				$this->model_catalog_seogen->titleInfo($haystack, $lang);
				
				$end = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
			} 
			if (isset($this->request->post['infodesc_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackdesc = $this->request->post['infodesc_id'];
				
				$this->model_catalog_seogen->descInfo($haystackdesc, $lang);
				
				$end2 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end2 - $start), 2) . $this->language->get('text_2');
			}
			if (isset($this->request->post['infokey_id'])) {	
			
				$lang = $this->request->post['lang'];
				
				$haystackkey = $this->request->post['infokey_id'];
				
				$this->model_catalog_seogen->keywInfo($haystackkey, $lang);
				
				$end3 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end3 - $start), 2) . $this->language->get('text_2');
			}
			
			if (isset($this->request->post['infoh1_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackh1 = $this->request->post['infoh1_id'];
				
				$this->model_catalog_seogen->h1Info($haystackh1, $lang); 
				
				$end4 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end4 - $start), 2) . $this->language->get('text_2');
			}
					
			$this->response->setOutput(json_encode($json));	
		}
	}
	
	public function seoinfo() {
				
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
		$this->language->load('common/seogen');
		
		$prosto = $this->request->post['keyw_id'];
		
		$start = microtime(true);
		
		if ($prosto == '1') {
		
			$query = $this->db->query("SELECT `information_id`, `title` FROM `" . DB_PREFIX . "information_description`");

			foreach ($query->rows as $row) {
				$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'information_id=".((int)$row['information_id'])."'");
				
				if ($query_alias->num_rows) {
					$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = '".$this->db->escape($this->seo($row['title']))."' WHERE query = 'information_id=".((int)$row['information_id'])."';");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('information_id=".((int)$row['information_id'])."','".$this->db->escape($this->seo($row['title']))."');");
				}
			}		
		
		} elseif ($prosto == '0') {
		
			$query = $this->db->query("SELECT `information_id`, `title` FROM `" . DB_PREFIX . "information_description`");

			foreach ($query->rows as $row) {
				$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'information_id=".((int)$row['information_id'])."'");
				
				if ($query_alias->num_rows) {
					
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('information_id=".((int)$row['information_id'])."','".$this->db->escape($this->seo($row['title']))."');");
				}
			}
		}
		
		$end = microtime(true);
		
		$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
		
		$this->cache->delete('seo_bro');
		$this->cache->delete('information');
		
		$this->response->setOutput(json_encode($json));	
		
		}
	}
	
	public function keyw() {
				
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
		$this->language->load('common/seogen');
		
		$this->load->model('catalog/seogen');
		
		$prosto = $this->request->post['keyw_id'];
		
		$start = microtime(true);
		
		if ($prosto == '1') {
		
			$preview = $this->model_catalog_seogen->rewrite();		
		
		} elseif ($prosto == '0') {
		
			$preview = $this->model_catalog_seogen->unwrite();
		}
		
		$end = microtime(true);
		
		$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
		
		$this->response->setOutput(json_encode($json));	
		
		}
	}
	
	public function keyp() {
				
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
		$this->language->load('common/seogen');		
		
		$prosto = $this->request->post['keyp_id'];
		
		$start = microtime(true);
		
		if ($prosto == '1') {
		
			$query = $this->db->query("SELECT category_id,name FROM " . DB_PREFIX . "category_description;");

			foreach ($query->rows as $row) {
							
				$query_alias = $this->db->query("SELECT url_alias_id,query,keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=".((int)$row['category_id'])."';");
				
				if ($query_alias->num_rows) {
					$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = '".$this->db->escape($this->seo($row['name']))."' WHERE query = 'category_id=".((int)$row['category_id'])."';");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('category_id=".((int)$row['category_id'])."','".$this->db->escape($this->seo($row['name']))."');");
				} 
			}		
		
		} elseif ($prosto == '0') {
		
			$query = $this->db->query("SELECT category_id,name FROM " . DB_PREFIX . "category_description;");

			foreach ($query->rows as $row) {
							
				$query_alias = $this->db->query("SELECT url_alias_id,query,keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=".((int)$row['category_id'])."';");
				
				if ($query_alias->num_rows) {
					
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias (query,keyword) VALUES ('category_id=".((int)$row['category_id'])."','".$this->db->escape($this->seo($row['name']))."');");
				} 
			}
		}
		
		$end = microtime(true);
		
		$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
		
		$this->cache->delete('seo_bro');
		$this->cache->delete('category.seopath');
		
		$this->response->setOutput(json_encode($json));	
		
		}
	}
	
	//categ
	
	public function pro() {
			
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$this->language->load('common/seogen');
		
			$this->load->model('catalog/seogen');
		
			$start = microtime(true);
				
			if (isset($this->request->post['pro_id'])) {	
				
				$lang = $this->request->post['lang'];
		 
				$haystack = $this->request->post['pro_id'];
						
				$this->model_catalog_seogen->cattitle($haystack, $lang);	
				
				$end = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end - $start), 2) . $this->language->get('text_2');
			} 
			if (isset($this->request->post['prodesc_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackdesc = $this->request->post['prodesc_id'];
				
				$this->model_catalog_seogen->prodesc($haystackdesc, $lang);	
				
				$end2 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end2 - $start), 2) . $this->language->get('text_2');
			}
			if (isset($this->request->post['prokey_id'])) {	
			
				$lang = $this->request->post['lang'];
				
				$haystackkey = $this->request->post['prokey_id'];
				
				$this->model_catalog_seogen->prokey($haystackkey, $lang);
				
				$end3 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end3 - $start), 2) . $this->language->get('text_2');
			}
			
			if (isset($this->request->post['proh1_id'])) {
			
				$lang = $this->request->post['lang'];
				
				$haystackh1 = $this->request->post['proh1_id'];
				
				$this->model_catalog_seogen->proh1($haystackh1, $lang);
				
				$end4 = microtime(true);
				
				$json['success'] = $this->language->get('text_1') . round(($end4 - $start), 2) . $this->language->get('text_2');
			} 
					
			$this->response->setOutput(json_encode($json));	
		}
	}
}
?>