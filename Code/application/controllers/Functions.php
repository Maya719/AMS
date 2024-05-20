<?php defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use stdClass;

class Functions
{
  public function formatSubscriptionFromUser($user)
  {
    $stdCls = array();
    $stdCls['endpoint'] = $user['endpoint'];
    $stdCls['publicKey'] = $user['publicKey'];
    $stdCls['authToken'] = $user['authToken'];
    $stdCls['endpoint'] = $user['endpoint'];
    $subscription = Subscription::create($stdCls);
    return $subscription;
  }
}