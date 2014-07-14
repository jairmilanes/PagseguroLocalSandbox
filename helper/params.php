<?php
class ParamsHelper extends  SandboxHelper {
	
	protected static $parsed = array();
	protected static $keys   = array('email', 'token', 'redirectURL', 'notificationURL', 'maxUses', 'maxAge', 'currency', 'item', 'reference', 'sender', 'shipping');
	
	public static function parse_checkout_params($params){
		self::$parsed = array();
		self::$parsed['checkout'] = array();
		//printR($params);
		foreach($params as $param => $value ){
			self::parse_param($param, $value);
		}
		$rs = self::$parsed;
		self::$parsed = array();
		return $rs;
	}
	
	protected static function find_checkout_key($param){
		$key = null;
		foreach( self::$keys as $k => $v ){
			if( false !== strpos($param, $v) ){
				$key = $v;
				break;
			}
		}
		return $key;
	}
	
	protected static function parse_param($param, $value){
		$key = self::find_checkout_key($param);
		if( $key ){
			switch($key){
				case 'charset':
				case 'token':
				case 'email':
					self::$parsed[$key] = $value;
					break;
				case 'redirectURL':
				case 'notificationURL':
				case 'maxUses':
				case 'maxAge':
				case 'currency':
				case 'reference':
					self::$parsed['checkout'][$key] = $value;
					break;
				case 'item':
					self::parse_items($key, $param, $value);
					break;
				case 'sender':
					self::parse_sender($key, $param, $value);
					break;
				case 'shipping':
					self::parse_shipping($key, $param, $value);
					break;
			}
		}
	}
	
	protected static function parse_sender($key, $param, $value){
		$var = str_replace($key,'',$param);
		$parts = preg_split('/(?=[A-Z])/', $var, -1, PREG_SPLIT_NO_EMPTY);
		$parts[0] = strtolower( $parts[0] );
		if( $parts[0] == 'phone' || $parts[0] == 'area' ){
		
			$child = ( $parts[0] == 'phone' )? 'number' : 'areaCode';
		
			if( !isset(self::$parsed['checkout'][$key]))
				self::$parsed['checkout'][$key] = array();
			if( !isset(self::$parsed[$key]['phone']))
				self::$parsed['checkout'][$key]['phone'] = array();
		
			self::$parsed['checkout'][$key]['phone'][$child] = $value;
		
		} else {
			self::$parsed['checkout'][$key][$parts[0]] = $value;
		}
	}
	
	protected static function parse_items($key, $param, $value){
		$var = str_replace($key,'',$param);
		$index = (int)(substr($var,-1,1)) - 1;
		
		if( !isset(self::$parsed['checkout']['items']))
			self::$parsed['checkout']['items'] = array();
		
		if( !isset(self::$parsed['checkout']['items'][$index]))
			self::$parsed['checkout']['items'][$index] = array();
		
		$var = strtolower(preg_replace('/[0-9]+/','', $var));
		self::$parsed['checkout']['items'][$index][$var] = $value;
	} 
	
	protected static function parse_shipping($key, $param, $value){
		
		$var = str_replace($key,'',$param);
		$parts = preg_split('/(?=[A-Z])/', $var, -1, PREG_SPLIT_NO_EMPTY);
		
		if( !isset(self::$parsed['checkout'][$key]))
			self::$parsed['checkout'][$key] = array();
		
		$parts[0] = strtolower( $parts[0] );

		switch($parts[0]){
			case 'type':
			case 'cost':
				self::$parsed['checkout'][$key][$parts[0]] = $value;
				break;
			case 'address':
				$address_key = strtolower(array_shift($parts));
		
				if( !isset(self::$parsed['checkout'][$key][$address_key])){
					self::$parsed['checkout'][$key][$address_key] = array();
				}
				$parts[0] = strtolower($parts[0]);
				$parts = implode('',$parts);
				self::$parsed['checkout'][$key][$address_key][$parts] = $value;
				break;
		}
	}
	
}