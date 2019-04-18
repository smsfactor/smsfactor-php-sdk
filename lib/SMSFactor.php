<?php

namespace SMSFactor;

/**
 * Class SMSFactor
 *
 * @package SMSFactor
 */
class SMSFactor
{
    // @var string The SMSFactor API token to be used for requests.
    public static $apiToken;
    
    // @var string The base URL for the SMSFactor API.
    public static $apiBase = 'https://api.smsfactor.com';
    
    /**
     * Sets the API token to be used for requests.
     *
     * @param string $apiToken
     */
    public static function setApiToken($apiToken)
    {
        self::$apiToken = $apiToken;
    }
}