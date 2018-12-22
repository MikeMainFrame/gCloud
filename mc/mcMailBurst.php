<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

use google\appengine\api\mail\Message;

$subject = 'Tick Tick Tick Tick';

$burst = "High speed mail processing, usning GCP"
             . PHP_EOL . "Next message is in an hour"
             . PHP_EOL . "passed thru " . $_SERVER['PHP_SELF'] . " " .  date(DATE_RFC2822);


emitMail('???@gmail.com', $subject, $burst);

exit;

function emitMail ($who, $subject, $body) {

    $message = new Message();
    $message->setSender('masterOfTheUniverse@gcloud19631205.appspotmail.com');
    $message->addTo($who);
    $message->setSubject($subject);
    $message->setTextBody($body);
    $message->send();

}
