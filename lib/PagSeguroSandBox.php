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
	
	/***** DM *****/
	const ORDER_TABLENAME 		  = 'orders';
	const NOTIFICATION_TABLENAME  = 'notifications';
	const TRANSACTION_TABLENAME   = 'transactions';
	
	const LOG_FILE 				  = 'sandbox.log';
	
	/**** DON'T EDIT THE CODE BELOW UNLESS YOU KNOW WHAT YOU ARE DOING ****/
	const NOTIFICATION_CODE_LENGTH = 39;
	const TRANSACTION_CODE_LENGTH = 36;
	
	private $order;
	private $notification;
	private $required_data = array(
			"token", 
			"currency", 
			"email", 
			"itemId1", 
			"itemDescription1", 
			"itemQuantity1", 
			"itemAmount1",
			"redirectURL"
		);
	
	private $transaction_possible_status = array(
			"1" => "Aguardando pagamento",
			"2" => "Em análise",
			"3" => "Paga",
			"4" => "Disponível",
			"5" => "Em disputa",
			"6" => "Devolvida",
			"7" => "Cancelada",
	);
	
	private $config;
	
	private $conn;
	
/*************************************************************************
 * CONSTRUCTOR
 *************************************************************************/
	
	public function __construct(){
		require BASE_PATH.'lib/SQLite3db.php';
		$this->conn = new SQLite3Database(BASE_PATH.'pagseguro_sandbox.db');
		$this->config = simplexml_load_file(BASE_PATH.'config.xml');		
	}

	
	
	
/*************************************************************************
 * DASHPANEL
 *************************************************************************/
	/**
	 * Sandbox dashboard
	 */
	public function sandbox(){
		require BASE_PATH.'includes/sandbox.php';
	}
	
	/**
	 * Transactions table refresh
	 */
	public function refresh(){
		require BASE_PATH.'includes/transactions_table.php';
	}
	
	/**
	 * Sandbox settings form
	 */
	public function settings(){
		if( $this->isRequest('POST') ){
			$params = $this->getParams();
			try {
				$errors = array();
				if(!isset($params['domain']) || empty($params['domain']) ){
					$errors['domain'] = true;
				}
				if(!isset($params['notificationUrl']) || empty($params['notificationUrl']) ){
					$errors['notificationUrl'] = true;
				}
				if(!isset($params['redirectUrl']) || empty($params['redirectUrl']) ){
					$errors['redirectUrl'] = true;
				}
				if(!isset($params['port']) || empty($params['port']) ){
					$errors['port'] = true;
				}
				
				if(!isset($params['checkout_complete']) || empty($params['checkout_complete']) ){
					$params['checkout_complete'] = 'redirect';
				}
	
				if( count($errors) > 0 ){
					die(json_encode($errors));
				}
				
				$xml = new SimpleXMLElement('<config/>');
				$xml->domain = $params['domain'];
				$xml->notificationUrl = $params['notificationUrl'];
				$xml->redirectUrl = $params['redirectUrl'];
				$xml->port = $params['port'];
				$xml->checkout_complete = $params['checkout_complete'];
				
				$string = $this->prepareXml($xml);
	
				$file_handle = fopen(BASE_PATH.'config.xml', 'w') or die("can't open log file");
				fwrite($file_handle, $string);
				fclose($file_handle);
			} catch( Exception $e ){
				die('0');
			}
			die('1');
		}
		require BASE_PATH.'includes/settings_form.php';
	}
	
	
	
	
	

/*************************************************************************
 * PUBLIC UNTERFACE
 *************************************************************************/
	
	/**
	 * Simulates a PagSeguro transaction
	 * returning a code ans date for rediraction
	 */
	public function checkout(){
		$this->order = $this->getParams();

		$code = $this->generateTransaction();

		$request_code = $this->saveCheckoutTransactionCode($code);
		
		// write xml file with proper formatting
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		//$dom->formatOutput = true;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		
		if( false !== $request_code ){

			$checkout = $dom->createElement('checkout');
			$dom->appendChild($checkout);
			$checkout->appendChild($dom->createElement('code', (string)$request_code));
			$checkout->appendChild($dom->createElement('date', date('Y-m-d\TH:i:s.\0\0\0P')));

		} else {
			
			$errors = $dom->createElement('errors');
			$dom->appendChild($errors);
			$error = $dom->createElement('error');
			$errors->appendChild($error);
			$error->appendChild( $dom->createElement('code', 11039 ));
			$error->appendChild( $dom->createElement('message', 'Malformed request XML' ));

		}
		
		header('Content-Type: text/html; charset=ISO-8859-1');
		echo $dom->saveXML();
		exit;

	}
	
	/**
	 * Procceses the checkout information
	 */
	public function checkoutProcess(){
		$code = $this->getParam('code');
		if( $this->isRequest('post') ){
			$paymentMethod = $this->getParam('paymentMethod');
			$transaction = $this->loadTransaction($code);
			
			if( !empty($transaction) ){	
				$xml = simplexml_load_string($transaction->xml);
				$xml->paymentMethod->type = $paymentMethod['type'];
				$xml->paymentMethod->code = $paymentMethod['code'];
				$xml_str = $this->prepareXml($xml);

				if( $this->updateTransaction($xml_str, $code) ){
					die($code);
				}
			}
			die(0);
		}
		$xml = $this->getTransactionByCheckoutCode($code);
		if( !empty($xml) ){
			require BASE_PATH.'includes/transaction_render_checkout.php';
		}	
		die(0);
	}
	
	/**
	 * Generates a PagSeguro fake notification
	 */
	public function notify(){
		if( $this->isRequest('POST') ){
			$params = $this->getParams();
			
			$status = $params['status'];
			$transaction_code = $params['code'];

			if( $this->setTransactionStatus($transaction_code, $status ) ){
				$rs = $this->_notify($transaction_code, $status);
				die($rs);
			}
		}
		die('Invalid request!');
	}
	
	/**
	 * Private notification method
	 * 
	 * @param string $transaction_code
	 * @param string $status
	 * @return mixed|boolean
	 */
	private function _notify($transaction_code, $status){
		$notification = $this->generateNotification($transaction_code, $status);
		if( false !== $notification ){
			$url = $this->config->domain.$this->config->notificationUrl;
			return $this->doRequest($url, $notification, 'POST');
		}
		return false;
	}
	
	/**
	 * Loads the checkout lightbox page
	 */
	public function embedded(){
		require BASE_PATH.'includes/transaction_checkout_process.php';
	}
	
	/**
	 * Searches a transaction by notification code
	 */
	public function searchNotification(){
		$params = $this->getParams();
		if( isset($params['code'])
				&& isset($params['email']) && isset($params['token']) ){
			$rs = $this->getTransactionByNotificationCode($params['code']);
			if( false !== $rs ){
				$xml = simplexml_load_string($rs->xml);
				die($xml->asXML());
			}
		}
		die();
	}
	
	/**
	 * Searches a transaction by transaction code
	 */
	public function searchTransaction(){
		$params = $this->getParams();
		if( isset($params['code'])
				&& isset($params['email']) && isset($params['token']) ){
			$rs = $this->loadTransaction($params['code']);
			if( false !== $rs ){
				$xml = simplexml_load_string($rs->xml);
				die($xml->asXML());
			}
		}
		die();
	}

	/**
	 * View a specific transaction
	 */
	public function view(){
		$code = $this->getParam('code');
		$rs = $this->loadTransaction($code, true);
		if( $rs ){
			$xml = simplexml_load_string($rs['xml']);
			require BASE_PATH.'includes/transaction_render_view.php';
			die();
		}
		die('error');
	}

	/**
	 * Removes a transaction from db
	 */
	public function remove(){
		$code = $this->getParam('code');
		if( $this->isRequest('post') ){
			if( $this->deleteTransaction($code) ){
				$this->deleteNotificationByTransactionCode($code);
				die('1');
			}
			die('0');
		}
		
		require BASE_PATH.'includes/transactions_delete_confirm.php';
	}
	
	/**
	 * Removes all transactions from database
	 */
	public function removeAll(){
		if( $this->isRequest('post')){
			try {
				$this->conn->query('BEGIN');
				$this->conn->query('DROP TABLE transactions');
				$this->conn->query('DROP TABLE notifications');
				$this->conn->query('DROP TABLE transaction_codes');
				$this->createTable('transactions');
				$this->createTable('notifications');
				$this->createTable('transaction_codes');
				$this->conn->query('COMMIT');
				
				die('1');
			} catch( Exception $e ){
				$this->conn->query('ROLLBACK');
				$this->log($e->getMessage());
			}
			die('0');
		}
		require BASE_PATH.'includes/transactions_wipe_confirm.php';
	}
	
	
	
	

/*************************************************************************
 * NOTIFICATIONS CRUD METHODS
 *************************************************************************/
	/**
	 * Generates a fake notification
	 * 
	 * @param string $transaction_code
	 * @param string $status
	 * @return boolean|array Notification
	 */
	private function generateNotification($transaction_code, $status){
		$id = $this->generateRandomString(self::NOTIFICATION_CODE_LENGTH);

		$notification = array(
			"notificationCode"  	=> $id,
			"notificationType"  	=> 1,
			"transactionStatus" 	=> $status,
			"transactionTextStatus" => $this->transaction_possible_status[$status]
		);

		$row = array(
			'id'  => $id,
			'transaction_code' => $transaction_code
		);
		
		$this->deleteNotification($transaction_code);
		
		if( $this->saveNotification($row) ){
			return $notification;
		}
		
		return false;
	}
	
	/**
	 * Deletes a notification 
	 * 
	 * @param string $id
	 */
	private function deleteNotification($id){
		try {
			return $this->conn->delete('notifications', array('id'=>$id));
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Deletes a notification by transaction code
	 *
	 * @param string $code
	 */
	private function deleteNotificationByTransactionCode($code){
		try {
			return $this->conn->delete('notifications', array('transaction_code'=>$code));
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Saves a new notification
	 * 
	 * @param array $data
	 */
	private function saveNotification($data){
		try {
			return $this->conn->insert('notifications', $data );
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Gets a transaction by suplying a pregenerated notification code
	 * 
	 * @param string $code
	 * @return boolean|array Transaction
	 */
	private function getTransactionByNotificationCode($code){
		try {
			$rs = $this->conn->get_row(sprintf('SELECT transaction_code FROM notifications WHERE id = "%s"', $code));
			if( !empty($rs)){
				$transaction = $this->loadTransaction( $rs->transaction_code );
				return ( !empty($transaction)? $transaction : false );
			}
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	
	
	
	
	
	
	
/*************************************************************************
 * TRANSACTIONS CRUD METHODS
 *************************************************************************/
	/**
	 * Gets all transactions from db
	 * 
	 * @return array()
	 */
	public function getTransactions(){
		try {
			return $this->conn->get_rows('SELECT code, xml, date FROM transactions ORDER BY date LIMIT 100');
		} catch( Exception $e ){
			$this->log($e->getMessages());
		}
		return array();
	}
	
	/**
	 * Sets a existing transaction status
	 * 
	 * @param string $code
	 * @param string|status
	 */
	private function setTransactionStatus($code, $status){
		$transaction = $this->loadTransaction($code);

		if( $transaction && array_key_exists((string)$status, $this->transaction_possible_status) ){
			$xml = simplexml_load_string($transaction->xml);
			$xml->status = $status;
			
			$xml_str = $this->prepareXml($xml);

			return $this->updateTransaction($xml_str, $code);
		}
		return false;
	}
	
	/**
	 * Gets a specific transaction by code
	 * 
	 * @param string $code
	 */
	private function loadTransaction($code, $return_array = false){
		try {
			return $this->conn->get_row(sprintf('SELECT * FROM transactions WHERE code = "%s"', $code), $return_array);
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Saves a new transaction to the database
	 * 
	 * @param array $data
	 */
	private function saveTransaction($data){
		try {
			return $this->conn->insert('transactions', $data);
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Saves a transaction request code
	 */
	private function saveCheckoutTransactionCode($transaction_code){
		$checkout_code = $this->generateRandomString(32);
		$data = array(
			'code' => $checkout_code,
			'transaction_code' => $transaction_code
		);
		try {
			if( $this->conn->insert('transaction_codes', $data) ){
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
	private function getTransactionByCheckoutCode($code){
		$sql = sprintf('SELECT transaction_code FROM transaction_codes WHERE code = "%s"', $code);
		$rs = $this->conn->get_row($sql);
		if( !empty( $rs ) ){
			$transaction = $this->loadTransaction($rs->transaction_code);
			if( !empty($transaction) ){
				return simplexml_load_string($transaction->xml);
			}
		}
		return false;
	}
	
	/**
	 * Updates a transaction
	 * 
	 * @param array $data
	 * @param string $code
	 */
	private function updateTransaction($xml, $code){
		try {
			return $this->conn->update('transactions', array('xml'=>$xml), array('code'=>$code));
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	/**
	 * Removes a transaction from the db
	 * 
	 * @param string $code
	 * @return boolean|number
	 */
	private function deleteTransaction($code){
		try {
			return $this->conn->delete('transactions', array('code'=>$code));
		} catch( Exception $e ){
			$this->log($e->getMessage());
		}
		return false;
	}
	
	
	
	
	
	
/*************************************************************************
 * TRANSACTION GENERATION
 *************************************************************************/
	
	/**
	 * Generate  fake transaction
	 * 
	 */
	private function generateTransaction() {

		$items = $this->getOrderItems();
		 
		$xml = new SimpleXMLElement("<transaction/>");
	
		$xml->date = date("c");
		$code = $this->generateRandomString(self::TRANSACTION_CODE_LENGTH);
		$xml->code = $code;
		if (isset($this->order['reference']))
			$xml->reference = $this->order['reference'];
	
		$xml->lastEventDate = date("c");
		$xml->paymentMethod->type = 1;
		$xml->paymentMethod->code = 101;
		$xml->grossAmount = number_format($this->calculateOrderTotal($items), 2, '.', '');
		$xml->discountAmount = "0.00";
		$xml->feeAmount = "0.00";
		$xml->netAmount = $xml->grossAmount;
		$xml->extraAmount = "0.00";
		$xml->installmentCount = 1;
		$xml->itemCount = count($items);
	
		$xml->type = 1;
		$xml->status = '1';
		// print items
		$itemsRoot = $xml->addChild("items");
		foreach ($items as $item) {
			$child = $itemsRoot->addChild("item");
			$child->id = $item["id"];
			$child->description = $item["description"];
			$child->quantity = $item["quantity"];
			$child->amount = number_format($item["amount"], 2, '.', '');
		}
	
		// sender
		$xml->sender->name = isset($this->order['senderName']) ? $this->order['senderName']: "Mauro Turm";
		$xml->sender->email = isset($this->order['senderEmail']) ? $this->order['senderEmail']: "mauro@mail.com";
		$xml->sender->phone->areaCode = isset($this->order['senderAreaCode']) ? $this->order['senderAreaCode']: "31";
		$xml->sender->phone->number = isset($this->order['senderPhone']) ? $this->order['senderPhone']: "55555555";
	
		// shipping
		$xml->shipping->address->street = isset($this->order['shippingAddressStreet']) ?
		$this->order['shippingAddressStreet'] : "Av. do Contorno";
		$xml->shipping->address->number = isset($this->order['shippingAddressNumber']) ?
		$this->order['shippingAddressNumber'] : "500";
		$xml->shipping->address->complement = isset($this->order['shippingAddressComplement']) ?
		$this->order['shippingAddressComplement']: "2o Andar";
		$xml->shipping->address->district = isset($this->order['shippingAddressDistrict']) ?
		$this->order['shippingAddressDistrict'] : "Funcionários";
		$xml->shipping->address->postalCode = isset($this->order['shippingAddressPostalCode']) ?
		$this->order['shippingAddressPostalCode']: "30110039";
		$xml->shipping->address->city = isset($this->order['shippingAddressCity']) ?
		$this->order['shippingAddressCity']: "Belo Horizonte";
		$xml->shipping->address->state = isset($this->order['shippingAddressState ']) ?
		$this->order['shippingAddressState '] : "MG";
		$xml->shipping->address->country = isset($this->order['shippingAddressCountry']) ?
		$this->order['shippingAddressCountry']: "BRA";
		$xml->shipping->type = 3;
		$xml->shipping->cost = "0.00";
	
		// write xml file with proper formatting
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		$dom->loadXML($xml->asXML());
	
		$data = array(
			'code' => $code,
			'xml' => $dom->saveXML(),
			'date' => date('Y-m-d H:i:s')  
		);
		
		if( $this->saveTransaction( $data ) ){
			return  $code;
		}
		
		return false;
	}
	
	/**
	 * Extract items from a transaction xml string
	 * 
	 * @return array
	 */
	private function getOrderItems() {
		$i = 1;
		$items = array();
		while (array_key_exists("itemAmount".$i, $this->order) && array_key_exists("itemQuantity".$i, $this->order)) {
			array_push($items, array("id" => $this->order["itemId".$i],
			"description" => $this->order["itemDescription".$i],
			"quantity" => $this->order["itemQuantity".$i],
			"amount" => $this->order["itemAmount".$i]));
			$i += 1;
		}
		 
		return $items;
	}
	
	/**
	 * Cauculates the total of this transaction
	 * 
	 * @param array $items
	 * @return number
	 */
	private function calculateOrderTotal($items) {
		$total = 0;
		foreach ($items as $item)
			$total += $item['amount']*$item['quantity'];
		 
		return $total;
	}
	
	/**
	 * Validates required pagseguro params
	 * 
	 * @return multitype:|string
	 */
	public function validateParams() {
		if (!$this->order)
			return array();
	
		$missing_params = array();
		foreach ($this->required_data as $key) {
			if (!array_key_exists($key, $this->order))
				array_push($missing_params, $key);
		}
	
		return implode(", ", $missing_params);
	}
	
	
	
	
	
	
/*************************************************************************
 * CURL
 *************************************************************************/
	
	/**
	 * Simple curl request method
	 *
	 * @param string $url
	 * @param array $data
	 * @param string $type
	 * @return mixed
	 */
	protected function doRequest( $url, $data = array(), $type = 'get' ){
		$curl = curl_init();
		$opts = array();
	
		if( strtolower($type) == 'post' ){
			$opts[CURLOPT_POST] = true;
			if( !empty($data)){
				$opts[CURLOPT_POSTFIELDS] = http_build_query($data);
			}
		}
		$opts[CURLOPT_RETURNTRANSFER] = 1;
		$opts[CURLOPT_URL] = $url;
		$opts[CURLOPT_FOLLOWLOCATION] = 1;
		
		
		curl_setopt_array($curl, $opts);
		$result = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
			
		return $result;
	}
	
	
	
	
	
	
/*************************************************************************
 * PARAMS RETRIVAL
 *************************************************************************/
	
	/**
	 * Tests request type
	 * 
	 * @param string $type
	 * @return boolean
	 */
	private function isRequest($type){
		return strtoupper($_SERVER['REQUEST_METHOD']) == strtoupper($type) ? true : false;
	}
	
	/**
	 * Gets all request params
	 * 
	 * @return array
	 */
	private function getParams(){
		$data = array();
		if (!empty($_GET) || !empty($_POST)) {
			$data = array_merge($data, $_GET, $_POST);
		}
		return $data;
	}
	
	/**
	 * Gets a specific request param
	 * 
	 * @param string $name
	 * @return mixed
	 */
	private function getParam($name){
		$data = array();
		if (!empty($_GET[$name]) || !empty($_POST[$name])) {
			if (empty($_GET[$name]))
				$data = $_POST[$name];
			else
				$data = $_GET[$name];
		}
		return $data;
	}
	
	
	
	
	
	
/*************************************************************************
 * STATUS HELPERS
 *************************************************************************/
	
	/**
	 * Converts a status numer to a readable string
	 * 
	 * @param string|number $status
	 * @return string
	 */
	public function getStatusString($status){
		return ( isset( $this->transaction_possible_status[(string)$status]) )? $this->transaction_possible_status[(string)$status] : false;
	}
	
	/**
	 * Gets a status class to use in html for colorcoded status
	 * 
	 * @param string|number $status
	 * @param string $type
	 * @return string
	 */
	public function getStatusClass($status, $type = 'btn'){
		$classes = array(
			"1" => $type."-info",
			"2" => $type."-info",
			"3" => $type."-success",
			"4" => $type."-info",
			"5" => $type."-warning",
			"6" => $type."-primary",
			"7" => $type."-danger"
		);
		if( array_key_exists((string)$status, $classes)){
			return $classes[(string)$status];
		}
		return '';
	}
	
	/**
	 * Processes a specific db file from the sql folder
	 * 
	 * @param string $name
	 * @return Ambigous <boolean, unknown, string>|boolean
	 */
	private function createTable($name){
		$db_file = BASE_PATH.'lib/sql/'.strtolower($name).'.sql';
		if( file_exists($db_file)){
			$sql = file_get_contents($db_file);
			return $this->conn->query($sql);
		}
		return false;
	}
	
	

	
	
/*************************************************************************
 * PAYMENT HELPERS
*************************************************************************/
	
	/**
	 * Returns the name of a payment type give it´s code
	 * 
	 * @param string $type
	 * @return Ambigous <string>|string
	 */
	protected function translatePaymentType($type){
		$types = array(
			"1" => "1 - Cartão de crédito",
			"2" => "2 - Boleto",
			"3" => "3 - Débito online (TEF)",
			"4" => "4 - Saldo PagSeguro",
			"5" => "5 - Oi Paggo",
			"7" => "7 - Depósito em conta"
		);
		if( array_key_exists((string)$type, $types)){
			return $types[$type];
		}
		return '';
	}
	
	/**
	 * Returns the name of a payment method given it´s code
	 * 
	 * @param string $method
	 * @return Ambigous <string>|string
	 */
	protected function translatePaymentMethod($method){
		$methods = array(
			"101" => "101 - Cartão de crédito Visa",
			"102" => "102 - Cartão de crédito MasterCard",
			"103" => "103 - Cartão de crédito American Express",
			"104" => "104 - Cartão de crédito Diners",
			"105" => "105 - Cartão de crédito Hipercard",
			"106" => "106 - Cartão de crédito Aura",
			"107" => "107 - Cartão de crédito Elo",
			"108" => "108 - Cartão de crédito PLENOCard",
			"109" => "109 - Cartão de crédito PersonalCard",
			"110" => "110 - Cartão de crédito JCB",
			"111" => "111 - Cartão de crédito Discover",
			"112" => "112 - Cartão de crédito BrasilCard",
			"113" => "113 - Cartão de crédito FORTBRASIL",
			"114" => "114 - Cartão de crédito CARDBAN",
			"115" => "115 - Cartão de crédito VALECARD",
			"116" => "116 - Cartão de crédito Cabal",
			"117" => "117 - Cartão de crédito Mais!",
			"118" => "118 - Cartão de crédito Avista",
			"119" => "119 - Cartão de crédito GRANDCARD",
			"120" => "120 - Cartão de crédito Sorocred",
			"202" => "202 - Boleto Santander",
			"301" => "301 - Débito online Bradesco",
			"302" => "302 - Débito online Itaú",
			"304" => "304 - Débito online Banco do Brasil",
			"306" => "306 - Débito online Banrisul",
			"307" => "307 - Débito online HSBC",
			"401" => "401 - Saldo PagSeguro",
			"701" => "701 - Depósito em conta - Banco do Brasil",
			"702" => "702 - Depósito em conta - HSBC"
		);
		
		if( array_key_exists((string)$method, $methods)){
			return $methods[$method];
		}
		return '';
	}
	
	
	
	
	/*************************************************************************
	 * GENERAL HELPERS
	*************************************************************************/
	
	/**
	 * Generates a snadbox action url
	 *
	 * @param action $action
	 * @return string
	 */
	private function url($action){
		return BASE_URL.'?action='.$action;
	}
	
	/**
	 * Prepares a simple xml string with Dom
	 *
	 * @param SimpleXMLElement $xml
	 * @return string
	 */
	private function prepareXml($xml){
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->xmlStandalone = true;
		$dom->encoding = "ISO-8859-1";
		$dom->loadXML($xml->asXML());
		return $dom->saveXML();
	}
	
	/**
	 * Gets current hostname
	 *
	 * @return string
	 */
	public function getCurrentHost() {
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		return $host.$uri;
	}
	
	/**
	 * Generates a random string given it´s length
	 *
	 * @param number $length
	 * @return string
	 */
	private function generateRandomString($length) {
		$characters = '0123456789ABCDEF-';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
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

if( !function_exists('printR')){
	function printR( $data, $exit = false ){
		echo'<pre>'.print_r($data, true ).'</pre>';
		if( $exit ) exit;
		return;
	}

}
?>