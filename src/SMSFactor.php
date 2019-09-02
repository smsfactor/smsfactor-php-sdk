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

    // @var string The application code. Do not manually change it.
    public static $applicationCode = 15;
    
    /**
     * Sets the API token to be used for requests.
     *
     * @param string $apiToken
     */
    public static function setApiToken($apiToken)
    {
        self::$apiToken = $apiToken;
    }

    /**
     * Sets the application code for the requests.
     *
     * @param string $applicationCode
     */
    public static function setApplicationCode($applicationCode)
    {
        self::$applicationCode = $applicationCode;
    }
}
