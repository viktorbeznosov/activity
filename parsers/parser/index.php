<?php

require_once './vendor/autoload.php';
require_once './lib/curl_query.php';

$client = new \GuzzleHttp\Client();
$headers = [
	'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
	'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36',
];

$result = $client->get('https://ntschool.ru/kursyi', $headers);

$content = $result->getBody()->getContents();
$host = 'https://ntschool.ru';

$pq = phpQuery::newDocument($content);
$elems = $pq->find('.courses-list--item');

$data = array();

foreach ($elems as $elem){
	$item = phpQuery::pq($elem);
	$link = $item->find('.courses-list--item-body--title');

	$name = $link->html();
	$price = $item->find('.newPrice')->html();
	$data[] = array(
		'name' => $name,
		'price' => $price
	);

	$img = $item->find('img');
	$img_src = $host . $img->attr('src');

	$img_content = $client->request('GET', $img_src);

	$re ='/[^\/]+(.(jpg|jpeg|png|bmp)$)/';
	preg_match($re, $img_src, $matches);
	$file_name = $matches[0];

	file_put_contents('./files/' . $file_name, $img_content->getBody());
}


print_r($data);