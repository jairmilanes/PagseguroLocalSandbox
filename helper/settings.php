<?php
class SettingsHelper extends SandboxHelper {
	
	public static function save($params){
		
		$errors = array();
		
		if(!isset($params['token']) || empty($params['token']) ){
			$params['token']  = false;
		}
		
		if(!isset($params['domain']) || empty($params['domain']) ){
			$errors['domain'] = true;
		}
		if(!isset($params['notificationUrl']) || empty($params['notificationUrl']) ){
			$errors['notificationUrl'] = true;
		} else {
			$params['notificationUrl'] = self::cleanDomainNameFromUrl($params['domain'], $params['notificationUrl']);
		}
		if(!isset($params['redirectUrl']) || empty($params['redirectUrl']) ){
			$errors['redirectUrl'] = true;
		} else {
			$params['redirectUrl'] = self::cleanDomainNameFromUrl($params['domain'], $params['redirectUrl']);
		}

		if(!isset($params['port']) || empty($params['port']) ){
			$errors['port'] = true;
		}
		
		if(!isset($params['checkout_complete']) || empty($params['checkout_complete']) ){
			$params['checkout_complete'] = 'redirect';
		}
		
		if(!isset($params['fixed_redirect']) || $params['fixed_redirect'] !== 'on' ){
			$params['fixed_redirect'] = '0';
		} else {
			$params['fixed_redirect'] = '1';
		}

		if( count($errors) > 0 ){
			die(json_encode($errors));
		}

		$xml = new SimpleXMLElement('<config/>');
		$xml->email 			= @$params['email'];
		if( $params['token'] ){
			$xml->token 			= $params['token'];
		}
		$xml->domain 			= $params['domain'];
		$xml->notificationUrl 	= $params['notificationUrl'];
		$xml->fixed_redirect 	= $params['fixed_redirect'];
		$xml->redirectUrl 		= $params['redirectUrl'];
		$xml->port 				= $params['port'];
		$xml->checkout_complete = $params['checkout_complete'];

		$xml = UtilsHelper::prepareXml($xml);

		return self::saveConfigXml($xml);
		
	}
	
	public static function saveConfigXml($xml){
		$file_handle = fopen(BASE_PATH.'config.xml', 'w') or die("can't open log file");
		fwrite($file_handle, $xml);
		return fclose($file_handle);
	}
	
	protected static function cleanDomainNameFromUrl($domain, $url){
		$domain = preg_replace("/^(http:\/\/)*(https:\/\/)*(www.)*/is", "", $domain);
		$n = preg_replace("/^(http:\/\/)*(https:\/\/)*(www.)*/is", "", $url);
		return str_replace($domain, "", $n);
	}
}