<?php
class TransactionCodesModel extends SandboxModel {
	
	public function __construct(){
		$this->setTablename('transaction_codes');
		parent::__construct();
	}

	public function insert($payment){
		$data = array(
			'code' => $payment->s_code,
			'data' => serialize($payment),
			'dt_created' => date('Y/m/d H:i:s'),
			'dt_updated' => date('Y/m/d H:i:s')
		);
		try {
			return $this->conn->insert( $this->getTablename(), $data );
		} catch( Exception $e ){
			return false;
		}
	}
	
	public function getByCode($code){
		$sql = "SELECT data FROM %s WHERE code = \"%s\"";
		$rs = $this->conn->get_row( sprintf($sql, $this->getTablename(),$code) );
		return $rs;
	}
	
	public function search( $initDate, $finalDate, $page = 1, $perPage = 50){
		
		if( $page <= 1 ){
			$offset = 0;
		} else {
			$offset = $page * $perPage;
		}
		
		$sql = 'SELECT data 
				FROM %s
				WHERE 
					dt_created >= "%s"
					AND dt_created <= "%s"
				LIMIT %d, %d
				ORDER BY dt_created DESC';

		$sql = sprintf($sql, $this->getTablename(), $initDate, $finalDate, $offset, $perPage );
		$rs = $this->conn->get_rows($sql);
		if( false !== $rs ){
			$results = array();
			foreach( $rs as $transaction ){
				$d = unserialize($transaction->data);
				$results[] = $d;
			}
			return $results;
		}
		return array();
	}
	
	public function dump(){
		$sql = sprintf("DELETE FROM %s", $this->getTablename());
		try {
			if( $this->conn->query($sql) ){
				return $this->conn->query('VACUUM');
			}
		} catch(Exception $e){
			return false;	
		}
	}
}