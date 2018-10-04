<?php
  include 'baSQL.php';
  $slam = new Sql(dsn, user, password);
  $myData = $slam->listTrxs("%");
