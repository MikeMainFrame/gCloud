<?php
  
  $temp = file_get_contents("gs://gcloud19631205.appspot.com/insert.sql");
  $allData = explode(";\r\n", $temp);

  $pdo->beginTransaction();

    for ($ix = 1; $ix < count($allData); $ix++ ) {
      $statement = $pdo->prepare($allData[$ix]);      
      $statement->execute();		
    }

  $pdo->commit();
   
  $statement = $pdo->prepare("SELECT id, date, text, amount FROM trx.trxs ORDER BY date desc LIMIT 9999");     
  $statement->execute();
  
  $collection = array();
  
  while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
  	array_push($collection, $row);
  }
  
  echo json_encode($collection);
