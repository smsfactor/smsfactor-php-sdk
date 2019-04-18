<?php

// SMSFactor singleton
require(dirname(__FILE__) . '/lib/SMSFactor.php');

// HttpClient
require(dirname(__FILE__) . '/lib/HTTPClient/guzzle/autoloader.php');
require(dirname(__FILE__) . '/lib/HTTPClient/ClientInterface.php');
require(dirname(__FILE__) . '/lib/HTTPClient/Client.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/InsufficientCredits.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/Unknown.php');

// API operations
require(dirname(__FILE__) . '/lib/APIOperations/Request.php');

// Plumbing
require(dirname(__FILE__) . '/lib/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/ApiResponse.php');

// SMSFactor API Resources
require(dirname(__FILE__) . '/lib/SMS.php');
require(dirname(__FILE__) . '/lib/Account.php');
require(dirname(__FILE__) . '/lib/Campaign.php');
require(dirname(__FILE__) . '/lib/ContactList.php');
require(dirname(__FILE__) . '/lib/Message.php');
require(dirname(__FILE__) . '/lib/Token.php');
require(dirname(__FILE__) . '/lib/Webhook.php');