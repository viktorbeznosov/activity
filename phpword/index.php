<?php

ini_set('error_reporting', E_ALL);

require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

$ROOTPATH = getcwd();
$fileName = $ROOTPATH . '/template.docx';
$resultFileName = $ROOTPATH . '/result.docx';

function file_force_download($file) {
	if (file_exists($file)) {
		// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
		// если этого не сделать файл будет читаться в память полностью!
		if (ob_get_level()) {
			ob_end_clean();
		}
		// заставляем браузер показать окно сохранения файла
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
		exit;
	}
}

$word = new PHPWord();

$template = $word->loadTemplate($fileName);

$template->setValue('first_name','Безносов');
$template->setValue('second_name','Виктор');

$template->saveAs($resultFileName);

file_force_download($resultFileName);