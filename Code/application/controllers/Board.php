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

            $this->db->select('*');
            $this->db->from('projects');
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
            $query9 = $this->db->get();
            $this->data['projects'] = $query9->result_array();

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
            if ($this->form_validation->run() == true) {
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
            redirect('auth', 'refresh');
        }
    }
    public function edit_sprint()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('update_id', 'update_id', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('name', 'Sprint Title', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('goal', 'Sprint Goal', 'trim|required|strip_tags|xss_clean');
            if ($this->form_validation->run() == true) {
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
            redirect('auth', 'refresh');
        }
    }
    public function filter_board()
    {
        $sprint_id = $this->input->post('sprint_id');
        $user_id = $this->input->post('user_id');
        $project_id = $this->input->post('project_id');
        $board = $this->input->post('board');

        $this->db->select('*');
        $this->db->from('task_status');
        $status_query = $this->db->get();
        $statuses = $status_query->result_array();

        if ($board && trim($board) == '1') {
            $this->db->select('*');
            $this->db->from('sprints');

            if ($sprint_id && trim($sprint_id) !== '') {
                $this->db->where('id', $sprint_id);
            }

            $sprint_query = $this->db->get();
            $sprint_data = $sprint_query->row_array();

            $this->db->select('i.*, p.title as project_title, pr.title as priority_title, pr.class as priority_class, u.first_name, u.last_name, u.profile');
            $this->db->from('tasks i');
            $this->db->join('issues_sprint is', 'is.issue_id = i.id', 'left');
            $this->db->join('projects p', 'p.id = i.project_id', 'left');
            $this->db->join('priorities pr', 'i.priority = pr.id', 'left');
            $this->db->join('task_users iu', 'iu.task_id = i.id', 'left');
            $this->db->join('users u', 'u.id = iu.user_id', 'left');

            if ($sprint_id && trim($sprint_id) !== '') {
                $this->db->where('is.sprint_id', $sprint_id);
            }

            $this->db->where('i.saas_id', $this->session->userdata('saas_id'));
            if ($user_id && trim($user_id) !== '') {
                $this->db->where('iu.user_id', $user_id);
            }

            if ($project_id && trim($project_id) !== '') {
                $this->db->where('p.id', $project_id);
            }

            $this->db->order_by('created', 'desc');
            $issues_query = $this->db->get();
            $issues_data = $issues_query->result_array();
        } else {
            $this->db->select('i.*, p.title as project_title, pr.title as priority_title, pr.class as priority_class, u.first_name, u.last_name, u.profile');
            $this->db->from('tasks i');
            $this->db->join('projects p', 'p.id = i.project_id', 'left');
            $this->db->join('priorities pr', 'i.priority = pr.id', 'left');
            $this->db->join('task_users iu', 'iu.task_id = i.id', 'left');
            $this->db->join('users u', 'u.id = iu.user_id', 'left');
            $this->db->where('p.dash_type', 0);
            $this->db->where('i.saas_id', $this->session->userdata('saas_id'));
            if ($user_id && trim($user_id) !== '') {
                $this->db->where('iu.user_id', $user_id);
            }
            if ($project_id && trim($project_id) !== '') {
                $this->db->where('p.id', $project_id);
            }

            $this->db->order_by('created', 'desc');
            $issues_query = $this->db->get();
            $issues_data = $issues_query->result_array();
        }

        $total = 0;
        $html = '';
        $completed = 0;
        foreach ($statuses as $status) {
            $html .= '<div class="col-xl-3 col-md-6 px-0">
            <div class="kanbanPreview-bx">
                <div class="draggable-zone dropzoneContainer" data-status-id="' . $status["id"] . '">
                    <div class="sub-card align-items-center d-flex justify-content-between mb-4">
                        <div>
                            <h4 class="mb-0">' . $status["title"] . '</h4>
                        </div>
                    </div>
                ';
            foreach ($issues_data as $issue) {                  // issue cards
                if ($status["id"] == $issue["status"]) {
                    $html .= $this->html_generating($status, $issue);
                    $total++;
                    if ($status["id"] == 4) {
                        $completed++;
                    }
                }
            }
            $html .= '</div>
                </div>
            </div>';
        }

        if ($completed != 0) {
            $percent =  $completed * 100 / $total;
            $rounded_percent = (int) round($percent);
        } else {
            $rounded_percent = 0;
        }
        $result = array(
            'sprint' => $sprint_data,
            'issues' => $issues_data,
            'html' => $html,
            'total' => $total,
            'completed' => $completed,
            'percent' => 'Total Progress ' . $rounded_percent . '%',
        );

        echo json_encode($result);
    }
    public function html_generating($status, $issue)
    {
        $html = '';
        if (isset($issue["profile"]) && !empty($issue["profile"])) {
            if (file_exists('assets/uploads/profiles/' . $issue["profile"])) {
                $file_upload_path = base_url('assets/uploads/profiles/' . $issue["profile"]);
            } else {
                $file_upload_path = base_url('assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $issue["profile"]);
            }
            $item["profile"] = true;
        }
        if (permissions('task_status') || $this->ion_auth->is_admin()) {
            $html .= '<div class="card draggable-handle draggable" data-id="' . $issue["id"] . '">';
        } else {
            $html .= '<div class="card draggable-handle" data-id="' . $issue["id"] . '">';
        }
        $html .= '<div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-' . $issue["priority_class"] . '"> <!-- priority class -->
                                <svg class="me-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="5" r="5" class="custom-circle-fill-' . $issue["priority_class"] . '" />
                                </svg>
                                ' . ($issue['project_title']) . '
                            </span>
                            <div class="dropdown">
                                <div class="btn-link" data-bs-toggle="dropdown">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="3.5" cy="11.5" r="2.5" transform="rotate(-90 3.5 11.5)" fill="#717579" />
                                        <circle cx="11.5" cy="11.5" r="2.5" transform="rotate(-90 11.5 11.5)" fill="#717579" />
                                        <circle cx="19.5" cy="11.5" r="2.5" transform="rotate(-90 19.5 11.5)" fill="#717579" />
                                    </svg>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item delete_issue" data-issue-id="' . $issue["id"] . '" href="javascript:void(0)">Delete</a>
                                    <a class="dropdown-item" href="' . base_url('issues/edit/' . $issue["id"]) . '">Edit</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-0"><a href="javascript:void(0);" class="text-black btn-detail-model" data-id="' . $issue["id"] . '" data-bs-toggle="modal" data-bs-target="#issue-detail-modal">' . ($issue['title']) . '</a></h5>
                        <div class="section-title mt-3 mb-1">' . ($this->lang->line('priority') ? ($this->lang->line('priority')) : 'Priority') . '</div>
                        <span class="badge light badge-' . $issue["priority_class"] . '">' . ($issue['priority_title']) . '</span>
                        <div class="row justify-content-between align-items-center kanban-user">
                            <div class="section-title mt-3 mb-1">' . ($this->lang->line('team_members') ? ($this->lang->line('team_members')) : 'Team Members') . '</div>';
        if (!empty($issue["profile"])) {
            $html .= '<ul class="users col-6">
                                            <li style="cursor: pointer;">
                                            <img data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . ($issue["first_name"] . ' ' . $issue["last_name"]) . '" src="' . $file_upload_path . '" alt="' . $file_upload_path . '"></li>
                                        </ul>';
        } else {
            $html .= '<ul class="kanbanimg col-6">
                                            <li><span data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . ($issue["first_name"] . ' ' . $issue["last_name"]) . '">' . (substr($issue["first_name"], 0, 1) . substr($issue["last_name"], 0, 1)) . '</span></li>
                                        </ul>';
        }
        $html .= '
            <!--<div class="col-6 d-flex justify-content-end">
                                    <span class="fs-14"><i class="far fa-clock me-2"></i>Due in 4 days</span>
                                </div> -->
                            </div>
                        </div>
                    </div>';
        return $html;
    }
    public function get_project_by_board_type()
    {
        $dash_type = $this->input->post('boardType');
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('dash_type', $dash_type);
        $status_query = $this->db->get();
        $project = $status_query->result_array();
        echo json_encode($project);
    }
    public function saveStatus()
    {
        if ($this->ion_auth->logged_in()) {
            $data["status"] = $this->input->post('status');
            if ($this->board_model->update_status($this->input->post('task'), $data)) {
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
            redirect('auth', 'refresh');
        }
    }
}
