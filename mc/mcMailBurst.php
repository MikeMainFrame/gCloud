<?php

use google\appengine\api\mail\Message;

$subject    = 'Google Cloud Platform';
$burst      = <<<EOT
Hey there
This is a campaign. Cloud solutions or cloud paradigm, will be a wild game.
I master all variations within GCP universe.
Cost is a lot less and a security a lot more and access is instant.
EOT;

emitMail(['mailReceiver'], $subject, $burst, $attachment);

exit;

function emitMail ($who, $subject, $body, $attachment) {

    $message = new Message();
    $message->setSender('["mailSender"]@gcloud19631205.appspotmail.com');
    $message->addTo($who);
    $message->setSubject($subject);
    $message->setTextBody($body);
    $message->send();
  
}
