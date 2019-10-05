<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
use google\appengine\api\mail\Message;

$storage = new StorageClient(['projectId' => 'gcloud19631205']);
$bucket = $storage->bucket('xmlsoap.dk');
$objects = $bucket->objects(['prefix' => 'gs://xmlsoap.dk/temp/AOR/I']);

foreach ($objects as $object) {
  $fileName = $object->name();
  break;
}  
  
$subject    = 'Pictures of you';
$burst      = <<<EOT

Hej Smukke,

Disse billeder får du af mig.

Efter 1000 dage har jeg jo fotograferet et par stykker.

Mikey

EOT;

$attachment = file_get_contents("gs://xmlsoap.dk/" . $fileName);

$name = substr($object->name(),5);

emitMail('mikeyKennethRasch@gmail.com', $name, $subject, $burst, $attachment);  
emitMail('annetteolanderrasmussen@gmail.com', $name, $subject, $burst, $attachment);  

$object->delete();

exit;

function emitMail ($who, $fileName, $subject, $body, $attachment) {

    $message = new Message();
    $message->setSender('michael.kenneth.rasch@gcloud19631205.appspotmail.com');
    $message->addTo($who);
    $message->setSubject($subject);
    $message->setTextBody($body);
    $message->AddAttachment($fileName, $attachment, '<1234567890>');
    $message->send();

}
