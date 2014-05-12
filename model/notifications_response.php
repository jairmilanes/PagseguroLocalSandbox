<?php
class NotificationsResponseModel extends SandboxModel {
	
	public function __construct(){
		parent::__construct();
		$this->setTablename('notifications_response');
	}

	public function insert($code, $response){
		$data = array(
			'code' => $code,
			'response' => $response
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
		$sql = 'SELECT code, response FROM %s WHERE code = "%s"';
		$rs = $this->conn->get_rows(sprintf($sql, $this->getTablename(), $code));
		if( !empty($rs)){
			return $rs;
		}
		return false;
	}
	
	
}