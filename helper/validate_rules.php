<?php
class ValidateRulesHelper extends SandboxHelper {
	
	/**
	 * Checkout validation
	 * @var array
	 */
	public static $checkout_rules = array(
			'currency'			=>	array('type'=>'in_array',  	'required'=>true, 	'against' => array('BRL'), 				'trim'=>true),
			'reference'			=>	array('type'=>'string',  	'required'=>false, 	'min'=>0, 			 'max'=>200, 		'trim'=>true),
			'extraAmount'   	=>	array('type'=>'float',  	'required'=>false, 	'min'=> -9999999,	 'max'=> 9999999,   'trim'=>true),
			'redirectURL'   	=>	array('type'=>'url',    	'required'=>false, 						 'max'=> 255, 	    'trim'=>true),
			'notificationURL'   =>	array('type'=>'url',    	'required'=>false, 						 'max'=> 255, 	  	'trim'=>true),
			'maxUses'   		=>	array('type'=>'numeric',    'required'=>false, 	'min'=> 1 , 		 'max'=> 255, 	  	'trim'=>true, 'pattern' =>  '/\d+$/'),
			'maxAge'   			=>	array('type'=>'numeric',    'required'=>false, 	'min'=> 30 , 		 'max'=> 999999999, 'trim'=>true, 'pattern' =>  '/\d+$/')
	);
	
	/**
	 * Receiver validation
	 * @var array
	 */
	public static $checkout_receiver_rules = array(
			'email'=>array('type'=>'email',  'required'=>false, 'min'=>1, 'max'=>60, 'trim'=>true)
	);
	
	/**
	 * Items validation rules
	 * @var array
	*/
	public static $checkout_items_rules = array(
			'id'			=>	array('type'=>'string',    'required'=>true, 'min'=>1,  'max'=>100, 		'trim'=>true),
			'description'	=>	array('type'=>'string',    'required'=>true, 'min'=>3,  'max'=>100, 		'trim'=>true),
			'amount'		=>	array('type'=>'float',     'required'=>true, 'pattern' =>  '/\d+.\d{2}$/',   'max'=> 9999999.00, 	'trim'=>true),
			'quantity'		=>	array('type'=>'numeric',   'required'=>true, 'min'=>1,  'max'=>999, 		'trim'=>true),
			'shippingCost'	=>	array('type'=>'float',     'required'=>false,		    'max'=>9999999,     'trim'=>true),
			'weight'		=>	array('type'=>'numeric',   'required'=>false, 'min'=>1,  'max'=>30000, 		'trim'=>true)
	);
	
	/**
	 * Sender validation
	 * @var array
	*/
	public static $checkout_sender_rules = array(
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
	public static $checkout_shipping_rules = array(
		'type' => array('type'=>'in_array', 'required'=>false, 'against' => array(1,2,3), 'trim'=>true),
		'cost' => array('type'=>'float',     'required'=>true, 'pattern' =>  '/\d+.\d{2}$/',   'max'=> 9999999.00, 	'trim'=>true),
		'address' => array(
			'street' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>80,  'trim'=>true),
			'number' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>20,  'trim'=>true),
			'complement' => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>40,  'trim'=>true),
			'district' 	 => array('type'=>'string',   'required'=>false,  'min'=>0, 'max'=>60,  'trim'=>true),
			'postalCode' => array('type'=>'string',   'required'=>false,  'min'=>7, 'max'=>9,   'trim'=>false),
			'city' 		 => array('type'=>'string',   'required'=>false,  'min'=>2, 'max'=>60,  'trim'=>true),
			'state' 	 => array('type'=>'string',   'required'=>false,  'min'=>2, 'max'=>2,   'trim'=>true, 'pattern' => '/\w{2}$/'),
			'country' 	 => array('type'=>'in_array', 'required'=>false,  'against' => array('BRA'),   'trim'=>true),
		)
	);
	
	/**
	 * Metadados validation
	 * @var array
	*/
	public static $checkout_metadata_rules = array(
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
	 * Validation
	 * @var unknown
	*/
	public static $rules = array(
			'charset' 	=> array('type'=>'in_array', 	'required'=>false,  'against' => array('ISO-8859-1','UTF-8'), 'trim'=>true),
			'email'		=> array('type'=>'email',  		'required'=>true, 	'max'=>60, 'trim'=>true),
			'token'		=> array('type'=>'string',  	'required'=>true, 	'min'=>32, 'max'=>32, 'trim'=>true),
	);
	
	public static function getRules(){
		$rules = self::$rules;
		$rules['checkout'] = self::$checkout_rules;
		$rules['checkout']['items'] = self::$checkout_items_rules;
		$rules['checkout']['sender'] = self::$checkout_sender_rules;
		$rules['checkout']['shipping'] = self::$checkout_shipping_rules;
		$rules['checkout']['receiver'] = self::$checkout_receiver_rules;
		$rules['checkout']['metadata'] = self::$checkout_metadata_rules;
		return $rules;
	}
	
	
	
}