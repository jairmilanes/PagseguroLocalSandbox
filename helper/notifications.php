<?php
class NotificationsHelper extends SandboxHelper {
	
	const NOTIFICATION_CODE_LENGTH = 39;
	/**
	 * Generates a fake notification
	 *
	 * @param string $transaction_code
	 * @param string $status
	 * @return boolean|array Notification
	 */
	public static function generateNotification($transaction_code, $status){
		$id = UtilsHelper::generateRandomString(self::NOTIFICATION_CODE_LENGTH);

		$notification = array(
				"notificationCode"  	=> $id,
				"notificationType"  	=> 1,
				"transactionStatus" 	=> $status,
				"transactionTextStatus" => UtilsHelper::getStatus($status)
		);
	
		$row = array(
				'id'  => $id,
				'transaction_code' => $transaction_code
		);
		$model = new NotificationsModel();
		$model->deleteByTransactionCode($transaction_code);
	
		if( $model->save($row) ){
			$model = null;
			return $notification;
		}
	
		return false;
	}
}