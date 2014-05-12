<?php
/**
 * Pagseguro Sandbox Class
 *
 * Um ambiente de testes 100% integrado as API´s do Pagseguro
 * tudo funciona normalmente sem que altere nenhuma linha de codigo.
 * Crie transações, checkouts completos, escolha tipos e meios de pagemento,
 * consulte transações por código ou intervalo de datas dentre outras funcionalidades.
 *
 * @author Jair Milanes Junior
 *
 */
class PagSeguroSandBox {

	private $order;

	private $config;
	
	/**
	 * PagSeguroSandBox construnctor
	 */
	public function __construct(){
		$this->config = ConfigHelper::getInstance();
	}

	
/*************************************************************************
 * PAGSEGURO API UNTERFACE
 *************************************************************************/
	
	/**
	 * PagSeguro Checkout API
	 *
	 * @return string Xml containing code and current date
	 */
	public function v2Checkout(){
		
		printR(RequestHelper::getParams(), true);
		
		$dom = UtilsHelper::newDOM();
		
		$token = RequestHelper::getParam('token');
		$email = RequestHelper::getParam('email');
		
		$errors = $dom->createElement('errors');
		$istokenValid = true;
		if( !validateHelper::isValidToken($token) ){
			ResponseHelper::getInstance()->addApiError(10002, 'Token is required.');
			$istokenValid = false;
		}
		
		$isEmailValid= true;
		if( !validateHelper::isValidEmail($email)){
			ResponseHelper::getInstance()->addApiError(10003, 'Email invalid value.');
			$isEmailValid = false;
		}
		
		if(!$istokenValid || !$isEmailValid){
			ResponseHelper::getInstance()->renderApiError();
		}

		$this->order = RequestHelper::getParams();
		
		
		printR(validateHelper::validateCheckout($this->order), true);


		$code = TransactionsHelper::generateTransaction( $this->order );
		$model = new TransactionCodesModel();
		
		$request_code = $model->save($code);

		if( false !== $request_code ){
			ResponseHelper::getInstance()->returnRequestCode($request_code);
		} else {
			ResponseHelper::getInstance()->addApiError(11039, 'Malformed request XML')->renderApiError();
		}
		
	}
	
	/**
	 * Loads the checkout lightbox page
	 * Pagseguro "/checkout/embedded/i-ck.html"
	 */
	public function checkoutEmbeddedIck(){
		ResponseHelper::getInstance()->render('ws_checkout_embedded_ick');
	}
	
	/**
	 * Loads checkout date for use with the lightbox or redirect API
	 */
	public function checkoutProcess(){

		$code = RequestHelper::getParam('code');

		if( RequestHelper::isRequest('post') ){
			$paymentMethod = RequestHelper::getParam('paymentMethod');
			$model = new TransactionsModel();
			$transaction = $model->get($code);
			
			if( !empty($transaction) ){
				$xml = simplexml_load_string($transaction->xml);
				$xml->paymentMethod->type = $paymentMethod['type'];
				$xml->paymentMethod->code = $paymentMethod['code'];
				$xml_str = UtilsHelper::prepareXml($xml);
				if( $model->update($xml_str, $code) ){
					ResponseHelper::getInstance()->do200($code);
				}
			} else {
				ResponseHelper::getInstance()->do400();
			}
		}
		
		$notificationsModel = new TransactionCodesModel();
		$xml = $notificationsModel->getByCheckoutCode($code);
		
		$historyModel = new NotificationStatusHistoryModel();
		$history = $historyModel->getByCode($code);
		if( empty($history) ){
			$history = array();
		}
		
		if( !empty($xml) ){
			$type = RequestHelper::getParam('type');
			switch($type){
				case 'full':
					ResponseHelper::getInstance()->render('transaction_render_fullcheckout', array('xml' => $xml, 'history' => $history));
					break;
				default:
					ResponseHelper::getInstance()->render('transaction_render_checkout', array('xml' => $xml, 'history' => $history));
					break;
			}
		}
		ResponseHelper::getInstance()->do400();
	}
	
	/**
	 * Generates a PagSeguro fake notification
	 */
	public function notify(){
		if( RequestHelper::isRequest('POST') ){
			$params = RequestHelper::getParams();
			$status = $params['status'];
			$transaction_code = $params['code'];
			$model = new TransactionsModel();
			if( $model->setStatus($transaction_code, $status ) ){
				$model = null;
				$rs = $this->_notify($transaction_code, $status);
				die($rs);
			}
		}
		ResponseHelper::getInstance()->do400();
	}
	
	/**
	 * Private notification method
	 *
	 * @param string $transaction_code
	 * @param string $status
	 * @return mixed|boolean
	 */
	private function _notify($transaction_code, $status){
		$notification = NotificationsHelper::generateNotification($transaction_code, $status);
		
		if( false !== $notification ){
			$model = new NotificationStatusHistoryModel();
			$model->insert($transaction_code, $status);
			
			$url = $this->config->get('domain').$this->config->get('notificationUrl');
			$rs = RequestHelper::doRequest($url, $notification, 'POST');
			
			$responseModel = new NotificationsResponseModel();
			$responseModel->insert($transaction_code, $rs);
			return $rs;
		}
		return false;
	}
	
	/**
	 * Searches a transaction by transaction code
	 */
	public function v2Transactions(){
		
		// Verificar por busca por código ou busca por data
		
		$params = RequestHelper::getParams();
		if( isset($params['code'])
				&& isset($params['email']) && isset($params['token']) ){
			$model = new TransactionsModel();
			$rs = $model->get($params['code']);
			if( !empty($rs) ){
				$xml = simplexml_load_string($rs->xml);
				die($xml->asXML());
			}
			ResponseHelper::getInstance()->do404();
		} else {
			ResponseHelper::getInstance()->do401();
		}
	}
	
	/**
	 * Searches a transaction by transaction code
	 */
	public function searchTransactionByDate(){
		$params = RequestHelper::getParams();
		if( isset($params['code'])
				&& isset($params['email']) && isset($params['token']) ){
			$model = new TransactionsModel();
			$rs = $model->get($params['code']);
			if( !empty($rs) ){
				$xml = simplexml_load_string($rs->xml);
				die($xml->asXML());
			}
			ResponseHelper::getInstance()->do404();
		} else {
			ResponseHelper::getInstance()->do401();
		}
	}
	
	/**
	 * Searches a transaction by notification code
	 */
	public function v2TransactionsNotifications(){
		$params = RequestHelper::getParams();
		if( isset($params['code'])
				&& isset($params['email']) && isset($params['token']) ){
			$model = new NotificationsModel();
			$rs = $model->getTransactionByNotificationCode($params['code']);
			if( false !== $rs ){
				$xml = simplexml_load_string($rs->xml);
				die($xml->asXML());
			}
			ResponseHelper::getInstance()->do404();
		} else {
			ResponseHelper::getInstance()->do401();
		}
	}

	
	
/*************************************************************************
 * DASHBOARD UNTERFACE
*************************************************************************/
	
	/**
	 * Sandbox dashboard
	 */
	public function sandbox(){
		$model = new TransactionsModel();
		$transactions = $model->getTransactions();
		ResponseHelper::getInstance()->render('sandbox', array('transactions' => $transactions, 'config' => $this->config->asXml()));
	}
	
	/**
	 * Transactions table refresh
	 */
	public function refresh(){
		$model = new TransactionsModel();
		$transactions = $model->getTransactions();
		ResponseHelper::getInstance()->render('transactions_table', array('transactions' => $transactions));
	}
	
	/**
	 * Sandbox settings form
	 */
	public function settings(){
		if( RequestHelper::isRequest('POST') ){
			$params = RequestHelper::getParams();
			try {
				SettingsHelper::save($params);
			} catch( Exception $e ){
				die('0');
			}
			die('1');
		}
		ResponseHelper::getInstance()->render('settings_form', array('config' => $this->config->asXml() ));
	}

	/**
	 * View a specific transaction
	 */
	public function view(){
		$code = RequestHelper::getParam('code');
		$model = new TransactionsModel();
		$rs = $model->get($code, true);
		if( $rs ){
			$historyModel = new NotificationStatusHistoryModel();
			$history = $historyModel->getByCode($code);
			if( empty($history) ){
				$history = array();
			}
			
			$xml = simplexml_load_string($rs['xml']);
			ResponseHelper::getInstance()->render('transaction_render_view', array('xml' => $xml, 'history' => $history));
		}
		ResponseHelper::getInstance()->do404();
	}

	/**
	 * Removes a transaction from db
	 */
	public function remove(){
		$code = RequestHelper::getParam('code');
		if( RequestHelper::isRequest('post') ){
			$model = new TransactionsModel();
			if( $model->delete($code) ){
				$model = new NotificationsModel();
				$model->deleteByTransactionCode($code);
				die('1');
			}
			die('0');
		}
		ResponseHelper::getInstance()->render('transactions_delete_confirm', array('code' => $code));
	}
	
	/**
	 * Removes all transactions from database
	 */
	public function removeAll(){
		if( RequestHelper::isRequest('post')){
			$model = new TransactionsModel();
			if( $model->removeAll() ){
				die('1');
			}
			die('0');
		}
		ResponseHelper::getInstance()->render('transactions_wipe_confirm');
	}

	
	/**
	 * Renders help page
	 */
	public function help(){
		ResponseHelper::getInstance()->render('help');
	}

}

?>