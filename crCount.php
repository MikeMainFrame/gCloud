<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);  
  use Google\Cloud\Storage\StorageClient;

  $storage = new StorageClient();
  $bucket = $storage->bucket("crcountlog");
  $object = $bucket->object('crCountLog.xml');
  $stringXML = $object->downloadAsString();
  
  $postdata = file_get_contents("php://input"); 
  echo $postdata;
  
  //$fname = dirname(__FILE__) . '//staticdata//crCountLog.xml';  
  $dom = new DOMDocument; 
  //$dom->load($fname, LIBXML_DTDLOAD|LIBXML_DTDATTR); // made by triticum 
  $dom->loadXML($stringXML); 
  $root = $dom->documentElement;                     // we have the root entry */
  
  $row = $dom->createDocumentFragment();             // load the client fragment ...
  $row->appendXML($postdata);
  $root->appendChild($row);
  // $dom->save($fname);                                // At this point we save it - casted !
  file_put_contents("gs://crcountlog/crCountLog.xml", $dom->saveXML());
  echo "good";
?>
