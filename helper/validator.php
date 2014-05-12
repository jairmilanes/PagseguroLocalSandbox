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


    /**
     *
     * @the constructor, duh!
     *
     */
    public function __construct()
    {
    }

    /**
     *
     * @add the source
     *
     * @paccess public
     *
     * @param array $source
     *
     */
    public function addSource($source, $trim=false)
    {
        $this->source = $source;
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

            if($opt['required'] == true)
            {
                $this->is_set($var);
            }

            /*** Trim whitespace from beginning and end of variable ***/
            if( array_key_exists('trim', $opt) && $opt['trim'] == true )
            {
                $this->source[$var] = trim( $this->source[$var] );
            }

            switch($opt['type'])
            {
            	case 'in_array':
            		$this->validateInArray($var, $opt['against'], $opt['required']);
            		if(!array_key_exists($var, $this->errors))
            		{
            			$this->sanitizeDate($var);
            		}
            		break;
            	case 'date':
            		$this->validateDate($var, $opt['required']);
            		if(!array_key_exists($var, $this->errors))
            		{
            			$this->sanitizeDate($var);
            		}
            		break;
                case 'email':
                    $this->validateEmail($var, ( !isset($opt['max'])? false : $opt['max'] ), $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeEmail($var);
                    }
                    break;

                case 'url':
                    $this->validateUrl($var);
                    if(!array_key_exists($var, ( !isset($opt['max'])? false : $opt['max'] ), $this->errors))
                    {
                        $this->sanitizeUrl($var);
                    }
                    break;

                case 'numeric':
                    $this->validateNumeric($var, $opt['min'], $opt['max'], $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeNumeric($var);
                    }
                    break;

                case 'string':
                    $this->validateString($var, $opt['min'], $opt['max'], $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeString($var);
                    }
                break;

                case 'float':
                    $this->validateFloat($var, ( !isset($opt['max'])? false : $opt['max'] ), $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeFloat($var);
                    }
                    break;

                case 'ipv4':
                    $this->validateIpv4($var, $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeIpv4($var);
                    }
                    break;

                case 'ipv6':
                    $this->validateIpv6($var, $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeIpv6($var);
                    }
                    break;

                case 'bool':
                    $this->validateBool($var, $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
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
        if(!isset($this->source[$var]))
        {
            $this->errors[$var] = $var . ' is not set';
        }
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
    		$this->errors[$var] = $var . ' is not a valid value';
    	}
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
            $this->errors[$var] = $var . ' is not a valid IPv4';
        }
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
            $this->errors[$var] = $var . ' is not a valid IPv6';
        }
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
    	$this->errors[$var] = $var . ' is an invalid date format (dd/MM/yyyy)';
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
    private function validateFloat($var, $max = false, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_FLOAT) === false)
        {
            $this->errors[$var] = $var . ' is an invalid float';
        }
        if( false !== $max && !isset($this->errors[$var]) ){
        	if( $this->source[$var] > $max ){
        		$this->errors[$var] = $var.' exceeds the maximum value of '.$max;
        	}
        }
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
    private function validateString($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(isset($this->source[$var]))
        {
            if(strlen($this->source[$var]) < $min)
            {
                $this->errors[$var] = $var . ' is too short';
            }
            elseif(strlen($this->source[$var]) > $max)
            {
                $this->errors[$var] = $var . ' is too long';
            }
            elseif(!is_string($this->source[$var]))
            {
                $this->errors[$var] = $var . ' is invalid';
            }
        }
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
        if(filter_var($this->source[$var], FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))===FALSE)
        {
            $this->errors[$var] = $var . ' is an invalid number';
        }
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
    private function validateUrl($var, $max = false, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_URL) === FALSE)
        {
            $this->errors[$var] = $var . ' is not a valid URL';
        }
        if( $max !== false && !isset($this->errors[$var]) ){
        	if(strlen($this->source[$var]) > $max)
        	{
        		$this->errors[$var] = $var . ' is exceds maximum length of '.$max.' chars';
        	}
        }
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
    private function validateEmail($var, $max = false, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $this->errors[$var] = $var . ' is not a valid email address';
        }
        if( $max !== false && !isset($this->errors[$var]) ){
        	if(strlen($this->source[$var]) > $max)
        	{
        		$this->errors[$var] = $var . ' is exceds maximum length of '.$max.' chars';
        	}
        }
        
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
            $this->errors[$var] = $var . ' is Invalid';
        }
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
        $this->sanitized[$var] = (int) filter_var($this->source[$var], FILTER_SANITIZE_NUMBER_INT);
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