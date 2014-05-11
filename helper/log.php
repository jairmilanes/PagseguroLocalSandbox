<?php
class LogHelper extends SandboxHelper {
	
	protected static $instance;
	
	protected $logfile;
	
	public function __construct(){
		$this->logfile = BASE_PATH.'logs/error.log';
	}
	
	public static function getInstance(){
		if( !self::$instance instanceof self ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Simple log method
	 *
	 * @param string $msg
	 * @return boolean
	 */
	public function log($msg){
		$msg = $msg."\r\n\r\n";
		$file_handle = fopen($this->logfile, 'w') or die("can't open log file");
		fwrite($file_handle, $msg);
		fclose($file_handle);
		return true;
	}
}