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
            $this->db->from('priorities');
            $query8 = $this->db->get();
            $this->data['priorities'] = $query8->result_array();

            $this->db->select('*');
            $this->db->from('sprints');
            $this->db->where('status', 1);
            $query2 = $this->db->get();
            $this->data['sprints'] = $query2->result_array();

            $this->db->select('issues.*, projects.title AS project_name');
            $this->db->from('issues_sprint');
            $this->db->join('issues', 'issues_sprint.issue_id = issues.id');
            $this->db->join('projects', 'issues.project_id = projects.id');
            $this->db->where('issues_sprint.sprint_id', $this->data['sprints'][0]["id"]);
            $query = $this->db->get();
            $issues_sprint = $query->result_array();
            foreach ($issues_sprint as &$item) {
                $id = $item["id"];
                $this->db->select('users.*');
                $this->db->from('issues_users');
                $this->db->join('users', 'issues_users.user_id = users.id');
                $this->db->where('issues_users.issue_id', $id);
                $query = $this->db->get();
                $issues_users = $query->row();
                if (isset($issues_users->profile) && !empty($issues_users->profile)) {
                    if (file_exists('assets/uploads/profiles/' . $issues_users->profile)) {
                        $file_upload_path = 'assets/uploads/profiles/' . $issues_users->profile;
                    } else {
                        $file_upload_path = base_url('assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $issues_users->profile);
                    }
                    $item["profile"] = true;
                } else {
                    $file_upload_path = mb_substr(htmlspecialchars($issues_users->first_name), 0, 1, "utf-8") . '' . mb_substr(htmlspecialchars($issues_users->last_name), 0, 1, "utf-8");
                    $item["profile"] = false;
                }
                $item["user"] =   $file_upload_path;
                $item["user_name"] =   $issues_users->first_name . ' ' . $issues_users->last_name;
            }

            $this->data['issues'] = $issues_sprint;
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
    public function filter_board()
    {

        $this->db->select('s.id as sprint_id, s.title as sprint_title, i.id as issue_id, i.title as issue_title, u.id as user_id, u.first_name as user_first_name, u.last_name as user_last_name, u.profile as user_profile');
        $this->db->from('sprints s');
        $this->db->join('issues_sprint ispr', 's.id = ispr.sprint_id', 'left');
        $this->db->join('issues i', 'ispr.issue_id = i.id', 'left');
        $this->db->join('issues_users iu', 'i.id = iu.issue_id', 'left');
        $this->db->join('users u', 'iu.user_id = u.id', 'left');

        if ($this->input->post('sprint_id') && trim($this->input->post('sprint_id')) !== '') {
            $sprint_id = $this->input->post('sprint_id');
            $this->db->where('s.id', $sprint_id);
        }
        if ($this->input->post('user_id') && trim($this->input->post('user_id')) !== '') {
            $user_id = $this->input->post('user_id');
            $this->db->where('u.id', $user_id);
        }
        $query = $this->db->get();
        $sprints_with_issues_users_filtered = $query->result_array();

        foreach ($sprints_with_issues_users_filtered as &$value) {
            $tempHTML = '';
            if (isset($value["user_profile"]) && !empty($value["user_profile"])) {
                if (file_exists('assets/uploads/profiles/' . $value["user_profile"])) {
                    $file_upload_path = 'assets/uploads/profiles/' . $value["user_profile"];
                } else {
                    $file_upload_path = base_url('assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $value["user_profile"]);
                }
                $tempHTML .= '<div class="section-title mt-3 mb-1">' . ($this->lang->line('team_members') ? htmlspecialchars($this->lang->line('team_members')) : 'Team Members') . '</div>';
                $tempHTML .= '<ul class="users col-6">';
                $tempHTML .= '<li style="cursor: pointer;"><img data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . $value["user_first_name"] . ' ' . $value["user_last_name"] . '" src="' . $file_upload_path . '" alt="' . $value["user_last_name"] . '"></li>';
                $tempHTML .= '</ul>';
            } else {
                $file_upload_path = mb_substr(htmlspecialchars($value["user_first_name"]), 0, 1, "utf-8") . '' . mb_substr(htmlspecialchars($value["user_last_name"]), 0, 1, "utf-8");
                $tempHTML .= '<div class="section-title mt-3 mb-1">' . ($this->lang->line('team_members') ? htmlspecialchars($this->lang->line('team_members')) : 'Team Members') . '</div>';
                $tempHTML .= '<ul class="kanbanimg col-6">';
                $tempHTML .= '<li><span data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . $value["user_first_name"] . ' ' . $value["user_last_name"] . '">' . $file_upload_path . '</span></li>';
                $tempHTML .= '</ul>';
            }

            $tempHTML .= '<div class="col-6 d-flex justify-content-end">
                            <span class="fs-14"><i class="far fa-clock me-2"></i>Due in 4
                                days
                            </span>
                        </div>';
            $value["user_profile"] = $tempHTML;
        }

        echo json_encode(array(
            'status' => true,
            'issues' => $sprints_with_issues_users_filtered
        ));
    }
}
