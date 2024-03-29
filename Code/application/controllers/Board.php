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

            $this->db->select('*');
            $this->db->from('task_status');
            $query7 = $this->db->get();
            $this->data['task_statuses'] = $query7->result_array();

            $this->db->select('*');
            $this->db->from('sprints');
            $this->db->where('status', 1);
            $query2 = $this->db->get();
            $this->data['sprints'] = $query2->result_array();

            $issues = [];
            foreach ($this->data['sprints'] as $sprint) {
                $this->db->select('issues.*, projects.title AS project_name'); 
                $this->db->from('issues_sprint');
                $this->db->join('issues', 'issues_sprint.issue_id = issues.id');
                $this->db->join('projects', 'issues.project_id = projects.id');
                $this->db->where('issues_sprint.sprint_id', $sprint["id"]);
                $query = $this->db->get();
                $issues_sprint = $query->result_array();

                foreach ($issues_sprint as $item) {
                    $issues[] = $item; 
                }
            }

            $this->data['issues'] = $issues;



            if ($this->ion_auth->is_admin() || permissions('project_view_all')) {
                $this->data['system_users'] = $this->ion_auth->members()->result();
            } elseif (permissions('project_view_selected')) {
                $selected = selected_users();
                foreach ($selected as $user_id) {
                    $users[] = $this->ion_auth->user($user_id)->row();
                }
                $users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
                $this->data['system_users'] = $users;
            }

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
    public function edit_sprint()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('update_id', 'update_id', 'trim|required|strip_tags|xss_clean');
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

                if ($this->board_model->update_sprint($this->input->post('update_id'), $data)) {
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
