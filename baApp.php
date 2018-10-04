<?php
  include 'baSQL.php';

  $connection = getenv('connection');
  $password = getenv('password');
  $user = getenv('user');

  $slam = new Sql(connection, user, password);
  $myData = $slam->listTrxs("%");
