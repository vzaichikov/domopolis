<?php
	
	function getAmazonDomainsList(){
		return [
		'amazon.com.br',
		'amazon.ca',
		'amazon.com.mx',
		'amazon.com',
		'amazon.cn',
		'amazon.in',
		'amazon.co.jp',
		'amazon.sg',
		'amazon.ae',
		'amazon.sa',
		'amazon.fr',
		'amazon.de',
		'amazon.it',
		'amazon.nl',
		'amazon.pl',
		'amazon.es',
		'amazon.se',
		'amazon.com.tr',
		'amazon.co.uk',
		'amazon.com.au'
		];
	}

	function atrim($string){	
		$string = preg_replace('/(\x{200e}|\x{200f})/u', '', $string);
		$string = str_replace(['"', '“', '„'], "'", $string);
		$string = trim($string);

		return $string;
	}

	function clean_string( $string ) {
   	 	$string = preg_replace( "/[^a-zA-ZА-Яа-я0-9\s]/", '', $string );

    	return $string;
	}

	function prepareEOLArray($string){
		$result = [];

		$array = explode(PHP_EOL, $string);

		foreach ($array as $line){
			if (trim($line) && mb_strlen(trim($line)) > 0){
				$result[] = trim($line);
			}
		}

		return $result;

	}

	//Функции для обратной совместимости, ебу я где они могут использоваться, но на всякий случай
	function simple_translit($string)
	{   		
		$from = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','і','є');
		$to = array('a','b','v','g','d','e','yo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sch','','y','','e','yu','ya','A','B','V','G','D','E','YO','ZH','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','KH','TS','CH','SH','SCH','','Y','','E','YU','YA','i','ie');

		return str_replace($from, $to, $string);
	}

	function simple_rm1($st){
		$st = str_replace('"','',$st);
		
		return $st;	
	}	

	function simple_rms($st)
	{
		$st = str_replace(',','',$st);
		$st = str_replace('’','',$st);
		$st = str_replace(' ','-',$st);
		$st = str_replace('"','',$st);
		$st = str_replace(')','',$st);
		$st = str_replace('(','',$st);
		$st = str_replace('.','',$st);
		$st = str_replace('+','',$st);
		$st = str_replace('*','',$st);
		$st = str_replace('“','',$st);
		$st = str_replace('”','',$st);
		$st = str_replace('&quot;','-',$st);
		$st = str_replace('&amp;','-and-',$st);
		$st = str_replace('&','-and-',$st);
		$st = str_replace('«','',$st);
		$st = str_replace('»','',$st);
		$st = str_replace('.','',$st);
		$st = str_replace('/','-',$st);
		$st = str_replace('\\','-',$st);
		$st = str_replace('%','-',$st);
		$st = str_replace('№','-',$st);
		$st = str_replace('#','-',$st);
		$st = str_replace('_','-',$st);
		$st = str_replace('–','-',$st);
		$st = str_replace('---','-',$st);
		$st = str_replace('--','-',$st);
		$st = str_replace('\'','',$st);
		$st = str_replace('!','',$st);
		return $st;
	}
	
	function simple_normalize($st){
		return strtolower(rms(translit($st)));
	} 
	
	function tryToGuessPageType($request){
	
		if (!empty($request['route'])){
		
			if ($request['route'] == 'product/product' && !empty($request['product_id'])){
				return 'product';
			}
		
			if ($request['route'] == 'product/category' && !empty($request['path'])){
				return 'category';
			}
		
		}
		
		return false;

	}

	if (!function_exists('is_cli')){
		function is_cli(){
			return (php_sapi_name() == 'cli');	
		}
	}

	if (!function_exists('echoLine')){
		function echoLine($line){
			if (is_cli()){
				echo $line . PHP_EOL;
			}
		}
	}
	
	function tryToGuessIfStringIsSKU($string){}
	
	function loadAndRenameCatalogModels($path, $className, $classNameTo){
		
		$modelCatalogProductContents = file_get_contents(DIR_CATALOG . $path);
		
		$modelCatalogProductContents = str_replace($className, $classNameTo, $modelCatalogProductContents);
		$modelCatalogProductContents = str_replace('<?php', '', $modelCatalogProductContents);
		$modelCatalogProductContents = str_replace('<?', '', $modelCatalogProductContents);
		
		eval($modelCatalogProductContents);
	}

	function loadAndRenameAnyModels($path, $className, $classNameTo){
		
		$modelCatalogProductContents = file_get_contents($path);
		
		$modelCatalogProductContents = str_replace($className, $classNameTo, $modelCatalogProductContents);
		$modelCatalogProductContents = str_replace('<?php', '', $modelCatalogProductContents);
		$modelCatalogProductContents = str_replace('<?', '', $modelCatalogProductContents);
		
		eval($modelCatalogProductContents);
	}
	
	function getFreeDeliveryInfo($shippingSettings){
		
		if (!empty($shippingSettings['sumrate'])){
			$exploded = explode(',', $shippingSettings['sumrate']);
			
			foreach ($exploded as $info){
				if (strpos($info, ':0') !== false){
					return (int)str_replace(':0', '', $info);
				}
			}
			
		}
		
		return PHP_INT_MAX;
	}
	
	function array_insert2(&$array, $pos, $insert)
	{
		$array = array_merge(array_slice($array, 0, $pos), [$insert], array_slice($array, $pos));
	}
	
	function reparseCartProductsByStock($products){
		$results = array(
		'in_stock' => array(),
		'not_in_stock' => array(),
		'certificates' => array(),	
		);
		
		foreach ($products as $product){
			if ($product['is_certificate']){
				
				$results['certificates'][] = $product;
				
				} elseif ($product['current_in_stock']){
				
				$results['in_stock'][] = $product;
				
				} else {
				
				$results['not_in_stock'][] = $product;
				
			}
		}
		
		return $results;
	}
	
	function addQueryArgs(array $args, string $url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			$urlParts = parse_url($url);
			if (isset($urlParts['query'])) {
				parse_str($urlParts['query'], $urlQueryArgs);
				$urlParts['query'] = http_build_query(array_merge($urlQueryArgs, $args));
				$newUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'] . '?' . $urlParts['query'];
				} else {
				$newUrl = $url . '?' . http_build_query($args);
			}
			return $newUrl;
			
			} else {
			return $url;
		}
	}

	function preparePhone($phone){

		if ($phone[0] == '+'){
			$phone = substr($phone, 1);			
		}
		$phone = '+' . preg_replace("/\D+/", "", $phone);

		return $phone;

	}
	
	function getPluralDays($number, $titles) {}
	
	
	function getUkrainianWeekDayDeclenced($weekday) {
		
		$array = array(
		1 => 'понеділок',
		2 => 'вівторок',
		3 => 'середу',
		4 => 'четвер',
		5 => "п'ятницю",
		6 => 'суботу',
		7 => 'неділю'
		);
		
		return $array[$weekday];
		
	}
	
	function getUkrainianPluralWord($number, $titles, $show_number = false) {
		if( is_string( $titles ) )
		$titles = preg_split( '/, */', $titles );
		
		// когда указано 2 элемента
		if( empty( $titles[2] ) )
		$titles[2] = $titles[1];
		
		$cases = [ 2, 0, 1, 1, 1, 2 ];
		
		$intnum = abs( (int) strip_tags( $number ) );
		
		$title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
		? 2
		: $cases[ min( $intnum % 10, 5 ) ];
		
		return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
	}
	
	
	function sortByOrder($a, $b){
		return $a["sort_order"] > $b["sort_order"];
	}
	
	function prepareFileName($filename){
		$filename = urlencode($filename);
		$filename = str_replace('+', ' ', $filename);
		
		return $filename;
	}
	
	function prepareFuckenOpenGraph($string){
		$string = strip_tags($string);
		$string = str_replace(PHP_EOL, ' ', $string);
		$string = str_replace('&nbsp;', ' ', $string);
		$string = str_replace('  ', ' ', $string);
		
		return $string;	
	}
	
	
	function getDeliveryCompany($delivery_code){
		
		$delivery_names = array(
		//украшка
		'dostavkaplus.sh3' => 'Новой Почтой',
		'dostavkaplus.sh4' => 'ТК ИнТайм',
		//рашка
		'dostavkaplus.sh5' => 'Почтой России ЕМS',
		'dostavkaplus.sh6' => 'ТК СДЭК',
		'dostavkaplus.sh7' => 'ТК СДЭК',
		//Белорашка
		'dostavkaplus.sh9' => 'Службой Vozim.by',
		);
		
		if (isset($delivery_names[$delivery_code])){
			return 	$delivery_names[$delivery_code];		
			} else {
			return "неизвестно";
		}
	}
	
	function prepareEcommPrice($price) : float{
		
		$hbprice = str_replace('.','',$price);
		$hbprice = str_replace(',','.',$hbprice);
		$hbprice = preg_replace("/[^0-9.]/", "", $hbprice);
		$hbprice = ltrim($hbprice,'.');
		$hbprice = rtrim($hbprice,'.');
		
		return (float)$hbprice;
	}
	
	function prepareEcommString($string){
		$string = str_replace('&amp;', '&', $string);
		$string = str_replace("'", "`", $string);
		$string = str_replace('"', "`", $string);
		
		return $string;
	}
	
	if (extension_loaded('mbstring')) {
		mb_internal_encoding('UTF-8');
		
		function utf8_strlen($string) {
			return mb_strlen($string);
		}
		
		function utf8_strpos($string, $needle, $offset = 0) {
			return mb_strpos($string, $needle, $offset);
		}
		
		function utf8_strrpos($string, $needle, $offset = 0) {
			return mb_strrpos($string, $needle, $offset);
		}
		
		function utf8_substr($string, $offset, $length = null) {
			if ($length === null) {
				return mb_substr($string, $offset, utf8_strlen($string));
				} else {
				return mb_substr($string, $offset, $length);
			}
		}
		
		function utf8_strtoupper($string) {
			return mb_strtoupper($string);
		}
		
		function utf8_strtolower($string) {
			return mb_strtolower($string);
		}
		} elseif (function_exists('iconv')) {
		function utf8_strlen($string) {
			return iconv_strlen($string, 'UTF-8');
		}
		
		function utf8_strpos($string, $needle, $offset = 0) {
			return iconv_strpos($string, $needle, $offset, 'UTF-8');
		}
		
		function utf8_strrpos($string, $needle) {
			return iconv_strrpos($string, $needle, 'UTF-8');
		}
		
		function utf8_substr($string, $offset, $length = null) {
			if ($length === null) {
				return iconv_substr($string, $offset, utf8_strlen($string), 'UTF-8');
				} else {
				return iconv_substr($string, $offset, $length, 'UTF-8');
			}
		}
		
		
		function utf8_strtolower($string) {
			static $upper_to_lower;
			
			if ($upper_to_lower == null) {
				$upper_to_lower = array(
				0x0041 => 0x0061,
				0x03A6 => 0x03C6,
				0x0162 => 0x0163,
				0x00C5 => 0x00E5,
				0x0042 => 0x0062,
				0x0139 => 0x013A,
				0x00C1 => 0x00E1,
				0x0141 => 0x0142,
				0x038E => 0x03CD,
				0x0100 => 0x0101,
				0x0490 => 0x0491,
				0x0394 => 0x03B4,
				0x015A => 0x015B,
				0x0044 => 0x0064,
				0x0393 => 0x03B3,
				0x00D4 => 0x00F4,
				0x042A => 0x044A,
				0x0419 => 0x0439,
				0x0112 => 0x0113,
				0x041C => 0x043C,
				0x015E => 0x015F,
				0x0143 => 0x0144,
				0x00CE => 0x00EE,
				0x040E => 0x045E,
				0x042F => 0x044F,
				0x039A => 0x03BA,
				0x0154 => 0x0155,
				0x0049 => 0x0069,
				0x0053 => 0x0073,
				0x1E1E => 0x1E1F,
				0x0134 => 0x0135,
				0x0427 => 0x0447,
				0x03A0 => 0x03C0,
				0x0418 => 0x0438,
				0x00D3 => 0x00F3,
				0x0420 => 0x0440,
				0x0404 => 0x0454,
				0x0415 => 0x0435,
				0x0429 => 0x0449,
				0x014A => 0x014B,
				0x0411 => 0x0431,
				0x0409 => 0x0459,
				0x1E02 => 0x1E03,
				0x00D6 => 0x00F6,
				0x00D9 => 0x00F9,
				0x004E => 0x006E,
				0x0401 => 0x0451,
				0x03A4 => 0x03C4,
				0x0423 => 0x0443,
				0x015C => 0x015D,
				0x0403 => 0x0453,
				0x03A8 => 0x03C8,
				0x0158 => 0x0159,
				0x0047 => 0x0067,
				0x00C4 => 0x00E4,
				0x0386 => 0x03AC,
				0x0389 => 0x03AE,
				0x0166 => 0x0167,
				0x039E => 0x03BE,
				0x0164 => 0x0165,
				0x0116 => 0x0117,
				0x0108 => 0x0109,
				0x0056 => 0x0076,
				0x00DE => 0x00FE,
				0x0156 => 0x0157,
				0x00DA => 0x00FA,
				0x1E60 => 0x1E61,
				0x1E82 => 0x1E83,
				0x00C2 => 0x00E2,
				0x0118 => 0x0119,
				0x0145 => 0x0146,
				0x0050 => 0x0070,
				0x0150 => 0x0151,
				0x042E => 0x044E,
				0x0128 => 0x0129,
				0x03A7 => 0x03C7,
				0x013D => 0x013E,
				0x0422 => 0x0442,
				0x005A => 0x007A,
				0x0428 => 0x0448,
				0x03A1 => 0x03C1,
				0x1E80 => 0x1E81,
				0x016C => 0x016D,
				0x00D5 => 0x00F5,
				0x0055 => 0x0075,
				0x0176 => 0x0177,
				0x00DC => 0x00FC,
				0x1E56 => 0x1E57,
				0x03A3 => 0x03C3,
				0x041A => 0x043A,
				0x004D => 0x006D,
				0x016A => 0x016B,
				0x0170 => 0x0171,
				0x0424 => 0x0444,
				0x00CC => 0x00EC,
				0x0168 => 0x0169,
				0x039F => 0x03BF,
				0x004B => 0x006B,
				0x00D2 => 0x00F2,
				0x00C0 => 0x00E0,
				0x0414 => 0x0434,
				0x03A9 => 0x03C9,
				0x1E6A => 0x1E6B,
				0x00C3 => 0x00E3,
				0x042D => 0x044D,
				0x0416 => 0x0436,
				0x01A0 => 0x01A1,
				0x010C => 0x010D,
				0x011C => 0x011D,
				0x00D0 => 0x00F0,
				0x013B => 0x013C,
				0x040F => 0x045F,
				0x040A => 0x045A,
				0x00C8 => 0x00E8,
				0x03A5 => 0x03C5,
				0x0046 => 0x0066,
				0x00DD => 0x00FD,
				0x0043 => 0x0063,
				0x021A => 0x021B,
				0x00CA => 0x00EA,
				0x0399 => 0x03B9,
				0x0179 => 0x017A,
				0x00CF => 0x00EF,
				0x01AF => 0x01B0,
				0x0045 => 0x0065,
				0x039B => 0x03BB,
				0x0398 => 0x03B8,
				0x039C => 0x03BC,
				0x040C => 0x045C,
				0x041F => 0x043F,
				0x042C => 0x044C,
				0x00DE => 0x00FE,
				0x00D0 => 0x00F0,
				0x1EF2 => 0x1EF3,
				0x0048 => 0x0068,
				0x00CB => 0x00EB,
				0x0110 => 0x0111,
				0x0413 => 0x0433,
				0x012E => 0x012F,
				0x00C6 => 0x00E6,
				0x0058 => 0x0078,
				0x0160 => 0x0161,
				0x016E => 0x016F,
				0x0391 => 0x03B1,
				0x0407 => 0x0457,
				0x0172 => 0x0173,
				0x0178 => 0x00FF,
				0x004F => 0x006F,
				0x041B => 0x043B,
				0x0395 => 0x03B5,
				0x0425 => 0x0445,
				0x0120 => 0x0121,
				0x017D => 0x017E,
				0x017B => 0x017C,
				0x0396 => 0x03B6,
				0x0392 => 0x03B2,
				0x0388 => 0x03AD,
				0x1E84 => 0x1E85,
				0x0174 => 0x0175,
				0x0051 => 0x0071,
				0x0417 => 0x0437,
				0x1E0A => 0x1E0B,
				0x0147 => 0x0148,
				0x0104 => 0x0105,
				0x0408 => 0x0458,
				0x014C => 0x014D,
				0x00CD => 0x00ED,
				0x0059 => 0x0079,
				0x010A => 0x010B,
				0x038F => 0x03CE,
				0x0052 => 0x0072,
				0x0410 => 0x0430,
				0x0405 => 0x0455,
				0x0402 => 0x0452,
				0x0126 => 0x0127,
				0x0136 => 0x0137,
				0x012A => 0x012B,
				0x038A => 0x03AF,
				0x042B => 0x044B,
				0x004C => 0x006C,
				0x0397 => 0x03B7,
				0x0124 => 0x0125,
				0x0218 => 0x0219,
				0x00DB => 0x00FB,
				0x011E => 0x011F,
				0x041E => 0x043E,
				0x1E40 => 0x1E41,
				0x039D => 0x03BD,
				0x0106 => 0x0107,
				0x03AB => 0x03CB,
				0x0426 => 0x0446,
				0x00DE => 0x00FE,
				0x00C7 => 0x00E7,
				0x03AA => 0x03CA,
				0x0421 => 0x0441,
				0x0412 => 0x0432,
				0x010E => 0x010F,
				0x00D8 => 0x00F8,
				0x0057 => 0x0077,
				0x011A => 0x011B,
				0x0054 => 0x0074,
				0x004A => 0x006A,
				0x040B => 0x045B,
				0x0406 => 0x0456,
				0x0102 => 0x0103,
				0x039B => 0x03BB,
				0x00D1 => 0x00F1,
				0x041D => 0x043D,
				0x038C => 0x03CC,
				0x00C9 => 0x00E9,
				0x00D0 => 0x00F0,
				0x0407 => 0x0457,
				0x0122 => 0x0123
				);
			}
			
			$unicode = utf8_to_unicode($string);
			
			if (!$unicode) {
				return false;
			}
			
			for ($i = 0; $i < count($unicode); $i++){
				if (isset($upper_to_lower[$unicode[$i]])) {
					$unicode[$i] = $upper_to_lower[$unicode[$i]];
				}
			}
			
			return unicode_to_utf8($unicode);
		}
		
		function utf8_strtoupper($string) {
			static $lower_to_upper;
			
			if ($lower_to_upper == null) {
				$lower_to_upper = array(
				0x0061 => 0x0041,
				0x03C6 => 0x03A6,
				0x0163 => 0x0162,
				0x00E5 => 0x00C5,
				0x0062 => 0x0042,
				0x013A => 0x0139,
				0x00E1 => 0x00C1,
				0x0142 => 0x0141,
				0x03CD => 0x038E,
				0x0101 => 0x0100,
				0x0491 => 0x0490,
				0x03B4 => 0x0394,
				0x015B => 0x015A,
				0x0064 => 0x0044,
				0x03B3 => 0x0393,
				0x00F4 => 0x00D4,
				0x044A => 0x042A,
				0x0439 => 0x0419,
				0x0113 => 0x0112,
				0x043C => 0x041C,
				0x015F => 0x015E,
				0x0144 => 0x0143,
				0x00EE => 0x00CE,
				0x045E => 0x040E,
				0x044F => 0x042F,
				0x03BA => 0x039A,
				0x0155 => 0x0154,
				0x0069 => 0x0049,
				0x0073 => 0x0053,
				0x1E1F => 0x1E1E,
				0x0135 => 0x0134,
				0x0447 => 0x0427,
				0x03C0 => 0x03A0,
				0x0438 => 0x0418,
				0x00F3 => 0x00D3,
				0x0440 => 0x0420,
				0x0454 => 0x0404,
				0x0435 => 0x0415,
				0x0449 => 0x0429,
				0x014B => 0x014A,
				0x0431 => 0x0411,
				0x0459 => 0x0409,
				0x1E03 => 0x1E02,
				0x00F6 => 0x00D6,
				0x00F9 => 0x00D9,
				0x006E => 0x004E,
				0x0451 => 0x0401,
				0x03C4 => 0x03A4,
				0x0443 => 0x0423,
				0x015D => 0x015C,
				0x0453 => 0x0403,
				0x03C8 => 0x03A8,
				0x0159 => 0x0158,
				0x0067 => 0x0047,
				0x00E4 => 0x00C4,
				0x03AC => 0x0386,
				0x03AE => 0x0389,
				0x0167 => 0x0166,
				0x03BE => 0x039E,
				0x0165 => 0x0164,
				0x0117 => 0x0116,
				0x0109 => 0x0108,
				0x0076 => 0x0056,
				0x00FE => 0x00DE,
				0x0157 => 0x0156,
				0x00FA => 0x00DA,
				0x1E61 => 0x1E60,
				0x1E83 => 0x1E82,
				0x00E2 => 0x00C2,
				0x0119 => 0x0118,
				0x0146 => 0x0145,
				0x0070 => 0x0050,
				0x0151 => 0x0150,
				0x044E => 0x042E,
				0x0129 => 0x0128,
				0x03C7 => 0x03A7,
				0x013E => 0x013D,
				0x0442 => 0x0422,
				0x007A => 0x005A,
				0x0448 => 0x0428,
				0x03C1 => 0x03A1,
				0x1E81 => 0x1E80,
				0x016D => 0x016C,
				0x00F5 => 0x00D5,
				0x0075 => 0x0055,
				0x0177 => 0x0176,
				0x00FC => 0x00DC,
				0x1E57 => 0x1E56,
				0x03C3 => 0x03A3,
				0x043A => 0x041A,
				0x006D => 0x004D,
				0x016B => 0x016A,
				0x0171 => 0x0170,
				0x0444 => 0x0424,
				0x00EC => 0x00CC,
				0x0169 => 0x0168,
				0x03BF => 0x039F,
				0x006B => 0x004B,
				0x00F2 => 0x00D2,
				0x00E0 => 0x00C0,
				0x0434 => 0x0414,
				0x03C9 => 0x03A9,
				0x1E6B => 0x1E6A,
				0x00E3 => 0x00C3,
				0x044D => 0x042D,
				0x0436 => 0x0416,
				0x01A1 => 0x01A0,
				0x010D => 0x010C,
				0x011D => 0x011C,
				0x00F0 => 0x00D0,
				0x013C => 0x013B,
				0x045F => 0x040F,
				0x045A => 0x040A,
				0x00E8 => 0x00C8,
				0x03C5 => 0x03A5,
				0x0066 => 0x0046,
				0x00FD => 0x00DD,
				0x0063 => 0x0043,
				0x021B => 0x021A,
				0x00EA => 0x00CA,
				0x03B9 => 0x0399,
				0x017A => 0x0179,
				0x00EF => 0x00CF,
				0x01B0 => 0x01AF,
				0x0065 => 0x0045,
				0x03BB => 0x039B,
				0x03B8 => 0x0398,
				0x03BC => 0x039C,
				0x045C => 0x040C,
				0x043F => 0x041F,
				0x044C => 0x042C,
				0x00FE => 0x00DE,
				0x00F0 => 0x00D0,
				0x1EF3 => 0x1EF2,
				0x0068 => 0x0048,
				0x00EB => 0x00CB,
				0x0111 => 0x0110,
				0x0433 => 0x0413,
				0x012F => 0x012E,
				0x00E6 => 0x00C6,
				0x0078 => 0x0058,
				0x0161 => 0x0160,
				0x016F => 0x016E,
				0x03B1 => 0x0391,
				0x0457 => 0x0407,
				0x0173 => 0x0172,
				0x00FF => 0x0178,
				0x006F => 0x004F,
				0x043B => 0x041B,
				0x03B5 => 0x0395,
				0x0445 => 0x0425,
				0x0121 => 0x0120,
				0x017E => 0x017D,
				0x017C => 0x017B,
				0x03B6 => 0x0396,
				0x03B2 => 0x0392,
				0x03AD => 0x0388,
				0x1E85 => 0x1E84,
				0x0175 => 0x0174,
				0x0071 => 0x0051,
				0x0437 => 0x0417,
				0x1E0B => 0x1E0A,
				0x0148 => 0x0147,
				0x0105 => 0x0104,
				0x0458 => 0x0408,
				0x014D => 0x014C,
				0x00ED => 0x00CD,
				0x0079 => 0x0059,
				0x010B => 0x010A,
				0x03CE => 0x038F,
				0x0072 => 0x0052,
				0x0430 => 0x0410,
				0x0455 => 0x0405,
				0x0452 => 0x0402,
				0x0127 => 0x0126,
				0x0137 => 0x0136,
				0x012B => 0x012A,
				0x03AF => 0x038A,
				0x044B => 0x042B,
				0x006C => 0x004C,
				0x03B7 => 0x0397,
				0x0125 => 0x0124,
				0x0219 => 0x0218,
				0x00FB => 0x00DB,
				0x011F => 0x011E,
				0x043E => 0x041E,
				0x1E41 => 0x1E40,
				0x03BD => 0x039D,
				0x0107 => 0x0106,
				0x03CB => 0x03AB,
				0x0446 => 0x0426,
				0x00FE => 0x00DE,
				0x00E7 => 0x00C7,
				0x03CA => 0x03AA,
				0x0441 => 0x0421,
				0x0432 => 0x0412,
				0x010F => 0x010E,
				0x00F8 => 0x00D8,
				0x0077 => 0x0057,
				0x011B => 0x011A,
				0x0074 => 0x0054,
				0x006A => 0x004A,
				0x045B => 0x040B,
				0x0456 => 0x0406,
				0x0103 => 0x0102,
				0x03BB => 0x039B,
				0x00F1 => 0x00D1,
				0x043D => 0x041D,
				0x03CC => 0x038C,
				0x00E9 => 0x00C9,
				0x00F0 => 0x00D0,
				0x0457 => 0x0407,
				0x0123 => 0x0122
				);
			}
			
			$unicode = utf8_to_unicode($string);
			
			if (!$unicode) {
				return false;
			}
			
			for ($i = 0; $i < count($unicode); $i++){
				if (isset($lower_to_upper[$unicode[$i]])) {
					$unicode[$i] = $lower_to_upper[$unicode[$i]];
				}
			}
			
			return unicode_to_utf8($unicode);
		}
		
		function utf8_to_unicode($string) {
			$unicode = array();
			
			for ($i = 0; $i < strlen($string); $i++) {
				$chr = ord($string[$i]);
				
				if ($chr >= 0 && $chr <= 127) {
					$unicode[] = (ord($string[$i]) * pow(64, 0));
				}
				
				if ($chr >= 192 && $chr <= 223) {
					$unicode[] = ((ord($string[$i]) - 192) * pow(64, 1) + (ord($string[$i + 1]) - 128) * pow(64, 0));
				}
				
				if ($chr >= 224 && $chr <= 239) {
					$unicode[] = ((ord($string[$i]) - 224) * pow(64, 2) + (ord($string[$i + 1]) - 128) * pow(64, 1) + (ord($string[$i + 2]) - 128) * pow(64, 0));
				}
				
				if ($chr >= 240 && $chr <= 247) {
					$unicode[] = ((ord($string[$i]) - 240) * pow(64, 3) + (ord($string[$i + 1]) - 128) * pow(64, 2) + (ord($string[$i + 2]) - 128) * pow(64, 1) + (ord($string[$i + 3]) - 128) * pow(64, 0));
				}
				
				if ($chr >= 248 && $chr <= 251) {
					$unicode[] = ((ord($string[$i]) - 248) * pow(64, 4) + (ord($string[$i + 1]) - 128) * pow(64, 3) + (ord($string[$i + 2]) - 128) * pow(64, 2) + (ord($string[$i + 3]) - 128) * pow(64, 1) + (ord($string[$i + 4]) - 128) * pow(64, 0));
				}
				
				if ($chr == 252 && $chr == 253) {
					$unicode[] = ((ord($string[$i]) - 252) * pow(64, 5) + (ord($string[$i + 1]) - 128) * pow(64, 4) + (ord($string[$i + 2]) - 128) * pow(64, 3) + (ord($string[$i + 3]) - 128) * pow(64, 2) + (ord($string[$i + 4]) - 128) * pow(64, 1) + (ord($string[$i + 5]) - 128) * pow(64, 0));
				}
			}
			
			return $unicode;
		}
		
		function unicode_to_utf8($unicode) {
			$string = '';
			
			for ($i = 0; $i < count($unicode); $i++){
				if ($unicode[$i] < 128){
					$string .= chr($unicode[$i]);
				}
				
				if ($unicode[$i] >= 128 && $unicode[$i] <= 2047) {
					$string .= chr(($unicode[$i] / 64) + 192) . chr(($unicode[$i] % 64) + 128);
				}
				
				if ($unicode[$i] >= 2048 && $unicode[$i] <= 65535) {
					$string .= chr(($unicode[$i] / 4096) + 224) . chr(128 + (($unicode[$i] / 64) % 64)) . chr(($unicode[$i] % 64) + 128);
				}
				
				if ($unicode[$i] >= 65536 && $unicode[$i] <= 2097151) {
					$string .= chr(($unicode[$i] / 262144) + 240) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
				}
				
				if ($unicode[$i] >= 2097152 && $unicode[$i] <= 67108863) {
					$string  .= chr(($unicode[$i] / 16777216) + 248) . chr((($unicode[$i] / 262144) % 64) + 128) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
				}
				
				if ($unicode[$i] >= 67108864 && $unicode[$i] <= 2147483647) {
					$string .= chr(($unicode[$i] / 1073741824) + 252) . chr((($unicode[$i] / 16777216) % 64) + 128) . chr((($unicode[$i] / 262144) % 64) + 128) . chr(128 + (($unicode[$i] / 4096) % 64)) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
				}
				
			}
			
			return $string;
		}
	}																					