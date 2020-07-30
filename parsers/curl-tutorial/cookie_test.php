<?php

require 'vendor/autoload.php';

$cook = false;

if (isset($_COOKIE['curl_session_cookie'])){
    $cook = true;

    echo "Сессионная кука есть\n\r";
}

if (isset($_COOKIE['curl_normal_cookie'])){
    $cook = true;

    echo "Нормальная кука есть\n\r";
}

setcookie('curl_session_cookie', 1);
setcookie('curl_normal_cookie', 1, microtime(true) + 1000);

if ($cook){
    echo "I know you";
} else {
    echo "You are new";
}