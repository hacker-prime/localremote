<?php

// The purpose of this file is to change the uri/url based on the environment it is in, whether local or remote/live server.
// The background on this is that if you upload all the files from localhost to remotehost or live server then you will get errors because
// several files make reference to uris/urls that have localhost in them but there is no such uris/urls on the remotehost/liver server.
// It will create an error that says something to the effect, 'there is no such url or cannot find url'  

// https://www.php.net/manual/en/reserved.variables.server.php

// 'HTTP_HOST' - Contents of the Host: header from the current request, if there is one.
//NOTE - The $_SERVER['HTTP_HOST'] is different on the localhost versus the remote server
//NOTE - The $_SERVER['HTTP_HOST'] on localhost/my laptop is localhost
//NOTE - The $_SERVER['HTTP_HOST'] on the remotehost/Hostinger is phoenixprime.io

// echo $_SERVER['HTTP_HOST'];  //      On the localhost/my laptop I get localhost but on the remote server/Hostinger, I get phoenixprime.io
// echo "<br />";

// 'REQUEST_URI' - The URI which was given in order to access this page; for instance, '/index.html'.
//NOTE - The $_SERVER['REQUEST_URI'] on localhost/my laptop is /phoenixprime.io/sections/contractor/test.php
//NOTE - The $_SERVER['REQUEST_URI'] on the remotehost/Hostinger is /contractor/test.php
//NOTE - The $_SERVER['REQUEST_URI'] starts after the $_SERVER['HTTP_HOST'].

// echo $_SERVER['REQUEST_URI'];  //    On the localhost/my laptop I get /phoenixprime.io/sections/contractor/test.php On the remote server/hostinger I get /test.php
// echo "<br />";


// https://stackoverflow.com/questions/10109907/how-to-get-the-same-serverrequest-uri-on-both-localhost-and-live-server
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $localhost = "http://localhost/"; //Originally, there would be no slash at the end of localhost but that has been added due to the issue I encountered and had to reache out to Hostinger.com about, the issue was When I am on this page https://phoenixprime.io/sections/customer/transportation.php and click confirm and it sends information over to https://phoenixprime.io/sections/customer/request.php I get the following error: Composer detected issues in your platform: Your Composer dependencies require a PHP version ">= 8.0.2". The suggested solution of selecting a newer version of PHP helped but I still got a status code of 500 and then I realized the issue was in the bootstrap.php file which contains PayPal logic. Within the bootstrap.php file I had 'return_url' => $host.'/phoenixprime.io/sections/customer/response.php','cancel_url' => $host.'/phoenixprime.io/sections/customer/payment-cancelled.html' but the issue is that the string that was being appended to $host had a slash at the beginning which would give a final result of https:///phoenixprime.io/sections/customer/response.php and three slashes would result in a url that doesn't exist. Instead of https:/// it should be https:// so I removed the slash from the url in the string that comes after $host. That experience/realiztion made me realize it's better to remove the slash at the start of the urls that have phoenixprime so that when the code is in the remote host/liver server/hostinger environment then there will only ever be two slashes in the https instead of three slashes. But since that slash in front of the urls that have phoenixprime will have to be removed, it would require adding a slash at the end of the $host variable for the if condition that determines the environment being in the localhost environment.
    $host = "http://localhost/";
    $uri = $localhost.$_SERVER['REQUEST_URI'];
    // echo $uri http://localhost/phoenixprime.io/sections/localremote.php
} else {
    $remotehost = "https://";
    $host = "https://";
    $uri = $remotehost.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];   
    // echo $uri https://phoenixprime.io/sections/localremote.php
}

?>
