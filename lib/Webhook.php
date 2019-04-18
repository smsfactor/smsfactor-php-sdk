<?php

namespace SMSFactor;

/**
 * Class Webhook
 *
 * @package SMSFactor
 */
class Webhook extends ApiResource
{
    /**
     * Webhook types
     */
    const TYPE_MO = 'MO';
    const TYPE_DLR = 'DLR';
    const TYPE_STOP = 'STOP';
    const TYPE_CLICKER = 'CLICKER';
    
    
    /**
     * Create a webhook.
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function create($params = null)
    {
        $url = "/webhook";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Update a webhook.
     *
     * @param int        $id Id of the webhook.
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function update($id, $params = null)
    {
        $url = "/webhook/{$id}";
        $response = self::_staticRequest('put', $url, $params);
        
        return $response;
    }
    
    /**
     * Get all your webhooks.
     *
     * @return ApiResponse The api response.
     */
    public static function all()
    {
        $url = "/webhook";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Delete one of your webhooks.
     * @param int $id Id of the webhook.
     *
     * @return ApiResponse The api response.
     */
    public static function delete($id)
    {
        $url = "/webhook/{$id}";
        $response = self::_staticRequest('delete', $url);
        
        return $response;
    }
}