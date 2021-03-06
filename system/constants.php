<?php

//CLOUDFLARE
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) && $_SERVER["HTTP_CF_CONNECTING_IP"]) {
	$_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}


//CLI MODE
if (is_cli()){
	define('CLI_MODE', true);
} else {
	define('CLI_MODE', false);
}

//DEBUG
if ((isset($_GET['hello']) && $_GET['hello'] == 'world')){
	define('IS_DEBUG', true);
	define('DEV_ENVIRONMENT', true);
	define('DEBUGSQL', true);

} else {

	if (thisIsAjax()){
		define('IS_DEBUG', false);
		define('DEV_ENVIRONMENT', false);

	} elseif (is_cli()) {

		define('IS_DEBUG', true);
		define('DEV_ENVIRONMENT', false);

	} else {

		define('DEV_ENVIRONMENT', false);
		define('IS_DEBUG', false);
	}

	if (isset($_GET['hello']) && $_GET['hello'] == 'justsql'){
		define('DEBUGSQL', true);
	} else {
		define('DEBUGSQL', false);
	}
}


//WEBP
if (isset($_SERVER['HTTP_ACCEPT']) && isset($_SERVER['HTTP_USER_AGENT'])) {
	if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
		header('X-IMAGE-WEBP: TRUE');	
		define('WEBPACCEPTABLE', true);	
	} else {
		define('WEBPACCEPTABLE', false);	
	}
} else {
	define('WEBPACCEPTABLE', false);
}


//AVIF
if (isset($_SERVER['HTTP_ACCEPT']) && isset($_SERVER['HTTP_USER_AGENT'])) {
	if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/avif' ) !== false ) {	
		header('X-IMAGE-AVIF: TRUE');
		define('AVIFACCEPTABLE', true);	
	} else {
		define('AVIFACCEPTABLE', false);	
	}
} else {
	define('AVIFACCEPTABLE', false);
}

if (IS_DEBUG){
	error_reporting (E_ALL);	
	ini_set('display_errors', 1);
	} else {
	error_reporting (0);	
	ini_set('display_errors', 0);
}		

