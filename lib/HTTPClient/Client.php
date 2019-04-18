<?php

namespace SMSFactor\HttpClient;

use SMSFactor\Error;
use Exception;

class Client implements ClientInterface
{
    private static $instance;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function request($method, $baseUrl, $url, $headers, $params, $queryStringParams)
    {
        $method = strtolower($method);
        
        try {
            $requestParams = [
                'headers' => $headers,
                'query' => $queryStringParams,
                'json' => $params,
            ];
            
            $client = new \GuzzleHttp\Client(['base_uri' => $baseUrl]);
            $response = $client->request($method, $url, $requestParams);
            
            return [(string)$response->getBody(), $response->getStatusCode(), $response->getHeaders()];
        }
        catch(Exception $e) {
            $message = $e->getMessage();
            throw new Error\ApiConnection($message);
        }
    }

}
