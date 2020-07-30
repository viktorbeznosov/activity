<?php
    var_dump($_REQUEST);die();
session_start();
$link = new PDO('mysql:host=localhost;dbname=temp.loc', 'root', 'root');
$link->exec("set names utf8");
//Так работает
//curl -d "query=1155010001156" -X POST https://rmsp.nalog.ru/search-proc.json
//curl -d -X GET  https://rmsp.nalog.ru/search-proc.json?query=1155010001156

//1155010001156

$headers = [
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Encoding: gzip, deflate',
    'Accept-Language: en-US,en;q=0.5',
    'Cache-Control: no-cache',
    'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
];

function packPostData(array $post_data) {
    $result = '';
    foreach($post_data as $key=>$value) {
        $result .= $key . "=" . $value . "&";
    }
    return $result;
}

if (!empty($_POST)){
  $query = $_POST['query'];

  $post = [
      'query' => $query,
      'mode' => 'quick',
      'page' => '',
      'pageSize' => 10,
      'sortField' => 'NAME_EX',
      'sort' => 'ASC',
  ];


  $ch = curl_init('https://rmsp.nalog.ru/search-proc.json');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, packPostData($post));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // execute!
  $response = curl_exec($ch);

  $result = json_decode($response);

  curl_close($ch);

  if (!empty($result->data)){

    $category = $result->data[0]->category;
    $name = $result->data[0]->namep;
    $ogrn = $result->data[0]->ogrn;
    $inn = $result->data[0]->inn;

    if ($category == 1){
      $category_name =  "Микропредприятие";
    }
    else if ($category == 2){
      $category_name =  "Малое предприятие";
    }
    else if ($category == 3){
      $category_name = "Среднее предприятие";
    }
    else{
      $category_name = "Крупное предприятие";
    }

    if (!isset($_SESSION['check']) || (time() - $_SESSION['check']['time'] > 300 || $_SESSION['check']['query'] != $query)){
        $_SESSION['check'] = array(
            'name' => $category_name,
            'time' => time(),
            'query' => $query
        );

        $stmt = $link->prepare("INSERT INTO firms (name, category, ogrn, inn) VALUES ('".$name."', '".$category_name."', '".$ogrn."', '".$inn."')");
        $stmt = $link->prepare("INSERT INTO firms (name, category, ogrn, inn) VALUES (:name, :category, :ogrn, :inn)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category_name);
        $stmt->bindParam(':ogrn', $ogrn);
        $stmt->bindParam(':inn', $inn);

        // вставим одну строку
        $stmt->execute();

        //print_r($stmt);
    }
    else{
        $category_name = $_SESSION['check']['name'];
    }




  }
  else{
    $category_name = "По заданным параметрам не найдено сведений";
  }

  echo $category_name;

}

if (!empty($_GET)){
    //Здесь должен быть вывод из базы результатов проверок
    $sth = $link->prepare("SELECT * FROM firms");
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)){
        print_r(json_encode($result));
    }
    else{
        return false;
    }

}




?>
