<?php
  //header("Content-Type: application/xhtml+xml; charset=utf-8");
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  $fname = dirname(__FILE__) . '\\..\\xml\\ac33609353.xml';
  $xname = dirname(__FILE__) . '\\acGroupLegal.xsl';
  
  $dom = new DOMDocument;
  $dom->load($fname, LIBXML_DTDLOAD|LIBXML_DTDATTR);
  $xsl = new DOMDocument;
  $xsl->load($xname);
  $proc = new XSLTProcessor;
  $proc->importStyleSheet($xsl);

  
  $clientXML = $proc->transformToDoc($dom);
      
  echo $clientXML->saveXML();
  
?>
