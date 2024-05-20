<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

error_reporting(E_ALL);

try {

  $endpoint = base64_decode($argv[1]);
  $publicKey = base64_decode($argv[2]);
  $authToken = base64_decode($argv[3]);
  $contentEncoding = "aes128gcm";

  $sub = [
    "endpoint" => $endpoint,
    "publicKey" => $publicKey,
    "authToken" => $authToken,
    "contentEncoding" => $contentEncoding,
  ];
  $logFilePath = __DIR__ . '/888_error_log.txt';
  if (!file_exists($logFilePath))
    file_put_contents($logFilePath, '');
  file_put_contents($logFilePath, "testing " . PHP_EOL, FILE_APPEND);

  $auth = array(
    'VAPID' => array(
      'subject' => 'https://test.com',
      'publicKey' => file_get_contents(__DIR__ . '/../keys/public_key.txt'),
      'privateKey' => file_get_contents(__DIR__ . '/../keys/private_key.txt'),
    ),
  );

  $webPush = new WebPush($auth);
  $subscription = Subscription::create($sub);
  $report = $webPush->sendOneNotification($subscription, "{'message':' Hello! 👋'}");
  $endpoint = $report->getRequest()->getUri()->__toString();
  if ($report->isSuccess()) {
    echo "[v] Message sent successfully for subscription {$endpoint}.";
  } else {
    // echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
    $error = "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
    // $logFilePath = __DIR__ . '/888_error_log.txt';
    // if (!file_exists($logFilePath))
    //   file_put_contents($logFilePath, '');
    // file_put_contents($logFilePath, $error . PHP_EOL, FILE_APPEND);
  }
} catch (\Throwable $th) {
  // throw $th;
  $error = "Exception: " . $th->getMessage();
  $logFilePath = __DIR__ . '/888_error_log.txt';
  if (!file_exists($logFilePath)) {
    // Create the error log file if it doesn't exist
    file_put_contents($logFilePath, '');
  }
  file_put_contents($logFilePath, $error . PHP_EOL, FILE_APPEND);
  throw $th;
  // save the errors to a text file
}