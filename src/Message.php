<?php

namespace SMSFactor;

/**
 * Class Message
 *
 * @package SMSFactor
 */
class Message extends SMS
{
    /**
     * Send, or simulate, a message.
     *
     * @param array|null $params
     * @param boolean    $simulate True for simulating the sending, false for real sending. Defaults to false.
     *
     * @return ApiResponse The api response.
     */
    public static function send($params = null, $simulate = false)
    {
        $url = $simulate ? "/send/simulate" : "/send";
        $response = self::_staticRequest('get', $url, null, $params);
        
        return $response;
    }
}
