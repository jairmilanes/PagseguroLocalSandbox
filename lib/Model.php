<?php
class SandboxModel {
	
	const LOG_FILE = 'logs/model.errors.log';
	
	/***** DM *****/
	const ORDER_TABLENAME 		   		= 'orders';
	const NOTIFICATIONS_TABLENAME  		= 'notifications';
	const TRANSACTIONS_TABLENAME   		= 'transactions';
	const TRANSACTION_CODES_TABLENAME   = 'transaction_codes';
	
	protected $tablename;
	
	protected $conn;
	
	public function __construct(){
		if( !class_exists('SQLite3Database') ){
			require BASE_PATH.'lib/SQLite3db.php';
		}
		$this->conn = new SQLite3Database(BASE_PATH.'pagseguro_sandbox.db');
		
	}
	
	/**
	 * @return the $tablename
	 */
	protected function getTablename() {
		return $this->tablename;
	}

	/**
	 * @return the $conn
	 */
	protected function getConn() {
		return $this->conn;
	}

	/**
	 * @param field_type $tablename
	 */
	protected function setTablename($tablename) {
		$this->tablename = $tablename;
	}

	/**
	 * @param SQLite3Database $conn
	 */
	protected function setConn($conn) {
		$this->conn = $conn;
	}
	
	/**
	 * Processes a specific db file from the sql folder
	 *
	 * @param string $name
	 * @return Ambigous <boolean, unknown, string>|boolean
	 */
	protected function createTable($name){
		$db_file = BASE_PATH.'lib/sql/'.strtolower($name).'.sql';
		if( file_exists($db_file)){
			$sql = file_get_contents($db_file);
			return $this->conn->query($sql);
		}
		return false;
	}
	
	/**
	 * Simple log method
	 *
	 * @param string $msg
	 * @return boolean
	 */
	protected function log($msg){
		$msg = $msg."\r\n\r\n";
		$file_handle = fopen(BASE_PATH.self::LOG_FILE, 'w') or die("can't open log file");
		fwrite($file_handle, $msg);
		fclose($file_handle);
		return true;
	}

}