<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  $postdata = file_get_contents("php://input"); 
  $zFileContents = file_get_contents("gs://crcountlog/crCountLog.xml");
  $dom = new DOMDocument; 
  $dom->loadXML($zFileContents); 
  $root = $dom->documentElement;                     // we have the root entry */
  $row = $dom->createDocumentFragment();             // load the client fragment ...
  $row->appendXML($postdata);
  $root->appendChild($row);
  file_put_contents("gs://crcountlog/crCountLog.xml", $dom->saveXML());
  echo "good";
?>
