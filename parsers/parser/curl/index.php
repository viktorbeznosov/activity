<?php
	require_once ('../lib/curl_query.php');

	$curl = curl_init('temp.loc/parser/index.php');

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);

	echo $result;