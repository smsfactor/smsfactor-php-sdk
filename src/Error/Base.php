<?php

namespace SMSFactor\Error;

use Exception;

abstract class Base extends Exception
{
    public function __construct(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->httpBody = $httpBody;
        $this->jsonBody = $jsonBody;
        $this->httpHeaders = $httpHeaders;

        $this->smsFactorCode = (is_object($jsonBody) && property_exists($jsonBody, 'status') && is_int($jsonBody->status) && $jsonBody->status < 0) ? $jsonBody->status : null;
    }

    public function getSMSFactorCode()
    {
        return $this->smsFactorCode;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function getHttpBody()
    {
        return $this->httpBody;
    }

    public function getJsonBody()
    {
        return $this->jsonBody;
    }

    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    public function __toString()
    {
        return parent::__toString();
    }
}
