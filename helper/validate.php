<?php
class validateHelper extends SandboxHelper {
	
	private static $required_data = array(
			"token",
			"currency",
			"email",
			"itemId1",
			"itemDescription1",
			"itemQuantity1",
			"itemAmount1",
			"redirectURL"
	);

	/**
	 * Receiver validation
	 * @var array
	 */
	private static $checkout_receiver_rules = array(
		'email'=>array('type'=>'email',  'required'=>false, 'min'=>1, 'max'=>60, 'trim'=>true)
	);
	
	/**
	 * Items validation rules
	 * @var array
	 */
	private static $checkout_items_rules = array(
		'id'			=>	array('type'=>'string',    'required'=>true, 'min'=>1,  'max'=>100, 		'trim'=>true),
		'description'	=>	array('type'=>'string',    'required'=>true, 'min'=>3,  'max'=>100, 		'trim'=>true),
		'amount'		=>	array('type'=>'float',     'required'=>true,  			'max'=>9999999,  	'trim'=>true),
		'quantity'		=>	array('type'=>'numeric',   'required'=>true, 'min'=>1,  'max'=>999, 		'trim'=>true),
		'shippingCost'	=>	array('type'=>'float',     'required'=>false,		    'max'=>9999999,     'trim'=>true),
		'weight'		=>	array('type'=>'numeric',   'required'=>true, 'min'=>1,  'max'=>30000, 		'trim'=>true)
	);
	
	/**
	 * Sender validation
	 * @var array
	 */
	private static $checkout_sender_rules = array(
		'name'		=>	array('type'=>'string',  	'required'=>false, 'min'=>3,  'max'=>50, 'trim'=>true),
		'email'		=>	array('type'=>'email',   	'required'=>false, 			  'max'=>60, 'trim'=>true),
		'phone'		=>	array(
			'areaCode' => array('type'=>'numeric', 	'required'=>false, 'min'=>2,  'max'=>2, 'trim'=>true),
			'number'   => array('type'=>'numeric', 	'required'=>false, 'min'=>7,  'max'=>9, 'trim'=>true),
		),
		'documents' =>	array(
			'document' => array(
				'type'  => array('type'=>'string', 	'required'=>false, 'min'=>3,   'max'=>3,  'trim'=>true),
				'value' => array('type'=>'numeric',	'required'=>false, 'min'=>11,  'max'=>11, 'trim'=>true),
			)
		),
		'bornDate'	=>	array('type'=>'date',  	'required'=>false, 'min'=>30,  'max'=>50, 'trim'=>true)
	);
	
	/**
	 * Shipping validation rules
	 * @var array
	 */
	private static $checkout_shipping_rules = array(
		'type' => array('type'=>'in_array', 'required'=>false, 'against' => array(1,2,3), 'trim'=>true),
		'cost' => array('type'=>'float', 	'required'=>false, 'max' => 9999999, 'trim'=>true),
		'address' => array(
			'street' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>80,  'trim'=>true),
			'number' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>20,  'trim'=>true),
			'complement' => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>40,  'trim'=>true),
			'district' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>60,  'trim'=>true),
			'postalCode' => array('type'=>'numeric',  'required'=>false,  'min'=>8, 'max'=>8,   'trim'=>true),
			'city' 		 => array('type'=>'string',   'required'=>false,  'min'=>2, 'max'=>60,  'trim'=>true),
			'state' 	 => array('type'=>'string',   'required'=>false,  'min'=>2, 'max'=>2,   'trim'=>true),
			'country' 	 => array('type'=>'in_array', 'required'=>false, 					    'trim'=>true, 	'against' => array('BRA')),
		)
	);
	
	/**
	 * Metadados validation
	 * @var array
	 */
	private static $checkout_metadata_rules = array(
		'key'   => array('type'=>'in_array', 'required'=>false, 'against' => array(
																			'PASSENGER_CPF',
																			'PASSENGER_PASSPORT',
																			'ORIGIN_CITY',
																			'DESTINATION_CITY',
																			'ORIGIN_AIRPORT_CODE',
																			'DESTINATION_AIRPORT_CODE',
																			'GAME_NAME',
																			'PLAYER_ID',
																			'TIME_IN_GAME_DAYS',
																			'MOBILE_NUMBER',
																			'PASSENGER_NAME'
																		), 'trim'=>true, ),
		'value' => array('type'=>'string', 	 'required'=>false, 'min' => 0, 'max' => 100, 	  'trim'=>true),
		'group' => array('type'=>'numeric',  'required'=>false, 'min' => 1, 'max' => 9999999, 'trim'=>true)
	);
	
	/**
	 * Checkout validation
	 * @var array
	 */
	private static $checkout_rules = array(
			'currency'		=>	array('type'=>'string',  'required'=>true, 'min'=>3, 'max'=>3, 'trim'=>true),
			//'items'			=>  self::checkout_items_rules,
			'reference'		=>	array('type'=>'string',  'required'=>false, 'min'=>0, 'max'=>200, 'trim'=>true),
			//'sender'		=>  self::checkout_sender_rules,
			//'shipping'		=>  self::checkout_shipping_rules,
			'extraAmount'   =>	array('type'=>'float',  'required'=>false, 'min'=> -9999999, 'max'=> 9999999, 'trim'=>true),
			'redirectURL'   =>	array('type'=>'url',    'required'=>false, 					 'max'=> 255, 	  'trim'=>true),
			'notificationURL'   =>	array('type'=>'url',    'required'=>false, 					 'max'=> 255, 	  'trim'=>true),
			'maxUses'   =>	array('type'=>'numeric',    'required'=>false, 'min'=> 1 , 'max'=> 255, 	  'trim'=>true),
			'maxAge'   =>	array('type'=>'numeric',    'required'=>false, 'min'=> 30 , 'max'=> 999999999, 	  'trim'=>true),
			//'metadata'		=>  self::checkout_metadata_rules,
	);
	
	/**
	 * Validation
	 * @var unknown
	 */
	private static $rules = array(
		'charset' 	=> array('type'=>'in_array', 	'required'=>false,  'against' => array('ISO-8859-1','UTF-8'), 'trim'=>true),
		'email'		=> array('type'=>'email',  		'required'=>true, 	'max'=>60, 'trim'=>true),
		'token'		=> array('type'=>'string',  	'required'=>true, 	'min'=>32, 'max'=>32, 'trim'=>true),
	);
	
	private static function getRules(){
		$rules = self::$rules;
		$rules['checkout'] = self::$checkout_rules;
		$rules['checkout']['items'] = self::$checkout_items_rules;
		$rules['checkout']['sender'] = self::$checkout_sender_rules;
		$rules['checkout']['shipping'] = self::$checkout_shipping_rules;
		$rules['checkout']['receiver'] = self::$checkout_receiver_rules;
		$rules['checkout']['metadata'] = self::$checkout_metadata_rules;
		return $rules;
	}
	
	/**
	 * Validates required pagseguro params
	 *
	 * @return multitype:|string
	 */
	public static function validateParams() {
		if (!$this->order)
			return array();
	
		$missing_params = array();
		foreach ($this->required_data as $key) {
			if (!array_key_exists($key, $this->order))
				array_push($missing_params, $key);
		}
	
		return implode(", ", $missing_params);
	}
	
	/**
	 * Validates a complete checkout information
	 * @param array $data
	 * @return multitype:unknown |boolean
	 */
	public static function validateCheckout(array $data){
		
		$errors = array();
		
		if( isset($data['checkout']) ){
			
			$checkout = $data['checkout'];
			unset($data['checkout']);
			
			if( isset($checkout['items']) && count($checkout['items']) > 0 ){
				$items = $checkout['items'];
				unset($checkout['items']);
				
				$rs = self::_validateItems($items);
				if( true !== $rs ){
					$errors['checkout']['items'] = $rs;
				}
			}
			
			if( isset($checkout['sender']) && count($checkout['sender']) > 0 ){
				$sender = $checkout['sender'];
				unset($checkout['sender']);
				
				$rs = self::_validateSender($sender);
				if( true !== $rs ){
					$errors['checkout']['sender'] = $rs;
				}
			}
			
			if( isset($checkout['shipping']) && count($checkout['shipping']) > 0 ){
				$shipping = $checkout['shipping'];
				unset($checkout['shipping']);
				
				$rs = self::_validateShipping($shipping);
				if( true !== $rs ){
					$errors['checkout']['shipping'] = $rs;
				}
			}
			
			if( isset($checkout['receiver']) && count($checkout['receiver']) > 0 ){
				$receiver = $checkout['receiver'];
				unset($checkout['receiver']);
				
				$rs = self::_validateReceiver($receiver);
				if( true !== $rs ){
					$errors['checkout']['receiver'] = $rs;
				}
			}
			
			if( isset($checkout['metadata']) && count($checkout['metadata']) > 0 ){
				$metadata = $checkout['metadata'];
				unset($checkout['metadata']);
				
				$rs = self::_validateMetadata($metadata);
				if( true !== $rs ){
					$errors['checkout']['metadata'] = $rs;
				}
			}
			
			$rs = self::_validateCheckout($checkout);
			if( true !== $rs ){
				foreach( $rs as $key => $error ){
					$errors['checkout'][$key] = $error;
				}
			}
		}
		
		$rs = self::_validate($data);
		if( true !== $rs ){
			foreach( $rs as $key => $error ){
				$errors[$key] = $error;
			}
		}

		if( sizeof($errors) > 0 ){
			return $errors;
		}
		return true;
	}
	
	/**
	 * Validates root checkout information
	 * @param array $data
	 * @return multitype:|boolean
	 */
	private static function _validate(array $data){
		$rules = self::$rules;
		$validator = new ValidatorHelper();
		$validator->addSource($data);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		return true;
	}
	
	/**
	 * Validates the base checkout information
	 * @param array $checkout
	 * @return multitype:|boolean
	 */
	private static function _validateCheckout(array $checkout){
		$rules = self::$checkout_rules;
		$validator = new ValidatorHelper();
		$validator->addSource($checkout);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		return true;
	}
	
	/**
	 * Validate checkout items
	 * @param array $items
	 * @return Ambigous <boolean, multitype:multitype: >
	 */
	private static function _validateItems(array $items){
		$errors = array();
		foreach( $items as $item ){
			$validator = new ValidatorHelper();
			$validator->addSource($item);
			$validator->AddRules(self::$checkout_items_rules);
			$validator->run();
			if( sizeof($validator->errors) > 0){
				$errors[] = $validator->errors;
			}
			$validator = null;
		}
		return (sizeof($errors) > 0 )? $errors : true;
	}
	
	/**
	 * Validates checkout sender information
	 * @param array $sender
	 * @return multitype:multitype: unknown |boolean
	 */
	private static function _validateSender(array $sender){
		$errors = array();
		$rules = self::$checkout_sender_rules;
		if( isset( $sender['phone'])){
			$phone = $sender['phone'];
			$r = $rules['phone'];
			unset($rules['phone']);

			$validator = new ValidatorHelper();
			$validator->addSource($phone);
			$validator->AddRules($r);
			$validator->run();
			
			if( sizeof($validator->errors) > 0){
				$errors['phone'] = $validator->errors;
			}
			$validator = null;
		}
		
		if( isset( $sender['documents'])){
			$documents = $sender['documents'];
			$r = $rules['documents'];
			unset($rules['documents']);
			
			foreach( $documents as $document ){
				$validator = new ValidatorHelper();
				$validator->addSource($document);
				$validator->AddRules($r);
				$validator->run();
				if( sizeof($validator->errors) > 0){
					$errors['documents'][] = $validator->errors;
				}
			}
			$validator = null;
		}
		
		$validator = new ValidatorHelper();
		$validator->addSource($sender);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			foreach( $validator->errors as $key => $error ){
				$errors[$key] = $error;
			}
			return $errors;
		}
		
		return true;
	}
	
	/**
	 * Validates checkout shipping information
	 * @param array $shipping
	 * @return multitype:multitype: unknown |boolean
	 */
	private static function _validateShipping(array $shipping){
		$errors = array();
		$rules = self::$checkout_shipping_rules;
		if( isset( $shipping['address'])){
			$address = $shipping['address'];
			$r = $rules['address'];
			unset($rules['address']);
				
			$validator = new ValidatorHelper();
			$validator->addSource($address);
			$validator->AddRules($r);
			$validator->run();
				
			if( sizeof($validator->errors) > 0){
				$errors['address'] = $validator->errors;
			}
		}
		$validator = new ValidatorHelper();
		$validator->addSource($shipping);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			foreach( $validator->errors as $key => $error ){
				$errors[$key] = $error;
			}
			return $errors;
		}
		return true;
	}
	
	/**
	 * Validates checkout receivers information
	 * @param array $receiver
	 * @return multitype:|boolean
	 */
	private static function _validateReceiver(array $receiver){
		$rules = self::$checkout_receiver_rules;
		$validator = new ValidatorHelper();
		$validator->addSource($receiver);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		return true;
	}
	
	/**
	 * Validates checkout metadata information
	 * @param array $metadata
	 * @return multitype:multitype: |boolean
	 */
	private static function _validateMetadata(array $metadata){
		$errors  = array();
		$rules = self::$checkout_receiver_rules;
		foreach( $metadata as $meta ){
			$rules = self::$checkout_receiver_rules;
			$validator = new ValidatorHelper();
			$validator->addSource($meta);
			$validator->AddRules($rules);
			$validator->run();
			if( sizeof($validator->errors) > 0){
				$errors[] = $validator->errors;
			}
		}
		if( sizeof($errors) > 0){
			return $errors;
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function validateStatus($status){
		$transaction_possible_status = UtilsHelper::getStatusArray();
		$staus_codes = UtilsHelper::getStatus((string)$status);
		return  !empty($staus_codes); //   array_key_exists((string)$status, self::transaction_possible_status);
	}
	
	public static function isValidToken($token){
		$localToken = ConfigHelper::getInstance()->get('token');
		if( $token !== $localToken ){
			return false;
		}
		return true;
	}
	
	public static function isValidEmail($email){
		$localEmail = ConfigHelper::getInstance()->get('email');
		if( $email !== $localEmail ){
			return false;
		}
		return true;
	}
	
	public static function isValidUser($token, $email){
		if( !self::isValidToken($token) || self::isValidEmail($email)){
			return false;
		}
		return true;
	}
}