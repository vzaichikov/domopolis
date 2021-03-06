<?

namespace hobotix\Amazon;

class InfoUpdater
{

	const CLASS_NAME = 'hobotix\\Amazon\\InfoUpdater';

	private $db;	
	private $config;
	private $lengthCache = false;
	private $weightCache = false;	

	private $removeFromName = [
		'N/A',
		'1x',
		'1X',
		'включаючи ПДВ',
		'1 шт.',
		'1 шт'
	];

	private $removeFromReview = [
		'Читайте далі',
		'читайте далі',
		'Читати далі',
		'читати далі',
		'Докладно',
		'Lesen Sie weiter',
		'Sie weiter',
		'lessen Sie weiter',
		'продовжуйте читати'
	];

	public const descriptionsQueryLimit = 5000;

	private $rfClient;

	public function __construct($registry, $rfClient){

		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->log = $registry->get('log');
		$this->rfClient = $rfClient;
		$this->setDimensionsCache();

	}

	public function getTotalNames(){
		return $this->db->query("SELECT COUNT(*) as total FROM product_description WHERE language_id = '" . $this->config->get('config_language_id') . "' AND name <> ''")->row['total'];
	}

	public function getNames($start){
		$sql = "SELECT product_id, name, language_id FROM product_description WHERE name <> '' AND language_id = '" . $this->config->get('config_language_id') . "' ORDER BY product_id ASC limit " . (int)$start . ", " . (int)self::descriptionsQueryLimit;		
		$query = $this->db->ncquery($sql);

		return $query->rows;
	}

	public function normalizeProductReview($review){
		//Убираем все кавычки, и другие непонятные спецсимволы, из-за них потом проблемы
		$review = str_replace(['"', ',,', '?'], '', $review);

		//Кавычки и другие символы, одинарная кавычка только с пробелом, потому что иначе это апостроф
		$review = str_replace(["&amp;", "' ", "( "], ['&', ' ', '('], $review);

		//Упоминания Amazon
		$review = str_ireplace(["Amazon", "amazon", "Амазон"], ['Domopolis'], $review);

		//Кавычка в начале - точно не апостроф
		$review = ltrim($review, "'");

		//Заданные строки
		$review = str_ireplace($this->removeFromReview, [''], $review);
		
		//Убрать всё остальное кроме нужных букв, цифр и символов
		$review = preg_replace('/[^a-zA-Z0-9а-щА-ЩЬьЮюЯяЇїІіЄєҐґ()\-,&Ø\'\.\/\* ]/mui', '', $review, -1);

		//Убираем двойные пробелы
		$review = str_replace(['  '], [' '], $review);
		$review = trim($review);

		$review = trim($review);

		return $review;

	}
	
	public function normalizeProductName($name){
		echoLine('[InfoUpdater] O: ' . $name);
		//Убираем все кавычки, и другие непонятные спецсимволы, из-за них потом проблемы
		$name = str_replace(['"', ',,', '?'], '', $name);

		//Кавычки и другие символы, одинарная кавычка только с пробелом, потому что иначе это апостроф
		$name = str_replace(["&amp;", "' ", "( "], ['&', ' ', '('], $name);

		//Кавычка в начале - точно не апостроф
		$name = ltrim($name, "'");

		//Заданные строки
		$name = str_ireplace($this->removeFromName, [''], $name);
		
		//Убрать всё остальное кроме нужных букв, цифр и символов
		$name = preg_replace('/[^a-zA-Z0-9а-щА-ЩЬьЮюЯяЇїІіЄєҐґ()\-,&Ø\'\.\/\* ]/mui', '', $name, -1);

		//Убираем двойные пробелы
		$name = str_replace(['  '], [' '], $name);
		$name = trim($name);

		//Находим первое вхождение кириллических символов или цифр
		$cyrfirst = strpbrk($name, 'АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя0123456789абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ');
		
		//Если есть, то обрезаем строку с начала до конца (типа убираем латиницу из начала)
		if ($cyrfirst){
			$name = $cyrfirst;
		}

		//Обрезать пробелы
		$name = trim($name);

		//Первая буква - большая, функция своя, в хелпере utf8
		$name = \mb_ucfirst($name);
		
		//Логика штук
		$array_from = [];
		$array_to	= [];
		for($i=100; $i>=2; $i--){
			$array_from[] = $i . ' шт';
			$array_from[] = $i . 'шт';
			$array_from[] = $i . ' штук';
			$array_from[] = $i . 'X ';
			$array_from[] = $i . 'x ';

			$array_to[]   = $i . ' ' . ' шт. ';
			$array_to[]   = $i . ' ' . ' шт. ';
			$array_to[]   = $i . ' ' . ' шт. ';
			$array_to[]   = $i . ' ' . ' шт. ';
			$array_to[]   = $i . ' ' . ' шт. ';			
		}

		$name = str_ireplace($array_from, $array_to, $name);
		$name = str_replace(['..'], ['.'], $name);		
		$name = str_replace(['. .'], ['.'], $name);
		$name = str_replace(['  '], [' '], $name);

		echoLine('[InfoUpdater] N: ' . $name);

		return $name;
	}


	public function setProductIsFilledFromAmazon($product_id){
		$this->db->query("UPDATE product SET filled_from_amazon = 1 WHERE product_id = '" . (int)$product_id . "'");

		return $this;
	}

	public function enableProduct($product_id){
		$this->db->query("UPDATE product SET status = 1 WHERE product_id = '" . (int)$product_id . "' AND filled_from_amazon = 1 AND product_id IN (SELECT product_id FROM product_to_category WHERE category_id IN (SELECT category_id FROM category WHERE status = 1))");

		return $this;
	}

	public function setDescriptionIsFilledFromAmazon($product_id){
		$this->db->query("UPDATE product SET description_filled_from_amazon = 1 WHERE product_id = '" . (int)$product_id . "'");

		return $this;
	}

	public function deleteLoadedAmazonData($asin){
		$this->db->query("DELETE FROM product_amzn_data WHERE asin LIKE ('" . $this->db->escape($asin) . "')");

		return $this;
	}

	public function createAsinCacheFileName($asin){
		$path      = 'asin/' . substr($asin,0,3) . '/' . substr($asin, 3, 3) . '/';
		$directory = DIR_CACHE . $path;

		if (!is_dir($directory)){
			mkdir($directory, 0775, true);
		}

		$filename  = $asin . '.json'; 

		return [
			'full' => $directory . $filename,
			'path' => $path . $filename
		];
	}

	public function putAsinDataToFileCache($asin, $json){

		$file = $this->createAsinCacheFileName($asin);
		file_put_contents($file['full'], $json);

		return $file['path'];

	}

	public function updateProductAmznData($product, $updateDimensions = true){
		
		if ($this->config->get('config_enable_amazon_asin_file_cache')){

			$file = $this->putAsinDataToFileCache($product['asin'], $product['json']);

			$sql = "INSERT INTO product_amzn_data SET
			product_id = '" . (int)$product['product_id'] . "', 
			asin = '" . $this->db->escape($product['asin']) . "',
			file = '" . $this->db->escape($file) . "',
			json = NULL
			ON DUPLICATE KEY UPDATE
			asin = '" . $this->db->escape($product['asin']) . "',
			file = '" . $this->db->escape($file) . "',
			json = NULL";

		} else {

			$sql = "INSERT INTO product_amzn_data SET
			product_id = '" . (int)$product['product_id'] . "', 
			asin = '" . $this->db->escape($product['asin']) . "',
			json = '" . $this->db->escape($product['json']) . "'
			ON DUPLICATE KEY UPDATE
			asin = '" . $this->db->escape($product['asin']) . "',
			json = '" . $this->db->escape($product['json']) . "'";

		}

		$this->db->query($sql);

		if ($updateDimensions){
			$this->parseAndUpdateProductDimensions($product['json']);
		}

		return $this;
	}

	public function setDimensionsCache(){
		if (!$this->weightCache) {
			$this->weightCache = [];

			$query = $this->db->query("SELECT * FROM weight_class WHERE 1");

			foreach ($query->rows as $row){
				$this->weightCache[$row['amazon_key']] = $row;
			}
		}

		if (!$this->lengthCache) {
			$this->lengthCache = [];

			$query = $this->db->query("SELECT * FROM length_class WHERE 1");

			foreach ($query->rows as $row){
				$this->lengthCache[$row['amazon_key']] = $row;
			}
		}
	}

	public function parseDimesionsString($string){
		$string = atrim($string);
		$exploded1 = explode(';', $string);

		if (count($exploded1) != 2){
			return false;
		}

		$exploded_length = explode('x', atrim($exploded1[0]));

		$exploded_weight_class = explode(' ', atrim($exploded1[1]));
		$exploded_length_class = explode(' ', atrim($exploded_length[2]));

		if (count($exploded_length) != 3 || count($exploded_weight_class) != 2 || count($exploded_length_class) != 2){
			return false;
		}

		$length_class_id = 0;
		$weight_class_id = 0;
		if (!empty($this->weightCache[atrim($exploded_weight_class[1])])){
			$weight_class_id = $this->weightCache[atrim($exploded_weight_class[1])]['weight_class_id'];
		}

		if (!empty($this->lengthCache[atrim($exploded_length_class[1])])){
			$length_class_id = $this->lengthCache[atrim($exploded_length_class[1])]['length_class_id'];
		}

		$weight = (float)atrim($exploded_weight_class[0]);
		if (!$weight_class_id){
			echoLine('Не найдена единица измерения веса: ' . atrim($exploded_weight_class[1]));
			$weight = 0;
		}

		$length = (float)atrim($exploded_length[0]);
		$width 	= (float)atrim($exploded_length[1]);
		$height = (float)atrim($exploded_length[2]);

		if (!$length_class_id){
			echoLine('Не найдена единица измерения размера: ' . atrim($exploded_length_class[1]));

			$length = 0;
			$width 	= 0;
			$height = 0;
		}

		return [
			'length' 			=> $length,
			'width' 			=> $width,
			'height' 			=> $height,
			'weight'			=> (float)atrim($exploded_weight_class[0]),
			'length_class_id' 	=> $length_class_id,
			'weight_class_id' 	=> $weight_class_id,
		];
	}

	public function parseAndUpdateProductDimensions($json){			

		if (!$json || empty($json['dimensions'])){
			return false;
		}

		if ($data = $this->parseDimesionsString($json['dimensions'])){			

		$this->db->query("UPDATE product SET
				length 					= '" . (float)$data['length'] . "',
				width					= '" . (float)$data['width'] . "',
				height					= '" . (float)$data['height'] . "',
				weight 					= '" . (float)$data['weight'] . "',
				length_class_id 		= '" . (int)$data['length_class_id'] . "',
				weight_class_id 		= '" . (int)$data['weight_class_id'] . "',
				pack_length 			= '" . (float)$data['length'] . "',
				pack_width				= '" . (float)$data['width'] . "',
				pack_height				= '" . (float)$data['height'] . "',
				pack_weight 			= '" . (float)$data['weight'] . "',
				pack_length_class_id 	= '" . (int)$data['length_class_id'] . "',
				pack_weight_class_id 	= '" . (int)$data['weight_class_id'] . "'
				WHERE asin = '" . $this->db->escape($json['asin']) . "'");

			return true;

		} else {

			echoLine($json['dimensions']);

		}

		return false;
	}

		//Работа с справочником товаров
	public function updateProductNotFoundOnAmazon($product_id){

		$this->db->query("UPDATE product SET amzn_not_found = 1 WHERE product_id = '" . $product_id . "'");			

		return $this;		
	}

	public function updateProductAmazonLastSearch($product_id){
		$this->db->query("UPDATE product SET amzn_last_search = NOW() WHERE product_id = '" . $product_id . "'");				

		return $this;
	}	

	public function setInvalidASIN($asin){
		$this->db->query("UPDATE product SET old_asin = asin WHERE asin = '" . $this->db->escape($asin) . "'");		
		$this->db->query("UPDATE product SET asin = 'INVALID' WHERE asin = '" .$this->db->escape($asin) . "'");

		return $this;
	}

	public function updateASINInDatabase($product){

		if ($product['asin'] == 'INVALID'){
			$this->db->query("UPDATE product SET old_asin = asin WHERE product_id = '" . $product['product_id'] . "'");
		}

		$this->db->query("UPDATE product SET asin = '" . $this->db->escape($product['asin']) . "' WHERE product_id = '" . $product['product_id'] . "'");				

		return $this;
	}						


	public function validateASINAndUpdateIfNeeded($product){

		if (empty($product['asin']) && empty($product['ean'])){
			return $product;
		}

		if (empty($product['asin'])){
			
			$rfRequests = [new \CaponicaAmazonRainforest\Request\ProductRequest($this->config->get('config_rainforest_api_domain_1'), null, ['customer_zipcode' => $this->config->get('config_rainforest_api_zipcode_1'), 'gtin' => $product['ean']])];
			$apiEntities = $this->rfClient->retrieveProducts($rfRequests);	

			if (!$apiEntities){
				return false;				
			}

			foreach ($apiEntities as $key => $rfProduct) {
				
				if ($rfProduct->getAsin()){

					$product['asin'] = $rfProduct->getAsin();						
					$this->updateASINInDatabase($product);

				}					
			}

		}


		return $product;
	}

}		