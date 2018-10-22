<?php

/*
 * M.Rasch 2018
*/
  error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  
  $search = "%";
  
  if ($_GET) $search = $_GET["search"] . "%";
  
  $connection = "mysql:unix_socket=/cloudsql/gcloud19631205:europe-west1:miketriticum2";
  $user = "root";
  $password = "MCMLX1i1";
  
  $pdo = new PDO($connection, $user, $password); 
  
  if ($search === 'load%') {
	  $temp = file_get_contents("gs://gcloud19631205.appspot.com/insert.sql");
	  $allData = explode(";\r\n", $temp);
	  //print_r($allData);
	  $pdo->beginTransaction();
	  
	  for ($ix = 1; $ix < count($allData); $ix++ ) {
	  	echo $allData[$ix];
	    $statement = $pdo->prepare($allData[$ix]);      
	    $statement->execute();		
	  }
	  $pdo->commit();
  }
  
  $statement = $pdo->prepare("SELECT * FROM trx.trxs WHERE text LIKE ? ORDER BY date desc LIMIT 9999");      
  $statement->bindValue(1, $search, PDO::PARAM_STR);
  $statement->execute();
  
  $collection = array();
  
  while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
  	array_push($collection, $row);
  }
  
  echo json_encode($collection);
