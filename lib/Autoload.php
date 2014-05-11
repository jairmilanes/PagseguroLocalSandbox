<?php
define( 'BASE_PATH', realpath(dirname(__FILE__).'/../').'/' );

if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
	define( 'PAGSEGURO_WS', 'https://'.$_SERVER['HTTP_HOST']);
}else{
	define( 'PAGSEGURO_WS', 'http://'.$_SERVER['HTTP_HOST']);
}
define( 'BASE_URL', PAGSEGURO_WS.'/');

//define( 'PAGSEGURO_WS_CHECKOUT', 		PAGSEGURO_WS.'/v2/checkout/');
//define( 'PAGSEGURO_WS_TRANSACTIONS', 	PAGSEGURO_WS.'/v2/transactions/');
//define( 'PAGSEGURO_WS_NOTIFICATIONS', 	PAGSEGURO_WS_TRANSACTIONS.'notifications/');

require BASE_PATH.'lib/PagSeguroSandBox.php';
require BASE_PATH.'lib/Controller.php';
require BASE_PATH.'lib/Model.php';
require BASE_PATH.'lib/Helper.php';

/*** nullify any existing autoloads ***/
spl_autoload_register(null, false);

/*** specify extensions that may be loaded ***/
spl_autoload_extensions('.php');

/*** class Loader ***/
function LzPagseguroAutoloader($class)
{	
	$parts = preg_split('/(?=[A-Z])/',$class);
	$parts = array_filter($parts);

	$folder = array_pop($parts);

	$parts = array_map('strtolower', $parts);
	$filename = implode('_', $parts).'.php';

	$folder = BASE_PATH.strtolower($folder).'/';

	$file = $folder.$filename;
	
	if (!file_exists($file))
	{
		return false;
	}
	include $file;
}

/*** register the loader functions ***/
spl_autoload_register('LzPagseguroAutoloader');


if( !function_exists('printR')){
	function printR( $data, $exit = false ){
		echo'<pre>'.print_r($data, true ).'</pre>';
		if( $exit ) exit;
		return;
	}

}