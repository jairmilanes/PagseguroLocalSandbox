<?php
class NotificationStatusHistoryModel extends SandboxModel {
	
	public function __construct(){
		parent::__construct();
		$this->setTablename('notification_status_history');
	}

	public function insert($code, $status, $date = null){
		$data = array(
			'code' => $code,
			'status' => $status,
			'date' => ( is_null($date)? date('Y-m-d H:i:s') : $date )
		);
		try {
			return $this->conn->insert($this->getTablename(), $data );
		} catch( PDOException $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
	public function getByCode($code){
		$sql = 'SELECT code, status, date FROM %s WHERE code = "%s"';
		$rs = $this->conn->get_rows(sprintf($sql, $this->getTablename(), $code));
		if( !empty($rs)){
			return $rs;
		}
		return false;
	}
	
	
}