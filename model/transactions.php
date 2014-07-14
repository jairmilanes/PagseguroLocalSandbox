<?php
class TransactionsModel extends SandboxModel {
	
	public function __construct(){
		$this->setTablename('transactions');
		parent::__construct();
	}
	
	/**
	 * Gets a specific transaction by code
	 *
	 * @param string $code
	 */
	public function get($code, $return_array = false){
		try {
			return $this->conn->get_row( sprintf('SELECT * FROM %s WHERE code = "%s"', $this->getTablename(), $code), $return_array );
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Saves a new transaction to the database
	 *
	 * @param array $data
	 */
	public function save($data){
		try {
			return $this->conn->insert($this->getTablename(), $data);
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Gets all transactions from db
	 *
	 * @return array()
	 */
	public function getTransactions(){
		try {
			return $this->conn->get_rows(sprintf('SELECT code, xml, date FROM %s ORDER BY date LIMIT 100',$this->getTablename()));
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessages());
		}
		return array();
	}
	
	/**
	 * Removes a transaction from the db
	 *
	 * @param string $code
	 * @return boolean|number
	 */
	public function delete($code){
		try {
			return $this->conn->delete($this->getTablename(), array('code'=>$code));
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Updates a transaction
	 *
	 * @param array $data
	 * @param string $code
	 */
	public function update($xml, $code){
		
		try {
			return $this->conn->update($this->getTablename(), array('xml'=>$xml), array('code'=>$code));
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Sets a existing transaction status
	 *
	 * @param string $code
	 * @param string|status
	 */
	public function setStatus($code, $status){

		$transaction = $this->get($code);
	
		if( $transaction && validateHelper::validateStatus($status) ){
			$xml = simplexml_load_string($transaction->xml);
			$xml->status = $status;
				
			$xml_str = UtilsHelper::prepareXml($xml);
	
			return $this->update($xml_str, $code);
		}
		return false;
	}
	
	/**
	 * Removes all transactions from database
	 */
	public function removeAll(){
		try {
			$this->conn->query('BEGIN');
			$this->conn->query('DROP TABLE transactions');
			$this->conn->query('DROP TABLE notifications');
			$this->conn->query('DROP TABLE transaction_codes');
			$this->conn->query('DROP TABLE notification_status_history');
			$this->createTable('transactions');
			$this->createTable('notifications');
			$this->createTable('transaction_codes');
			$this->createTable('notification_status_history');
			$this->conn->query('COMMIT');

			return true;
		} catch( Exception $e ){
			$this->conn->query('ROLLBACK');
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}

	
}