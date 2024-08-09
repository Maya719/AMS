<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function get_team_list()
	{
		if ($this->ion_auth->logged_in()) {

			$bulkData = array();
			if ($this->ion_auth->is_admin() || permissions('user_view_all')) {
				$system_users = $this->ion_auth->all_roles()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$system_users = $users;
			}
			foreach ($system_users as $system_user) {
				if (isset($system_user->saas_id) && $this->session->userdata('saas_id') == $system_user->saas_id) {
					$tempRow[] = $system_user;
					$tempRow['id'] = $system_user->user_id;
					$tempRow['email'] = $system_user->email;
					$tempRow['active'] = $system_user->active;
					$tempRow['first_name'] = $system_user->first_name . ' ' . $system_user->last_name;
					$tempRow['last_name'] = $system_user->last_name;

					$group = $this->ion_auth->get_users_groups($system_user->user_id)->result();
					if (!empty($group)) {
						$tempRow['role'] = $group[0]->description;
					}
					$tempRow['group_id'] = $group[0]->id;
					$tempRow['projects_count'] = get_count('id', 'project_users', 'user_id=' . $system_user->user_id);
					$tempRow['tasks_count'] = get_count('id', 'task_users', 'user_id=' . $system_user->user_id);

					$tempRow['phone'] = $system_user->phone != 0 ? $system_user->phone : '';

					$tempRow['status'] = $system_user->active == 1 ? ('<span class="badge badge-success">' . ($this->lang->line('active') ? $this->lang->line('active') : 'Active') . '</span>') : ('<span class="badge badge-danger">' . ($this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive') . '</span>');

					$rows[] = $tempRow;
				}
			}

			$bulkData['rows'] = $rows;
			print_r(json_encode($bulkData));
		} else {
			return '';
		}
	}

	public function get_client_list()
	{
		if ($this->ion_auth->logged_in()) {

			$bulkData = array();

			$system_users = $this->ion_auth->users(array(4))->result();
			foreach ($system_users as $system_user) {
				if (isset($system_user->saas_id) && $this->session->userdata('saas_id') == $system_user->saas_id) {
					$tempRow[] = $system_user;
					$tempRow['id'] = $system_user->user_id;
					$tempRow['email'] = $system_user->email;
					$tempRow['active'] = $system_user->active;
					$tempRow['first_name'] = $system_user->first_name . ' ' . $system_user->last_name;
					$tempRow['last_name'] = $system_user->last_name;
					$tempRow['phone'] = $system_user->phone != 0 ? $system_user->phone : '';
					$tempRow['company'] = company_details('company_name', $system_user->user_id);
					$tempRow['projects_count'] = get_count('id', 'projects', 'client_id=' . $system_user->user_id);
					$tempRow['status'] = $system_user->active == 1 ? ('<span class="badge badge-success">' . ($this->lang->line('active') ? $this->lang->line('active') : 'Active') . '</span>') : ('<span class="badge badge-danger">' . ($this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive') . '</span>');

					$rows[] = $tempRow;
				}
			}

			$bulkData['rows'] = $rows;
			print_r(json_encode($bulkData));
		} else {
			return '';
		}
	}

	public function client()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('clients') && ($this->ion_auth->is_admin() || permissions('client_view'))) {
			$this->data['page_title'] = 'Clients - ' . company_name();
			$this->data['main_page'] = 'Clients';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$system_users = $this->ion_auth->users(array(4))->result();
			foreach ($system_users as $system_user) {
				if (isset($system_user->saas_id) && $this->session->userdata('saas_id') == $system_user->saas_id) {
					$tempRow['id'] = $system_user->user_id;
					$tempRow['email'] = $system_user->email;
					$tempRow['active'] = $system_user->active;
					$tempRow['first_name'] = $system_user->first_name;
					$tempRow['last_name'] = $system_user->last_name;
					$tempRow['phone'] = $system_user->phone != 0 ? $system_user->phone : '';
					$tempRow['company'] = company_details('company_name', $system_user->user_id);

					$tempRow['profile'] = '';
					if ($system_user->profile) {
						if (file_exists('assets/uploads/profiles/' . $system_user->profile)) {
							$file_upload_path = 'assets/uploads/profiles/' . $system_user->profile;
						} else {
							$file_upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $system_user->profile;
						}
						$tempRow['profile'] = base_url($file_upload_path);
					}

					$tempRow['short_name'] = mb_substr($system_user->first_name, 0, 1, "utf-8") . '' . mb_substr($system_user->last_name, 0, 1, "utf-8");
					$group = $this->ion_auth->get_users_groups($system_user->user_id)->result();
					$tempRow['role'] = ucfirst($group[0]->name);
					$tempRow['group_id'] = $group[0]->id;
					$tempRow['projects_count'] = get_count('id', 'projects', 'client_id=' . $system_user->user_id);
					$rows[] = $tempRow;
				}
			}
			$this->data['system_users'] = isset($rows) ? $rows : '';
			$this->data['user_groups'] = $this->ion_auth->groups(array(1, 2, 4))->result();
			$this->load->view('clients', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function create_user()
	{
		$this->data['is_allowd_to_create_new'] = if_allowd_to_create_new("users");
		if ($this->ion_auth->logged_in() && is_module_allowed('team_members') && ($this->ion_auth->is_admin() || permissions('user_view') || is_assign_users() || $this->ion_auth->in_group(3))) {
			$saas_id = $this->session->userdata('saas_id');
			$this->data['user_groups'] = $this->ion_auth->get_all_groups();
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('shift');
			$this->data['shift_types'] = $query->result_array();
			$this->db->where('saas_id', $saas_id);
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('devices');
			$this->data['devices'] = $query->result_array();
			$this->db->where('saas_id', $saas_id);
			$query4 = $this->db->get('leaves_type');
			$this->data['leave_types'] = $query4->result_array();
			$this->data['page_title'] = 'Create User - ' . company_name();
			$this->data['main_page'] = 'Create User';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('create_user', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function edit_user($id)
	{

		if ($this->ion_auth->logged_in() && is_module_allowed('team_members') && ($this->ion_auth->is_admin() || permissions('user_view') || is_assign_users() || $this->ion_auth->in_group(3))) {
			$this->data['user_groups'] = $this->ion_auth->get_all_groups();
			$saas_id = $this->session->userdata('saas_id');
			$query = $this->db->get('shift');
			$this->data['shift_types'] = $query->result_array();

			$this->db->where('saas_id', $saas_id);
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();

			$query = $this->db->get('devices');
			$this->data['devices'] = $query->result_array();
			$saas_id = $this->session->userdata('saas_id');
			
			$this->db->where('saas_id', $saas_id);
			$query4 = $this->db->get('leaves_type');
			$this->data['leave_types'] = $query4->result_array();

			$this->db->where('user_id', $id);
			$query5 = $this->db->get('applied_policies');
			$query5_result = $query5->row_array();
			$appliedRulesJSON = $query5_result['applied_rules'];
			$appliedRules = json_decode($appliedRulesJSON, true);

			$this->data['applied_policies'] = $appliedRules;

			$this->data['page_title'] = 'Edit User - ' . company_name();
			$this->data['main_page'] = 'Edit User';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$group = $this->ion_auth->get_users_groups($id)->result();
			if (!empty($group)) {
				$this->data['role'] = $group[0]->id;
			}
			$this->data['data'] = $this->ion_auth->user($id)->row();
			// echo json_encode($this->data);
			$this->load->view('edit_user', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function index()
	{
		$this->data['is_allowd_to_create_new'] = if_allowd_to_create_new("projects");
		if ($this->ion_auth->logged_in() && is_module_allowed('team_members') && ($this->ion_auth->is_admin() || permissions('user_view') || is_assign_users() || $this->ion_auth->in_group(3))) {
			$this->data['page_title'] = 'Employee - ' . company_name();
			$this->data['main_page'] = 'Employee';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$saas_id = $this->session->userdata('saas_id');
			$query = $this->db->where('saas_id', $saas_id)->get('shift');
			$this->data['shift_types'] = $query->result_array();

			$query3 = $this->db->where('saas_id', $saas_id)->get('departments');
			$this->data['departments'] = $query3->result_array();

			$query = $this->db->where('saas_id', $saas_id)->get('devices');
			$this->data['devices'] = $query->result_array();
			
			if (is_saas_admin()) {
				$system_users = $this->ion_auth->users(array(3))->result();
				foreach ($system_users as $system_user) {
					if ($this->session->userdata('saas_id') == $system_user->saas_id && $this->session->userdata('email') != $system_user->email) {
						$tempRow['employee_id'] = $system_user->employee_id;
						$tempRow['id'] = $system_user->user_id;
						$tempRow['email'] = $system_user->email;
						$tempRow['active'] = $system_user->active;
						$tempRow['first_name'] = $system_user->first_name;
						$tempRow['last_name'] = $system_user->last_name;
						$tempRow['father_name'] = $system_user->father_name;
						$tempRow['cnic'] = $system_user->cnic;
						$tempRow['gender'] = $system_user->gender;
						$tempRow['join_date'] = $system_user->join_date;
						$tempRow['company'] = company_details('company_name', $system_user->user_id);
						$tempRow['phone'] = $system_user->phone != 0 ? $system_user->phone : '';
						$user_id = $tempRow['id'];
						$tempRow['status'] = (($system_user->active == 1) ? '<span class="badge badge-success mb-1">' . ($this->lang->line('active') ? $this->lang->line('active') : 'Active') . '</span>' : '<span class="badge badge-danger mb-1">' . ($this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive') . '</span>');


						$shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
						$shift_result = $shift_query->row_array();
						$shift_id = $shift_result['shift_id'];

						if ($shift_id === '0') {
							$tempRow['shift_type'] = '<span class="text-muted">No Shift Assigned</span>';
						} else {
							$shift_query = $this->db->query("SELECT * FROM shift WHERE id = $shift_id");
							$shift_result = $shift_query->row_array();
							$tempRow['shift_type'] = $shift_result['name'];
						}
						$tempRow['profile'] = '';
						if ($system_user->profile) {
							if (file_exists('assets/uploads/profiles/' . $system_user->profile)) {
								$file_upload_path = 'assets/uploads/profiles/' . $system_user->profile;
							} else {
								$file_upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $system_user->profile;
							}
							$tempRow['profile'] = base_url($file_upload_path);
						}

						$shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
						$shift_result = $shift_query->row_array();
						$department_id = $shift_result['department'];

						if ($department_id === '0' || $department_id === '') {
							$tempRow['department'] = '';
						} else {
							$departmentQuery = $this->db->query("SELECT * FROM departments WHERE id = $department_id");
							$department_result = $departmentQuery->row_array();
							$tempRow['department'] = $department_result['department_name'];
						}

						$tempRow['short_name'] = mb_substr($system_user->first_name, 0, 1, "utf-8") . '' . mb_substr($system_user->last_name, 0, 1, "utf-8");
						$group = $this->ion_auth->get_users_groups($system_user->user_id)->result();

						if (!empty($group)) {
							$tempRow['role'] = $group[0]->description;
						}
						$tempRow['group_id'] = $group[0]->id;
						$tempRow['projects_count'] = get_count('id', 'project_users', 'user_id=' . $system_user->user_id);
						$tempRow['tasks_count'] = get_count('id', 'task_users', 'user_id=' . $system_user->user_id);
						$rows[] = $tempRow;
					}
				}
				$this->data['saas_users'] = $rows;
			} elseif ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}
			$this->data['user_groups'] = $this->ion_auth->get_all_groups();
			if (is_saas_admin()) {
				$this->load->view('saas-admins', $this->data);
			} else {
				// echo json_encode($this->data);
				$this->load->view('users', $this->data);
			}
		} else {
			redirect_to_index();
		}
	}

	public function get_saas_users()
	{
		if ($this->ion_auth->logged_in() && is_saas_admin()) {
			return $this->users_model->get_saas_users();
		} else {
			return '';
		}
	}

	public function saas()
	{

		if ($this->ion_auth->logged_in() && is_saas_admin()) {
			set_expire_all_expired_plans();
			$this->notifications_model->edit('', 'new_user', '', '', '');
			$this->data['page_title'] = 'Users - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['plans'] = $this->plans_model->get_plans();
			$this->data['saas_users'] = $this->users_model->get_saas_users();
			// echo json_encode($this->data);
			$this->load->view('saas-users', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function company()
	{
		if ($this->ion_auth->logged_in() && is_client()) {
			$this->data['page_title'] = 'Company Settings - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['company_details'] = company_details();
			$this->load->view('company', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function profile()
	{

		if ($this->ion_auth->logged_in()) {
			$this->data['page_title'] = 'Profile - ' . company_name();
			$this->data['main_page'] = 'Profile';
			$this->data['current_user'] = $profile_user = $this->ion_auth->user()->row();
			$query = $this->db->get('shift');
			$this->data['shift_types'] = $query->result_array();
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$tempRow = [];
			$user_id = $profile_user->user_id;
			// Check if the user ID is not empty and is numeric
			if (!empty($user_id) && is_numeric($user_id)) {
				// Fetch all records from the users table based on the user ID
				$query = $this->db->query("SELECT * FROM users WHERE id = {$user_id}");
				$user_data = $query->row();

				if ($user_data && !is_client()) {
					$tempRow['id'] = $user_data->id;
					$tempRow['email'] = $user_data->email;
					$tempRow['active'] = $user_data->active;
					$tempRow['first_name'] = $user_data->first_name;
					$tempRow['last_name'] = $user_data->last_name;
					$tempRow['phone'] = $user_data->phone != 0 ? $user_data->phone : '';
					$tempRow['profile'] = !empty($user_data->profile) ? $user_data->profile : '';
					$tempRow['short_name'] = mb_substr($user_data->first_name, 0, 1, "utf-8") . '' . mb_substr($user_data->last_name, 0, 1, "utf-8");
					$tempRow['projects_count'] = get_count('id', 'project_users', 'user_id=' . $user_data->id);
					$tempRow['tasks_count'] = get_count('id', 'task_users', 'user_id=' . $user_data->id);
					$group = $this->ion_auth->get_users_groups($user_data->id)->result();
					$tempRow['role'] = ucfirst($group[0]->description);
					$tempRow['group_id'] = $group[0]->id;
					$user_id = $tempRow['id'];
					$shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
					$shift_result = $shift_query->row_array();
					$tempRow['shift_id'] = $shift_result['shift_id'];
					$tempRow['cnic'] = $user_data->cnic;
					$tempRow['father_name'] = $user_data->father_name;
					$tempRow['gender'] = $user_data->gender;
					$deviceArray = json_decode($user_data->device_id);
					$deviceNumber = isset($deviceArray[0]) ? intval($deviceArray[0]) : 1;
					$tempRow['device'] = $deviceNumber;
					$tempRow['status'] = $user_data->active;
					$tempRow['employee_id'] = $user_data->employee_id;
					$tempRow['finger_config'] = $user_data->finger_config;
					$tempRow['department'] = $user_data->department;
					$tempRow['martial_status'] = $user_data->martial_status;
					$tempRow['blood_group'] = $user_data->blood_group;


					$department_id = $tempRow['department'];

					$query = $this->db->query("SELECT * FROM departments WHERE id = $department_id");
					$department = $query->row_array();
					$tempRow['department_name'] = $department['department_name'];
					// Function to check if a date is in the desired format
					function isValidDateFormat($date)
					{
						$dateTimeObj = DateTime::createFromFormat('d M Y', $date);
						return $dateTimeObj !== false && !array_sum($dateTimeObj->getLastErrors());
					}

					// Assuming $user_data->DOB and $user_data->join_date are in the format 'Y-m-d' (e.g., '2022-01-03')
					if (isValidDateFormat($user_data->DOB)) {
						$dateOfBirth = $user_data->DOB;
					} else {
						$dateOfBirth = date("d M Y", strtotime($user_data->DOB));
					}

					if (isValidDateFormat($user_data->join_date)) {
						$joinDate = $user_data->join_date;
					} else {
						$joinDate = date("d M Y", strtotime($user_data->join_date));
					}

					$tempRow['date_of_birth'] = $dateOfBirth;
					$tempRow['join_date'] = $joinDate;
					$tempRow['desgnation'] = $user_data->desgnation;
					$tempRow['emg_person'] = $user_data->emg_person;
					$tempRow['emg_number'] = $user_data->emg_number;
					$tempRow['address'] = $user_data->address;

					// Assign the updated $tempRow to $this->data['profile_user']
					$this->data['profile_user'] = $tempRow;
				}
			}

			$this->data['profile_user'] = $tempRow;
			$this->data['user_groups'] = $this->ion_auth->groups(array(1, 2))->result();
			$this->load->view('profile', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function detail()
	{
		if ($this->ion_auth->logged_in()) {
			$this->data['page_title'] = 'Profile - ' . company_name();
			$this->data['current_user'] = $profile_user = $this->ion_auth->user()->row();
			$query = $this->db->get('shift');
			$this->data['shift_types'] = $query->result_array();
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$query = $this->db->get('devices');
			$this->data['devices'] = $query->result_array();
			$user_id = $this->uri->segment($this->uri->total_segments());
			if (is_assign_users()) {
				$selected = selected_users();
				$selected[] = $this->session->userdata('user_id');
				if (!empty($selected)) {
					if (!in_array($user_id, $selected)) {
						$user_id = 0;
					}
				} else {
					$user_id = 0;
				}
			}
			if (!empty($user_id) && is_numeric($user_id)) {
				$query = $this->db->query("SELECT * FROM users WHERE id = {$user_id}");
				$user_data = $query->row();

				if ($user_data) {
					$tempRow['id'] = $user_data->id;
					$tempRow['email'] = $user_data->email;
					$tempRow['active'] = $user_data->active;
					$tempRow['first_name'] = $user_data->first_name;
					$tempRow['last_name'] = $user_data->last_name;
					$tempRow['phone'] = $user_data->phone != 0 ? $user_data->phone : '';
					$tempRow['profile'] = !empty($user_data->profile) ? $user_data->profile : '';
					$tempRow['short_name'] = mb_substr($user_data->first_name, 0, 1, "utf-8") . '' . mb_substr($user_data->last_name, 0, 1, "utf-8");
					$tempRow['projects_count'] = get_count('id', 'project_users', 'user_id=' . $user_data->id);
					$tempRow['tasks_count'] = get_count('id', 'task_users', 'user_id=' . $user_data->id);
					$group = $this->ion_auth->get_users_groups($user_data->id)->result();
					$tempRow['role'] = ucfirst($group[0]->description);
					$tempRow['group_id'] = $group[0]->id;
					$user_id = $tempRow['id'];
					$shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
					$shift_result = $shift_query->row_array();
					$tempRow['shift_id'] = $shift_result['shift_id'];
					$tempRow['cnic'] = $user_data->cnic;
					$tempRow['father_name'] = $user_data->father_name;
					$tempRow['gender'] = $user_data->gender;
					$tempRow['status'] = $user_data->active;
					$tempRow['employee_id'] = $user_data->employee_id;
					$deviceArray = json_decode($user_data->device_id);
					$deviceNumber = isset($deviceArray[0]) ? intval($deviceArray[0]) : 1;
					$tempRow['device_id'] = $deviceNumber;
					$tempRow['department'] = $user_data->department;
					// Function to check if a date is in the desired format
					function isValidDateFormat($date)
					{
						$dateTimeObj = DateTime::createFromFormat('d M Y', $date);
						return $dateTimeObj !== false && !array_sum($dateTimeObj->getLastErrors());
					}

					// Assuming $user_data->DOB and $user_data->join_date are in the format 'Y-m-d' (e.g., '2022-01-03')
					if (isValidDateFormat($user_data->DOB)) {
						$dateOfBirth = $user_data->DOB;
					} else {
						$dateOfBirth = date("d M Y", strtotime($user_data->DOB));
					}

					if (isValidDateFormat($user_data->join_date)) {
						$joinDate = $user_data->join_date;
					} else {
						$joinDate = date("d M Y", strtotime($user_data->join_date));
					}

					$tempRow['date_of_birth'] = $dateOfBirth;
					$tempRow['join_date'] = $joinDate;
					$tempRow['desgnation'] = $user_data->desgnation;
					$tempRow['emg_person'] = $user_data->emg_person;
					$tempRow['emg_number'] = $user_data->emg_number;
					$tempRow['address'] = $user_data->address;

					// Assign the updated $tempRow to $this->data['profile_user']
					$this->data['profile_user'] = $tempRow;
				}
			}

			$this->data['profile_user'] = $tempRow;
			$this->data['user_groups'] = $this->ion_auth->get_all_groups();
			$this->load->view('detail', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function ajax_get_user_by_id($id = '')
	{
		$id = !empty($id) ? $id : $this->input->post('id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			$system_user = $this->ion_auth->user($id)->row();
			$where = " WHERE id = $id ";
			$query = $this->db->query("SELECT * FROM users " . $where);
			$results = $query->result_array();
			if (!empty($system_user)) {
				$tempRow['id'] = $system_user->id;
				$tempRow['profile'] = $system_user->profile;
				$tempRow['first_name'] = $system_user->first_name;
				$tempRow['last_name'] = $system_user->last_name;
				$tempRow['father_name'] = $system_user->father_name;
				$tempRow['company'] = company_details('company_name', $system_user->id);
				$tempRow['short_name'] = mb_substr($system_user->first_name, 0, 1, "utf-8") . '' . mb_substr($system_user->last_name, 0, 1, "utf-8");
				$tempRow['phone'] = $system_user->phone;
				$tempRow['active'] = $system_user->active;
				$tempRow['cnic'] = $results[0]['cnic'];
				$tempRow['gender'] = $results[0]['gender'];
				$tempRow['desgnation'] = $results[0]['desgnation'];
				$tempRow['department'] = $results[0]['department'];
				$tempRow['emg_person'] = $results[0]['emg_person'];
				$tempRow['emg_number'] = $results[0]['emg_number'];
				$tempRow['device_id'] = $results[0]['device_id'];
				$tempRow['DOB'] = $results[0]['DOB'];
				$tempRow['email'] = $results[0]['email'];
				$tempRow['join_date'] = $results[0]['join_date'];
				$tempRow['address'] = $results[0]['address'];
				$tempRow['type'] = $results[0]['shift_id'];
				$tempRow['employee_id'] = $results[0]['employee_id'];
				$current_plan = get_current_plan($system_user->saas_id);
				if ($current_plan) {
					$tempRow['current_plan_expiry'] = format_date($current_plan['end_date'], system_date_format());
					$tempRow['current_plan_id'] = $current_plan['plan_id'];
				}
				$group = $this->ion_auth->get_users_groups($system_user->id)->result();
				$tempRow['role'] = ucfirst($group[0]->name);
				$tempRow['group_id'] = $group[0]->id;
				$this->data['error'] = false;
				$this->data['data'] = $tempRow;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			} else {
				$this->data['error'] = true;
				$this->data['message'] = 'No user found.';
				echo json_encode($this->data);
			}
		} else {
			$this->data['error'] = true;
			$this->data['message'] = 'Access Denied';
			echo json_encode($this->data);
		}
	}

	public function get_active_inactive()
	{
		$system_user_ids = [];
		$system_users = [];

		if ($this->ion_auth->is_admin()) {
			$system_user = $this->ion_auth->users()->result();

			foreach ($system_user as $user) {
				$system_user_ids[] = $user->id;
			}
		} elseif (is_assign_users()) {
			$selected = selected_users();
			$selected[] = $this->session->userdata('user_id');
			$users = [];

			foreach ($selected as $user_id) {
				$users[] = $this->ion_auth->user($user_id)->row();
				$system_user_ids[] = $user_id;
			}
		}

		$status = $this->input->get('status');
		$department = $this->input->get('department');
		$shift = $this->input->get('shift');

		if (!empty($system_user_ids)) {
			if ($status == '1') {
				$this->db->where('active', 1);
			}
			if ($status == '0') {
				$this->db->where('active', 0);
			}
			if (isset($department) && !empty($department)) {
				$this->db->where('department', $department);
			}
			if (isset($shift) && !empty($shift)) {
				$this->db->where('shift_id', $shift);
			}
			$this->db->where_in('id', $system_user_ids);
			$query = $this->db->get('users');
			$system_users = $query->result();
		}

		$rows = [];
		$serial_no = 1;
		foreach ($system_users as $system_user) {
			if ($this->session->userdata('saas_id') == $system_user->saas_id) {
				$tempRow['employee_id'] = '<a  href="' . base_url('users/detail/' . $system_user->id) . '">' . $system_user->employee_id . '</a>';
				$tempRow['id'] = $system_user->id;
				$tempRow['email'] = $system_user->email;
				if ($system_user->active == 1) {
					$tempRow['status'] = '<span class="text-success">Active</span>';
				} else {
					$tempRow['status'] = '<span class="text-danger">Inactive</span>';
				}
				$user_id = $tempRow['id'];
				$tempRow['first_name'] = $system_user->first_name;
				$tempRow['last_name'] = $system_user->last_name;
				$tempRow['name'] = '<a href="' . base_url('users/edit_user/' . $system_user->id) . '">' . $system_user->first_name . ' ' . $system_user->last_name . '</a>';
				$tempRow['father_name'] = $system_user->father_name;
				$tempRow['cnic'] = $system_user->cnic;
				$tempRow['gender'] = $system_user->gender;
				$tempRow['joining_date'] = $system_user->join_date;
				$tempRow['s_no'] = $serial_no;
				$tempRow['desgnation'] = $system_user->desgnation;
				$tempRow['action'] = '<span class="badge light badge-primary"><a href="' . base_url('users/edit_user/' . $tempRow['id'] . '') . '" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>';
				$tempRow['company'] = company_details('company_name', $system_user->user_id);
				$tempRow['mobile'] = $system_user->phone != 0 ? $system_user->phone : '';
				$department = $system_user->department != 0 ? $system_user->department : '';
				if ($department === '0' || empty($department)) {
					$tempRow['department'] = '<span class="text-danger">No Shift Assigned</span>';
				} else {
					$department_query = $this->db->query("SELECT * FROM departments WHERE id = $department");
					$department_result = $department_query->row_array();
					$tempRow['department'] = $department_result['department_name'];
				}

				$shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
				$shift_result = $shift_query->row_array();
				$shift_id = $shift_result['shift_id'];

				if ($shift_id === '0') {
					$tempRow['shift_type'] = '<span class="text-danger">No Shift Assigned</span>';
				} else {
					$shift_query = $this->db->query("SELECT * FROM shift WHERE id = $shift_id");
					$shift_result = $shift_query->row_array();
					$tempRow['shift_type'] = $shift_result['name'];
				}


				$tempRow['profile'] = '';
				if ($system_user->profile) {
					if (file_exists('assets/uploads/profiles/' . $system_user->profile)) {
						$file_upload_path = 'assets/uploads/profiles/' . $system_user->profile;
					} else {
						$file_upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/' . $system_user->profile;
					}
					$tempRow['profile'] = base_url($file_upload_path);
				}

				$group = $this->ion_auth->get_users_groups($user_id)->result();
				$tempRow['role'] = $group[0]->description;
				$tempRow['group_id'] = $group[0]->id;
				$tempRow['projects_count'] = '<span class="badge badge-secondary">' . get_count('id', 'project_users', 'user_id=' . $user_id) . '</span>';
				$tempRow['tasks_count'] = '<span class="badge badge-secondary">' . get_count('id', 'task_users', 'user_id=' . $user_id) . '</span>';
				if ($group[0]->name != 'client') {
					$rows[] = $tempRow;
					$serial_no++;
				}
			}
		}
		echo json_encode($rows);
	}

	public function get_employee_id()
	{
		$report = $this->users_model->get_employee_id();
		echo json_encode($report);
	}
}
