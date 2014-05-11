<?php
class TransactionsHelper extends SandboxHelper {

	const TRANSACTION_CODE_LENGTH = 36;
	/**
	 * Generate  fake transaction
	 *
	 */
	public static function generateTransaction($order) {
	
		$items = self::getOrderItems($order);
			
		$xml = new SimpleXMLElement("<transaction/>");
	
		$xml->date = date("c");
		$code = UtilsHelper::generateRandomString(self::TRANSACTION_CODE_LENGTH);
		$xml->code = $code;
		if (isset($order['reference']))
			$xml->reference = $order['reference'];
	
		$xml->lastEventDate = date("c");
		$xml->paymentMethod->type = 1;
		$xml->paymentMethod->code = 101;
		$xml->grossAmount = number_format(UtilsHelper::calculateOrderTotal($items), 2, '.', '');
		$xml->discountAmount = "0.00";
		$xml->feeAmount = "0.00";
		$xml->netAmount = $xml->grossAmount;
		$xml->extraAmount = "0.00";
		$xml->installmentCount = 1;
		$xml->itemCount = count($items);
	
		$xml->type = 1;
		$xml->status = '1';
		// print items
		$itemsRoot = $xml->addChild("items");
		foreach ($items as $item) {
			$child = $itemsRoot->addChild("item");
			$child->id = $item["id"];
			$child->description = $item["description"];
			$child->quantity = $item["quantity"];
			$child->amount = number_format($item["amount"], 2, '.', '');
		}
	
		// sender
		$xml->sender->name = isset($order['senderName']) ? $order['senderName']: "Mauro Turm";
		$xml->sender->email = isset($order['senderEmail']) ? $order['senderEmail']: "mauro@mail.com";
		$xml->sender->phone->areaCode = isset($order['senderAreaCode']) ? $order['senderAreaCode']: "31";
		$xml->sender->phone->number = isset($order['senderPhone']) ? $order['senderPhone']: "55555555";
	
		// shipping
		$xml->shipping->address->street = isset($order['shippingAddressStreet']) ?
		$order['shippingAddressStreet'] : "Av. do Contorno";
		$xml->shipping->address->number = isset($order['shippingAddressNumber']) ?
		$order['shippingAddressNumber'] : "500";
		$xml->shipping->address->complement = isset($order['shippingAddressComplement']) ?
		$order['shippingAddressComplement']: "2o Andar";
		$xml->shipping->address->district = isset($order['shippingAddressDistrict']) ?
		$order['shippingAddressDistrict'] : "Funcionários";
		$xml->shipping->address->postalCode = isset($order['shippingAddressPostalCode']) ?
		$order['shippingAddressPostalCode']: "30110039";
		$xml->shipping->address->city = isset($order['shippingAddressCity']) ?
		$order['shippingAddressCity']: "Belo Horizonte";
		$xml->shipping->address->state = isset($order['shippingAddressState ']) ?
		$order['shippingAddressState '] : "MG";
		$xml->shipping->address->country = isset($order['shippingAddressCountry']) ?
		$order['shippingAddressCountry']: "BRA";
		$xml->shipping->type = 3;
		$xml->shipping->cost = "0.00";
	
		// write xml file with proper formatting
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		$dom->loadXML($xml->asXML());
	
		$data = array(
				'code' => $code,
				'xml' => $dom->saveXML(),
				'date' => date('Y-m-d H:i:s')
		);
	
		$model = new TransactionsModel();
		if( $model->save( $data ) ){
			return  $code;
		}
	
		return false;
	}
	
	/**
	 * Extract items from a transaction xml string
	 *
	 * @return array
	 */
	private static function getOrderItems($order) {
		$i = 1;
		$items = array();
		while (array_key_exists("itemAmount".$i, $order) && array_key_exists("itemQuantity".$i, $order)) {
			array_push($items, array("id" => $order["itemId".$i],
			"description" => $order["itemDescription".$i],
			"quantity" => $order["itemQuantity".$i],
			"amount" => $order["itemAmount".$i]));
			$i += 1;
		}
			
		return $items;
	}
}