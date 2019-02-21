<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
use google\appengine\api\mail\Message;

$storage = new StorageClient(['projectId' => '........']);
$bucket = $storage->bucket('xmlsoap.dk');
$objects = $bucket->objects(['prefix' => 'temp/C']);

foreach ($objects as $object) {
  $fileName = $object->name();
  break;
}  
  
$subject    = 'manuals';
$burst      = <<<EOT

Vedlagt er næste manual ...

EOT;

$attachment = file_get_contents("gs://xmlsoap.dk/" . $fileName);

$name = substr($object->name(),5);

emitMail('...........@gmail.com', $name, $subject, $burst, $attachment);  

$object->delete();

exit;

function emitMail ($who, $fileName, $subject, $body, $attachment) {

    $message = new Message();
    $message->setSender('.....@gcloud19631205.appspotmail.com');
    $message->addTo($who);
    $message->setSubject($subject);
    $message->setTextBody($body);
    $message->AddAttachment($fileName, $attachment, '<1234567890>');
    $message->send();

}
