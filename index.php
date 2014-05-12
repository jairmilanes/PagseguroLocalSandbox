<?php
require_once 'lib/Autoload.php';

$action = 'index';
if( isset($_GET['action'])){
	$action = $_GET['action'];
}

$sandbox = new PagSeguroSandBox();

switch( $action ){
	/**
	 * SANDBOX INTERFACE
	 */
	// Generates a new notification request
	case 'notify':
		$sandbox->notify();
		break;
	// View a transaction information
	case 'view':
		$sandbox->view();
		break;
	// Refreshes transactins table
	case 'refresh':
		$sandbox->refresh();
		break;
	// Processes settings post
	case 'settings':
		$sandbox->settings();
		break;
	// Deletes a transaction
	case 'delete':
		$sandbox->remove();
		break;
	// Completly wipes the database record
	case 'wipe':
		$sandbox->removeAll();
		break;
	// Renders the help page
		break;
	case 'help':
		$sandbox->help();
		break;
			
	/**
	 * API INTERFACE
	 */
	// PAGSEGURO "/v2/checkout/ WS"
	case 'v2/checkout':
		$sandbox->v2Checkout();
		break;

	// PAGSEGURO "/v2/transactions/" WS
	case 'v2/transactions':
		$sandbox->v2Transactions();
		break;
	
	// PAGSEGURO "/v2/transactions/notifications/" WS
	case 'v2/transactions/notifications':
		$sandbox->v2TransactionsNotifications();
		break;
		
	// PAGSEGURO "/checkout/embedded/i-ck.html" LIGHT BOX API
	case 'checkout/embedded/i-ck':
		$sandbox->checkoutEmbeddedIck();
		
	// PAGSEGURO LIGHTBOX CONTENT
	case 'checkout_process':
		$sandbox->checkoutProcess();
		break;

	default:
		$sandbox->sandbox();
		break;
}
?>