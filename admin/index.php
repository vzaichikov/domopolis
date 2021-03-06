<?php
	
	ini_set('session.name', ini_get('session.name') . 'A');

	define('VERSION', '1.5.6.4');
	set_error_handler('error_handler');

	function loadJsonConfig($config){
		if (defined('DIR_SYSTEM')){
			$json = file_get_contents(DIR_SYSTEM . 'config/' . $config . '.json');
			} else {
			$json = file_get_contents(dirname(__FILE__) . '/../system/config/' . $config . '.json');
		}
		
		return json_decode($json, true);
	}	

	function is_cli(){
		return (php_sapi_name() === 'cli');
	}

	function echoLine($line){
		if (is_cli()){
			echo $line . PHP_EOL;
		}
	}
	
	//define DEBUG Session
	if (isset($_GET['hello']) && $_GET['hello'] == 'world'){
		define('IS_DEBUG', true);
		} else {
		
		if ($_SERVER['REMOTE_ADDR'] == '31.43.104.37' && $_SERVER['REMOTE_ADDR'] == '172.68.238.76' || $_SERVER['REMOTE_ADDR'] == '95.67.113.206' || $_SERVER['REMOTE_ADDR'] == '135.181.195.119'){
			define('IS_DEBUG', false);
			} else {
			define('IS_DEBUG', false);
		}
	}
	
	//find http host
	$httpHost 		= str_replace('www.', '', $_SERVER['HTTP_HOST']);
	$configFiles 	= loadJsonConfig('configs');	
	
	// Configuration	
	if (isset($configFiles[$httpHost])){		
		if (file_exists($configFiles[$httpHost])) {
			$configFile = $configFiles[$httpHost];
			require_once($configFiles[$httpHost]);
			} else {
			die ('no config file!');
		}
		
		} else {
		die ('ho config file assigned to host');
	}	

	if ($httpHost != parse_url(HTTPS_CATALOG, PHP_URL_HOST)){
		die('sorry');
	}
	
	if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == '1' || $_SERVER['HTTPS'])) || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https') || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'))) {	
		define('IS_HTTPS', true);			
		} else {
		define('IS_HTTPS', false);
	}
	
	require_once(DIR_SYSTEM . '../vendor/autoload.php');
	
	//VirtualQMOD
	//require_once('../vqmod/vqmod.php');
	//VQMod::bootup();
	require_once(DIR_SYSTEM . 'startup.php');
	
	// Application Classes
	require_once(DIR_SYSTEM . 'library/currency.php');
	require_once(DIR_SYSTEM . 'library/customer.php');
	require_once(DIR_SYSTEM . 'library/user.php');
	require_once(DIR_SYSTEM . 'library/weight.php');
	require_once(DIR_SYSTEM . 'library/length.php');
	require_once(DIR_SYSTEM . 'library/cart.php');
	require_once(DIR_SYSTEM . 'library/smsQueue.php');
	require_once(DIR_SYSTEM . 'library/mAlert.php');
	require_once(DIR_SYSTEM . 'library/pushQueue.php');
	require_once(DIR_SYSTEM . 'library/Bitrix24.php');
	require_once(DIR_SYSTEM . 'library/shortAlias.php');
	require_once(DIR_SYSTEM . 'library/sessionDBHandler.php');
	require_once(DIR_SYSTEM . 'library/PageCache.php');
	require_once(DIR_SYSTEM . 'library/hobotix/EmailBlackList.php');
	require_once(DIR_SYSTEM . 'library/hobotix/RainforestAmazon.php');
	require_once(DIR_SYSTEM . 'library/hobotix/PricevaAdaptor.php');
	require_once(DIR_SYSTEM . 'library/hobotix/simpleProcess.php');	
	
	// Registry
	$registry = new Registry();
	
	// Loader
	$loader = new Loader($registry);
	$registry->set('load', $loader);
	
	// Config
	$config = new Config();
	$registry->set('config', $config);
	
	// Database
	$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$registry->set('db', $db);
	
	// Settings
	$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");
	
	foreach ($query->rows as $setting) {
		if (!$setting['serialized']) {
			$config->set($setting['key'], $setting['value']);
			} else {		
			$config->set($setting['key'], unserialize($setting['value']));
		}
	}
	
	$configFilesPrefix = '';
	if (count($configFileExploded = explode('.', $configFile)) == 3){
		if (mb_strlen($configFileExploded[1]) == 2){
			$configFilesPrefix = trim($configFileExploded[1]);
		}
	}
	$registry->get('config')->set('config_config_file_prefix', $configFilesPrefix);
	
	
	// Url
	$url = new Url(HTTP_SERVER, $config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);	
	$registry->set('url', $url);
	
	// Log
	$log = new Log('php-errors-admin.log');
	$registry->set('log', $log);
	
	// smsQueue
	$smsQueue = new smsQueue($registry);
	$registry->set('smsQueue', $smsQueue);
	
	//pushQueue
	$pushQueue = new pushQueue($registry);
	$registry->set('pushQueue', $pushQueue);

	$pricevaAdaptor = new hobotix\PricevaAdaptor($registry);
	$registry->set('pricevaAdaptor', $pricevaAdaptor);
	
	
	if (IS_DEBUG){
		error_reporting (E_ALL);	
		ini_set('display_errors', 1);
		} else {
		error_reporting (0);	
		ini_set('display_errors', 0);
	}

	function error_handler($errno, $errstr, $errfile, $errline) {
		global $log, $config;
		
		switch ($errno) {
			case E_NOTICE:
			case E_USER_NOTICE:
			$error = 'Notice';
			break;
			case E_WARNING:
			case E_USER_WARNING:
			$error = 'Warning';
			break;
			case E_ERROR:
			case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
			default:
			$error = 'Unknown';
			break;
		}
		
		if (IS_DEBUG) {
			echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
		}
		
		
		//	debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		
		return true;
	}
	
	
	// Request
	$request = new Request();
	$registry->set('request', $request);
	
	// Response
	$response = new Response();
	$response->addHeader('Content-Type: text/html; charset=utf-8');
	$registry->set('response', $response); 
	
	// Cache
	$cache = new Cache();
	$registry->set('cache', $cache); 
	
	// Cache
	$PageCache = new PageCache(false);
	$registry->set('PageCache', $PageCache); 
	
	// Session
	$session = new Session();
	$registry->set('session', $session); 
	
	$mAlert = new mAlert($registry);
	$registry->set('mAlert', $mAlert);
	
	// shortAlias
	$shortAlias = new shortAlias($registry);
	$registry->set('shortAlias', $shortAlias);
	
	$Bitrix24 = new Bitrix24($registry);
	$registry->set('Bitrix24', $Bitrix24);
		
	$registry->set('mobileDetect', new Mobile_Detect);
	$registry->set('simpleProcess', new hobotix\simpleProcess());
	
	//?????????????????????? ??????????
	$languages = [];
	$languages_id_code_mapping = [];
	$query = $registry->get('db')->query("SELECT * FROM `language` WHERE status = '1'"); 

	foreach ($query->rows as $result) {
		$languages[$result['code']] = $result;
		$languages_id_code_mapping[$result['language_id']] = $result['code'];
	}

	//ALL LANGUAGES TO REGISTRY
	$registry->set('languages', $languages);
	$registry->set('languages_id_code_mapping', $languages_id_code_mapping);
	$registry->get('config')->set('config_language_id', $languages[$config->get('config_admin_language')]['language_id']);
	$registry->get('config')->set('config_rainforest_source_language_id', $languages[$registry->get('config')->get('config_rainforest_source_language')]['language_id']);
	
	// Language	
	$language = new Language($languages[$config->get('config_admin_language')]['directory'], $registry);
	$language->load($languages[$config->get('config_admin_language')]['filename']);	
	$registry->set('language', $language);
	

	$registry->set('document', new Document()); 		
	$registry->set('currency', new Currency($registry));		
	$registry->set('weight', new Weight($registry));
	$registry->set('length', new Length($registry));
	$registry->set('user', new User($registry));
	$registry->set('cart', new Cart($registry));
	$registry->set('openbay', new Openbay($registry));
	
	$emailBlackList = new hobotix\EmailBlackList($registry);
	$registry->set('emailBlackList', $emailBlackList);
			
	$rainforestAmazon = new hobotix\RainforestAmazon($registry);
	$registry->set('rainforestAmazon', $rainforestAmazon);
	
	// Customer
	$registry->set('customer', new Customer($registry));
	
	// Front Controller
	$controller = new Front($registry);
	
	// Login
	$controller->addPreAction(new Action('common/home/login'));
	
	// Permission
	$controller->addPreAction(new Action('common/home/permission'));
	
	// Router
	if (isset($request->get['route'])) {
		$action = new Action($request->get['route']);
		} else {
		$action = new Action('common/home');
	}
	
	// Dispatch
	$controller->dispatch($action, new Action('error/not_found'));
	
	// Output
	$response->output();