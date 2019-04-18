<?php

namespace SMSFactor;

/**
 * Class Token
 *
 * @package SMSFactor
 */
class Token extends ApiResource
{
    /**
     * Get all your tokens
     *
     * @return ApiResponse The api response.
     */
    public static function all()
    {
        $url = '/token';
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    
    /**
     * Create a token
     * 
     * @return ApiResponse The api response.
     */
    public static function create($params = null)
    {
        $url = '/token';
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Delete one of your tokens.
     *
     * @param int Id of the token.
     *
     * @return ApiResponse The api response.
     */
    public static function delete($id)
    {
        $url = "/token/{$id}";
        $response = self::_staticRequest('delete', $url);
        
        return $response;
    }
}