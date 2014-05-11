<?php
class ResponseHelper extends SandboxHelper {
	
	protected $path;
	
	protected $data;
	
	protected static $instance;

	public function __construct(){
		$this->path = BASE_PATH.'view/';
	}
	
	public static function getInstance(){
		if( !self::$instance instanceof self ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function render($filename, $data = array() ){
		$this->data = $data;
		$file = $this->getFilename($filename);
		if( file_exists($file)){
			require $file;
		}
		die('');
	}
	
	public function renderXml($xml, $encoding = 'UTF-8', $status = 200){
		http_response_code($status);
		header ("Content-Type:text/xml charset=$encoding");
		die($xml);
	}
	
	public function renderJson($array){
		header ("Content-Type:text/json");
		die(json_encode($array));
	}
	
	public function do301(){
		http_response_code(301);
		die('Moved Permanently');
	}
	
	public function do404page($msg){
		$this->render('404');
	}
	
	public function do404($msg){
		http_response_code(404);
		die(( is_null($msg)? 'Not Found': $msg ));
	}
	
	public function do401($msg = null ){
		http_response_code(401);
		die(( is_null($msg)? 'Unauthorized': $msg ));
	}
	
	public function do400($msg = null){
		http_response_code(400);
		die(( is_null($msg)? 'Bad Request': $msg ));
	}
	
	public function do200($msg = null){
		http_response_code(200);
		die(( is_null($msg)? 'OK': $msg ));
	}

	public function getData($key = null){
		if(!is_null($key)){
			if( isset($this->data[$key])){
				return $this->data[$key];
			}
			return false;
		}
		return $this->data;
	}
	
	private function getFilename($filename){
		return $this->path.$filename.'.php';
	}
}