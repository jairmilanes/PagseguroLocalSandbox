<?php
/*
 *************************************************************************
* The MIT License (MIT)
*
* Copyright (c) [2014] [Jair Milanes Junior]

* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
************************************************************************
*/

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