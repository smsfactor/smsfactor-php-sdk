<?php

namespace SMSFactor;

/**
 * Class Account
 *
 * @package SMSFactor
 */
class Account extends ApiResource
{
    /**
     * Account types
     */
    const TYPE_COMPANY = 'company';
    const TYPE_ASSOCIATION = 'association';
    const TYPE_ADMINISTRATION = 'administration';
    const TYPE_PRIVATE = 'private';
    
    
    /**
     * Create an account.
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function create($params = null)
    {
        $url = "/account";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Retrieve your account informations.
     *
     * @return ApiResponse The api response.
     */
    public static function get()
    {
        $url = "/account";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Get all your sub-accounts.
     *
     * @return ApiResponse The api response.
     */
    public static function subAccounts()
    {
        $url = "/sub-accounts";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Get remaining credits on your account.
     * 
     * @return ApiResponse The api response.
     */
    public static function credits()
    {
        $url = '/credits';
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
}