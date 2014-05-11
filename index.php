<?php
require_once 'lib/Autoload.php';

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
	case 'checkout_process':
		$sandbox->checkoutProcess();
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
	case 'wipe':
		$sandbox->removeAll();
		break;
	case 'embedded':
		$sandbox->embedded();
		break;
	case 'help':
		$sandbox->help();
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