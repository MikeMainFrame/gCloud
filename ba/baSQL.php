<?php

/*
 * M.Rasch 2018
*/

  $search = "%";
  
  if ($_GET) $search = $_GET["search"] . "%";
  
  $connection = "mysql:unix_socket=/cloudsql/gcloud19631205:europe-west1:miketriticum2";
  $user = "root";
  $password = "MCMLX1i1";
  
  $pdo = new PDO($connection, $user, $password);
  
  $statement = $pdo->prepare("SELECT * FROM trx.trxs WHERE text LIKE ? ORDER BY date desc LIMIT 9999");      
  $statement->bindValue(1, $search, PDO::PARAM_STR);
  $statement->execute();
  
  $rows = array();
  
  while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
    array_push($rows, $row);
  }
  

  echo json_encode($rows);
  
?>
