<?php defined('BASEPATH') or exit('No direct script access allowed');
class Issues extends CI_Controller
{
    public $data = [];
    public $ion_auth;

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['page_title'] = 'Create issue - ' . company_name();
            $this->data['main_page'] = 'Create issue';
            $this->data['current_user'] = $this->ion_auth->user()->row();

            $this->db->select('*');
            $this->db->from('projects');
            $this->db->where_in('saas_id', $this->session->userdata());
            $query = $this->db->get();
            $this->data['projects'] = $query->result_array();

            $this->db->select('*');
            $this->db->from('sprints');
            $this->db->where_in('saas_id', $this->session->userdata());
            $query = $this->db->get();
            $this->data['sprints'] = $query->result_array();
            

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

            $this->load->view('issues-create', $this->data);
        } else {
            redirect('auth', 'refresh');
        }
    }
    public function edit($id = '')
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['page_title'] = 'Edit issue - ' . company_name();
            $this->data['main_page'] = 'Edit issue';
            $this->data['current_user'] = $this->ion_auth->user()->row();
            $this->db->select('*');
            $this->db->from('projects');
            $this->db->where_in('saas_id', $this->session->userdata());
            $query = $this->db->get();
            $this->data['projects'] = $query->result_array();


            $this->db->select('*');
            $this->db->from('issues');
            $this->db->where('id', $id);
            $query2 = $this->db->get();
            $this->data['issue'] = $query2->row();

            $this->db->select('*');
            $this->db->from('issues_sprint');
            $this->db->where('issue_id', $id);
            $query2 = $this->db->get();
            $this->data['issues_sprint'] = $query2->row();
            
            $this->db->select('*');
            $this->db->from('sprints');
            $this->db->where_in('saas_id', $this->session->userdata());
            $query = $this->db->get();
            $this->data['sprints'] = $query->result_array();

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
            $this->load->view('issues-edit', $this->data);
        } else {
            redirect('auth', 'refresh');
        }
    }
    public function create_issue()
    {

        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('issue_type', 'Type', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('project_id', 'Project', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|strip_tags|xss_clean');
            if ($this->form_validation->run() == TRUE) {

                $data = [
                    'title' => $this->input->post('title'),
                    'saas_id' => $this->session->userdata('saas_id'),
                    'project_id' => $this->input->post('project_id'),
                    'issue_type' => $this->input->post('issue_type'),
                    'description' => $this->input->post('description')?$this->input->post('description'):'',
                ];
                $id = $this->issues_model->create_issue($data);
                if ($id) {
                    if($this->input->post('sprint')) {
                        $sprintIssue = [
                            'issue_id'=>$id,
                            'sprint_id'=>$this->input->post('sprint')
                        ];
                        $this->issues_model->create_issue_sprint($sprintIssue);
                    }
                    $this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
                    $this->session->set_flashdata('message_type', 'success');
                    $this->data['data'] = $data;
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
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
    public function edit_issue()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('update_id', 'ID', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('issue_type', 'Type', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('project_id', 'Project', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|strip_tags|xss_clean');
            if ($this->form_validation->run() == TRUE) {

                $data = [
                    'title' => $this->input->post('title'),
                    'saas_id' => $this->session->userdata('saas_id'),
                    'project_id' => $this->input->post('project_id'),
                    'issue_type' => $this->input->post('issue_type'),
                    'description' => $this->input->post('description')?$this->input->post('description'):'',
                ];
                if ($this->issues_model->edit_issue($this->input->post('update_id'),$data)) {
                    if($this->input->post('sprint')) {
                        $sprintIssue = [
                            'sprint_id'=>$this->input->post('sprint')
                        ];
                        $this->issues_model->edit_issue_sprint($this->input->post('update_id'),$sprintIssue);
                    }
                    $this->session->set_flashdata('message', $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.");
                    $this->session->set_flashdata('message_type', 'success');
                    $this->data['data'] = $data;
                    $this->data['error'] = false;
                    $this->data['message'] = $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.";
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
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
}
