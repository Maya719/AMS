<?php defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '/../../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

// require_once 'Functions.php';

class API extends CI_Controller
{
  public $data = [];

  public function __construct()
  {
    parent::__construct();

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    // Load the library
  }


  public function push_subscription()
  {
    header('Content-Type: text/json');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // $res = save_notifications("testing", "this is test notification", "999");
    // echo $res;
    // exit;

    $subscription = json_decode(file_get_contents('php://input'), true);
    if (!isset($subscription['endpoint'])) {
      echo 'Error: not a subscription';
      return;
    }

    // if ($user == 1) {
    //   $query = $this->db->query("SELECT * FROM users WHERE active ='1' AND finger_config = '1'" . $where);
    // } elseif ($user == 2) {
    //   $query = $this->db->query("SELECT * FROM users WHERE active ='0'  AND finger_config = '1'" . $where);
    // }
    // $results = $query->result_array();
    // echo json_encode($results);

    $user_id = "90";
    $saas_id = "8";

    $existing_record = $this->db->get_where('notification_subscribers', array('user_id' => $user_id));
    if ($existing_record)
      $this->db->delete('notification_subscribers', array('user_id' => $user_id));
    $method = $_SERVER['REQUEST_METHOD'];
    try {
      switch ($method) {
        case 'POST':
          $sub = array();
          $sub['saas_id'] = $saas_id;
          $sub['user_id'] = $user_id;
          $sub["endpoint"] = json_encode($subscription);
          $this->db->insert('notification_subscribers', $sub);
          echo json_encode(['message' => "Updated"]);
          exit;
          break;
        case 'DELETE':
          // delete the subscription corresponding to the endpoint
          break;
        default:
          echo "Error: method not handled";
      }
      //code...
    } catch (\Throwable $th) {
      echo json_encode([$th->getMessage()]);
    }
  }
  public function index()
  {
    echo "dddd";
  }


  public function send_push_notification()
  {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $recipients = [8];
    push_notifications('holiday', $recipients);

    exit;
  }
}