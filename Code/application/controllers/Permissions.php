<?php defined('BASEPATH') or exit('No direct script access allowed');

class Permissions extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || is_module_allowed('user_permissions'))) {
			$this->data['page_title'] = 'Settings - ' . company_name();
			$this->data['main_page2'] = 'roles';
			$this->data['main_page'] = 'Roles';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['system_users'] = $this->ion_auth->members()->result();
			$this->data['departments'] = $this->department_model->saas_department();
			$this->data['shifts'] = $this->shift_model->saas_shifts();
			$this->data['permissions'] = permissions();
			$query = $this->db->get('permissions_list');
			$groups = $this->ion_auth->get_all_groups();
			$groups = array_filter($groups, function ($group) {
				return !in_array($group->name, ['admin', 'saas_admin', 'clients']);
			});
			$this->data['groups'] = $groups;
			$this->data['permissions_list'] = $query->result_array();
			$this->data['clients_permissions'] = clients_permissions();
			$this->load->view('setting-forms/roles', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function create()
	{
		if ($this->ion_auth->logged_in() && !$this->ion_auth->in_group(3) && !$this->ion_auth->in_group(4)) {
			$this->form_validation->set_rules('description', 'Name', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('descriptive_name', 'Description', 'trim|strip_tags|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$users = $this->input->post('users');
				$users = json_encode($users);

				$data_json = [
					'attendance_view' => $this->input->post('attendance_view') ? '1' : '0',
					'leaves_view' => $this->input->post('leaves_view') ? '1' : '0',
					'leaves_create' => $this->input->post('leaves_create') ? '1' : '0',
					'leaves_edit' => $this->input->post('leaves_edit') ? '1' : '0',
					'leaves_delete' => $this->input->post('leaves_delete') ? '1' : '0',
					'leaves_status' => $this->input->post('leaves_status') ? '1' : '0',
					'leave_type_view' => $this->input->post('leave_type_view') ? '1' : '0',
					'leave_type_create' => $this->input->post('leave_type_create') ? '1' : '0',
					'leave_type_edit' => $this->input->post('leave_type_edit') ? '1' : '0',
					'leave_type_delete' => $this->input->post('leave_type_delete') ? '1' : '0',
					'shift_view' => $this->input->post('shift_view') ? '1' : '0',
					'shift_create' => $this->input->post('shift_create') ? '1' : '0',
					'shift_edit' => $this->input->post('shift_edit') ? '1' : '0',
					'shift_delete' => $this->input->post('shift_delete') ? '1' : '0',
					'biometric_request_view' => $this->input->post('biometric_request_view') ? '1' : '0',
					'biometric_request_create' => $this->input->post('biometric_request_create') ? '1' : '0',
					'biometric_request_edit' => $this->input->post('biometric_request_edit') ? '1' : '0',
					'biometric_request_delete' => $this->input->post('biometric_request_delete') ? '1' : '0',
					'biometric_request_status' => $this->input->post('biometric_request_status') ? '1' : '0',
					'project_view' => $this->input->post('project_view') ? '1' : '0',
					'project_create' => $this->input->post('project_create') ? '1' : '0',
					'project_edit' => $this->input->post('project_edit') ? '1' : '0',
					'project_delete' => $this->input->post('project_delete') ? '1' : '0',
					'task_view' => $this->input->post('task_view') ? '1' : '0',
					'task_create' => $this->input->post('task_create') ? '1' : '0',
					'task_edit' => $this->input->post('task_edit') ? '1' : '0',
					'task_delete' => $this->input->post('task_delete') ? '1' : '0',
					'task_status' => $this->input->post('task_status') ? '1' : '0',
					'user_view' => $this->input->post('user_view') ? '1' : '0',
					'user_create' => $this->input->post('user_create') ? '1' : '0',
					'user_edit' => $this->input->post('user_edit') ? '1' : '0',
					'user_delete' => $this->input->post('user_delete') ? '1' : '0',
					'departments_view' => $this->input->post('departments_view') ? '1' : '0',
					'departments_create' => $this->input->post('departments_create') ? '1' : '0',
					'departments_edit' => $this->input->post('departments_edit') ? '1' : '0',
					'departments_delete' => $this->input->post('departments_delete') ? '1' : '0',
					'plan_holiday_view' => $this->input->post('plan_holiday_view') ? '1' : '0',
					'plan_holiday_create' => $this->input->post('plan_holiday_create') ? '1' : '0',
					'plan_holiday_edit' => $this->input->post('plan_holiday_edit') ? '1' : '0',
					'plan_holiday_delete' => $this->input->post('plan_holiday_delete') ? '1' : '0',
					'notes_view' => $this->input->post('notes_view') ? '1' : '0',
					'todo_view' => $this->input->post('todo_view') ? '1' : '0',
					'chat_view' => $this->input->post('chat_view') ? '1' : '0',
					'chat_delete' => $this->input->post('chat_delete') ? '1' : '0',
					'client_view' => $this->input->post('client_view') ? '1' : '0',
					'client_create' => $this->input->post('client_create') ? '1' : '0',
					'client_edit' => $this->input->post('client_edit') ? '1' : '0',
					'client_delete' => $this->input->post('client_delete') ? '1' : '0',
					'team_members_and_client_can_chat' => $this->input->post('team_members_and_client_can_chat') ? '1' : '0',
				];
				$data = array(
					'saas_id' => $this->session->userdata('saas_id'),
					'name' => str_replace(' ', '_', strtolower($this->input->post('description'))),
					'description' => $this->input->post('description'),
					'descriptive_name' => $this->input->post('descriptive_name'),
					'permissions' => json_encode($data_json),
					'assigned_users' => $users,
				);
				$id = $this->settings_model->roles_create($data);
				if ($id) {
					$this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.";
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
	public function edit()
	{
		if ($this->ion_auth->logged_in() && !$this->ion_auth->in_group(3) && !$this->ion_auth->in_group(4)) {
			$this->form_validation->set_rules('update_id', 'Id', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('description', 'Name', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('descriptive_name', 'Description', 'trim|strip_tags|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$id = $this->input->post('update_id');
				$users = $this->input->post('users');
				$users = json_encode($users);

				$data_json = [
					'attendance_view' => $this->input->post('attendance_view') ? '1' : '0',
					'leaves_view' => $this->input->post('leaves_view') ? '1' : '0',
					'leaves_create' => $this->input->post('leaves_create') ? '1' : '0',
					'leaves_edit' => $this->input->post('leaves_edit') ? '1' : '0',
					'leaves_delete' => $this->input->post('leaves_delete') ? '1' : '0',
					'leaves_status' => $this->input->post('leaves_status') ? '1' : '0',
					'leave_type_view' => $this->input->post('leave_type_view') ? '1' : '0',
					'leave_type_create' => $this->input->post('leave_type_create') ? '1' : '0',
					'leave_type_edit' => $this->input->post('leave_type_edit') ? '1' : '0',
					'leave_type_delete' => $this->input->post('leave_type_delete') ? '1' : '0',
					'shift_view' => $this->input->post('shift_view') ? '1' : '0',
					'shift_create' => $this->input->post('shift_create') ? '1' : '0',
					'shift_edit' => $this->input->post('shift_edit') ? '1' : '0',
					'shift_delete' => $this->input->post('shift_delete') ? '1' : '0',
					'biometric_request_view' => $this->input->post('biometric_request_view') ? '1' : '0',
					'biometric_request_create' => $this->input->post('biometric_request_create') ? '1' : '0',
					'biometric_request_edit' => $this->input->post('biometric_request_edit') ? '1' : '0',
					'biometric_request_delete' => $this->input->post('biometric_request_delete') ? '1' : '0',
					'biometric_request_status' => $this->input->post('biometric_request_status') ? '1' : '0',
					'project_view' => $this->input->post('project_view') ? '1' : '0',
					'project_create' => $this->input->post('project_create') ? '1' : '0',
					'project_edit' => $this->input->post('project_edit') ? '1' : '0',
					'project_delete' => $this->input->post('project_delete') ? '1' : '0',
					'task_view' => $this->input->post('task_view') ? '1' : '0',
					'task_create' => $this->input->post('task_create') ? '1' : '0',
					'task_edit' => $this->input->post('task_edit') ? '1' : '0',
					'task_delete' => $this->input->post('task_delete') ? '1' : '0',
					'task_status' => $this->input->post('task_status') ? '1' : '0',
					'user_view' => $this->input->post('user_view') ? '1' : '0',
					'user_create' => $this->input->post('user_create') ? '1' : '0',
					'user_edit' => $this->input->post('user_edit') ? '1' : '0',
					'user_delete' => $this->input->post('user_delete') ? '1' : '0',
					'departments_view' => $this->input->post('departments_view') ? '1' : '0',
					'departments_create' => $this->input->post('departments_create') ? '1' : '0',
					'departments_edit' => $this->input->post('departments_edit') ? '1' : '0',
					'departments_delete' => $this->input->post('departments_delete') ? '1' : '0',
					'plan_holiday_view' => $this->input->post('plan_holiday_view') ? '1' : '0',
					'plan_holiday_create' => $this->input->post('plan_holiday_create') ? '1' : '0',
					'plan_holiday_edit' => $this->input->post('plan_holiday_edit') ? '1' : '0',
					'plan_holiday_delete' => $this->input->post('plan_holiday_delete') ? '1' : '0',
					'notes_view' => $this->input->post('notes_view') ? '1' : '0',
					'todo_view' => $this->input->post('todo_view') ? '1' : '0',
					'chat_view' => $this->input->post('chat_view') ? '1' : '0',
					'chat_delete' => $this->input->post('chat_delete') ? '1' : '0',
					'client_view' => $this->input->post('client_view') ? '1' : '0',
					'client_create' => $this->input->post('client_create') ? '1' : '0',
					'client_edit' => $this->input->post('client_edit') ? '1' : '0',
					'client_delete' => $this->input->post('client_delete') ? '1' : '0',
					'team_members_and_client_can_chat' => $this->input->post('team_members_and_client_can_chat') ? '1' : '0',
				];
				$data = array(
					'saas_id' => $this->session->userdata('saas_id'),
					'name' => str_replace(' ', '_', strtolower($this->input->post('description'))),
					'description' => $this->input->post('description'),
					'descriptive_name' => $this->input->post('descriptive_name'),
					'permissions' => json_encode($data_json),
					'assigned_users' => $users,
				);

				if ($this->settings_model->roles_edit($id, $data)) {
					$this->session->set_flashdata('message', $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.";
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
	public function get_roles_by_id()
	{
		if ($this->ion_auth->logged_in() && !$this->ion_auth->in_group(3) && !$this->ion_auth->in_group(4)) {
			$this->form_validation->set_rules('id', 'id', 'trim|required|strip_tags|xss_clean|is_numeric');

			if ($this->form_validation->run() == TRUE) {
				$data = $this->settings_model->get_roles_by_id($this->input->post('id'));
				$this->data['error'] = false;
				$this->data['data'] = $data ? $data : '';
				$this->data['message'] = "Success";
				echo json_encode($this->data);
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
