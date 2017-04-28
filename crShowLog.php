<?php
  //header("Content-Type: application/xhtml+xml; charset=utf-8");
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  $dom = new DOMDocument;
  $zFileContents = file_get_contents("gs://crcountlog/crCountLog.xml");
  $dom->loadXML($zFileContents); 

  $xsl = new DOMDocument;
  $zFileContents = file_get_contents("gs://crcountlog/crStatic.xsl");
  $xsl->loadXML($zFileContents); 
  $proc = new XSLTProcessor;
  $proc->importStyleSheet($xsl);
  $clientXML = $proc->transformToDoc($dom);
      
  echo $clientXML->saveXML();
?>
