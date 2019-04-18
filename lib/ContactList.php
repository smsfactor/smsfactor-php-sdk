<?php

namespace SMSFactor;

/**
 * Class List
 *
 * @package SMSFactor
 */
class ContactList extends ApiResource
{
    /**
     * Create a list.
     * 
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function create($params = null)
    {
        $url = "/list";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Get all your lists.
     * 
     * @return ApiResponse The api response.
     */
    public static function all()
    {
        $url = "/lists";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Get one of your lists.
     * 
     * @param int $id Id of the list.
     * 
     * @return ApiResponse The api response.
     */
    public static function get($id)
    {
        $url = "/list/{$id}";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Delete one of your lists.
     *
     * @param int $id Id of the list.
     *
     * @return ApiResponse The api response.
     */
    public static function delete($id)
    {
        $url = "/list/{$id}";
        $response = self::_staticRequest('delete', $url);
        
        return $response;
    }
    
    /**
     * Add contacts to a list.
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function addContacts($params = null)
    {
        $url = "/list";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Remove a contact from a list.
     *
     * @param int $id Id of the contact in the list.
     *
     * @return ApiResponse The api response.
     */
    public static function removeContact($id)
    {
        $url = "/list/contact/{$id}";
        $response = self::_staticRequest('delete', $url);
        
        return $response;
    }
    
    /**
     * Deduplicate a list.
     *
     * @param int $id Id of the list.
     *
     * @return ApiResponse The api response.
     */
    public static function deduplicate($id)
    {
        $url = "/list/deduplicate/{$id}";
        $response = self::_staticRequest('put', $url);
        
        return $response;
    }
    
    /**
     * Get your blacklist.
     *
     * @return ApiResponse The api response.
     */
    public static function blacklist()
    {
        $url = "/blacklist";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Add contacts to your blacklist.
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function addToBlacklist($params = null)
    {
        $url = "/blacklist";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
    
    /**
     * Get your NPAI list (unassigned numbers).
     *
     * @return ApiResponse The api response.
     */
    public static function npai()
    {
        $url = "/npai";
        $response = self::_staticRequest('get', $url);
        
        return $response;
    }
    
    /**
     * Add contacts to the NPAI list (unassigned numbers).
     *
     * @param array|null $params
     *
     * @return ApiResponse The api response.
     */
    public static function AddToNpai($params = null)
    {
        $url = "/npai";
        $response = self::_staticRequest('post', $url, $params);
        
        return $response;
    }
}