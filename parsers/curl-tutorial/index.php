<?php

require 'vendor/autoload.php';
$config = require_once('config.php');


// ---------------------------------------------------------------------
// --[ Functions ]------------------------------------------------------
// ---------------------------------------------------------------------

function request($url, $postdata = null, $cookiefile = 'tmp/cookie.txt'){

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);

    curl_setopt($ch, CURLOPT_PROXY, '168.102.134.47:8080');
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);

    curl_setopt($ch, CURLOPT_TIMEOUT, 9);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);

    if ($postdata) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $html = curl_exec($ch);
    curl_close($ch);

    return $html;
}

// ---------------------------------------------------------------------
// --[ Main code ]------------------------------------------------------
// ---------------------------------------------------------------------

file_put_contents('tmp/cookie.txt', '');

//$html = request('https://www.reddit.com/');

//$post = array(
//    'op' => 'login',
//    'csrf_token' => 'e3c8875745e4a84242f1de038f9e481c1f28477f',
//    'user' => $config['username'],
//    'passwd' => $config['password'],
//    'dest' => 'https://www.reddit.com',
//    'api_type' => 'json'
//);
//
//$html = request('https://www.reddit.com/post/login/', $post);

$html = request('http://httpbin.org/ip');

var_dump($html);

//=========================================================================





