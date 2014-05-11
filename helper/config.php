<?php
class ConfigHelper extends SandboxHelper {
	
	protected static $instance;
	
	private $config;
	
	public function __construct(){
		$this->config = simplexml_load_file(BASE_PATH.'config.xml', 'SimpleXMLElement', LIBXML_NOEMPTYTAG );
		if( empty($this->config->token) ){
			$this->config->token = UtilsHelper::generateToken();
			SettingsHelper::saveConfigXml(UtilsHelper::prepareXml($this->config));
		}
	}
	
	public static function getInstance(){
		if( !self::$instance instanceof self ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function get($key){
		if( isset($this->config->$key)){
			return (string)$this->config->$key;
		}
		return false;
	}
	
	public function asArray()
	{
		return UtilsHelper::xml2array($this->config);
	}
	
	public function asXml(){
		return $this->config;
	}

}