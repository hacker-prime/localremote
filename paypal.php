<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// https://phpdelusions.net/articles/paths
require  __DIR__.'/../vendor/autoload.php';

// This if else statement was insnpired by config.php
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $host = "";
    $username = "";
    $password = "";
    $database = "";

    $client_id = "";
    $client_secret = "";
    $returnL_url = "";
    $cancel_url = "";    
}else{
    $host = "";
    $username = "";
    $password = "";
    $database = "";

    $client_id = "";
    $client_secret = "";
    $returnL_url = "";
    $cancel_url = "";
}

// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'return_url' => $returnL_url,
    'cancel_url' => $cancel_url
];



// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => $host,
    'username' => $username,
    'password' => $password,
    'name' => $database
];

$apiContext = getApiContext(
    $paypalConfig['client_id'],
    $paypalConfig['client_secret'],
    $enableSandbox
);

/**
 * Set up a connection to the API
 *
 * @param string $clientId
 * @param string $clientSecret
 * @param bool   $enableSandbox Sandbox mode toggle, true for test payments
 * @return \PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret, $enableSandbox = false)
{
    $apiContext = new ApiContext(
        new OAuthTokenCredential($clientId, $clientSecret)
    );

    $apiContext->setConfig([
        'mode' => $enableSandbox ? 'sandbox' : 'live'
    ]);

    return $apiContext;
}
