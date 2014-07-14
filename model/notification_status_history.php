<?php
/**
 * NotificationStatusHistoryModel Class
 *
 * Keeps track of all notifications created
 *
 * @author Jair Milanes Junior
 *
 */
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
		$sql = 'SELECT
					history.code,
					history.status,
					history.date,
					response.response
				FROM
					%s as history
					notifications_response as response
				WHERE
					history.code = "%s" AND response.code = "%s"';
		
		$sql = 'SELECT
					history.code,
					history.status,
					history.date,
					response.response
				FROM
					%s as history
				LEFT JOIN
					notifications_response as response
					ON history.code = response.code
				WHERE
					history.code = "%s"
				GROUP BY history.status';
		
		$rs = $this->conn->get_rows(sprintf($sql, $this->getTablename(), $code, $code));
		if( !empty($rs)){
			return $rs;
		}
		return false;
	}
	
	
}