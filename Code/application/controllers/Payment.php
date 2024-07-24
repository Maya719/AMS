<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/myFatoorah/PaymentMyfatoorahApiV2.php');
class Payment extends CI_Controller
{
    public $data = [];
    public $mf;
    public $apiKey;
    public function __construct()
    {
        parent::__construct();
        $this->apiKey = get_myfatoorah_secret_key();
        $testMode = 'yes';
        $this->mf = new PaymentMyfatoorahApiV2($this->apiKey, ($testMode === 'yes'));
    }
    public function create_session($plan_id = '')
    {
        $stripeSecret = get_stripe_secret_key();
        if ($stripeSecret) {
            if (empty($plan_id)) {
                $plan_id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }
            if (!empty($plan_id) || is_numeric($plan_id)) {
                if (empty($sass_id) || !is_numeric($plan_id)) {
                    $sass_id = $this->session->userdata("saas_id");
                }
                $plan = $this->plans_model->get_plans($plan_id);
                if ($plan) {
                    $gatwayId = 2;
                    $postFields = [
                        'paymentMethodId' => $gatwayId,
                        'InvoiceValue'    => $plan[0]['price'],
                        'CallBackUrl'     => base_url('payment/callback'),
                        'ErrorUrl'        => base_url('payment/callback'),
                        'CustomerName'       => $plan[0]['title'],
                        'DisplayCurrencyIso' => 'USD',
                    ];

                    try {
                        $data = $this->mf->getInvoiceURL($postFields, $gatwayId);
                        header('Location: ' . $data['invoiceURL']);
                    } catch (Exception $ex) {
                        echo json_encode(['error' => true, 'message' => $ex->getMessage()]);
                    }
                }
            }
        }
    }

    public function callback()
    {
        if ($this->input->get('paymentId')) {
            $keyId = $this->input->get('paymentId');
            $this->session->set_flashdata('message', $this->lang->line('plan_subscribed_successfully') ? $this->lang->line('plan_subscribed_successfully') : "Plan subscribed successfully.");
            $this->session->set_flashdata('message_type', 'success');
            redirect('plans');
        } else {
            redirect('payment/index');
        }
    }
}
