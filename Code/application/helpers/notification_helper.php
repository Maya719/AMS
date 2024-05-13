<?php
defined('BASEPATH') or exit('No direct script access allowed');


require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function save_notifications($type, $notification, $from_id = '', $to_id)
{
  $CI =& get_instance();
  // $query = $CI->db->query("insert into notifications(notification, type, type_id, from_id, to_id) values ('$notification', '$type', 888, $to_id) ");

  if ($type === 'holiday') {
    $saas_id = $CI->session->userdata('saas_id');
  }

  $CI->db->insert("notifications", [
    "notification" => $notification,
    "type" => $type,
    "type_id" => "111",
    "from_id" => "222",
    "to_id" => $to_id
  ]);

  return "done";
}

function generate_notification_message($type, $data = [])
{
  $response = [];
  if ('holiday') {
    $response['msg'] = "Incoming holiday 😀";
  } else if ('event') {
    $response['msg'] = "Holiday for an upcomming event 😀";
  } else if ("project") {
    $response['msg'] = "New project assigned to you.";
  } else if ("task_assignment") {
    $response['msg'] = "New task assigned to you.";
  } else if ("task_completion") {
    $response['msg'] = "Your task has been marked as completed.";
  } else if ("leave_forwarded_to") {
    $response['msg'] = "Your leave has been forwareded. ";
  } else if ("leave_approved") {
    $response['msg'] = "Your leave have been approved.";
  } else if ("biometric_missing_request") {
    $response['msg'] = "You attendence request has been recieved.";
  } else if ("biometric_missing_request_approved") {
    $response['msg'] = "You attendence request has been approved.";
  }
  return $response;
}

function push_notifications($type, $recipients = [], $metadata = [])
{
  $CI =& get_instance();
  $subscribers = array();
  switch ($type) {

    // 
    // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // 
    // 
    // just the type is requried without any recipients
    case 'holiday':
    case 'event':
      // $saas_id = sanitizeDigits($CI->session->userdata('saas_id'));
      $saas_id = $recipients[0];
      $query = $CI->db->query("SELECT * FROM notification_subscribers WHERE saas_id = $saas_id");
      $subscribers = $query->result_array();
      // push
      break;

    //
    // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // 
    // 
    case "project": // the type and list of recipients (client, and everyone that has been added to it)
    case "task_assignment": // the type, assigne and client
    case "task_completion": // the type, assigne and client
    case "leave_forwarded_to": // the type, forwarded to and user
    case "leave_approved": // the type, forwarded to and user
    case "biometric_missing_request": // the type, forwarded to and user
    case "biometric_missing_request_approved": // the type, forwarded to and user
      $ids = implode(", ", $recipients);
      $query = $CI->db->query("SELECT * FROM notification_subscribers WHERE user_id in ($ids)");
      $subscribers = $query->result_array();
      break;
    default:
      return false;
  }
  $notifications = [];
  $message = generate_notification_message($type);
  foreach ($subscribers as $key => $value) {
    $subscription = Subscription::create(json_decode($value['endpoint'], true));
    $notifications[] = ['subscription' => $subscription, 'payload' => '{"message":"' . $message['msg'] . '"}',];
  }

  $auth = array(
    'VAPID' => array(
      'subject' => 'https://github.com/Minishlink/web-push-php-example/',
      'publicKey' => file_get_contents(__DIR__ . '/../keys/public_key.txt'), // don't forget that your public key also lives in app.js
      'privateKey' => file_get_contents(__DIR__ . '/../keys/private_key.txt'), // in the real world, this would be in a secret file
    ),
  );

  $webPush = new WebPush($auth, [], 6, ['verify' => false]);
  foreach ($notifications as $notification)
    $webPush->queueNotification($notification['subscription'], $notification['payload']);

  foreach ($webPush->flush() as $report) {
    $endpoint = $report->getRequest()->getUri()->__toString();

    if ($report->isSuccess()) {
      echo json_encode("[v] Message sent successfully for subscription {$endpoint}.");
    } else {
      echo json_encode("[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}");
    }
  }

}


