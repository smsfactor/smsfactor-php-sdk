<?php

namespace SMSFactor\ApiOperations;

/**
 * Trait for resources that need to make API requests.
 */
trait Request
{
    /**
     * @param string     $method HTTP method ('get', 'post', etc.)
     * @param string     $url URL for the request
     * @param array|null $params list of parameters for the request
     * @param array|null $queryStringParams list of parameters for the request (added in url)
     *
     * @return string the JSON response
     */
    protected function _request($method, $url, $params = null, $queryStringParams = null)
    {
        $response = static::_staticRequest($method, $url, $params, $queryStringParams);
        
        return $response;
    }
    
    /**
     * @param string     $method HTTP method ('get', 'post', etc.)
     * @param string     $url URL for the request
     * @param array|null $params list of parameters for the request
     * @param array|null $queryStringParams list of parameters for the request (added in url)
     *
     * @return string the JSON response
     */
    protected static function _staticRequest($method, $url, $params = null, $queryStringParams = null)
    {
        $requestor = new \SMSFactor\ApiRequestor();
        $response = $requestor->request($method, $url, $params, $queryStringParams);
        
        return $response;
    }
    
    
}