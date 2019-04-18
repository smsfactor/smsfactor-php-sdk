<?php

namespace SMSFactor\HttpClient;

interface ClientInterface
{
    /**
     * @param string $method The HTTP method being used
     * @param string $baseUrl The base URL being requested, including domain and protocol
     * @param string $url The URL being requested (example : /credits)
     * @param array  $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array  $params KV pairs for parameters.
     * @param array  $params KV pairs for parameters added in url.
     *
     * @throws \SMSFactor\Error\Api
     * @throws \SMSFactor\Error\ApiConnection
     * @return array An array whose first element is raw request body, second
     *    element is HTTP status code and third array of HTTP headers.
     */
    public function request($method, $baseUrl, $url, $headers, $params, $queryStringParams);
}
