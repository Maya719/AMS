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
            $this->data['is_allowd_to_create_new'] = if_allowd_to_create_new("projects");

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
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
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
        // Validate inputs
        $sprint_id = $this->input->post('sprint_id');
        $user_id = $this->input->post('user_id');
        $project_id = $this->input->post('project_id');
        $board = $this->input->post('board');

        // Determine the users based on input and permissions
        if (!empty($user_id)) {
            // Use the provided user_id
            $users = [$user_id];
        } else {
            if ($this->ion_auth->is_admin() || permissions('project_view_all')) {
            } else if (permissions('project_view_selected')) {
                $users = selected_users();
            } else {
                $users = [$this->session->userdata('user_id')];
            }
        }
        // Fetch statuses
        $statuses = $this->get_statuses();

        $issues_data = $this->get_issues($sprint_id, $project_id, $board, $users);
        $sprint_data = $this->get_sprint($sprint_id);

        $html = '';
        $completed = 0;
        $total = 0;
        list($html, $completed, $total) = $this->generate_html_and_metrics($statuses, $issues_data);

        // Calculate the progress percentage
        $rounded_percent = $this->calculate_progress($completed, $total);

        // Prepare the result
        $result = [
            'sprint' => $sprint_data ?? [],
            'issues' => $issues_data,
            'html' => $html,
            'total' => $total,
            'completed' => $completed,
            'user_id' => $user_id,
            'percent' => 'Total Progress ' . $rounded_percent . '%',
        ];

        // Return JSON-encoded result
        echo json_encode($result);
    }

    private function get_sprint($sprint_id)
    {
        $this->db->select('*');
        $this->db->from('sprints');
        $this->db->where('id', $sprint_id);
        $status_query = $this->db->get();
        return $status_query->row();
    }
    private function get_statuses()
    {
        $this->db->select('*');
        $this->db->from('task_status');
        $status_query = $this->db->get();
        return $status_query->result_array();
    }

    private function get_issues($sprint_id, $project_id, $board, $users)
    {
        // Fetch issues based on the input filters
        $this->db->select('i.*, p.title as project_title, pr.title as priority_title, pr.class as priority_class, u.first_name, u.last_name, u.profile');
        $this->db->from('tasks i');
        $this->db->join('projects p', 'p.id = i.project_id', 'left');
        $this->db->join('priorities pr', 'i.priority = pr.id', 'left');
        $this->db->join('task_users iu', 'iu.task_id = i.id', 'left');
        $this->db->join('users u', 'u.id = iu.user_id', 'left');

        // Add filters based on input parameters
        if ($board && trim($board) == '1') {
            // Handle sprint board
            $this->db->join('issues_sprint is', 'is.issue_id = i.id', 'left');
            if ($sprint_id && trim($sprint_id) !== '') {
                $this->db->where('is.sprint_id', $sprint_id);
            }
        } else {
            // Handle other boards
            $this->db->where('p.dash_type', 0);
        }

        // Additional filters
        $this->db->where('i.saas_id', $this->session->userdata('saas_id'));
        if (!empty($users)) {
            $this->db->where_in('iu.user_id', $users);
        }
        if ($project_id && trim($project_id) !== '') {
            $this->db->where('p.id', $project_id);
        }

        // Execute the query and return results
        $this->db->order_by('created', 'desc');
        $issues_query = $this->db->get();
        return $issues_query->result_array();
    }

    private function generate_html_and_metrics($statuses, $issues_data)
    {
        $html = '';
        $completed = 0;
        $total = 0;

        // Generate HTML and calculate completion metrics
        foreach ($statuses as $status) {
            $html .= '<div class="col-xl-3 col-md-6 px-0">';
            $html .= '<div class="kanbanPreview-bx">';
            $html .= '<div class="draggable-zone dropzoneContainer" data-status-id="' . $status["id"] . '">';
            $html .= '<div class="sub-card align-items-center d-flex justify-content-between mb-4">';
            $html .= '<div>';
            $html .= '<h4 class="mb-0">' . $status["title"] . '</h4>';
            $html .= '</div>';
            $html .= '</div>';

            // Add issue cards based on status
            foreach ($issues_data as $issue) {
                if ($status["id"] == $issue["status"]) {
                    $html .= $this->html_generating($status, $issue);
                    $total++;
                    if ($status["id"] == 4) {
                        $completed++;
                    }
                }
            }

            $html .= '</div></div></div>';
        }

        return [$html, $completed, $total];
    }

    private function calculate_progress($completed, $total)
    {
        if ($completed == 0 || $total == 0) {
            return 0;
        }
        return (int) round($completed * 100 / $total);
    }

    public function html_generating($status, $issue)
    {
        $due_or_not = '';
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
        $html .= '<div class="card-body">';
        if ($this->ion_auth->is_admin() || permissions('task_delete') || permissions('task_edit')) {

            $html .= '<div class="d-flex justify-content-between mb-2">
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
                                <div class="dropdown-menu dropdown-menu-right">';
            if ($this->ion_auth->is_admin() || permissions('task_delete')) {
                $html .= '<a class="dropdown-item delete_issue" data-issue-id="' . $issue["id"] . '" href="javascript:void(0)">Delete</a>';
            }
            if ($this->ion_auth->is_admin() || permissions('task_edit')) {

                $html .= '<a class="dropdown-item" href="' . base_url('issues/edit/' . $issue["id"]) . '">Edit</a>';
            }
            $html .= '</div>
                            </div>
                        </div>';
        }

        $html .= '<h5 class="mb-0"><a href="javascript:void(0);" class="text-black btn-detail-model" data-id="' . $issue["id"] . '" data-bs-toggle="modal" data-bs-target="#issue-detail-modal">' . ($issue['title']) . '</a></h5>
                        <div class="section-title mt-3 mb-1">' . ($this->lang->line('priority') ? ($this->lang->line('priority')) : 'Priority') . '</div>
                        <span class="badge light badge-' . $issue["priority_class"] . '">' . ($issue['priority_title']) . '</span>
                        <div class="row justify-content-between align-items-center kanban-user">
                            <div class="section-title mt-3 mb-1">' . ($this->lang->line('team_member') ? ($this->lang->line('team_member')) : 'Team Member') . '</div>';
        if (!empty($issue["profile"])) {
            $html .= '<ul class="users col-4">
                                            <li style="cursor: pointer;">
                                            <img data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . ($issue["first_name"] . ' ' . $issue["last_name"]) . '" src="' . $file_upload_path . '" alt="' . $file_upload_path . '"></li>
                                        </ul>';
        } else {
            $html .= '<ul class="kanbanimg col-4">
                                            <li><span data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . ($issue["first_name"] . ' ' . $issue["last_name"]) . '">' . (substr($issue["first_name"], 0, 1) . substr($issue["last_name"], 0, 1)) . '</span></li>
                                        </ul>';
        }
        $due_or_not = $this->get_due_dates($issue["starting_date"], $issue["due_date"], $status["id"]);
        $html .= '
                                <div class="col-8 d-flex justify-content-end">
                                    <span class="fs-14"><i class="far fa-clock me-2"></i>' . $due_or_not . '</span>
                                </div> 
                            </div>
                        </div>
                    </div>';
        return $html;
    }
    public function get_due_dates($starting_date, $due_date, $status)
    {
        $current = date('Y-m-d');

        if ($status == 4) {
            return 'completed';
        } else {
            if ($due_date < $current) {
                // Calculate days overdue
                $datetime1 = new DateTime($due_date);
                $datetime2 = new DateTime($current);
                $interval = $datetime1->diff($datetime2);
                $days_overdue = $interval->days;
                return $days_overdue . ' days overdue';
            } else {
                // Calculate days until due date
                $datetime1 = new DateTime($current);
                $datetime2 = new DateTime($due_date);
                $interval = $datetime1->diff($datetime2);
                $days_until_due = $interval->days;
                if ($days_until_due == 0) {
                    return 'delivery days';
                }else{
                    return 'Due in ' . $days_until_due . ' days';
                }
            }
        }
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
