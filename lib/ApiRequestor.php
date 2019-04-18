<?php

namespace SMSFactor;

/**
 * Class ApiRequestor
 *
 * @package SMSFactor
 */
class ApiRequestor
{
    /**
     * @var string|null
     */
    private $_apiToken;

    /**
     * @var string
     */
    private $_apiBase;
    
    /**
     * @var HttpClient\ClientInterface
     */
    private static $_httpClient;

    /**
     * ApiRequestor constructor.
     *
     * @param string|null $apiToken
     * @param string|null $apiBase
     */
    public function __construct($apiToken = null, $apiBase = null)
    {
        if (!$apiToken) {
            $apiToken = SMSFactor::$apiToken;
        }
        $this->_apiToken = $apiToken;
        if (!$apiBase) {
            $apiBase = SMSFactor::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }
    
    /**
     * @param string     $method
     * @param string     $url
     * @param array|null $params
     * @param array|null $queryStringParams list of parameters for the request (added in url)
     *
     * @return ApiResponse An API response.
     * @throws Error\Api
     * @throws Error\ApiConnection
     * @throws Error\Authentication
     * @throws Error\InsufficientCredits
     * @throws Error\InvalidRequest
     * @throws Error\Unknown
     */
    public function request($method, $url, $params = null, $queryStringParams = null)
    {
        $params = $params ?: [];
        $queryStringParams = $queryStringParams ?: [];
        list($rbody, $rcode, $rheaders) = $this->_requestRaw($method, $url, $params, $queryStringParams);
        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $json);
        
        return $resp;
    }
    
    /**
     * @static
     *
     * @param string $apiToken
     *
     * @return array
     */
    private static function _defaultHeaders($apiToken)
    {
        $defaultHeaders = [
            'Accept' => 'application/json',
            'X-application' => 15,
            'Authorization' => 'Bearer ' . $apiToken,
        ];
        return $defaultHeaders;
    }
    
    /**
     * @param string $method
     * @param string $url
     * @param array  $params
     * @param array  $queryStringParams
     *
     * @return string
     * @throws Error\ApiConnection
     * @throws Error\Authentication
     */
    private function _requestRaw($method, $url, $params, $queryStringParams)
    {
        $myApiToken = $this->_apiToken;
        if (!$myApiToken) {
            $msg = 'No API token provided.  (HINT: set your API key using '
                . '"SMSFactor::setApiToken(<API-TOKEN>)".';
            throw new Error\Authentication($msg);
        }
        
        $defaultHeaders = $this->_defaultHeaders($myApiToken);
        
        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $this->_apiBase,
            $url,
            $defaultHeaders,
            $params,
            $queryStringParams
        );
        return [$rbody, $rcode, $rheaders];
    }
    
    /**
    * @param string $rbody
    * @param int    $rcode
    * @param array  $rheaders
    *
    * @return mixed
    * @throws Error\Api
    * @throws Error\Authentication
    * @throws Error\InsufficientCredits
    * @throws Error\InvalidRequest
    * @throws Error\Unknown
    */
    private function _interpretResponse($rbody, $rcode, $rheaders)
    {
        $resp = json_decode($rbody);
        $jsonError = json_last_error();
        if ($resp === null && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid response body from API: $rbody "
            . "(HTTP response code was $rcode, json_last_error() was $jsonError)";
            throw new Error\Api($msg, $rcode, $rbody);
        }
        
        $this->handleErrorResponse($rbody, $rcode, $rheaders, $resp);
        return $resp;
    }
    
    /**
     * @param string $rbody A JSON string.
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Error\Authentication      if the error is caused by a bad token.
     * @throws Error\InsufficientCredits if the error is caused by insuffient credits for the action.
     * @throws Error\InvalidRequest      if the error is caused by an invalid request.
     * @throws Error\Unknown             if the error is caused by an unknown reason.
     * @throws Error\Api                 otherwise.
     */
    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
    {
        $exceptionClassName = null;
        $msg = null;
        
        // Error returned by API (with code)
        if(property_exists($resp, 'status') && is_int($resp->status) && $resp->status < 0) {
            $mapErrors = [
                -1  => 'Authentication',            // Auth error
                -2  => 'InvalidRequest',            // XML error
                -3  => 'InsufficientCredits',       // Insufficient credits
                -6  => 'InvalidRequest',            // JSON error
                -7  => 'InvalidRequest',            // Data error
                -99 => 'Unknown',                   // Unknown error
            ];
            $msg = property_exists($resp, 'details') ? $resp->details : null;
            
            $exceptionClassName = array_key_exists($resp->status, $mapErrors) ? $mapErrors[$resp->status] : 'Api';
        }
        // Error returned by API (no code)
        elseif(property_exists($resp, 'error')) {
            $exceptionClassName = 'Api';
            $msg = $resp->error;
        }
        
        // There is an error
        if(!empty($exceptionClassName)) {
            $exceptionFullClassName = 'SMSFactor\Error\\'.$exceptionClassName;
            throw new $exceptionFullClassName($msg, $rcode, $rbody, $resp, $rheaders);
        }
    }
    
    /**
     * @static
     *
     * @param HttpClient\ClientInterface $client
     */
    public static function setHttpClient($client)
    {
        self::$_httpClient = $client;
    }
    
    /**
     * @return HttpClient\ClientInterface
     */
    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = HttpClient\Client::instance();
        }
        return self::$_httpClient;
    }
}