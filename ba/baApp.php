<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Google Cloud Project Using MySQL and PHP:: by Mike/TRITICUM :: Q4 2018</title>
    <style> td { border-bottom: 1px solid #ddd} </style>
  </head>
  <body>
  <span id="zSearch"  contenteditable="true">Search Criteria %</span>  
  <button id="zButton">_Search_</button>
  <p id="zOutput">Initial state before SQL actions  
<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1); 

  echo date(DATE_RFC2822) . " starting baApp.php ....<br />First search will erase these lines ;o)";
  
  include 'baSQL.php'; 

?>
</p>
</body>
<script src="staticdata/ba.js" defer></script>
</html>
