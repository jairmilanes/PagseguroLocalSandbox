<?php
class TransactionsHelper extends SandboxHelper {

	const TRANSACTION_CODE_LENGTH = 36;
	/**
	 * Generate  fake transaction
	 *
	 */
	public static function generateTransaction($order) {
	
		$checkout = $order['checkout'];
		$items = @$checkout['items'];
			
		$xml = new SimpleXMLElement("<transaction/>");
	
		$xml->date = date("c");
		$code = UtilsHelper::generateRandomString(self::TRANSACTION_CODE_LENGTH);
		$xml->code = $code;
		if (isset($checkout['reference']))
			$xml->reference = $checkout['reference'];
	
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
		$sender = @$checkout['sender'];
		$xml->sender->name = isset($sender['name']) ? $sender['name']: "Mauro Turm";
		$xml->sender->email = isset($sender['email']) ? $sender['email']: "mauro@mail.com";
		$xml->sender->phone->areaCode = isset($sender['phone']['areaCode']) ? $sender['phone']['areaCode']: "31";
		$xml->sender->phone->number = isset($sender['phone']['number']) ? $sender['phone']['number']: "55555555";
	
		// shipping
		$shipping = @$checkout['shipping'];
		$xml->shipping->address->street = isset($shipping['address']['street']) ?
		$shipping['address']['street'] : "Av. do Contorno";
		$xml->shipping->address->number = isset($shipping['address']['number']) ?
		$shipping['address']['number'] : "500";
		$xml->shipping->address->complement = isset($shipping['address']['complement']) ?
		$shipping['address']['complement']: "2o Andar";
		$xml->shipping->address->district = isset($shipping['address']['district']) ?
		$shipping['address']['district'] : "Funcionários";
		$xml->shipping->address->postalCode = isset($shipping['address']['postalCode']) ?
		$shipping['address']['postalCode']: "30110039";
		$xml->shipping->address->city = isset($shipping['address']['city']) ?
		$shipping['address']['city']: "Belo Horizonte";
		$xml->shipping->address->state = isset($shipping['address']['state']) ?
		$shipping['address']['state'] : "MG";
		$xml->shipping->address->country = isset($shipping['address']['country']) ?
		$shipping['address']['country']: "BRA";
		$xml->shipping->type = isset($shipping['type']) ? $shipping['type']: 3;
		$xml->shipping->cost = isset($shipping['cost']) ? $shipping['cost']: "0.00";
	
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
}