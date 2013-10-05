<?php

/*
    The MIT License (MIT)

    Copyright (c) 2013 "jfd34"

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
*/

/**
 * An interface to the MediaWiki API.
 * 
 * @author jfd34
 */
class APIInterface {
    
    /**
     * The single instance of the APIInterface class.
     * 
     * @access private
     * @var APIInterface
     */
    public static $instance;
    
    /**
     * Whether initialisation of this class is complete. (i.e. the init() method has been called)
     * 
     * @access private
     * @static
     * @var bool
     */
    private static $_initComplete = false;
    
    /**
     * Whether the interface is in a logged-in state.
     * 
     * @access private
     * @var bool
     */
    private $_loggedIn = false;
    
    /**
     * The path to the server-side MediaWiki API.
     * 
     * @access public
     * @var string
     */
    public $apiPath = 'https://en.wikipedia.org/w/api.php';
    
    /**
     * The request headers to be sent to the server.
     * 
     * @access public
     * @var array
     */
    public $headers = [];
    
    /**
     * The cookies to be sent to the server.
     * 
     * @access private
     * @var array
     */
    private $_cookies = [];
    
    /**
     * The number of seconds to wait after each request.
     * 
     * @access public
     * @var int
     */
    public $delay = 3;
    
    /**
     * Initialises this class. Can be called only once, subsequent calls throw an APIInterfaceException.
     * 
     * @static
     */
    public static function init() {
        if ( self::$_initComplete ) {
            throw new APIInterfaceException("APIInterface::init() has already been called.");
        }
        
        self::$_initComplete = true;
        self::$instance = new APIInterface();
    }
    
    /**
     * Constructor (to prevent direct instantiation)
     * 
     * @access provate
     */
    private function __construct() {
        
    }
    
    /**
     * Destructor (logs out if the object is deleted in a logged-in state)
     * 
     * @access public
     */
    public function __destruct() {
        if ( $this->_loggedIn ) $this->logout();
    }
    
    /**
     * Log in to an account.
     * 
     * @param string $username The account's username
     * @param string $password The account's password
     */
    public function login($username, $password) {
        
        # First login step
        $requestData = [
            'action' => 'login',
            'lgname' => $username,
            'lgpassword' => $password,
        ];
        
        $result = $this->query('POST', [], $requestData);
        
        $loginResult = $result['login'];
        
        if ( $loginResult['result'] == 'Success' ) {
            # Only on versions of MediaWiki without a two-step login authentication
            $this->_loggedIn = true;
        }
        else if ( $loginResult['result'] == 'NeedToken' ) {
            
            # Second login with token
            $requestData = [
                'action' => 'login',
                'lgname' => $username,
                'lgpassword' => $password,
                'lgtoken' => $loginResult['token'],
            ];
            
            $result = $this->query('POST', [], $requestData);
            $loginResult = $result['login'];
            
            if ( $loginResult['result'] != 'Success' ) {
                throw new APIInterfaceException("Login failed: (result = {$loginResult['result']})", $requestData, $result);
            }
            
            $this->_loggedIn = true;
            
        }
        else {
            throw new APIInterfaceException("Login failed: (result = {$loginResult['result']})", $requestData, $result);
        }
        
    }
    
    /**
     * Log out of an account.
     */
    public function logout() {
        $this->query(
            'GET',
            [
                'action' => 'logout',
            ]
        );
        $this->_cookies = [];
        $this->_loggedIn = false;
    }
    
    /**
     * Query the API.
     * 
     * @param string $method The HTTP request method to use (GET or POST)
     * @param array $getdata An array containing the parameters for a GET request
     * @param array $postdata An array containing the parameters for a POST request
     * @return array An array containing the JSON-decoded API result.
     */
    public function query($method, $getdata = [], $postdata = []) {
        
        $headers = $this->headers;  # Copy the headers as some more headers have to be added locally
        $streamContextOptions = [];
        
        if ( $method == 'POST' ) {
            $postdata['format'] = 'json';  # Set the format to JSON
            
            $body = http_build_query($postdata);
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Content-Length: ' . strlen($body);
            $streamContextOptions['content'] = $body;
        }
        else {
            $getdata['format'] = 'json';
        }
        
        if ( $this->_cookies ) {
            $headers[] = "Cookie: " . implode(';', $this->_cookies);
        }
        
        $streamContextOptions['method'] = $method;
        $streamContextOptions['header'] = implode("\r\n", $headers);
        
        $streamContext = stream_context_create([ 'http' => $streamContextOptions ]);
        $uri = $this->apiPath . ($getdata ? '?' . http_build_query($getdata) : '');
        
        $result = file_get_contents($uri, 0, $streamContext);
        sleep($this->delay);
        
        if ( ! $result ) {
            throw new APIInterfaceException("Query to API failed", $postdata + $getdata, null);
        }
        
        $result = json_decode($result, true);
        
        if ( isset($result['error']) ) {
            throw new APIInterfaceException("Error from MediaWiki API: [{$result['error']['code']}] {$result['error']['info']}", $getdata + $postdata, $result);
        }
        
        $this->_setCookies($http_response_header);
        
        return $result;
        
    }
    
    /**
     * Parses the HTTP response headers and sets the cookies for future queries.
     * 
     * @param array $responseHeaders The response headers to parse.
     */
    private function _setCookies($responseHeaders) {
        
        foreach ( $responseHeaders as $header ) {
            if ( preg_match('/Set-Cookie \s* \: \s* ([a-z0-9_]+) \s* = \s* (.*?) (?:;|$)/isx', $header, $cookieMatch) ) {
                $this->_cookies[] = "{$cookieMatch[1]}={$cookieMatch[2]}";
            }
        }
        
    }
    
}

/**
 * An exception thrown by the APIInterface class.
 */
class APIInterfaceException extends Exception {
    
    /**
     * The request data sent to the API
     * 
     * @access private
     * @var array
     */
    private $_requestData;
    
    /**
     * The response data received from the API
     * 
     * @access private
     * @var array
     */
    private $_responseData;
    
    /**
     * Constructor function.
     * 
     * @param string $message The error message.
     * @param array $requestData An array containing the request data sent to the API.
     * @param array $responseData An array containing the response data received from the API.
     */
    public function __construct($message, $requestData = null, $responseData = null) {
        parent::__construct($message);
        $this->_requestData = $requestData;
        $this->_responseData = $responseData;
    }
    
    /**
     * Getter function.
     * 
     * @property-read array $requestData An array containing the request data sent to the API.
     * @property-read array $responseData An array containing the response data received from the API.
     */
    public function __get($name) {
        
        switch ( $name ) {
            case 'requestData' :
                return $this->_requestData;
                
            case 'responseData' :
                return $this->_responseData;
                
            default :
                trigger_error("Undefined property {$name} in " . __CLASS__, E_USER_NOTICE);
        }
        
    }
    
}

# Initialises the API interface so that it cannot be initialised again.
APIInterface::init();

?>