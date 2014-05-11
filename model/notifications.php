<?php
class NotificationsModel extends SandboxModel {
	
	public function __construct(){
		parent::__construct();
		$this->setTablename('notifications');
	}
	
	/**
	 * Saves a new notification
	 *
	 * @param array $data
	 */
	public function save($data){
		try {
			return $this->conn->insert($this->getTablename(), $data );
		} catch( PDOException $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}

	/**
	 * Deletes a notification
	 *
	 * @param string $id
	 */
	public function delete($id){
		try {
			return $this->conn->delete($this->getTablename(), array('id' => $id ) );
		}
		catch( PDOException $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
		}
		catch( Exception $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
		}
		return false;
	}
	
	/**
	 * Deletes a notification by transaction code
	 *
	 * @param string $code
	 */
	public function deleteByTransactionCode($code){
		try {
			$rs = $this->conn->delete($this->getTablename(), array('transaction_code'=>$code));
		}catch( Exception $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
			return false;
		} catch( PDOException $e ){
			LogHelper::getInstance()->log( $e->getMessage() );
			return false;
		}
		
		return $rs;
	}
	
	/**
	 * Gets a transaction by suplying a pregenerated notification code
	 *
	 * @param string $code
	 * @return boolean|array Transaction
	 */
	public function getTransactionByNotificationCode($code){
		try {
			$rs = $this->conn->get_row(sprintf('SELECT transaction_code FROM %s WHERE id = "%s"', $this->getTablename(), $code));
			if( !empty($rs)){
				$model = new TransactionsModel();
				$transaction = $model->get( $rs->transaction_code );
				return ( !empty($transaction)? $transaction : false );
			}
		} catch( Exception $e ){
			LogHelper::getInstance()->log($e->getMessage());
		}
		return false;
	}
	
}