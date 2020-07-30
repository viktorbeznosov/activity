<?php

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

function print_arr($arr){
    echo '<pre>' . print_r($arr) . '</pre>';
}

function get_content($url, $data){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/tmp/cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__. '/tmp/cookies.txt');
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

$auth_data = array(
    'login' => 'some login',
    'password' => 'some password'
)

