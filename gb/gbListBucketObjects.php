<?php
  require __DIR__ . '/vendor/autoload.php';

  use Google\Cloud\Storage\StorageClient;

  $storage = new StorageClient(['projectId' => 'hansolo']);
  $bucket = $storage->bucket('milliniumfalcon');
  $objects = $bucket->objects(['prefix' => 'temp/' . $_GET["search"]]);
  $all = [];
  foreach ($objects as $object) {
    $all[] = $object->info();
  }  
  echo json_encode($all);
