<?php

  use google\appengine\api\mail\Message;

  $mail = file_get_contents("php://input");
  file_put_contents("gs://gcloud19631205.appspot.com/mail" . round(microtime(true) * 1000) . ".txt", $mail);

  $A = explode("From: ", $mail);
  $B = explode("Date: ", $A[1]);
  $from =$B[0];

  $A = explode("Message-ID:", $B[1]);
  $date =$A[0];

  $B = explode('boundary="', $A[1]);
  $split = explode('"', $mail);

  $orig = $split[0];
  $head = $split[1];
  $body = $split[2];

  file_put_contents("gs://gcloud19631205.appspot.com/mailDecoded.txt", $from . $date . $orig . $head . $body);

  $source = "gs://gcloud19631205.appspot.com/mcMailreply.xml";
  $mother = new DOMDocument;
  $mother->loadXML(file_get_contents($source));
  $root = $mother->documentElement; 

  $reply = $mother->createElement('reply');
  $temp = $mother->createElement('from', $from);
  $reply->appendChild($temp);

  $temp = $mother->createElement('date', $date);
  $reply->appendChild($temp);

  $temp = $mother->createElement('origin', $orig);
  $reply->appendChild($temp);

  $temp = $mother->createElement('head', $head);
  $reply->appendChild($temp);

  $temp = $mother->createElement('body', $body);
  $reply->appendChild($temp);

  $root->appendChild($reply);
  file_put_contents($source, $mother->saveXML());

  include 'mcSpontane.php';
