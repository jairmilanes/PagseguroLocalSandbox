<?php
class TestCheckoutHelper extends SandboxHelper {
	public static function get_checkout_params(){
		
		$order = array();
		$order['email'] 						= 'suporte@lojamodelo.com.br';
		$order['token'] 						= '95112EE828D94278BD394E91C4388F20';
		$order['currency'] 						= 'BRL';
		$order['reference'] 					= 'REF1234';
		$order['extraAmount'] 					= 'REF1234';
		$order['redirectURL'] 					= 'REF1234';
		$order['notificationURL'] 				= 'REF1234';
		$order['maxUses'] 						= 'REF1234';
		$order['maxAge'] 						= 'REF1234';
		
		$order['itemId1'] 						= '0001';
		$order['itemDescription1']  			= 'Notebook Prata';
		$order['itemAmount1'] 					= 24300.00;
		$order['itemQuantity1'] 				= 1;
		$order['itemWeight1'] 					= 1000;
		$order['itemId2'] 						= '0002';
		$order['itemDescription2']  			= 'Notebook Rosa';
		$order['itemAmount2'] 					= 25600.00;
		$order['itemQuantity2'] 				= 2;
		$order['itemWeight2'] 					= 750;
		
		$order['senderName'] 					= 'Jose Comprador';
		$order['senderAreaCode'] 				= '11';
		$order['senderPhone'] 					= '56273440';
		$order['senderEmail'] 					= 'comprador@uol.com.br';
		$order['senderBornDate'] 				= '12/03/1982';
		
		$order['shippingType'] 					= 1;
		$order['shippingAddressStreet'] 		= 'Av. Brig. Faria Lima';
		$order['shippingAddressNumber'] 		= '1384';
		$order['shippingAddressComplement'] 	= '5o andar';
		$order['shippingAddressDistrict'] 		= 'Jardim Paulistano';
		$order['shippingAddressPostalCode'] 	= '01452002';
		$order['shippingAddressCity'] 			= 'Sao Paulo';
		$order['shippingAddressState'] 			= 'SP';
		$order['shippingAddressCountry'] 		= 'BRA';
		
		return $order;
	}
}
	




