<?php

use google\appengine\api\mail\Message;

$transaction = new DOMDocument;                                              
$transaction->loadXML(file_get_contents("php://input")); 

foreach ($transaction->documentElement->childNodes as $tag) {    
    if ($tag->nodeName === "who") 
      $who = $tag->nodeValue;
    elseif ($tag->nodeName === "subject") 
      $subject = $tag->nodeValue;
    elseif ($tag->nodeName === "body") 
      $body = $tag->nodeValue;   
}

emitMail($who, $subject, $body);

exit;

function emitMail ($who, $subject, $body) {

    $message = new Message();
    $message->setSender('masterOfTheUniverse@gcloud19631205.appspotmail.com');
    $message->addTo($who);
    $message->setSubject($subject);
    $message->setTextBody($body);
    $message->send();

}
