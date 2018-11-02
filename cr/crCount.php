<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  $DOM = new DOMDocument; 
  $DOM->loadXML(file_get_contents("gs://crcountlog/crCountLog.xml")); 
  $root = $DOM->documentElement;                     // we have the root entry */
  $row = $DOM->createDocumentFragment();             // load the client fragment ...
  $row->appendXML(file_get_contents("php://input"));
  $root->appendChild($row);
  file_put_contents("gs://crcountlog/crCountLog.xml", $DOM->saveXML());
  echo "good";
?>
