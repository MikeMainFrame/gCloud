<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);  
  
  $postdata = file_get_contents("php://input"); 
  
  $fname = dirname(__FILE__) . '//staticdata//crCountLog.xml';  
  $dom = new DOMDocument; 
  $dom->load($fname, LIBXML_DTDLOAD|LIBXML_DTDATTR); // made by triticum 
  $root = $dom->documentElement;                     // we have the root entry */
  
  $row = $dom->createDocumentFragment();             // load the client fragment ...
  $row->appendXML($postdata);
  $root->appendChild($row);
  $dom->save($fname);                                // At this point we save it - casted !
  echo "good";
?>
