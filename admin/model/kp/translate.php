<?
	use Panda\Yandex\TranslateSdk;
	
	class ModelKpTranslate extends Model {
		
		private $symbolLimit = 9999;
		private $sentensesDelimiter = '.';
		
		private function toSentenses ($text) {
			$sentArray = explode($this->sentensesDelimiter, $text);
			return $sentArray;
		}
		
		private function toBigPieces ($text) {
			$sentArray = $this->toSentenses($text);
			$i = 0;
			$bigPiecesArray[0] = '';
			for ($k = 0; $k < count($sentArray); $k++) {
				$bigPiecesArray[$i] .= $sentArray[$k].$this->sentensesDelimiter;
				if (strlen($bigPiecesArray[$i]) > $this->symbolLimit){
					$i++;
					$bigPiecesArray[$i] = '';
				}
			}
			
			return $bigPiecesArray;
		}
		
		private function fromBigPieces (array $bigPiecesArray) {
			
			ksort($bigPiecesArray);
			
			return implode($bigPiecesArray);
		}
		
		
		public function translateYandex($text, $from, $to, $returnString = false){
			$result = false;
			
			if (mb_strlen($text, 'UTF-8') > $this->symbolLimit){
				$translationResult = '';
				$translateArray = $this->toBigPieces($text);
				
				
				foreach ($translateArray as $translateItem){
					$translationResult .= $this->translateYandex($translateItem, $from, $to, true);
				}
				
				return json_encode(array(
				'translations' => array(
				'0' => array(
				'text' => $translationResult)
				)
				)
				);
			}
			
			try {
				$cloud = TranslateSdk\Cloud::createApi($this->config->get('config_yandex_translate_api_key'));							
				} catch (TranslateSdk\Exception\ClientException $e) {
				echoLine($e->getMessage());
				die();
			}
			
			try {
				$translate = new TranslateSdk\Translate($text);
				$translate->setSourceLang($from)->setTargetLang($to)->setFormat(TranslateSdk\Format::HTML);
				$result = $cloud->request($translate);
				} catch (TranslateSdk\Exception\ClientException $e) {
				echoLine($e->getMessage());			
			}
			
			if ($returnString){
				$json = json_decode($result, true);
				if (!empty($json['translations']) && !empty($json['translations'][0]) && !empty($json['translations'][0]['text'])){
					return $json['translations'][0]['text'];
				}
			}
			
			
			return $result;
		}		
		
		public function updateAttributeTranslation($product_id, $attribute_id, $language_id, $text){										
			$this->db->query("UPDATE product_attribute SET text = '" . $this->db->escape($text) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "' AND attribute_id = '" . (int)$attribute_id . "'");
		}
		
		public function updateReviewTranslation($review_id, $language_id, $text, $field){										
			$this->db->query("UPDATE review_description SET `" . $field . "` = '" . $this->db->escape($text) . "' WHERE review_id = '" . (int)$review_id . "' AND language_id = '" . (int)$language_id . "'");
		}
		
		public function updateShopRatingTranslation($rate_id, $language_id, $text, $field){										
			$this->db->query("UPDATE shop_rating_description SET `" . $field . "` = '" . $this->db->escape($text) . "' WHERE rate_id = '" . (int)$rate_id . "' AND language_id = '" . (int)$language_id . "'");
		}
		
		public function updateDescriptionTranslation($product_id, $language_id, $text){										
			$this->db->query("UPDATE product_description SET description = '" . $this->db->escape($text) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
		}
		
		public function updateNameTranslation($product_id, $language_id, $text){										
			$this->db->query("UPDATE product_description SET name = '" . $this->db->escape($text) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
		}
		
		public function setTranslationMarker($product_id, $language_id, $marker = 1){										
			$this->db->query("UPDATE product_description SET translated = '" . (int)$marker . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
		}
		
		
		public function updateCollectionDescriptionTranslation($collection_id, $language_id, $text){										
			$this->db->query("UPDATE collection_description SET description = '" . $this->db->escape($text) . "' WHERE collection_id = '" . (int)$collection_id . "' AND language_id = '" . (int)$language_id . "'");
		}
	}					