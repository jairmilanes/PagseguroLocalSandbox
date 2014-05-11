<?php
class RequestHelper extends SandboxHelper {

	/**
	 * Tests request type
	 *
	 * @param string $type
	 * @return boolean
	 */
	public static function isRequest($type){
		return strtoupper($_SERVER['REQUEST_METHOD']) == strtoupper($type) ? true : false;
	}
	
	/**
	 * Gets all request params
	 *
	 * @return array
	 */
	public static function getParams(){
		$data = array();
		if (!empty($_GET) || !empty($_POST)) {
			$data = array_merge($data, $_GET, $_POST);
		}
		return $data;
	}
	
	/**
	 * Gets a specific request param
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function getParam($name){
		$data = '';
		if (!empty($_GET[$name]) || !empty($_POST[$name])) {
			if (empty($_GET[$name]))
				$data = $_POST[$name];
			else
				$data = $_GET[$name];
		}
		return $data;
	}
	
	/**
	 * Simple curl request method
	 *
	 * @param string $url
	 * @param array $data
	 * @param string $type
	 * @return mixed
	 */
	public static function doRequest( $url, $data = array(), $type = 'get' ){
		$curl = curl_init();
		$opts = array();
	
		if( strtolower($type) == 'post' ){
			$opts[CURLOPT_POST] = true;
			if( !empty($data)){
				$opts[CURLOPT_POSTFIELDS] = http_build_query($data);
			}
		}
		$opts[CURLOPT_RETURNTRANSFER] = 1;
		$opts[CURLOPT_URL] = $url;
		$opts[CURLOPT_FOLLOWLOCATION] = 1;
	
	
		curl_setopt_array($curl, $opts);
		$result = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
			
		return $result;
	}
}