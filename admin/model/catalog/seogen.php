<?php
class ModelCatalogSeogen extends Model {

	public function title($data, $lang) {
	
		$query = $this->db->query("SELECT pd.name as pname, p.model as model, p.price as price, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id,  m.name as brand FROM " . DB_PREFIX . "product_description pd
		LEFT JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
		INNER JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id
		LEFT JOIN " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id AND cd.language_id = ".$lang."
		LEFT JOIN " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id;");
				
		foreach ($query->rows as $product) {
			
			$product['price'] = $this->currency->format($product['price']);
			
			$needle = Array($product['pname'], $product['model'], $product['price'], $product['cname'], $product['brand']);
			
			$searchArray = array('{name}', '{model}', '{price}', '{catname}', '{brand}');			
				
			$replace = str_replace($searchArray, $needle, $data);
				
			$ch2s = $replace;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_title = '". htmlspecialchars($ch2s) ."' WHERE product_id = ".$product['product_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function titleMan($data, $lang) {
	
		$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $query = $this->db->query("SELECT DISTINCT cd.name FROM
							". DB_PREFIX . "manufacturer m 
							LEFT JOIN ". DB_PREFIX. "product p ON (m.manufacturer_id = p.manufacturer_id)
							LEFT JOIN ". DB_PREFIX. "product_to_category p2c ON (p2c.product_id = p.product_id)
							LEFT JOIN ". DB_PREFIX. "category c ON (c.category_id = p2c.category_id)
							LEFT JOIN ". DB_PREFIX. "category_description cd ON (cd.category_id = p2c.category_id)
							WHERE
							p.status = 1
							AND m.manufacturer_id = '".(int)$row['manufacturer_id']."'
							AND c.status = 1
							AND p2c.main_category = 1
							AND cd.language_id = '".$lang."'");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['name']);
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}
			
			/* $query3 = $this->db->query("SELECT max(coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), p.price) ) AS max_price, min(coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), p.price) ) AS min_price FROM " . DB_PREFIX . "product p 
					LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)
					LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id) WHERE p.status = '1' AND p.manufacturer_id = '" . (int)$row['manufacturer_id'] . "'"); */
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P            
            WHERE P.manufacturer_id = '" . (int)$row['manufacturer_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET seo_title = '". htmlspecialchars($ch2s) ."' WHERE manufacturer_id = ".(int)$row['manufacturer_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function descMan($data, $lang) {
	
		$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $query = $this->db->query("SELECT DISTINCT cd.name FROM
							". DB_PREFIX . "manufacturer m 
							LEFT JOIN ". DB_PREFIX. "product p ON (m.manufacturer_id = p.manufacturer_id)
							LEFT JOIN ". DB_PREFIX. "product_to_category p2c ON (p2c.product_id = p.product_id)
							LEFT JOIN ". DB_PREFIX. "category c ON (c.category_id = p2c.category_id)
							LEFT JOIN ". DB_PREFIX. "category_description cd ON (cd.category_id = p2c.category_id)
							WHERE
							p.status = 1
							AND m.manufacturer_id = '".(int)$row['manufacturer_id']."'
							AND c.status = 1
							AND p2c.main_category = 1
							AND cd.language_id = '".$lang."'");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['name']);
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}			
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P            
            WHERE P.manufacturer_id = '" . (int)$row['manufacturer_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET meta_description = '". htmlspecialchars($ch2s) ."' WHERE manufacturer_id = ".(int)$row['manufacturer_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	}
	
	public function keywMan($data, $lang) {
	
		$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $query = $this->db->query("SELECT DISTINCT cd.name FROM
							". DB_PREFIX . "manufacturer m 
							LEFT JOIN ". DB_PREFIX. "product p ON (m.manufacturer_id = p.manufacturer_id)
							LEFT JOIN ". DB_PREFIX. "product_to_category p2c ON (p2c.product_id = p.product_id)
							LEFT JOIN ". DB_PREFIX. "category c ON (c.category_id = p2c.category_id)
							LEFT JOIN ". DB_PREFIX. "category_description cd ON (cd.category_id = p2c.category_id)
							WHERE
							p.status = 1
							AND m.manufacturer_id = '".(int)$row['manufacturer_id']."'
							AND c.status = 1
							AND p2c.main_category = 1
							AND cd.language_id = '".$lang."'");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['name']);
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}			
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P            
            WHERE P.manufacturer_id = '" . (int)$row['manufacturer_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET meta_keyword = '". htmlspecialchars($ch2s) ."' WHERE manufacturer_id = ".(int)$row['manufacturer_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	}
	
	public function h1Man($data, $lang) {
	
		$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $query = $this->db->query("SELECT DISTINCT cd.name FROM
							". DB_PREFIX . "manufacturer m 
							LEFT JOIN ". DB_PREFIX. "product p ON (m.manufacturer_id = p.manufacturer_id)
							LEFT JOIN ". DB_PREFIX. "product_to_category p2c ON (p2c.product_id = p.product_id)
							LEFT JOIN ". DB_PREFIX. "category c ON (c.category_id = p2c.category_id)
							LEFT JOIN ". DB_PREFIX. "category_description cd ON (cd.category_id = p2c.category_id)
							WHERE
							p.status = 1
							AND m.manufacturer_id = '".(int)$row['manufacturer_id']."'
							AND c.status = 1
							AND p2c.main_category = 1
							AND cd.language_id = '".$lang."'");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['name']);
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{cat}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}			
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P            
            WHERE P.manufacturer_id = '" . (int)$row['manufacturer_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET seo_h1 = '". htmlspecialchars($ch2s) ."' WHERE manufacturer_id = ".(int)$row['manufacturer_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	}
	
	public function titleInfo($data, $lang) {
	
		$query = $this->db->query("SELECT information_id, title FROM " . DB_PREFIX . "information_description WHERE language_id = '" . (int)$lang . "'");
				
		foreach ($query->rows as $row) {
		
			$store = $this->config->get('config_name');
			
			$needle = Array($row['title'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_title = '". htmlspecialchars($ch2s) ."' WHERE information_id = ".(int)$row['information_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function descInfo($data, $lang) {
	
		$query = $this->db->query("SELECT information_id, title FROM " . DB_PREFIX . "information_description WHERE language_id = '" . (int)$lang . "'");
				
		foreach ($query->rows as $row) {
		
			$store = $this->config->get('config_name');
			
			$needle = Array($row['title'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_description = '". htmlspecialchars($ch2s) ."' WHERE information_id = ".(int)$row['information_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	}
	
	public function keywInfo($data, $lang) {
	
		$query = $this->db->query("SELECT information_id, title FROM " . DB_PREFIX . "information_description WHERE language_id = '" . (int)$lang . "'");
				
		foreach ($query->rows as $row) {
		
			$store = $this->config->get('config_name');
			
			$needle = Array($row['title'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_keyword = '". htmlspecialchars($ch2s) ."' WHERE information_id = ".(int)$row['information_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	}
	
	public function h1Info($data, $lang) {
	
		$query = $this->db->query("SELECT information_id, title FROM " . DB_PREFIX . "information_description WHERE language_id = '" . (int)$lang . "'");
				
		foreach ($query->rows as $row) {
		
			$store = $this->config->get('config_name');
			
			$needle = Array($row['title'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_h1 = '". htmlspecialchars($ch2s) ."' WHERE information_id = ".(int)$row['information_id']." AND language_id = '" . (int)$lang . "'");
			
		}
		
		return;
	}
	
	public function desc($data, $lang) {
	
		$query = $this->db->query("SELECT pd.name as pname, p.model as model, p.price as price, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id,  m.name as brand FROM " . DB_PREFIX . "product_description pd
		LEFT JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
		INNER JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id
		LEFT JOIN " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id AND cd.language_id = ".$lang."
		LEFT JOIN " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id;");
				
		foreach ($query->rows as $product) {
		
			$product['price'] = $this->currency->format($product['price']);
		
			$needle = Array($product['pname'], $product['model'], $product['price'], $product['cname'], $product['brand']);
			
			$searchArray = array('{name}', '{model}', '{price}', '{catname}', '{brand}');			
				
			$replacedesc = str_replace($searchArray, $needle, $data);
							
			$ch1s = $replacedesc;
				
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description = '". htmlspecialchars($ch1s) ."' WHERE product_id = ".$product['product_id']." AND language_id = '" . (int)$lang . "'");
		} 
		
		return;
	}
	
	public function keyw($data, $lang) {
	
		$query = $this->db->query("SELECT pd.name as pname, p.model as model, p.price as price, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id,  m.name as brand FROM " . DB_PREFIX . "product_description pd
		LEFT JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
		INNER JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id
		LEFT JOIN " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id AND cd.language_id = ".$lang."
		LEFT JOIN " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id;");
				
		foreach ($query->rows as $product) {
			
			$product['price'] = $this->currency->format($product['price']);
			
			$needle = Array($product['pname'], $product['model'], $product['price'], $product['cname'], $product['brand']);
			
			$searchArray = array('{name}', '{model}', '{price}', '{catname}', '{brand}');			
				
			$replacekey = str_replace($searchArray, $needle, $data);
				
			$keywords = $replacekey;
				
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword = '". htmlspecialchars($keywords) ."' WHERE product_id = ".$product['product_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
	
	}
	
	public function h1($data, $lang) {
		
		$query = $this->db->query("SELECT pd.name as pname, p.model as model, p.price as price, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id,  m.name as brand FROM " . DB_PREFIX . "product_description pd
		LEFT JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
		INNER JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id
		LEFT JOIN " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id AND cd.language_id = ".$lang."
		LEFT JOIN " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id;");
				
		foreach ($query->rows as $product) {
		
			$product['price'] = $this->currency->format($product['price']);
			
			$needle = Array($product['pname'], $product['model'], $product['price'], $product['cname'], $product['brand']);
			
			$searchArray = array('{name}', '{model}', '{price}', '{catname}', '{brand}');			
				
			$replaceh1 = str_replace($searchArray, $needle, $data);
				
			$ch2sh1 = $replaceh1;
				
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_h1 = '". htmlspecialchars($ch2sh1) ."' WHERE product_id = ".$product['product_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}

	public function rewrite() {
	
		$ende = "";
	
		$query = $this->db->query("SELECT `product_id`, `name` FROM `" . DB_PREFIX . "product_description`");
		
		foreach ($query->rows as $row) {
		
			$gebuk = $this->seo($row['name']);
		
			$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'product_id=".((int)$row['product_id'])."'");
			
			if ($query_alias->num_rows) {
				$this->db->query("UPDATE `" . DB_PREFIX . "url_alias` SET `keyword` = '".$this->db->escape($gebuk).$this->db->escape($ende)."' WHERE `query` = 'product_id=".((int)$row['product_id'])."'");
			} else {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` (`query`, `keyword`) VALUES ('product_id=".((int)$row['product_id'])."', '".$this->db->escape($gebuk).$this->db->escape($ende)."')");
			}
		}
						
		return true;
	}
	
	public function unwrite() { 
	
		$ende = "";
	
		$query = $this->db->query("SELECT `product_id`, `name` FROM `" . DB_PREFIX . "product_description`");
		 
		foreach ($query->rows as $row) {
		
			$gebuk = $this->seo($row['name']);
		
			$query_alias = $this->db->query("SELECT `url_alias_id`, `query`, `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'product_id=".((int)$row['product_id'])."'");
			
			if (!$query_alias->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` (`query`, `keyword`) VALUES ('product_id=".((int)$row['product_id'])."', '".$this->db->escape($gebuk).$this->db->escape($ende)."')");
			}
		}
		
		$this->cache->delete('seo_bro');				
		$this->cache->delete('product.seopath');
		
		return true;    	
	  }
	  
	public function cattitle($data, $lang) { 
		
		$query = $this->db->query("SELECT category_id, name FROM " . DB_PREFIX . "category_description WHERE language_id = '".$lang."'");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $this->db->query("SELECT DISTINCT p.manufacturer_id AS manufacturer_id, m.name AS manufacturer_name FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$row['category_id'] . "' ORDER BY `m`.`name` ASC");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['manufacturer_name']);
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P
            JOIN " . DB_PREFIX . "product_to_category POC
            on POC.product_id = P.product_id
            WHERE POC.category_id = '" . (int)$row['category_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_title = '". htmlspecialchars($ch2s) ."' WHERE category_id = ".(int)$row['category_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function prodesc($data, $lang) { 
		
		$query = $this->db->query("SELECT category_id,name FROM " . DB_PREFIX . "category_description WHERE language_id = '".$lang."'");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $this->db->query("SELECT DISTINCT p.manufacturer_id AS manufacturer_id, m.name AS manufacturer_name FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$row['category_id'] . "' ORDER BY `m`.`name` ASC");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['manufacturer_name']);
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P
            JOIN " . DB_PREFIX . "product_to_category POC
            on POC.product_id = P.product_id
            WHERE POC.category_id = '" . (int)$row['category_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_description = '". htmlspecialchars($ch2s) ."' WHERE category_id = ".(int)$row['category_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function prokey($data, $lang) { 
		
		$query = $this->db->query("SELECT category_id,name FROM " . DB_PREFIX . "category_description WHERE language_id = '".$lang."'");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $this->db->query("SELECT DISTINCT p.manufacturer_id AS manufacturer_id, m.name AS manufacturer_name FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$row['category_id'] . "' ORDER BY `m`.`name` ASC");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['manufacturer_name']);
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P
            JOIN " . DB_PREFIX . "product_to_category POC
            on POC.product_id = P.product_id
            WHERE POC.category_id = '" . (int)$row['category_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keyword = '". htmlspecialchars($ch2s) ."' WHERE category_id = ".(int)$row['category_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	public function proh1($data, $lang) { 
		
		$query = $this->db->query("SELECT category_id,name FROM " . DB_PREFIX . "category_description WHERE language_id = '".$lang."'");
				
		foreach ($query->rows as $row) {
		
			$sql2 = $this->db->query("SELECT DISTINCT p.manufacturer_id AS manufacturer_id, m.name AS manufacturer_name FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$row['category_id'] . "' ORDER BY `m`.`name` ASC");
			
			if ($sql2->num_rows) {
				
				$needle = Array($sql2->row['manufacturer_name']);
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			} else {
			
				$needle = Array('');
			
				$searchArray = array('{brand}');			
					
				$data2 = str_replace($searchArray, $needle, $data);
				
			}
			
			$query3 = $this->db->query("SELECT round(min(price)) as min, round(max(price)) as max FROM " . DB_PREFIX . "product P
            JOIN " . DB_PREFIX . "product_to_category POC
            on POC.product_id = P.product_id
            WHERE POC.category_id = '" . (int)$row['category_id'] . "' AND P.status = 1");
			
			if ($query3->num_rows) {
			
				$min = $this->currency->format($query3->row['min']);
				
				$max = $this->currency->format($query3->row['max']);
			
				$needle = Array($min, $max);
			
				$searchArray = array('{min}', '{max}');
			
				$data3 = str_replace($searchArray, $needle, $data2);
			
			}
			
			$store = $this->config->get('config_name');
			
			$needle = Array($row['name'], $store);
			
			$searchArray = array('{name}', '{store}');			
				
			$data4 = str_replace($searchArray, $needle, $data3);
				
			$ch2s = $data4;				
				
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_h1 = '". htmlspecialchars($ch2s) ."' WHERE category_id = ".(int)$row['category_id']." AND language_id = '" . (int)$lang . "'");
			
		} 
		
		return;
		
	}
	
	private function seo($name) {
	
		return $this->toAscii(html_entity_decode($name));
			
	}

	private function toAscii($string) {
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
			
		return $this->tolover($string);
	}
			
	private function tolover($string) {
	
		return strtolower($string);
		
	}
	
	
}
