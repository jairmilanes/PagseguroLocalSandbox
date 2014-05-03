<?php 
define( 'BASE_PATH', realpath(dirname(__FILE__)).'/' );

if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
	define( 'PAGSEGURO_WS', 'https://ws.pagseguro.uol.com.br');
}else{
	define( 'PAGSEGURO_WS', 'http://ws.pagseguro.uol.com.br');
}

define( 'BASE_URL', PAGSEGURO_WS);

define( 'PAGSEGURO_WS_CHECKOUT', 		PAGSEGURO_WS.'/v2/checkout/');
define( 'PAGSEGURO_WS_TRANSACTIONS', 	PAGSEGURO_WS.'/v2/transactions/');
define( 'PAGSEGURO_WS_NOTIFICATIONS', 	PAGSEGURO_WS_TRANSACTIONS.'notifications/');

require BASE_PATH.'lib/PagSeguroSandBox.php';
require BASE_PATH.'lib/PagSeguroLibrary.php';

$action = 'index';
if( isset($_GET['action'])){
	$action = $_GET['action'];
}

$sandbox = new PagSeguroSandBox();

switch( $action ){
	case 'notify':
		$sandbox->notify();
		break;
	case 'checkout':
		$sandbox->checkout();
		break;
	case 'view':
		$sandbox->view();
		break;
	case 'refresh':
		$sandbox->refresh();
		break;
	case 'settings':
		$sandbox->settings();
		break;
	case 'delete':
		$sandbox->remove();
		break;
	case 'search':
		if( $_GET['by'] == 'transaction' ){
			$sandbox->searchTransaction();
		} else if( $_GET['by'] == 'notification' ){
			$sandbox->searchNotification();
		}
		break;
	default:
		$sandbox->sandbox();
		break;
}
?>