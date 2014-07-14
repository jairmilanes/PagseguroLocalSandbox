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
	
	private static $map = array(
		'checkout' => array(
			'redirectURL' => array(
				'range'   => 11006,
				'invalid' => 11007
			),
			'currency' => array(
				'invalid'  => 11005,
				'required' => 11004
			),
			'maxUses' => array(
				'invalid' => 11042,
				'pattern' => 11042,
				'range' => 11043
			),
			'maxAge' => array(
				'invalid' => 11040,
				'pattern' => 11040,
				'range' => 11041
			),
			'items' => array(
				'id' => array(
					'invalid'  => 11025,
					'range'	   => 11025,
					'required' => 11025
				),
				'description' => array(
					'invalid'   => 11034,
					'required'  => 11033,
					'range' 	=> 11034
				),
				'amount' => array(
					'invalid'   => 11029,
					'required'  => 11028,
					'pattern'   => 11029,
					'range' 	=> 11030
				),
				'quantity' => array(
					'invalid'   => 11024,
					'required'  => 11026,
					'range'     => 11027
				),
				'weight' => array(
					'invalid'   => 11035,
					'pattern'   => 11035
				),
			),
			'reference' => array(
				'invalid' => 11008,
				'range'   => 11008
			),
			'sender' => array(
				'name' => array(
					'invalid' => 11012,
					'range'   => 11011
				),
				'email' => array(
					'invalid' => 11010,
					'range'   => 11009
				),
				'phone' => array(
					'areaCode' => array(
						'invalid' => 11013
					),
					'number' => array(
						'invalid' => 11014
					)
				)/*,
				'documents' => array(
					'document' => array(
						'type' => '',
						'value' => ''	
					)
				)*/
			),
			'shipping'  => array(
				'cost' => array(
					'invalid'   => 11031,
					'pattern'   => 11031,
					'range' 	=> 11032
				),
				'type' => array(
					'required' => 11015,
					'invalid'  => 11016
				),
				'address'  => array(
					'street' => array(
						'invalid' => 11018,
						'range' => 11018
					),
					'number' => array(
						'invalid' => 11019,
						'range' => 11019
					),
					'complement' => array(
						'invalid' => 11020,
						'range' => 11020
					),
					'district' => array(
						'invalid' => 11021,
						'range' => 11021
					),
					'postalCode' => array(
						'invalid' => 11017,
						'range' => 11017
					),
					'city' => array(
						'invalid' => 11022,
						'range' => 11022
					),
					'state' => array(
						'invalid' => 11023,
						'range'   => 11023,
						'pattern' => 11023
					)
				)
			)
		)
	);
	
	protected static $validated = array();

	public static function get_valids(){
		$rs = self::$validated;
		self::$validated = array();
		return $rs;
	}
	
	/**
	 * Validates required pagseguro params
	 *
	 * @return multitype:|string
	 */
	public static function validateRequired() {
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
		$errors_struct = array();
		$data = ParamsHelper::parse_checkout_params($data);

		if( isset($data['checkout']) ){
			
			self::$validated['checkout'] = array();
			
			$checkout = $data['checkout'];
			unset($data['checkout']);
			
			if( isset($checkout['items']) && count($checkout['items']) > 0 ){
				$items = $checkout['items'];
				unset($checkout['items']);
				
				$rs = self::_validateItems($items);
				
				if( true !== $rs ){
					$errors_struct['checkout']['items'] = $rs;
					$errors = array_merge($errors,$rs[0]);
				}
			}
			
			if( isset($checkout['sender']) && count($checkout['sender']) > 0 ){
				$sender = $checkout['sender'];
				unset($checkout['sender']);
				
				$rs = self::_validateSender($sender);
				if( true !== $rs ){
					$errors_struct['checkout']['sender'] = $rs;
					$errors = array_merge($errors,$rs);
				}
			}
			
			if( isset($checkout['shipping']) && count($checkout['shipping']) > 0 ){
				$shipping = $checkout['shipping'];
				unset($checkout['shipping']);
				
				$rs = self::_validateShipping($shipping);
				if( true !== $rs ){
					$errors_struct['checkout']['shipping'] = $rs;
					$errors = array_merge($errors,$rs);
				}
			}
			
			if( isset($checkout['receiver']) && count($checkout['receiver']) > 0 ){
				$receiver = $checkout['receiver'];
				unset($checkout['receiver']);
				
				$rs = self::_validateReceiver($receiver);
				if( true !== $rs ){
					$errors_struct['checkout']['receiver'] = $rs;
					$errors = array_merge($errors,$rs);
				}
			}
			
			if( isset($checkout['metadata']) && count($checkout['metadata']) > 0 ){
				$metadata = $checkout['metadata'];
				unset($checkout['metadata']);
				
				$rs = self::_validateMetadata($metadata);
				if( true !== $rs ){
					$errors_struct['checkout']['metadata'] = $rs;
					$errors = array_merge($errors,$rs);
				}
			}
			
			$rs = self::_validateCheckout($checkout);
			
			if( is_array($rs) ){
				foreach( $rs as $key => $error ){
					$errors_struct['checkout'][$key] = $error;
					array_push($errors,$error);
				}
			}
			
		} else {
			$errors_struct['checkout']['checkout'] = 'Checkout data not found!';
			$errors[] = array('code'=>'0','message'=>'Checkout data not found!');
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
		$rules = ValidateRulesHelper::$rules;
		$validator = new ValidatorHelper();
		$validator->addSource($data);
		$validator->AddRules($rules);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		//self::$validated[] = '';
		return true;
	}
	
	/**
	 * Validates the base checkout information
	 * @param array $checkout
	 * @return multitype:|boolean
	 */
	private static function _validateCheckout(array $checkout){
		$rules = ValidateRulesHelper::$checkout_rules;
		$validator = new ValidatorHelper();
		$validator->addSource($checkout);
		$validator->AddRules($rules);
		$validator->setErrorsMap(self::$map['checkout']);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		self::$validated['checkout'] = array_merge(self::$validated['checkout'], $validator->sanitized);
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
			$validator->AddRules(ValidateRulesHelper::$checkout_items_rules);
			$validator->setErrorsMap(self::$map['checkout']['items']);
			$validator->run();

			if( sizeof($validator->errors) > 0){
				$errors[] = $validator->errors;
			} else {
				if( !isset(self::$validated['checkout']['items']) ){
					self::$validated['checkout']['items'] = array();
				}
				self::$validated['checkout']['items'][] = $validator->sanitized;
			}
			$validator = null;
		}
		if( sizeof($errors) > 0 ){
			return $errors;
		}
		
		return true;
	}
	
	/**
	 * Validates checkout sender information
	 * @param array $sender
	 * @return multitype:multitype: unknown |boolean
	 */
	private static function _validateSender(array $sender){
		$errors = array();
		$validated = array();
		$rules = ValidateRulesHelper::$checkout_sender_rules;
		if( isset( $sender['phone'])){
			$phone = $sender['phone'];
			$r = $rules['phone'];
			unset($rules['phone']);

			$validator = new ValidatorHelper();
			$validator->addSource($phone);
			$validator->AddRules($r);
			$validator->setErrorsMap(self::$map['checkout']['sender']['phone']);
			$validator->run();
			
			if( sizeof($validator->errors) > 0){
				$errors['phone'] = $validator->errors;
			} else {
				$validated['phone'] = $validator->sanitized;
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
				$validator->setErrorsMap(self::$map['checkout']['sender']['documents']);
				$validator->AddRules($r);
				$validator->run();
				if( sizeof($validator->errors) > 0){
					$errors['documents'][] = $validator->errors;
				} else {
					$validated['documents'] = $validator->sanitized;
				}
			}
			$validator = null;
		}
		
		$validator = new ValidatorHelper();
		$validator->addSource($sender);
		$validator->AddRules($rules);
		$validator->setErrorsMap(self::$map['checkout']['sender']);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			foreach( $validator->errors as $key => $error ){
				$errors[$key] = $error;
			}
			return $errors;
		}
		$validated = array_merge($validated, $validator->sanitized);
		$validator = null;
		
		if( !isset(self::$validated['checkout']['sender']) ){
			self::$validated['checkout']['sender'] = array();
		}
		self::$validated['checkout']['sender'] = $validated;
		
		return true;
	}
	
	/**
	 * Validates checkout shipping information
	 * @param array $shipping
	 * @return multitype:multitype: unknown |boolean
	 */
	private static function _validateShipping(array $shipping){
		$errors = array();
		$validated = array();
		$rules = ValidateRulesHelper::$checkout_shipping_rules;

		if( isset( $shipping['address'])){
			$address = $shipping['address'];
			$r = $rules['address'];
			unset($rules['address']);
				
			$validator = new ValidatorHelper();

			$validator->addSource($address);
			$validator->AddRules($r);
			$validator->setErrorsMap(self::$map['checkout']['shipping']['address']);
			$validator->run();

			if( sizeof($validator->errors) > 0){
				$errors = $validator->errors;
			} else {
				$validated['address'] = $validator->sanitized;
			}			$validator = null;
		}
		
		$validator = new ValidatorHelper();

		$validator->addSource($shipping);
		$validator->AddRules($rules);
		$validator->setErrorsMap(self::$map['checkout']['shipping']);
		$validator->run();
		
		if( sizeof($validator->errors) > 0){
			foreach( $validator->errors as $key => $error ){
				$errors[$key] = $error;
			}
		}
		
		if( sizeof($errors) > 0 ){
			return $errors;
		}
		$validated = array_merge($validated, $validator->sanitized);
		
		if( !isset(self::$validated['checkout']['shipping']) ){
			self::$validated['checkout']['shipping'] = array();
		}
		self::$validated['checkout']['shipping'][] = $validated;
		
		return true;
	}
	
	/**
	 * Validates checkout receivers information
	 * @param array $receiver
	 * @return multitype:|boolean
	 */
	private static function _validateReceiver(array $receiver){
		$rules = ValidateRulesHelper::$checkout_receiver_rules;
		$validator = new ValidatorHelper();
		$validator->addSource($receiver);
		$validator->AddRules($rules);
		$validator->setErrorsMap(self::$map['checkout']['receiver']);
		$validator->run();
		if( sizeof($validator->errors) > 0){
			return $validator->errors;
		}
		if( !isset(self::$validated['checkout']['receiver']) ){
			self::$validated['checkout']['receiver'] = array();
		}
		self::$validated['checkout']['receiver'][] = $validator->sanitized;
		return true;
	}
	
	/**
	 * Validates checkout metadata information
	 * @param array $metadata
	 * @return multitype:multitype: |boolean
	 */
	private static function _validateMetadata(array $metadata){
		$errors  = array();
		$rules = ValidateRulesHelper::$checkout_receiver_rules;
		foreach( $metadata as $meta ){
			$rules = self::$checkout_receiver_rules;
			$validator = new ValidatorHelper();
			$validator->addSource($meta);
			$validator->AddRules($rules);
			$validator->setErrorsMap(array());
			$validator->run();
			if( sizeof($validator->errors) > 0){
				$errors[] = $validator->errors;
			}
		}
		if( sizeof($errors) > 0){
			return $errors;
		}
		
		if( !isset(self::$validated['checkout']['metadata']) ){
			self::$validated['checkout']['metadata'] = array();
		}
		self::$validated['checkout']['metadata'][] = $validator->sanitized;
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
/*
 * 
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
	}*/
 