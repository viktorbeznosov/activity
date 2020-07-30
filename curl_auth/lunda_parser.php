<?php
header("Content-type: text/html; charset=utf-8");



//==============================================================================
function login($url,$login,$pass){

    $headers = array(
      'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
      'X-Requested-With: XMLHttpRequest'
    );

   $ch = curl_init();
   if(strtolower((substr($url,0,5))=='https')) { // если соединяемся с https
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   }
   curl_setopt($ch, CURLOPT_URL, $url);
   // откуда пришли на эту страницу
   curl_setopt($ch, CURLOPT_REFERER, $url);
   // cURL будет выводить подробные сообщения о всех производимых действиях
   curl_setopt($ch, CURLOPT_VERBOSE, 1);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,"loginName=".$login."&psw=".$pass);
   curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
   curl_setopt($ch, CURLOPT_HEADER, 1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   //сохранять полученные COOKIE в файл
   curl_setopt($ch, CURLOPT_COOKIEJAR, './cookie.txt');
   $result=curl_exec($ch);

   // Убеждаемся что произошло перенаправление после авторизации
   // if(strpos($result,"Location: home.php")===false) die('Login incorrect');

   curl_close($ch);

   return $result;
}

function Read($url){
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   // откуда пришли на эту страницу
   curl_setopt($ch, CURLOPT_REFERER, $url);
   //запрещаем делать запрос с помощью POST и соответственно разрешаем с помощью GET
   curl_setopt($ch, CURLOPT_POST, 0);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   //отсылаем серверу COOKIE полученные от него при авторизации
   curl_setopt($ch, CURLOPT_COOKIEFILE, './cookie.txt');
   curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");

   $result = curl_exec($ch);

   curl_close($ch);

   return $result;
}

$url = "https://www.lunda.ru/lundaonline/common/login";
$login = "101@promelvent.ru";
$pass = "QB77FBI1XFT0";

echo "<pre>";
print_r(login($url,$login,$pass));
echo "</pre>";

$content = Read("https://www.lunda.ru/lundaonline/common/whoami/");

echo $content;

