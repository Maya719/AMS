<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$notifications = [

  // [
  //   // current PushSubscription format (browsers might change this in the future)
  //   'subscription' => Subscription::create([
  //     "endpoint" => "https://example.com/other/endpoint/of/another/vendor/abcdef...",
  //     "keys" => [
  //       'p256dh' => '(stringOf88Chars)',
  //       'auth' => '(stringOf24Chars)'
  //     ],
  //   ]),
  //   'payload' => '{"message":"Hello World!"}',
  // ],
  [
    'subscription' => Subscription::create([
      'endpoint' => "https://fcm.googleapis.com/fcm/send/enxkCa73A-I:APA91bGgFal-Rw0IeMTl18NyNJCVA6NtNQKkJoHSov3AIdFBhExS9rXMdGmPgZtkjqn9PBjFQfnobrr1VHBUvjun_7LUunVCQX_S1879_Ez1ZR1933LKv3pSRj-HyMHE5546gQF7Evgw",
      'publicKey' => 'BNZmzcMM0VgMRPA4LwRfhmcf+tVJ7/zG6b7kFVNSbGxPTAYmC9hGKmf82hAOG2NTR66dw+s3ik+IMD2g8XOZ3lI=',
      'authToken' => 'ZdPmsF/1yhgQbl9CZpM9wA==',
      'contentEncoding' => 'aes128gcm',
    ]),
    'payload' => '{"message":"test"}',
  ]
];

$webPush = new WebPush();

// send multiple notifications with payload
foreach ($notifications as $notification) {
  $webPush->queueNotification(
    $notification['subscription'],
    $notification['payload']
  );
}


foreach ($webPush->flush() as $report) {
  $endpoint = $report->getRequest()->getUri()->__toString();

  if ($report->isSuccess()) {
    echo "[v] Message sent successfully for subscription {$endpoint}.";
  } else {
    echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
  }
}
