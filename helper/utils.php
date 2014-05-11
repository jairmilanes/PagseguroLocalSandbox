<?php
class UtilsHelper extends SandboxHelper {
	
	/**
	 * Generates a snadbox action url
	 *
	 * @param action $action
	 * @return string
	 */
	public static function url($action){
		return BASE_URL.'?action='.$action;
	}
	
	/**
	 * Generates a random pagseguro like token
	 *
	 * @param number $length
	 * @return string
	 */
	public static function generateToken() {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVXYZ';
		$randomString = '';
		for ($i = 0; $i < 32; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	/**
	 * Generates a random string given it´s length
	 *
	 * @param number $length
	 * @return string
	 */
	public static function generateRandomString($length) {
		$characters = '0123456789ABCDEF-';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	/**
	 * Gets current hostname
	 *
	 * @return string
	 */
	public static function getCurrentHost() {
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		return $host.$uri;
	}
	
	/**
	 * Prepares a simple xml string with Dom
	 *
	 * @param SimpleXMLElement $xml
	 * @return string
	 */
	public static function prepareXml($xml){
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		$dom->loadXML($xml->asXML());
		return $dom->saveXML();
	}
	
	/**
	 * Returns the name of a payment method given it´s code
	 *
	 * @param string $method
	 * @return Ambigous <string>|string
	 */
	public static function translatePaymentMethod($method){
		$methods = array(
				"101" => "101 - Cartão de crédito Visa",
				"102" => "102 - Cartão de crédito MasterCard",
				"103" => "103 - Cartão de crédito American Express",
				"104" => "104 - Cartão de crédito Diners",
				"105" => "105 - Cartão de crédito Hipercard",
				"106" => "106 - Cartão de crédito Aura",
				"107" => "107 - Cartão de crédito Elo",
				"108" => "108 - Cartão de crédito PLENOCard",
				"109" => "109 - Cartão de crédito PersonalCard",
				"110" => "110 - Cartão de crédito JCB",
				"111" => "111 - Cartão de crédito Discover",
				"112" => "112 - Cartão de crédito BrasilCard",
				"113" => "113 - Cartão de crédito FORTBRASIL",
				"114" => "114 - Cartão de crédito CARDBAN",
				"115" => "115 - Cartão de crédito VALECARD",
				"116" => "116 - Cartão de crédito Cabal",
				"117" => "117 - Cartão de crédito Mais!",
				"118" => "118 - Cartão de crédito Avista",
				"119" => "119 - Cartão de crédito GRANDCARD",
				"120" => "120 - Cartão de crédito Sorocred",
				"202" => "202 - Boleto Santander",
				"301" => "301 - Débito online Bradesco",
				"302" => "302 - Débito online Itaú",
				"304" => "304 - Débito online Banco do Brasil",
				"306" => "306 - Débito online Banrisul",
				"307" => "307 - Débito online HSBC",
				"401" => "401 - Saldo PagSeguro",
				"701" => "701 - Depósito em conta - Banco do Brasil",
				"702" => "702 - Depósito em conta - HSBC"
		);
	
		if( array_key_exists((string)$method, $methods)){
			return $methods[$method];
		}
		return '';
	}
	
	/**
	 * Returns the name of a payment type give it´s code
	 *
	 * @param string $type
	 * @return Ambigous <string>|string
	 */
	public static function translatePaymentType($type){
		$types = array(
				"1" => "1 - Cartão de crédito",
				"2" => "2 - Boleto",
				"3" => "3 - Débito online (TEF)",
				"4" => "4 - Saldo PagSeguro",
				"5" => "5 - Oi Paggo",
				"7" => "7 - Depósito em conta"
		);
		if( array_key_exists((string)$type, $types)){
			return $types[$type];
		}
		return '';
	}
	
	public static function getStatusArray(){
		return array(
				"1" => "Aguardando pagamento",
				"2" => "Em análise",
				"3" => "Paga",
				"4" => "Disponível",
				"5" => "Em disputa",
				"6" => "Devolvida",
				"7" => "Cancelada",
		);
	}
	
	public static function getStatus($status){
		$array = self::getStatusArray();
		if( isset( $array[$status])){
			return $array[$status];
		}
		return '';
	}
	
	/**
	 * Converts a status numer to a readable string
	 *
	 * @param string|number $status
	 * @return string
	 */
	public static function getStatusString($status){
		$status = self::getStatus((string)$status);
		return ( !empty($status) )? $status : false;
	}
	
	/**
	 * Gets a status class to use in html for colorcoded status
	 *
	 * @param string|number $status
	 * @param string $type
	 * @return string
	 */
	public static function getStatusClass($status, $type = 'btn'){
		$classes = array(
				"1" => $type."-info",
				"2" => $type."-info",
				"3" => $type."-success",
				"4" => $type."-info",
				"5" => $type."-warning",
				"6" => $type."-primary",
				"7" => $type."-danger"
		);
		if( array_key_exists((string)$status, $classes)){
			return $classes[(string)$status];
		}
		return '';
	}
	
	
	/**
	 * Cauculates the total of this transaction
	 *
	 * @param array $items
	 * @return number
	 */
	public static function calculateOrderTotal($items) {
		$total = 0;
		foreach ($items as $item)
			$total += $item['amount']*$item['quantity'];
			
		return $total;
	}
	
	public static function xml2array ( $xmlObject, $out = array () )
	{
		foreach ( (array) $xmlObject as $index => $node )
			$out[$index] = ( is_object ( $node ) ) ? self::xml2array( $node ) : $node;
	
		return $out;
	}
	
	public static function newDOM(){
		// write xml file with proper formatting
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		return $dom;
	}
}