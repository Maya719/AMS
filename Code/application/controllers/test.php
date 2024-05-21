<?php


$user = array();
$user["endpoint"] = "https://fcm.googleapis.com/fcm/send/enxkCa73A-I:APA91bGgFal-Rw0IeMTl18NyNJCVA6NtNQKkJoHSov3AIdFBhExS9rXMdGmPgZtkjqn9PBjFQfnobrr1VHBUvjun_7LUunVCQX_S1879_Ez1ZR1933LKv3pSRj-HyMHE5546gQF7Evgw";
$user["publicKey"] = "BNZmzcMM0VgMRPA4LwRfhmcf+tVJ7/zG6b7kFVNSbGxPTAYmC9hGKmf82hAOG2NTR66dw+s3ik+IMD2g8XOZ3lI=";
$user["authToken"] = "ZdPmsF/1yhgQbl9CZpM9wA==";
$user["contentEncoding"] = "aes128gcm";

exec('cd', $output);
$pwd = $output[0];

exec(
  "php $pwd" . DIRECTORY_SEPARATOR . "Code" . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR . "helpers" . DIRECTORY_SEPARATOR . "notification_helper.php " .
  base64_encode($user['endpoint']) . " " . base64_encode($user['publicKey']) . " " . base64_encode($user['authToken']) . " " . base64_encode($user['contentEncoding']),
  $ot
);
print_r($ot);


// C:\xampp\htdocs\AMS\application\helpers\notification_helper.php
// C:\xampp\htdocs\AMS\Code\application\helpers