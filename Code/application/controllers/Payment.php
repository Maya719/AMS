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


    public function myfatoorah()
    {

        $invoiceValue       = 50;
        $displayCurrencyIso = 'KWD';
        
        
        try {
            $paymentMethods = $this->mf->getVendorGateways($invoiceValue, $displayCurrencyIso);
            $paymentMethodId = '20';
            

            echo json_encode($paymentMethods);
        } catch (Exception $ex) {
            echo 'Error processing payment: ' . $ex->getMessage();
        }
    }
    public function callbackw()
    {
    }
    public function create_payment()
    {
        $this->form_validation->set_rules('paymentMethodId', 'Payment MethodId', 'required');
        $this->form_validation->set_rules('name', 'Card Holder Name', 'required');
        $this->form_validation->set_rules('plan_id', 'Plan', 'required');

        if ($this->form_validation->run() == TRUE) {
            $plan = $this->plans_model->get_plans($this->input->post('plan_id'));

            if ($plan[0]['price'] > 0) {
                require_once('vendor/stripe/stripe-php/init.php');
                $stripeSecret = get_stripe_secret_key();
                $stripe = new \Stripe\StripeClient($stripeSecret);

                try {
                    $paymentIntent = $stripe->paymentIntents->create([
                        'amount' => $plan[0]['price'] * 100,
                        'currency' => get_saas_currency('currency_code'),
                        'payment_method' => $this->input->post('paymentMethodId'),
                        'confirm' => true,
                        'automatic_payment_methods' => [
                            'enabled' => true,
                            'allow_redirects' => 'never'
                        ],
                    ]);

                    if ($paymentIntent->status == 'succeeded') {
                        if ($this->handleSuccessfulPayment($plan, $this->input->post('saas_id'))) {
                            $this->session->set_flashdata('message', $this->lang->line('plan_subscribed_successfully') ? $this->lang->line('plan_subscribed_successfully') : "Plan subscribed successfully.");
                            $this->session->set_flashdata('message_type', 'success');
                            $response = ['error' => false, 'message' => 'Payment succeeded!', 'paymentIntent' => $paymentIntent];
                        } else {
                            $response = ['error' => true, 'message' => 'Failed to process the order.'];
                        }
                    } else {
                        $response = ['error' => true, 'message' => 'Payment is not yet complete.', 'paymentIntent' => $paymentIntent];
                    }
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $response = ['error' => true, 'message' => $e->getMessage()];
                }
            } else {
                if ($this->handleSuccessfulPayment($plan, $this->input->post('saas_id'))) {
                    $this->session->set_flashdata('message', $this->lang->line('trial_plan_subscribed_successfully') ? $this->lang->line('trial_plan_subscribed_successfully') : "Trail Plan subscribed successfully.");
                    $this->session->set_flashdata('message_type', 'success');
                    $response = ['error' => false, 'message' => 'Payment succeeded!', 'paymentIntent' => $paymentIntent];
                }
            }
        } else {
            $response = ['error' => true, 'message' => validation_errors()];
        }
        redirect('payment/paymentStatus?' . http_build_query($response));
    }

    private function SuccessPaymentMail($saas_id, $transaction_id)
    {
        $saas_admins = $this->ion_auth->users(array(3))->result();
        foreach ($saas_admins as $saas_admin) {
            $data = array(
                'notification' => '<span class="text-primary">' . $plan[0]['title'] . '</span>',
                'type' => 'new_plan',
                'type_id' => $this->input->post('plan_id'),
                'from_id' => $this->input->post('saas_id'),
                'to_id' => $saas_admin->user_id,
            );
            $notification_id = $this->notifications_model->create($data);
        }
        $template_data = array();
        $template_data['TRANSECTION_ID'] = 'T#' . $transaction_id;
        $email_template = render_email_template('subscription_completed', $template_data);
        $contation_subject = $email_template[0]['subject'];
        $user = $this->ion_auth->user($saas_id)->row();
        send_mail($user->email, $contation_subject, $email_template[0]['message']);
    }
    public function paymentStatus()
    {
        $data = $this->input->get();
        $this->load->view('companyProfile/payment-status', $data);
    }
    private function handleSuccessfulPayment($plan, $saas_id)
    {
        if ($plan[0]['price'] > 0) {
            $transaction_data = [
                'saas_id' => $saas_id,
                'amount' => $plan[0]['price'],
                'status' => 1,
            ];
            $transaction_id = $this->plans_model->create_transaction($transaction_data);
            $order_data = [
                'saas_id' => $saas_id,
                'plan_id' => $plan[0]['id'],
                'transaction_id' => $transaction_id,
            ];
            if ($this->plans_model->create_order($order_data)) {
                $this->setPlanUser($plan, $saas_id);
                $this->SuccessPaymentMail($saas_id, $transaction_id);
                return true;
            }
        } else {
            $this->setPlanUser($plan, $saas_id);
            return true;
        }
        return false;
    }

    private function setPlanUser($plan, $saas_id)
    {
        $dt = strtotime(date("Y-m-d"));
        switch ($plan[0]['billing_type']) {
            case "One Time":
                $date = NULL;
                break;
            case "Monthly":
                $date = date("Y-m-d", strtotime("+1 month", $dt));
                break;
            case "Yearly":
                $date = date("Y-m-d", strtotime("+1 year", $dt));
                break;
            case "three_days_trial_plan":
                $date = date("Y-m-d", strtotime("+3 days", $dt));
                break;
            case "seven_days_trial_plan":
                $date = date("Y-m-d", strtotime("+7 days", $dt));
                break;
            case "fifteen_days_trial_plan":
                $date = date("Y-m-d", strtotime("+15 days", $dt));
                break;
            case "thirty_days_trial_plan":
                $date = date("Y-m-d", strtotime("+1 month", $dt));
                break;
            default:
                $date = date("Y-m-d", strtotime("+3 days", $dt));
        }

        $users_plans_data = [
            'plan_id' => $plan[0]['id'],
            'expired' => 1,
            'start_date' => date("Y-m-d"),
            'end_date' => $date,
        ];

        $this->plans_model->update_users_plans($saas_id, $users_plans_data);
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
