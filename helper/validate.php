<?php
class validateHelper extends SandboxHelper {
	
	private static $required_data = array(
			"token",
			"currency",
			"email",
			"itemId1",
			"itemDescription1",
			"itemQuantity1",
			"itemAmount1",
			"redirectURL"
	);
	
	/**
	 * Validates required pagseguro params
	 *
	 * @return multitype:|string
	 */
	public static function validateParams() {
		if (!$this->order)
			return array();
	
		$missing_params = array();
		foreach ($this->required_data as $key) {
			if (!array_key_exists($key, $this->order))
				array_push($missing_params, $key);
		}
	
		return implode(", ", $missing_params);
	}
	
	
	public static function validateStatus($status){
		$transaction_possible_status = UtilsHelper::getStatusArray();
		$staus_codes = UtilsHelper::getStatus((string)$status);
		return  !empty($staus_codes); //   array_key_exists((string)$status, self::transaction_possible_status);
	}
	
	public static function isValidToken($token){
		$localToken = ConfigHelper::getInstance()->get('token');
		if( $token !== $localToken ){
			return false;
		}
		return true;
	}
	
	public static function isValidEmail($email){
		$localEmail = ConfigHelper::getInstance()->get('email');
		if( $email !== $localEmail ){
			return false;
		}
		return true;
	}
	
	public static function isValidUser($token, $email){
		if( !self::isValidToken($token) || self::isValidEmail($email)){
			return false;
		}
		return true;
	}
}