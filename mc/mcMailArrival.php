<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  use google\appengine\api\mail\Message;

  $mail = file_get_contents("php://input");
  file_put_contents("gs://gcloud19631205.appspot.com/mail" . round(microtime(true) * 1000) . ".txt", $mail);

  $phaseOne = explode("From:", $mail);
  $phaseTwo = explode("Date:", $phaseOne[1]);
  $from =$phaseTwo[0];
  $phaseThree = explode("Message-ID:", $phaseTwo[1]);
  $date =$phaseThree[0];
  $phaseFour = explode('boundary="', $phaseThree[1]);
  $phaseFive = explode('"', $phaseFour[1]);
  $key = $phaseFive[0];
  $phaseSix = explode($key, $phaseFive[1]);

  file_put_contents("gs://gcloud19631205.appspot.com/mailDecoded.txt", $from . $date . $key . $phaseSix[1]);
