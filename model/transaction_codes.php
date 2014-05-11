<?php
class TransactionCodesModel extends SandboxModel {
	
	public function __construct(){
		$this->setTablename('transaction_codes');
		parent::__construct();
	}
	
	/**
	 * Saves a transaction request code
	 */
	public function save($transaction_code){
		$checkout_code = UtilsHelper::generateRandomString(32);
		$data = array(
				'code' => $checkout_code,
				'transaction_code' => $transaction_code
		);
		try {
			if( $this->conn->insert($this->getTablename(), $data) ){
				return $checkout_code;
			}
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Finds a transaction by checkout code
	 *
	 * @param string $code
	 * @return SimpleXMLElement|boolean
	 */
	public function getByCheckoutCode($code){
		$sql = sprintf('SELECT transaction_code FROM %s WHERE code = "%s"', $this->getTablename(), $code);
		$rs = $this->conn->get_row($sql);
		if( !empty( $rs ) ){
			$model = new TransactionsModel();
			$transaction = $model->get($rs->transaction_code);
			if( !empty($transaction) ){
				return simplexml_load_string($transaction->xml);
			}
		}
		return false;
	}
	
}