<?php
  error_reporting(E_ALL);
  $source = "gs://gcloud19631205.appspot.com/mcMail.xml";
  $mother = new DOMDocument;
  $mother->loadXML(file_get_contents($source));
  $newNode = $mother->createDocumentFragment();
  $newNode->appendXML(file_get_contents("php://input"));
  $mother->documentElement->appendChild($newNode);
  file_put_contents($source, $mother->saveXML());

  include 'mcSpontane.php';

?>
