<?php
class ValidatorHelper extends SandboxHelper {

    /*
    * @errors array
    */
    public $errors = array();

    /*
    * @the validation rules array
    */
    private $validation_rules = array();

    /*
     * @the sanitized values array
     */
    public $sanitized = array();
     
    /*
     * @the source
     */
    private $source = array();
	
    
    private $existing_codes = array();
    
    private $error_codes = array(
    		11001 => 'receiverEmail is required.',
    		11002 => 'receiverEmail invalid length: {0}',
    		11003 => 'receiverEmail invalid value.',
    		11004 => 'Currency is required.',
    		11005 => 'Currency invalid value: {0}',
    		11006 => 'redirectURL invalid length: {0}',
    		11007 => 'redirectURL invalid value: {0}',
    		11008 => 'reference invalid length: {0}',
    		11009 => 'senderEmail invalid length: {0}',
    		11010 => 'senderEmail invalid value: {0}',
    		11011 => 'senderName invalid length: {0}',
    		11012 => 'senderName invalid value: {0}',
    		11013 => 'senderAreaCode invalid value: {0}',
    		11014 => 'senderPhone invalid value: {0}',
    		11015 => 'ShippingType is required.',
    		11016 => 'shippingType invalid type: {0}',
    		11017 => 'shippingPostalCode invalid Value: {0}',
    		11018 => 'shippingAddressStreet invalid length: {0}',
    		11019 => 'shippingAddressNumber invalid length: {0}',
    		11020 => 'shippingAddressComplement invalid length: {0}',
    		11021 => 'shippingAddressDistrict invalid length: {0}',
    		11022 => 'shippingAddressCity invalid length: {0}',
    		11023 => 'shippingAddressState invalid value: {0}, must fit the pattern: \w\{2\} (e. g. "SP")',
    		11024 => 'Itens invalid quantity.',
    		11025 => 'Item Id is required.',
    		11026 => 'Item quantity is required.',
    		11027 => 'Item quantity out of range: {0}',
    		11028 => 'Item amount is required. (e.g. "12.00")',
    		11029 => 'Item amount invalid pattern: {0}. Must fit the patern: \d+.\d\{2\}',
    		11030 => 'Item amount out of range: {0}',
    		11031 => 'Item shippingCost invalid pattern: {0}. Must fit the patern: \d+.\d\{2\}',
    		11032 => 'Item shippingCost out of range: {0}',
    		11033 => 'Item description is required.',
    		11034 => 'Item description invalid length: {0}',
    		11035 => 'Item weight invalid Value: {0}',
    		11036 => 'Extra amount invalid pattern: {0}. Must fit the patern: -?\d+.\d\{2\}',
    		11037 => 'Extra amount out of range: {0}',
    		11038 => 'Invalid receiver for checkout: {0}, verify receiver\'s account status.',
    		11039 => 'Malformed request XML: {0}.',
    		11040 => 'maxAge invalid pattern: {0}. Must fit the patern: \d+',
    		11041 => 'maxAge out of range: {0}',
    		11042 => 'maxUses invalid pattern: {0}. Must fit the patern: \d+',
    		11043 => 'maxUses out of range.',
    		11044 => 'initialDate is required.',
    		11045 => 'initialDate must be lower than allowed limit.',
    		11046 => 'initialDate must not be older than 6 months.',
    		11047 => 'initialDate must be lower than or equal finalDate.',
    		11048 => 'search interval must be lower than or equal 30 days.',
    		11049 => 'finalDate must be lower than allowed limit.',
    		11050 => 'initialDate invalid format, use \'yyyy-MM-ddTHH:mm\' (eg. 2010-01-27T17:25).',
    		11051 => 'finalDate invalid format, use \'yyyy-MM-ddTHH:mm\' (eg. 2010-01-27T17:25).',
    		11052 => 'page invalid value.',
    		11053 => 'maxPageResults invalid value (must be between 1 and 1000).',
    		11157 => 'senderCPF invalid value: {0}'
    );
    
    private $map = array();

    /**
     * @the constructor, duh!
     */
    public function __construct()
    {
    }

    /**
     * @add the source
     * @paccess public
     *
     * @param array $source
     */
    public function addSource($source)
    {
        $this->source = $source;
    }

    public function setErrorsMap($map){
    	$this->map = $map;
    }

    /**
     *
     * @run the validation rules
     *
     * @access public
     *
     */
    public function run()
    {
    	
    	
        /*** set the vars ***/
        foreach( new ArrayIterator($this->validation_rules) as $var=>$opt)
        {
        	if( !isset($opt['required'])){
        		$opt['required'] = false;
        	}

        	if( !isset($this->source[$var])){
        		$this->source[$var] = null;
        	}
        	
        	$empty = empty($this->source[$var]);
        	
            if( $opt['required'] == true ){
            	$this->is_set($var);
            }

            /*** Trim whitespace from beginning and end of variable ***/
            if( array_key_exists('trim', $opt) && $opt['trim'] == true && !$empty ){
            	$this->source[$var] = ( isset($this->source[$var]) )? trim( $this->source[$var] ) : '';
            }
            
            if( !$opt['required'] && $empty ) {
            	continue;
            }
            
            switch($opt['type'])
            {
            	case 'equalTo':
     
            		break;
            	case 'in_array':
            		if(false !== $this->validateInArray($var, $opt['against'], $opt['required'])){
            			$this->sanitized[$var] = $this->source[$var];
            		}
            		break;
            	case 'date':
            		if(false !== $this->validateDate($var, $opt['required'])){
            			$this->sanitizeDate($var);
            		}
            		break;
                case 'email':
                    if(false !== $this->validateEmail($var, @$opt['max'], $opt['required'])){
                        $this->sanitizeEmail($var);
                    }
                    break;

                case 'url':
                    if(false !== $this->validateUrl($var, @$opt['max'], $opt['required'])){
                        $this->sanitizeUrl($var);
                    }
                    break;

                case 'numeric':
                    if(false !== $this->validateNumeric($var, $opt['min'], $opt['max'], $opt['required'])){
                        $this->sanitizeNumeric($var);
                    }
                    break;

                case 'string':
                    if(false !== $this->validateString($var, $opt['min'], $opt['max'], @$opt['pattern'], $opt['required'])){
                        $this->sanitizeString($var);
                    }
                break;

                case 'float':
                    if(false !== $this->validateFloat($var, @$opt['max'], @$opt['pattern'], $opt['required'])){
                        $this->sanitizeFloat($var);
                    }
                    break;

                case 'ipv4':
                    if(false !== $this->validateIpv4($var, $opt['required'])){
                        $this->sanitizeString($var);
                    }
                    
                    break;

                case 'ipv6':
                    if(false !== $this->validateIpv6($var, $opt['required'])){
                        $this->sanitizeString($var);
                    }
                    break;

                case 'bool':
                    if(false !== $this->validateBool($var, $opt['required'])){
                        $this->sanitized[$var] = (bool) $this->source[$var];
                    }
                    break;
            }
        }
    }


    /**
     *
     * @add a rule to the validation rules array
     *
     * @access public
     *
     * @param string $varname The variable name
     *
     * @param string $type The type of variable
     *
     * @param bool $required If the field is required
     *
     * @param int $min The minimum length or range
     *
     * @param int $max the maximum length or range
     *
     */
    public function addRule($varname, $type, $required=false, $min=0, $max=0, $trim=false)
    {
        $this->validation_rules[$varname] = array('type'=>$type, 'required'=>$required, 'min'=>$min, 'max'=>$max, 'trim'=>$trim);
        /*** allow chaining ***/
        return $this;
    }


    /**
     *
     * @add multiple rules to teh validation rules array
     *
     * @access public
     *
     * @param array $rules_array The array of rules to add
     *
     */
    public function AddRules(array $rules_array)
    {
        $this->validation_rules = array_merge($this->validation_rules, $rules_array);
    }

    /**
     *
     * @Check if POST variable is set
     *
     * @access private
     *
     * @param string $var The POST variable to check
     *
     */
    private function is_set($var)
    {
        if(!isset($this->source[$var]) || empty($this->source[$var]))
        {
            $this->errors[] =  $this->get_error_message($var, 'required', $var.' is not set or empty' );
            return false;
        }
        return true;
    }

    private function testPettern($pattern, $var, $required=false){
    	if($required==false && strlen($this->source[$var]) == 0)
    	{
    		return true;
    	}

    	if( !preg_match($pattern, $this->source[$var]) ){
    		$this->set_error($var, 'pattern', ' invalid pattern: {0}. Must fit the patern: \\'.$pattern.'\}' );
    		return false;
    	}
    	return true;
    }

    private function set_error($var, $type, $default){
    	$msg = $this->get_error_message($var, $type, $default );
    	if( false !== $msg ){
    		$this->errors[] = $msg;
    	}
    }
    
    private function get_error_message($var, $type, $default_msg ){
    	if( isset($this->map[$var][$type]) ){

    		if( !in_array($this->map[$var][$type], $this->existing_codes)){
    			$this->existing_codes[] = $this->map[$var][$type];
    			return array(
    					'code' => $this->map[$var][$type],
    					'message' => $this->error_codes[$this->map[$var][$type]]
    			);
    		} else {
    			return false;
    		}
    	}
    	return $default_msg;
    }

    /**
     *
     * @validate an in array values
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateInArray($var, $against, $required=false)
    {
    	if($required==false && strlen($this->source[$var]) == 0)
    	{
    		return true;
    	}
    	
    	if(!in_array($this->source[$var], $against) )
    	{
    		$this->set_error($var, 'invalid', $var . ' is not a valid value' );
    		return false;
    	}
    	return true;
    }
    
    
    /**
     *
     * @validate an ipv4 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateIpv4($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE)
        {
            $this->set_error($var, 'required', $var . ' is not a valid IPv4' );
            return false;
        }
        return true;
    }

    /**
     *
     * @validate an ipv6 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    public function validateIpv6($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === FALSE)
        {
            $this->set_error($var, 'required', $var . ' is not a valid IPv6' );
            return false;
        }
        return true;
    }
    
    /**
    *
    * @validate an date format
    *
    * @access private
    *
    * @param string $var The variable name
    *
    * @param bool $required
    *
    */
    private function validateDate($var, $required=false){
    	if($required==false && strlen($this->source[$var]) == 0)
    	{
    		return true;
    	}
    	if (substr_count($this->source[$var], '/') == 2) {
    		list($d, $m, $y) = explode('/', $this->source[$var]);
    		return checkdate($m, $d, sprintf('%04u', $y));
    	}
    	$this->set_error($var, 'required', $var . ' is an invalid date format (dd/MM/yyyy)' );
    	return false;
    }

    /**
     *
     * @validate a floating point number
     *
     * @access private
     *
     * @param $var The variable name
     *
     * @param bool $required
     */
    private function validateFloat($var, $max = null, $pattern = null, $required=false)
    {
    	$error = false;
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_FLOAT) === false)
        {
            $this->set_error($var, 'invalid', $var . ' is an invalid float');
            $error = true;
        }
        if( !empty($max) ){
        	if( $this->source[$var] > $max ){
        		$this->set_error($var, 'range', $var.' exceeds the maximum value of '.$max );
        		$error = true;
        	}
        }
        if( !empty($pattern)){
        	if( !$this->testPettern( $pattern, $var )){
        		$error = true;
        	}
        }
        return ( $error )? false : true;
    }

    /**
     *
     * @validate a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param int $min the minimum string length
     *
     * @param int $max The maximum string length
     *
     * @param bool $required
     *
     */
    private function validateString($var, $min=0, $max=0, $pattern = null, $required=false)
    {
    	$error = false;
        if($required==false && strlen($this->source[$var]) == 0){
            return true;
        }
        
        if( !empty($pattern)){
        	if( !$this->testPettern( $pattern, $var ) ){
        		$error = true;
        	}
        }
		
    	if( $max > 0 ){
        	if( !$this->validateStringRange($var, $min, $max, $required) ){
        		$error = true;
        	}
    	}
        
        if(!is_string($this->source[$var])){
        	$this->set_error($var, 'invalid', $var . ' is invalid' );
        	$error = true;
        }
        return ( $error )? false : true;
    }

    /**
     *
     * @validate an number
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param int $min The minimum number range
     *
     * @param int $max The maximum number range
     *
     * @param bool $required
     *
     */
    private function validateNumeric($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        $opts = array("options" => array("min_range"=>$min, "max_range"=>$max));

        if(filter_var($this->source[$var], FILTER_VALIDATE_INT, $opts)===FALSE)
        {
            $this->set_error($var, 'invalid', $var . ' is an invalid number' );
            return false;
        }
        return true;
    }

    /**
     *
     * @validate a url
     *
     * @access private
     *
      * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateUrl($var, $max = null, $required=false)
    {
    	$error = false;
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_URL) === FALSE)
        {
            $this->set_error($var, 'invalid', $var . ' is not a valid URL' );
            $error = true;
        }
        if(  !empty($max) ){
        	if(strlen($this->source[$var]) > $max)
        	{
        		$this->set_error($var, 'range', $var . ' is exceds maximum length of '.$max.' chars' );
        		$error = true;
        	}
        }
        return ( $error )? false : true;
    }


    /**
     *
     * @validate an email address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateEmail($var, $max = null, $required=false)
    {
    	$error = false;
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $this->set_error($var, 'invalid', $var . ' is not a valid email address' );
            $error = true;
        }
        if( !empty($max) ){
        	if(strlen($this->source[$var]) > $max)
        	{
        		$this->set_error($var, 'range', $var . ' is exceds maximum length of '.$max.' chars' );
        		$error = true;
        	}
        }
        return ( $error )? false : true;
    }


    /**
     * @validate a boolean
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param bool $required
     *
     */
    private function validateBool($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        filter_var($this->source[$var], FILTER_VALIDATE_BOOLEAN);
        {
            $this->set_error($var, 'invalid', $var . ' is Invalid');
            return false;
        }
        return true;
    }
    
    private function validateStringRange($var, $min = 0, $max = 0, $required=false){
    	if($required==false && empty($this->source[$var])){
    		return true;
    	}
    	if( $min > 0 ){
    		$min = $this->validateMinLength($var, $min);
    	} else { $min = true; }
    	$max = $this->validateMaxLength($var, $max);
    	return ( !$min || !$max )? false : true;
    }
    
    private function validateNumericRange($var, $min = 0, $max = 0, $required=false){
    	if($required==false && empty($this->source[$var])){
    		return true;
    	}
    	if( $min > 0 ){
    		$min = $this->validateMinLength($var, $min, $type = 'number');
    	}
    	$max = $this->validateMaxLength($var, $max, $type = 'number');
    	return ( !$min || !$max )? false : true;
    }
    
    private function validateMinLength($var, $min, $type = 'string'){
    	$isvalid = ( $type == 'string' )? 
    					(strlen($this->source[$var]) >= $min):
    					($this->source[$var] >= $min);
    	if(!$isvalid){
    		$this->set_error($var, 'range', $var . ' is too short');
    		return false;
    	}
    	return true;
    }
    
	private function validateMaxLength($var, $max, $type = 'string'){
    	$isvalid = ( $type == 'string' )? 
    					(strlen($this->source[$var]) <= $max):
    					($this->source[$var] <= $max);
    	if(!$isvalid)
    	{
    		$this->set_error($var, 'range', $var . ' is too long');
    		return false;
    	}
    	return true;
    }
    
    private function validateEqualTo($var, $control, $required=false){
    	if($required==false && empty($this->source[$var])){
    		return true;
    	}
    	if( $this->source[$var] !== $control ){
    		$this->set_error($var, 'invalid', $var.' is not equal to '.$control);
    		return false;
    	}
    	return true;
    }

    ########## SANITIZING METHODS ############
    /**
     *
     * @santize and date
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @return string
     *
     */
    public function sanitizeDate($var)
    {
    	$this->sanitized[$var] = $this->source[$var];
    }

    /**
     *
     * @santize and email
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @return string
     *
     */
    public function sanitizeEmail($var)
    {
        $email = preg_replace( '((?:\n|\r|\t|%0A|%0D|%08|%09)+)i' , '', $this->source[$var] );
        $this->sanitized[$var] = (string) filter_var($email, FILTER_SANITIZE_EMAIL);
    }


    /**
     *
     * @sanitize a url
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeUrl($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var],  FILTER_SANITIZE_URL);
    }

    /**
     *
     * @sanitize a numeric value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeNumeric($var)
    {
        $this->sanitized[$var] = filter_var((int)$this->source[$var], FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     *
     * @sanitize a float value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeFloat($var)
    {
    	$this->sanitized[$var] = filter_var((float)$this->source[$var], FILTER_SANITIZE_NUMBER_FLOAT);
    }

    /**
     *
     * @sanitize a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeString($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var], FILTER_SANITIZE_STRING);
    }

    
} /*** end of class ***/

?>