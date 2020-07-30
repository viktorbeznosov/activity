<?php

error_reporting( E_ERROR );

$user = 'root';
$pass = '';
$dbname = 'test';
$host = 'localhost';

$name = $_POST['name'];
$form = $_POST['form'];
$id = $_POST['form_id'];

try {
  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->exec("set names utf8");
} catch(PDOException $e) {
    echo $e->getMessage();
}

if ($name && $form){
  if ($id){
    $sql = 'UPDATE document_forms SET name = ?, form = ? WHERE id = ?';
    $sth = $db->prepare($sql);
    if ($sth->execute(array($name,$form,$id))){
       print_r(json_encode(array('success' => 1,'id' => $id)));
    }
  } else {
    $sql = 'INSERT INTO document_forms (name, form) VALUES (:name, :form)';
    $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    if ($sth->execute(array(':name' => $name, ':form' => $form))){
      print_r(json_encode(array('success' => 1,'id' => $db->lastInsertId())));
    }
  }


}
