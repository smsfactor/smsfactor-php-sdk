<?php

namespace SMSFactor;

/**
 * Class ApiResponse
 *
 * @package SMSFactor
 */
class ApiResponse
{
    private $headers;
    private $body;
    private $json;
    private $code;
    
    /**
     * @param string $body
     * @param integer $code
     * @param array|null $headers
     * @param array|null $json
     *
     * @return obj An APIResponse
     */
    public function __construct($body, $code, $headers, $json)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->json = $json;
    }
    
    /**
     * @return array The response code
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @return array The response headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    
    /**
     * @return array The response body
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @return array The response json
     */
    public function getJson()
    {
        return $this->json;
    }
    
    /**
     * Magic Method - Getter
     * 
     * @param string $name
     * 
     * @return mixed The corresponding value in JSON or NULL
     */
    public function __get($name)
    {
        return property_exists($this->json, $name) ? $this->json->{$name} : null;
    }
    
    /**
     * Magic Method - Isset
     *
     * @param string $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return property_exists($this->json, $name);
    }
}