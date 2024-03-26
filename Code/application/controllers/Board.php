<?php defined('BASEPATH') or exit('No direct script access allowed');
class Board extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public $data = [];
    public $ion_auth;
    public $form_validation;
    public $input;
    public $session;
    public $lang;
    public $board_model;

    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['page_title'] = 'Board - ' . company_name();
            $this->data['main_page'] = 'Board';
            $this->data['current_user'] = $this->ion_auth->user()->row();
            $this->load->view('board', $this->data);
        } else {
            redirect('auth', 'refresh');
        }
    }
    public function create_sprint()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('name', 'Sprint Title', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('goal', 'Sprint Goal', 'trim|required|strip_tags|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('duration') == 5) {
                    $data["starting_date"] = $this->input->post('starting_date');
                    $data["starting_time"] = $this->input->post('starting_time');
                    $data["ending_date"] = $this->input->post('ending_date');
                    $data["ending_time"] = $this->input->post('ending_time');
                    $data["duration"] = '';
                } else {
                    $data["duration"] = $this->input->post('duration');
                    $data["starting_date"] = '';
                    $data["starting_time"] = '';
                    $data["ending_date"] = '';
                    $data["ending_time"] = '';
                }
                $data["saas_id"] = $this->session->userdata('saas_id');
                $data["goal"] = $this->input->post('goal');
                $data["title"] = $this->input->post('name');

                if ($this->board_model->create_sprint($data)) {
                    $this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
                    $this->session->set_flashdata('message_type', 'success');
                    $this->data['data'] =  $data;
                    $this->data['error'] = false;
                    $this->data['message'] = $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.";
                    echo json_encode($this->data);
                } else {
                    $this->data['error'] = true;
                    $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                    echo json_encode($this->data);
                }
            } else {
                $this->data['error'] = true;
                $this->data['message'] = validation_errors();
                echo json_encode($this->data);
            }
        } else {
            redirect('auth', 'refresh');
        }
    }
}
