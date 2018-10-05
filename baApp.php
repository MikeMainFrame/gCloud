<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1); 

  echo "starting ...";


  $connection = getenv('connection');
  $password = getenv('password');
  $user = getenv('user');
  echo $connection;
  echo $password;
  echo $user;

  include 'baSQL.php';

  
?>
