<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1); 

  echo "starting ...";


  $connection = getenv('connection');
  $password = getenv('password');
  $user = getenv('user');
 echo $connection;
  include 'baSQL.php';


  $slam = new Sql(connection, user, password);
  $myData = $slam->listTrxs("%");
  echo $myData;
  echo $connection;
  echo $password;
  echo $user;

?>
