<?php

namespace SMSFactor;

/**
 * Class Campaign
 *
 * @package SMSFactor
 */
class Campaign extends SMS
{
    /**
     * Send, or simulate, a campaign.
     *
     * @param array|null $params
     * @param boolean $simulate True for simulating the sending, false for real sending. Defaults to false.
     *
     * @return ApiResponse The api response.
     */
    public static function send($params = null, $simulate = false)
    {
        $url = $simulate ? "/send/simulate" : "/send";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Send, or simulate, a campaign to lists.
     * 
     * @param array|null $params
     * @param boolean $simulate True for simulating the sending, false for real sending. Defaults to false.
     *
     * @return ApiResponse The api response.
     */
    public static function sendToLists($params = null, $simulate = false)
    {
        $url = $simulate ? "/send/lists/simulate" : "/send/lists";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Get campaigns history.
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function history($params = null)
    {
        $url = "/campaigns";
        $response = self::_staticRequest('get', $url, null, $params);
        
        return $response;
    }
    
    /**
     * Get one of your campaigns.
     *
     * @param int $id Id of the campaign.
     *
     * @return ApiResponse The api response.
     */
    public static function get($id)
    {
        $url = "/campaign/{$id}";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Cancel a future campaign.
     *
     * @param int $id Id of the campaign.
     *
     * @return ApiResponse The api response.
     */
    public static function cancel($id)
    {
        $url = "/send/{$id}";
        $response = self::_staticRequest('delete', $url);
        
        return $response;
    }
}