<?php


namespace tvorwachs\ClouDNS;

/**
 * ClouDNS API class
 * @copyright 2014 Techreanimate
 * @author Luis Rodriguez
 * @author Tobias Vorwachs
 */
class ClouDNS
{
    /**
	 * API credential information required to execute requests
	 */
    protected static $apiUrl = 'https://api.cloudns.net/';
    protected static $authId;
    protected static $authPassword;
	
	/**
	 * Verify SSL connection
	 */
    protected static $sslCheck = true;
	
    /**
	 * storage for API responses
	 */
    public $Response;
	
	/**
	 * Pass in options to set as an array
	 * @param $options
     * @return array
	 */
	public static  function setOptions(Array $options = array()){
		self::$apiUrl = isset($options['apiUrl']) ? $options['apiUrl'] : self::$apiUrl;
        self::$authId = isset($options['authId']) ? $options['authId'] : self::$authId;
        self::$sslCheck = isset($options['sslCheck']) ? $options['sslCheck'] : self::$sslCheck;
        self::$authPassword = isset($options['authPassword']) ? $options['authPassword'] : self::$authPassword;
		
		/* Check if login still works */
		$api = new ClouDNS();
		$status = $api->login();
		if($status['status'] != 'Success') return $status;
		
		
		return array('status' => 'Success');
	}
	
	/**
	 * Test login details
	 */
    protected function login(){
		$get = array(
			'auth-id' => self::$authId,
			'auth-password' => self::$authPassword
		);
		
		/* Clean options for GET */
		$get_string = $this->urlEncode($get);
		
		/* Connect */
		$result = $this->connect($get_string,'dns/login.json');
		
		/* Return an array result */
		return json_decode($result,true);
	}
    
    /**
	 * determine our IP address
	 * @return string our public IP address, as seen by icanhazip.com
	 */
    public function detectIp(){
        $ch = curl_init( 'http://icanhazip.com' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        $result = rtrim(curl_exec( $ch ) );
        curl_close( $ch );
        return $result;
    }
	
	/**
	 * Returns the GET array to be used for authentication
	 */
	protected function getAuth(){
		return array('auth-id' => self::$authId,'auth-password' => self::$authPassword);
	}
	
	/** 
	 * Runs the final connection with all the data needed
	 * @param $get_string
	 * @param $directory (optional) - The directory of the api you are calling dns/ or domains/
	 * @return mixed
	 */
    protected function connect($get_string, $directory = 'dns/'){
		$request = curl_init(self::$apiUrl.$directory.'?'.$get_string); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, self::$sslCheck); // uncomment this line if you get no gateway response.
			$this->Response = curl_exec($request); // execute curl post and store results in $post_response
		curl_close ($request); // close curl object
		
		return $this->Response;
	}
	
	/** 
	 * This section takes the input fields and converts them to the proper format
	 * for an http post.  For example: "auth_id=username&auth_password=a1B2c3D4"
	 */
    protected function urlEncode(Array $get_values = array()){
		$get_string = "";
		foreach( $get_values as $key => $value ){
			$get_string .= "$key=" . urlencode( $value ) . "&";
		}
		return rtrim( $get_string, "& " );
	}
}
