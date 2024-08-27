<?php defined('BASEPATH') or exit('No direct script access allowed');
class Attendance extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
		// Load the library
	}
	/**
	 * Display the Attendance page for the current user.
	 * 
	 * This function checks if the user is logged in and has the necessary permissions 
	 * to view the Attendance page. It retrieves the relevant shifts and departments 
	 * data based on the user's `saas_id`, prepares the page title and main page 
	 * details, and then loads the Attendance view with the data.
	 * 
	 * - Only users with the appropriate permissions can view this page.
	 * - Admins can view all system users, while non-admin users will see assigned users.
	 * - Redirects to the index page if the user does not have access.
	 *
	 * @return void
	 */
	public function index()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4) && is_module_allowed('attendance') && ($this->ion_auth->is_admin() || permissions('attendance_view_all') || permissions('attendance_view'))) {
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query4 = $this->db->get('shift');
			$this->data['shifts'] = $query4->result_array();
			$this->db->where('saas_id', $saas_id);
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$this->data['page_title'] = 'Attendance - ' . company_name();
			$this->data['main_page'] = 'Attendance';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			if ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}
			$this->load->view('pages/attendance/attendance', $this->data);
		} else {
			redirect_to_index();
		}
	}

	/**
	 * Retrieve attendance data for the logged-in user.
	 * 
	 * This function checks if the user is logged in and meets specific criteria:
	 * - The user is not a SaaS admin.
	 * - The user is not in group 4.
	 * 
	 * If the conditions are met, it retrieves attendance data from the `attendance_model`.
	 * Otherwise, it returns an empty string.
	 * 
	 * @return mixed The attendance data retrieved from the model, or an empty string if access is denied.
	 */
	public function get_attendance()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			return $this->attendance_model->get_attendance();
		} else {
			return '';
		}
	}
	/**
	 * Retrieve users based on their active/inactive status.
	 * 
	 * This function checks if the user is logged in and has the necessary permissions. 
	 * If so, it retrieves a list of users filtered by their status (active or inactive) 
	 * and returns this data as a JSON response.
	 * 
	 * - Accessible only to authorized users who are not SaaS admins or part of group 4.
	 * - The status is passed through a POST request.
	 * 
	 * @return void
	 */
	public function get_users_by_status()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$activeInactive = $this->input->post('status');
			$users = $this->attendance_model->get_users_by_status($activeInactive);
			echo json_encode($users);
		} else {
			return '';
		}
	}
	/**
	 * Retrieve users based on their department.
	 * 
	 * This function checks if the user is logged in and has the necessary permissions. 
	 * If so, it retrieves a list of users filtered by their department and returns this 
	 * data as a JSON response.
	 * 
	 * - Accessible only to authorized users who are not SaaS admins or part of group 4.
	 * - The department is passed through a POST request.
	 * 
	 * @return void
	 */
	public function get_users_by_department()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$department = $this->input->post('department');
			$users = $this->attendance_model->get_users_by_department($department);

			echo json_encode($users);
		} else {
			return '';
		}
	}
	/**
	 * Retrieve users based on their assigned shift.
	 * 
	 * This function checks if the user is logged in and has the necessary permissions. 
	 * If so, it retrieves a list of users filtered by their shift ID and returns this 
	 * data as a JSON response.
	 * 
	 * - Accessible only to authorized users who are not SaaS admins or part of group 4.
	 * - The shift ID is passed through a POST request.
	 * 
	 * @return void
	 */
	public function get_users_by_shifts()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$shift_id = $this->input->post('shift_id');
			$users = $this->attendance_model->get_users_by_shifts($shift_id);
			echo json_encode($users);
		} else {
			return '';
		}
	}
	/**
	 * Establish a connection using the Attendance model.
	 * 
	 * This function serves as a proxy to establish a connection by invoking the `connect` 
	 * method of the `attendance_model`. It abstracts the connection process, making it 
	 * accessible through the current class.
	 * 
	 * @return mixed The result of the `connect` method from the `attendance_model`.
	 */
	public function connect()
	{
		return $this->attendance_model->connect();
	}

	/**
	 * Retrieve the attendance report for the logged-in user.
	 * 
	 * This function verifies if the user is authenticated and has the necessary permissions:
	 * - The user is logged in.
	 * - The user is not a SaaS admin.
	 * - The user does not belong to group 4.
	 * 
	 * If these conditions are satisfied, it fetches the user's attendance report 
	 * from the `attendance_model` and returns it. If the user does not meet the 
	 * criteria, an empty string is returned.
	 * 
	 * @return mixed The user's attendance report from the model, or an empty string if access is denied.
	 */
	public function get_user_attendance()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$attendanceReport = $this->attendance_model->get_user_attendance();
			return $attendanceReport;
		} else {
			return '';
		}
	}
	/**
	 * Display the attendance page for a specific user.
	 * 
	 * This function checks if the user is authenticated and has the necessary permissions:
	 * - The user is logged in.
	 * - The user is not a SaaS admin.
	 * - The user is not part of group 4.
	 * 
	 * The function fetches the employee ID from the URI and verifies if the logged-in user is an admin 
	 * or has assigned users. If so, it retrieves the user's data based on the employee ID and sets 
	 * the user's name in the view data. If not, it uses the logged-in user's data.
	 * 
	 * The function then prepares additional data, including the page title, the current user, 
	 * and a list of system users, before loading the attendance view.
	 * 
	 * If the user does not meet the criteria, they are redirected to the index page.
	 * 
	 * @return void
	 */
	public function user_attendance()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$employee_id = $this->uri->segment($this->uri->total_segments());
			if ($this->ion_auth->is_admin() || is_assign_users()) {
				$user_data = $this->ion_auth->user($employee_id)->row();
				$user_query = $this->db->get_where('users', ['employee_id' => $employee_id]);
				$user_data = $user_query->row();
				if ($user_data) {
					$this->data['name'] = $user_data->first_name . ' ' . $user_data->last_name;
				}
			} else {
				$user_data = $this->ion_auth->user()->row();
				$this->data['name'] = $user_data->first_name . ' ' . $user_data->last_name;
			}
			$this->data['page_title'] = 'Attendance - ' . company_name();
			$this->data['main_page'] = 'Attendance';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['system_users'] = $this->ion_auth->users([1, 2])->result();
			$this->load->view('pages/attendance/user-attendance', $this->data);
		} else {
			redirect_to_index();
		}
	}

	/**
	 * Retrieve and format attendance data for a single user.
	 * 
	 * This function first checks if the user is logged in and has the necessary permissions:
	 * - The user is logged in.
	 * - The user is not a SaaS admin.
	 * - The user is not part of group 4.
	 * 
	 * If the conditions are met, it retrieves the user ID, start date, and end date from the POST data.
	 * It then fetches attendance data for the specified user and date range using the `att_model`'s 
	 * `get_attendance` method. The attendance data is formatted using the `attendance_model`'s 
	 * `format_single_user_attendance` method. The formatted data is then returned as a JSON response.
	 * 
	 * If the user does not meet the criteria, an empty string is returned.
	 * 
	 * @return string|void JSON encoded formatted attendance data or an empty string if access is denied.
	 */
	public function get_single_user_attendance()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$user_id = $this->input->post('user_id');
			if (empty($user_id)) {
				$user = $this->ion_auth->user()->row();
				$user_id = $user->employee_id;
			}
			$from = $this->input->post('from');
			$too = $this->input->post('too');
			$attendance = $this->att_model->get_attendance($user_id, $from, $too);
			$formatted_data = $this->attendance_model->format_single_user_attendance($attendance, $this->input->post());
			echo json_encode($formatted_data);
		} else {
			return '';
		}
	}

	
	public function get_leaves()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$user_id = $this->input->post('user_id');
			$from = $this->input->post('from');
			$too = $this->input->post('too');
			if ($this->ion_auth->is_admin()) {
				$result = [
					'user_id' => $user_id,
					'from' => $from,
				];
			} else {
				$result = [
					'from' => $from,
					'too' => $too
				];
			}

			$attendanceReport = $this->attendance_model->get_leaves($result);

			echo json_encode($attendanceReport);
		} else {
			return '';
		}
	}


	public function get_attendance_report()
	{
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4)) {
			$user_id = $this->input->post('user_id');
			$filter = $this->input->post('filter');
			$from = $this->input->post('from');
			$too = $this->input->post('too');
			$limit = $this->input->post('limit');
			$offset = $this->input->post('offset');
			$search = $this->input->post('search');
			$departments = $this->input->post('departments');
			$active_users = $this->input->post('active_users');
			$result = [
				'user_id' => $user_id,
				'filter' => $filter,
				'from' => $from,
				'too' => $too,
				'search' => $search,
				'limit' => $limit,
				'offset' => $offset,
				'departments' => $departments,
				'active_users' => $active_users,
			];
			$attendanceReport = $this->attendance_model->get_attendance_report($result);

			echo json_encode($attendanceReport);
		} else {
			return '';
		}
	}


	// user attendance page


	public function get_active_inactive_users()
	{
		$user = $this->input->get('value');
		$where = "";

		if ($user == 1) {
			$query = $this->db->query("SELECT * FROM users WHERE active ='1' AND finger_config = '1'" . $where);
		} elseif ($user == 2) {
			$query = $this->db->query("SELECT * FROM users WHERE active ='0'  AND finger_config = '1'" . $where);
		}
		$results = $query->result_array();
		echo json_encode($results);
	}

	public function get_user_checkin_time()
	{
		$user_id = $this->input->post('user_id');
		$currentDate = date('Y-m-d');
		$dateRanges = [];

		for ($i = 0; $i < 4; $i++) {
			$dateRanges[] = date("Y-m-d", strtotime("-{$i} day"));
		}

		$queryResults = [];

		foreach ($dateRanges as $dateRange) {
			$query = $this->db->query(
				"SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user
					FROM attendance
					LEFT JOIN users ON users.employee_id = attendance.user_id
					WHERE users.id = ? AND DATE(attendance.finger) BETWEEN ? AND ? AND finger_config = '1'",
				[$user_id, $dateRange, $dateRange]
			);
			$queryResults[] = $query->result_array();
		}

		$remind = 1;
		$user = '';

		foreach ($queryResults as $result) {
			if (count($result) == 1) {
				$user = $result[0]["user"];
				$remind = 0;
				break;
			}
		}

		$array3 = [
			'user' => $queryResults[0][0]["user"],
			'time' => date("h:i A", strtotime($queryResults[0][0]["finger"])),
			'remind' => $remind
		];
		echo json_encode($array3);
	}
	public function get_home_attendance_for_admin($date)
	{

		$get = [
			"from" => $date,
			"too" => $date
		];
		// $get_data = $this->attendance_model->get_attendance_for_admin($get);
		// $format = $this->attendance_model->formated_data($get_data,$get);
		return $get;
	}

	public function offclock()
	{
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		if ($this->ion_auth->logged_in() && !is_saas_admin() && !$this->ion_auth->in_group(4) && is_module_allowed('attendance') && ($this->ion_auth->is_admin() || is_assign_users())) {
			$this->data['page_title'] = 'Off Clock - ' . company_name();
			$this->data['main_page'] = 'Off Clock';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			if ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}

			if (!empty($this->data['system_users'])) {
				$user_ids = array_map(function ($user) {
					return $user->employee_id;
				}, $this->data['system_users']);
				$this->db->select('offclock.*, CONCAT(users.first_name, " ", users.last_name) as full_name');
				$this->db->from('offclock');
				$this->db->join('users', 'users.employee_id = offclock.user_id');
				$this->db->where_in('user_id', $user_ids);
				$query = $this->db->get();
				$result = $query->result();
				$this->data["offclock"] = $result;
				$this->load->view('pages/attendance/offclock', $this->data);
			} else {
				$this->data["offclock"] = [];
				$this->load->view('pages/attendance/offclock', $this->data);
			}
		} else {
			redirect_to_index();
		}
	}
	public function create_offclock()
	{
		if ($this->ion_auth->logged_in()) {
			$this->form_validation->set_rules('date', 'Date', 'trim|required|strip_tags|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$user_ids = $this->input->post('users');
				$insert_data = [];

				foreach ($user_ids as $user_id) {
					$data = array(
						'user_id' => $user_id,
						'date' => format_date($this->input->post('date'), "Y-m-d"),
						'saas_id' => $this->session->userdata("saas_id")
					);
					$insert_data[] = $data;
				}

				if (!empty($insert_data)) {
					$this->db->insert_batch('offclock', $insert_data);
				}
				$this->data['insert_data'] = $insert_data;
				$this->data['error'] = false;
				$this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
				$this->session->set_flashdata('message_type', 'success');
				$this->data['message'] = $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.";
				echo json_encode($this->data);
			} else {
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data);
			}
		} else {
			$this->data['error'] = true;
			$this->session->set_flashdata('message', $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "access_denied.");
			$this->session->set_flashdata('message_type', 'error');
			$this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
			echo json_encode($this->data);
		}
	}
	public function get_offclock_by_id()
	{
		if ($this->ion_auth->logged_in()) {
			$this->form_validation->set_rules('id', 'id', 'trim|required|strip_tags|xss_clean|is_numeric');

			if ($this->form_validation->run() == TRUE) {
				$id = $this->input->post('id');
				$this->db->select('*');
				$this->db->from('offclock');
				$this->db->where('id', $id);
				$query = $this->db->get();
				$result = $query->result();
				$this->data['data'] = $result;
				$this->data['error'] = false;
				echo json_encode($this->data);
			} else {
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
				echo json_encode($this->data);
			}
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
			echo json_encode($this->data);
		}
	}

	public function edit_offclock()
	{

		if ($this->ion_auth->logged_in()) {
			$this->form_validation->set_rules('update_id', 'ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			$this->form_validation->set_rules('date', 'Date', 'trim|required|strip_tags|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$data["user_id"] = $this->input->post('users');
				$data["date"] = format_date($this->input->post('date'), "Y-m-d");
				if ($this->attendance_model->edit_offclock($this->input->post('update_id'), $data)) {
					$this->data['error'] = false;
					$this->data['data'] = $data;
					$this->session->set_flashdata('message', $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.");
					$this->session->set_flashdata('message_type', 'success');
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

	public function delete_offclock($id = '')
	{ {
			if ($this->ion_auth->logged_in()) {
				if (empty($id)) {
					$id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
				}

				if (!empty($id) && $this->attendance_model->delete_offclock($id)) {
					$this->session->set_flashdata('message', $this->lang->line('deleted_successfully') ? $this->lang->line('deleted_successfully') : "Deleted successfully.");
					$this->session->set_flashdata('message_type', 'success');
					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('deleted_successfully') ? $this->lang->line('deleted_successfully') : "Deleted successfully.";
					echo json_encode($this->data);
				} else {
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
					echo json_encode($this->data);
				}
			} else {
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
				echo json_encode($this->data);
			}
		}
	}




































	public function get_filters_for_user()
	{
		if (!empty($this->input->get('employee_id'))) {
			$employee_id = $this->input->get('employee_id');
			$user = $this->ion_auth->user($employee_id)->row();
			$shift_id = $user->shift_id;
			$department_id = $user->department;
			$this->db->select('*');
			$this->db->from('shift');
			$this->db->where('id', $shift_id);
			$query = $this->db->get();
			$shift_info = $query->row();

			$this->db->select('*');
			$this->db->from('departments');
			$this->db->where('id', $department_id);
			$query2 = $this->db->get();
			$department_info = $query2->row();
			$array = [
				'shift' => [$shift_info],
				'department' => [$department_info]
			];
		} else {
			$user = $this->ion_auth->user()->row();
			$saas_id = $user->saas_id;
			$this->db->select('*');
			$this->db->from('shift');
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get();
			$shifts = $query->result();
			$this->db->select('*');
			$this->db->from('departments');
			$this->db->where('saas_id', $saas_id);
			$query2 = $this->db->get();
			$departments = $query2->result();
			$array = [
				'shift' => $shifts,
				'department' => $departments
			];
		}
		echo json_encode($array);
	}
}
