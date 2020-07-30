<?php

	function curl_get($url, $referer = 'http://www.google.com'){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36');
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

//		$headers = [
//			'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
//			'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36',
//		];
//
//		$ch = curl_init($url);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//		curl_setopt($ch, CURLOPT_REFERER, $referer);
//		$data = curl_exec($ch);
//		curl_close($ch);

		return $data;
	}