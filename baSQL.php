<?php


$dsn = getenv('CLOUDSQL_DSN');
$user = getenv('CLOUDSQL_USER');
$password = getenv('CLOUDSQL_PASSWORD');

// create the PDO client
$pdo = new PDO($dsn, $user, $password);

     
        $pdo = $this->newConnection();
        $statement = $pdo->prepare("SELECT * FROM trxs WHERE text like ? ORDER BY date desc LIMIT 9999");      
        $statement->bindValue(1, $search, PDO::PARAM_INT);
        $statement->execute();
        $rows = array();
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          array_push($rows, $row);
        }

        return  $rows;
  ?>
