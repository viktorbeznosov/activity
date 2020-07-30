<?php
	$str = file_get_contents('http://theory.phphtml.net');
//	echo (htmlspecialchars($str));
	preg_match_all('#<ul.*?>(.+?)</ul>#su', $str, $res);
	print_r($res);

//	preg_match_all('#<body.*>(.+?)</body>#su', $str, $res);
//	var_dump($res);


?>