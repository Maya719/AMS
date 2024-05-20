<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

defined('BASEPATH') or exit('No direct script access allowed');

class Notif extends CI_Controller
{
  public $data = [];

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {

    $this->load->view('notif');
    return;

    // $subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));
    $subscription = [
      "endpoint" => "https://fcm.googleapis.com/fcm/send/dyF0_g8d9sQ:APA91bHHJhK0u0WqRNG35ZUHhSO59Wru6fnoFKrRQ-cch1ofBPaX9mDNrIfAHBvScKFon1YZrPxat2nG__t96o0m5hDtL70am_i8TBnnLuTpCyWx7AmqY6vNhaqodvIbK5UZmQIBv3D1",
      "expirationTime" => null,
      "keys" => [
        "p256dh" => "BBJoVgmCWE2-hqtWEkFaWFGLTj5p0m6891OCXl4GmposAMnU6fVU7WKBGpmOTJ2uIuH2d1stiTj8xz7vH3GPCs8",
        "auth" => "YcVQSt3asBJPH5sCKi_80g"
      ]
    ];
    $auth = array(
      'VAPID' => array(
        'subject' => 'https://github.com/Minishlink/web-push-php-example/',
        'publicKey' => file_get_contents(base_url('assets/public_key.txt')), // don't forget that your public key also lives in 
        'privateKey' => file_get_contents(base_url('assets/private_key.txt')), // don't forget that your public key also lives in 
      ),
    );

    $webPush = new WebPush($auth);

    $report = $webPush->sendOneNotification(
      $subscription,
      '{"message":"Hello! 👋"}',
    );

    // handle eventual errors here, and remove the subscription from your server if it is expired
    $endpoint = $report->getRequest()->getUri()->__toString();

    if ($report->isSuccess()) {
      echo "[v] Message sent successfully for subscription {$endpoint}.";
    } else {
      echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
    }

  }


}