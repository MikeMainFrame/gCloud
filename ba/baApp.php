<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=0.8">
    <title>Google Cloud Project Using MySQL and PHP and ECMA 6:: by Mike/TRITICUM :: Q4 2018</title>
  </head>
  <body>
  <button id="zButton">_Search_</button>
  <p id="zSearch"  contenteditable="true">Search Criteria %</p>
  <pre id="zOutput">Initial state before SQL actions  </pre>
<?php

  echo date(DATE_RFC2822) . " starting baApp.php ....<br />";
  
  include 'baSQL.php';

?>
</body>
<script src="staticdata/ba.js" defer></script>
</html>
