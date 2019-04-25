<?php

namespace SMSFactor;

/**
 * Class SMS
 *
 * @package SMSFactor
 */
abstract class SMS extends ApiResource
{
    /**
     * Message push types
     */
    const PUSHTYPE_ALERT = 'alert';
    const PUSHTYPE_MARKETING = 'marketing';
}
