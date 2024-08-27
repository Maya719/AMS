<?php defined('BASEPATH') or exit('No direct script access allowed');

class Leaves extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Retrieve and return the leave balance for a specific user.
	 *
	 * This function checks if the current user is logged in and has the appropriate permissions 
	 * (either belongs to group 1 or has 'leaves_view' permission). If the user has the necessary
	 * permissions, the function retrieves the leave balance for the specified user ID and returns
	 * it as a JSON response.
	 * 
	 * @return void|string Outputs the leave balance as a JSON-encoded array if the user has permission.
	 *                     Returns an empty string if the user does not have the necessary permissions.
	 */

	public function get_leaves_balance()
	{
		$from = date('Y-01-01');
		$too = date('Y-m-d');
		$late_min = 0;
		$absents = 0;
		$leave_types = $this->att_model->get_db_leave_types();
		$user_id = $this->input->post('user_id');
		$user = $this->ion_auth->user($user_id)->row();
		$leave_summary = [];
		foreach ($leave_types as $leave_type) {
			$paid_leaves = 0;
			$unpaid_leaves = 0;
			$total = 0;
			if ($user->finger_config == 1) {
				$leaves = $this->att_model->get_db_leaves($user->employee_id, $from, $too, $leave_type->id);
				foreach ($leaves as $leave) {
					$leaveDuration = (new DateTime($leave->ending_date))->diff(new DateTime($leave->starting_date))->days + 1;

					if (strpos($leave->leave_duration, 'Full') !== false) {
						if ($leave->paid == 0) {
							$paid_leaves += $leaveDuration;
						} else {
							$unpaid_leaves += $leaveDuration;
						}
					} elseif (strpos($leave->leave_duration, 'Half') !== false) {
						if ($leave->paid == 0) {
							$paid_leaves += 0.5;
						} else {
							$unpaid_leaves += 0.5;
						}
					}
				}
				$total = $this->att_model->get_total_of_leave_type_for_user($leave_type, $user, $too);
			}

			$leave_summary[] = [
				'leave_type_name' => $leave_type->name,
				'total_leaves' => $total,
				'paid_leaves' => $paid_leaves,
				'unpaid_leaves' => $unpaid_leaves,
			];
		}
		if ($user->finger_config == 1) {
			$emp = get_employee_id_from_user_id($user_id);
			$late_min = $this->att_model->get_late_min($emp, $from, $too);
			$absents = $this->att_model->get_absents($emp, $from, $too);
		}

		$response = [
			'leave_summary' => $leave_summary,
			'absents' => $absents,
			'late_min' => $late_min,
		];
		echo json_encode($response);
	}

	/**
	 * Displays the leaves application page.
	 * 
	 * This function performs the following checks and actions:
	 * 1. Verifies if the user is logged in, the 'leaves' module is allowed, 
	 *    and the user has the necessary permissions (either is an admin or has 'leaves_view' permission).
	 * 2. Sets the page title and main page label.
	 * 3. Retrieves the current user's details.
	 * 4. Determines which users to list based on the user's role:
	 *    - If the user is an admin, retrieves all system users.
	 *    - If the user is assigned specific users, retrieves and filters these users to avoid duplicates.
	 * 5. Fetches leave types based on the current SaaS ID and stores them in the data array.
	 * 6. Loads the 'leaves' view with the populated data.
	 * 
	 * If the user does not have the required permissions or is not logged in,
	 * the function redirects to the index page.
	 * 
	 * @return void
	 */
	public function index()
	{
		if ($this->ion_auth->logged_in()  && is_module_allowed('leaves') && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->data['page_title'] = 'Leaves - ' . company_name();
			$this->data['main_page'] = 'Leaves Application';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			if ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				$user_ids = array_merge($selected, [$this->session->userdata('user_id')]);
				$user_ids = array_unique($user_ids);
				$users = array_map(function ($user_id) {
					return $this->ion_auth->user($user_id)->row();
				}, $user_ids);

				$this->data['system_users'] = $users;
			}
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('leaves_type');
			$this->data['leaves_types'] = $query->result_array();
			$this->load->view('pages/leave/leaves', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function delete($id = '')
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {

			if (empty($id)) {
				$id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
			}

			if (!empty($id) && is_numeric($id) && $this->leaves_model->delete($id)) {
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
	/*........................................................ Not Optomize Functions................................*/



	public function edit()
	{
		if (!$this->ion_auth->logged_in() || !($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->respondWithError($this->lang->line('access_denied') ?: "Access Denied");
			return;
		}

		$this->form_validation->set_rules('update_id', 'Leave ID', 'trim|required|strip_tags|xss_clean|is_numeric');
		$this->form_validation->set_rules('leave_reason', 'Leave Reason', 'trim|required|strip_tags|xss_clean');

		if ($this->form_validation->run() !== TRUE) {
			$this->respondWithError(validation_errors());
			return;
		}
		$incorrectTimesError = $this->incorrectTimesError();
		if ($incorrectTimesError["status"]) {
			$this->respondWithError($incorrectTimesError["message"]);
			return;
		}
		$data = $this->prepareLeaveData();
		$logs = $this->NextLog($data[0]);
		if ($this->leaves_model->edit($this->input->post('update_id'), $data[0])) {
			if ($data[1]) {
				$leave_id = $this->leaves_model->create($data[1]);
				foreach ($logs as $value) {
					$newlog = [
						"leave_id" => $leave_id,
						"group_id" => $value["group_id"],
						"level" => $value["level"],
						"status" => $value["status"],
						"remarks" => $value["remarks"],
					];
					$this->leaves_model->createLog($newlog);
				}
			}
			$this->respondWithSuccess($this->lang->line('updated_successfully') ?: "Updated Successfully.", $incorrectTimesError);
		} else {
			$this->respondWithError($this->lang->line('something_went_wrong') ?: "Something went wrong.");
			return;
		}
	}


	private function incorrectTimesError()
	{

		if ($this->input->post('short_leave')) {
			$startingTime = strtotime($this->input->post('starting_time'));
			$endingTime = strtotime($this->input->post('ending_time'));
			$durationSeconds = $endingTime - $startingTime;
			$durationHours = floor($durationSeconds / 3600);
			$durationMinutes = floor(($durationSeconds % 3600) / 60);
			if (($durationHours < 3) || ($durationHours == 3 && $durationMinutes == 0)) {
				$response = [
					"status" => false,
				];
			} else {
				$response = [
					"status" => true,
					"message" => 'Check Time manually'
				];
			}
		}
		return $response;
	}
	private function get_step_users($step, $leave)
	{
		$users = array();
		$this->db->where('step_no', $step);
		$getCurrentGroupStep = $this->db->get('leave_hierarchy');
		$forwordGroups = $getCurrentGroupStep->result_array();

		foreach ($forwordGroups as $forwordGroup) {
			$group_id = $forwordGroup["group_id"];
			$group_users = $this->ion_auth->users($group_id)->result();
			foreach ($group_users as $user) {
				$users[] = $user;
			}
		}

		$activeUsers = $this->sendNotification($users, $leave);
		return $activeUsers;
	}

	private function sendNotification($users, $leave)
	{
		$template_data = array();
		$leave_user = $this->ion_auth->user(get_user_id_from_employee_id($leave["user_id"]))->row();
		foreach ($users as $user) {
			if ($user->active == '1') {
				$template_data['EMPLOYEE_NAME'] = $leave_user->first_name . ' ' . $leave_user->last_name;
				$template_data['NAME'] = $user->first_name . ' ' . $user->last_name;
				$template_data['LEAVE_TYPE'] = '';
				$querys = $this->db->query("SELECT * FROM leaves_type");
				$leave_types = $querys->result_array();
				if (!empty($leave_types)) {
					foreach ($leave_types as $leave_type) {
						if ($leave["type"] == $leave_type['id']) {
							$template_data['LEAVE_TYPE'] = $leave_type['name'];
						}
					}
				}
				$template_data['STARTING_DATE'] = $leave['starting_date'] . ' ' . $leave['starting_time'];
				$template_data['REASON'] = $this->input->post('leave_reason');
				$template_data['DUE_DATE'] = $leave['ending_date'] . ' ' . $leave['ending_time'];
				$template_data['LEAVE_REQUEST_URL'] = base_url('leaves');
				$email_template = render_email_template('leave_request', $template_data);
				send_mail($user->email, $email_template[0]['subject'], $email_template[0]['message']);
				$notification_data = array(
					'notification' => 'Leave request received',
					'type' => 'leave_request',
					'type_id' => $this->input->post('update_id'),
					'from_id' => $this->input->post('user_id') ? $this->input->post('user_id') : $this->session->userdata('user_id'),
					'to_id' => $user->id,
				);
				$notification_id = $this->notifications_model->create($notification_data);
			}
		}
		return $template_data;
	}

	private function NextLog($leave)
	{
		$roler = $this->session->userdata('user_id');
		$group = $this->ion_auth->get_users_groups($roler)->result();
		$group_id = $group[0]->id;
		$this->db->where('group_id', $group_id);
		$getCurrentGroupStep = $this->db->get('leave_hierarchy');
		$heiCurrentGroupStepResult = $getCurrentGroupStep->row();
		$Step = $heiCurrentGroupStepResult->step_no;
		$log = [
			'leave_id' => $this->input->post('update_id'),
			'group_id' => $group_id,
			'remarks' => $this->input->post('remarks'),
			'status' => $this->input->post('status'),
			'level' => ($this->input->post('status') == 1) ? $Step + 1 : $Step+1,
		];
		$this->leaves_model->createLog($log);
		$this->get_step_users($Step + 1, $leave);
		$this->db->select('*');
		$this->db->from('leave_logs');
		$this->db->where('leave_id', $this->input->post('update_id'));
		$query = $this->db->get();
		return $query->result_array();
	}
	private function getStatus()
	{
		$leave = $this->db->select('level')->where('leave_id', $this->input->post('update_id'))->order_by('level', 'desc')->limit(1)->get('leave_logs')->row();
		$step = $leave->level;
		$highStep = $this->db->select('step_no')->where('saas_id', $this->session->userdata('saas_id'))->order_by('step_no', 'desc')->limit(1)->get('leave_hierarchy')->row()->step_no;
		$appOrRec = $this->db->select('recomender_approver')->where('saas_id', $this->session->userdata('saas_id'))->where('step_no', $step)->limit(1)->get('leave_hierarchy')->row()->recomender_approver;
		return ($highStep == $step || $appOrRec == 'approver') ? $this->input->post('status') : '0';
	}
	private function prepareLeaveData()
	{
		$employeeIdQuery = $this->db->select('employee_id')->get_where('users', array('id' => $this->input->post('user_id') ? $this->input->post('user_id') : $this->session->userdata('user_id')));
		if ($employeeIdQuery->num_rows() > 0) {
			$employeeIdRow = $employeeIdQuery->row();
			$employeeId = $employeeIdRow->employee_id;
		}
		$data = [
			'user_id' => $employeeId,
			'saas_id' => $this->session->userdata('saas_id'),
			'leave_reason' => $this->input->post('leave_reason'),
			'type' => $this->input->post('type'),
			'paid' => $this->input->post('paid'),
			'status' => $this->getStatus(),
			'status_last' => "0",
			'step' => "0",
			'document' => $this->handleFileUpload(),
		];
		$shift = $this->leaveUserShift();
		if ($this->input->post('half_day')) {
			$response = $this->prepairHalfDay($shift);
			$data = array(array_merge($data, $response));
		} elseif ($this->input->post('short_leave')) {
			$response = $this->prepairShort($shift);
			$data = array(array_merge($data, $response));
		} else {
			$data = $this->prepairFullDay($data, $shift);
		}
		return $data;
	}
	private function prepairFullDay($data, $shift)
	{
		if ($this->input->post('paid_days') > 0 && $this->input->post('unpaid_days') > 0) {
			// Set starting and ending times based on shift times
			$data['starting_time'] = date("H:i:s", strtotime($shift["starting_time"]));
			$data['ending_time'] = date("H:i:s", strtotime($shift["ending_time"]));

			// Retrieve form input for paid and unpaid days
			$paid_days = (int) $this->input->post('paid_days');
			$unpaid_days = (int) $this->input->post('unpaid_days');

			// Retrieve form input for starting and ending dates
			$starting_date = date("Y-m-d", strtotime($this->input->post('starting_date')));
			$ending_date = date("Y-m-d", strtotime($this->input->post('ending_date')));
			$data['starting_date'] = $starting_date;
			$data['ending_date'] = $ending_date;

			// Calculate total leave duration in days
			$total_days = (strtotime($ending_date) - strtotime($starting_date)) / (60 * 60 * 24) + 1;
			$data['leave_duration'] = $total_days . " Full Day/s";

			$Leaves = [];

			// Handle no paid or unpaid days
			if ($paid_days < 1 && $unpaid_days < 1) {
				$Leaves[] = $data;
			}

			// Handle paid leave
			if ($paid_days > 0) {
				$paid_leave_days = min($paid_days, $total_days);
				$paid_leave_data = $data;
				$paid_leave_data['paid'] = 0;
				$paid_leave_data['leave_duration'] = $paid_leave_days . " Full Day/s";
				$paid_leave_data['ending_date'] = date('Y-m-d', strtotime($starting_date . " + " . ($paid_leave_days - 1) . " days"));
				$Leaves[] = $paid_leave_data;
				$total_days -= $paid_leave_days;
			}

			// Handle unpaid leave
			if ($unpaid_days > 0 && $total_days > 0) {
				$unpaid_leave_days = min($unpaid_days, $total_days);
				$unpaid_leave_data = $data;
				$unpaid_leave_data['paid'] = 1;
				$unpaid_leave_data['starting_date'] = date('Y-m-d', strtotime($paid_leave_data['ending_date'] . " + 1 day"));
				$unpaid_leave_data['ending_date'] = date('Y-m-d', strtotime($unpaid_leave_data['starting_date'] . " + " . ($unpaid_leave_days - 1) . " days"));
				$unpaid_leave_data['leave_duration'] = $unpaid_leave_days . " Full Day/s";
				$Leaves[] = $unpaid_leave_data;
			}
			return $Leaves;
		} else {
			$data['starting_time'] = date("H:i:s", strtotime($shift["starting_time"]));
			$data['ending_time'] = date("H:i:s", strtotime($shift["ending_time"]));
			$paid_days = (int) $this->input->post('paid_days');
			$unpaid_days = (int) $this->input->post('unpaid_days');
			$starting_date = date("Y-m-d", strtotime($this->input->post('starting_date')));
			$ending_date = date("Y-m-d", strtotime($this->input->post('ending_date')));
			$data['starting_date'] = $starting_date;
			$data['ending_date'] = $ending_date;
			$total_days = (strtotime($ending_date) - strtotime($starting_date)) / (60 * 60 * 24) + 1;
			$data['leave_duration'] = $total_days . " Full Day/s";
			$data = array($data);
		}
		return $data;
	}
	private function prepairShort($shift)
	{
		$data['starting_date'] = date("Y-m-d", strtotime($this->input->post('date')));
		$data['ending_date'] = date("Y-m-d", strtotime($this->input->post('date')));
		$data['starting_time'] = date("H:i:s", strtotime($this->input->post('starting_time')));
		$data['ending_time'] = date("H:i:s", strtotime($this->input->post('ending_time')));
		$startingTime = strtotime($this->input->post('starting_time'));
		$endingTime = strtotime($this->input->post('ending_time'));
		$durationSeconds = $endingTime - $startingTime;
		$durationHours = floor($durationSeconds / 3600);
		$durationMinutes = floor(($durationSeconds % 3600) / 60);
		$data['leave_duration'] = $durationHours . " hrs " . $durationMinutes . " mins " . " Short Leave";

		$startingDate = date("Y-m-d", strtotime($this->input->post('date')));
		$endingDate = date("Y-m-d", strtotime($this->input->post('date')));
		$tempEndingDate = date("Y-m-d", strtotime("+1 day", strtotime($startingDate)));

		if ($startingTime >= strtotime('00:00:00', strtotime($tempEndingDate))) {
			$startingDate = $tempEndingDate;
		}

		if ($endingTime >= strtotime('00:00:00', strtotime($startingDate))) {
			$endingDate = $tempEndingDate;
		}

		if ($startingTime < $endingTime) {
			$startingDate = $tempEndingDate;
			$endingDate = $tempEndingDate;
		}


		if ($endingTime < $startingTime) {
			$startOfDay = strtotime('00:00:00', strtotime($data['starting_date']));
			$durationFirstDay = strtotime('23:59:59', strtotime($data['starting_date'])) - $startingTime;
			$durationSecondDay = $endingTime - $startOfDay;
			$durationSeconds = $durationFirstDay + $durationSecondDay;
		} else {
			$durationSeconds = $endingTime - $startingTime;
		}
		$durationHours = floor($durationSeconds / 3600);
		$durationMinutes = floor(($durationSeconds % 3600) / 60);
		$data['leave_duration'] = $durationHours . " hrs " . $durationMinutes . " mins " . " Short Leave";
		$data['starting_date'] = $startingDate;
		$data['ending_date'] = $endingDate;
		return $data;
	}
	private function prepairHalfDay($shift)
	{
		$half_day_period = $this->input->post('half_day_period');
		$startingTime = $half_day_period === "0" ? $shift["starting_time"] : $shift["break_end"];
		$endingTime = $half_day_period === "0" ? $shift["break_start"] : $shift["ending_time"];
		$half_day_period = $half_day_period === "0" ? "First Time" : "Second Time";
		$data["starting_date"] = format_date($this->input->post('date_half'), "Y-m-d");
		$data["ending_date"] = format_date($this->input->post('date_half'), "Y-m-d");
		$data["starting_time"] = format_date($startingTime, "h:i:s");
		$data["ending_time"] = format_date($endingTime, "h:i:s");
		$data['leave_duration'] = $half_day_period . " Half Day";
		if (strtotime($shift["starting_time"]) > strtotime($shift["ending_time"])) {
			$tempStartingDate = date("Y-m-d", strtotime($this->input->post('date_half')));
			$tempEndingDate = date("Y-m-d", strtotime("+1 day", strtotime($tempStartingDate)));

			if ($half_day_period === "Second Time" && strtotime($startingTime) >= strtotime('00:00:00', strtotime($tempStartingDate))) {
				$startingDate = $tempEndingDate;
			}

			if (strtotime($endingTime) >= strtotime('00:00:00', strtotime($tempStartingDate))) {
				$endingDate = $tempEndingDate;
			}
			$data['starting_date'] = $startingDate;
			$data['ending_date'] = $endingDate;
		}
		return $data;
	}
	private function leaveUserShift()
	{
		$shiftIdQuery = $this->db->select('shift_id')->get_where('users', array('id' => $this->input->post('user_id') ? $this->input->post('user_id') : $this->session->userdata('user_id')));
		$shiftIdRow = $shiftIdQuery->row();
		$shiftId = $shiftIdRow->shift_id;
		$query = $this->db->get_where('shift', array('id' => $shiftId));
		return $query->row_array();
	}
	private function handleFileUpload()
	{
		if ($this->input->post('document') && !empty($_FILES['documents']['name'])) {
			if (file_exists('assets/uploads/leaves/' . $this->input->post('document'))) {
				$file_upload_path = 'assets/uploads/leaves/' . $this->input->post('document');
			} else {
				$file_upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/leaves/' . $this->input->post('document');
				unlink($file_upload_path);
			}
			$upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/leaves/';

			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0775, true);
			}
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = '*';
			$config['overwrite'] = false;
			$config['max_size'] = 0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('documents')) {
				$uploaded_data = $this->upload->data('file_name');
				return $uploaded_data;
			}
		} else {
			return '';
		}
	}

	private function respondWithError($message)
	{
		$this->data['error'] = true;
		$this->data['message'] = $message;
		echo json_encode($this->data);
	}

	private function respondWithSuccess($message, $data)
	{
		$this->data['error'] = false;
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'success');
		$this->data['message'] = $message;
		$this->data['data'] = $data;
		echo json_encode($this->data);
	}
	public function get_leaves_by_id()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->form_validation->set_rules('id', 'id', 'trim|required|strip_tags|xss_clean|is_numeric');

			if ($this->form_validation->run() == TRUE) {
				$data = $this->leaves_model->get_leaves_by_id($this->input->post('id'));
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

	public function get_leaves()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			echo json_encode($this->leaves_model->get_leaves());
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
			echo json_encode($this->data);
		}
	}

	/*
*
*	Create Leave
*
*/
	public function create()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->form_validation->set_rules('starting_date', 'Starting Date', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('ending_date', 'Ending Date', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('leave_reason', 'Leave Reason', 'trim|required|strip_tags|xss_clean');
			$this->form_validation->set_rules('type_add', 'Leave Type', 'trim|required|strip_tags|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				$user_id = $this->input->post('user_id_add') ? $this->input->post('user_id_add') : $this->session->userdata('user_id');
				$shift_times = $this->leaves_model->get_shift_times($user_id);
				$employee_id = get_employee_id_from_user_id($user_id);
				$data = [
					'saas_id' => $this->session->userdata('saas_id'),
					'user_id' => $employee_id,
					'leave_reason' => $this->input->post('leave_reason'),
					'type' => $this->input->post('type_add'),
					'paid' => $this->input->post('paid'),
					'status' => '0',
					'status_last' => '0',
					'document' => $this->leaves_model->handle_document_upload()
				];

				$Leaves = [];

				if ($this->input->post('half_day')) {
					$Leaves[] = $this->handle_half_day_leave($data, $shift_times);
				} elseif ($this->input->post('short_leave')) {
					$short_leave_data = $this->handle_short_leave($data, $shift_times);
					if (isset($short_leave_data['error']) && $short_leave_data['error'] == true) {
						echo json_encode(['error' => true, 'message' => $short_leave_data['message']]);
						return;
					} else {
						$Leaves[] = $short_leave_data;
					}
				} else {
					$Leaves = $this->handle_full_day_leave($data, $shift_times);
				}

				try {
					foreach ($Leaves as $leave) {
						$leave_id = $this->leaves_model->create($leave);
						$group = get_notifications_group_id();
						$roler = $this->session->userdata('user_id');
						$group = $this->ion_auth->get_users_groups($roler)->result();
						$group_id = $group[0]->id;
						$this->db->where('group_id', $group_id);
						$getCurrentGroupStep = $this->db->get('leave_hierarchy');
						$heiCurrentGroupStepResult = $getCurrentGroupStep->row();
						$heiCurrentGroupStep_number = $heiCurrentGroupStepResult->step_no;
						$step = $this->leaves_model->leaveStep($heiCurrentGroupStep_number, $data["user_id"]);
						$log = [
							'leave_id' => $leave_id,
							'group_id' => $group_id,
							'remarks' => $this->input->post('leave_reason'),
							'status' => 0,
							'level' => $step
						];
						$this->leaves_model->createLog($log);
					}
					if ($leave_id) {
						$CreateNotifications = $this->CreateNotification($step, $data['user_id']);
						$user_id = $this->input->post('user_id_add') ? $this->input->post('user_id_add') : $this->session->userdata('user_id');
						$employee_id_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
						$employee_id_result = $employee_id_query->row_array();
						foreach ($CreateNotifications as $system_user) {
							$template_data = array();
							$template_data['EMPLOYEE_NAME'] = $employee_id_result['first_name'] . ' ' . $employee_id_result['last_name'];
							$template_data['NAME'] = $system_user->first_name . ' ' . $system_user->last_name;
							$type = $this->input->post('type_add');
							$template_data['LEAVE_TYPE'] = '';
							$querys = $this->db->query("SELECT * FROM leaves_type");
							$leaves = $querys->result_array();
							if (!empty($leaves)) {
								foreach ($leaves as $leave) {
									if ($type == $leave['id']) {
										$template_data['LEAVE_TYPE'] = $leave['name'];
									}
								}
							}
							$template_data['STARTING_DATE'] = $this->input->post('starting_date');
							$template_data['REASON'] = $this->input->post('leave_reason');
							$template_data['DUE_DATE'] = $this->input->post('ending_date');
							$template_data['LEAVE_REQUEST_URL'] = base_url('leaves');
							$email_template = render_email_template('leave_request', $template_data);
							send_mail($system_user->email, $email_template[0]['subject'], $email_template[0]['message']);

							$notification_data = array(
								'notification' => 'Leave request received',
								'type' => 'leave_request',
								'type_id' => $leave_id,
								'from_id' => $this->input->post('user_id') ? $this->input->post('user_id') : $this->session->userdata('user_id'),
								'to_id' => $system_user->user_id,
							);
							$notification_id = $this->notifications_model->create($notification_data);
						}
						$this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
						$this->session->set_flashdata('message_type', 'success');
						$this->data['error'] = false;
						$this->data['message'] = $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.";
						echo json_encode($this->data);
					}
				} catch (Exception $ex) {
					echo json_encode(['error' => $ex->getMessage()]);
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

	private function handle_short_leave($data, $shift_times)
	{
		$data['starting_date'] = date("Y-m-d", strtotime($this->input->post('date')));
		$data['ending_date'] = date("Y-m-d", strtotime($this->input->post('date')));
		$data['starting_time'] = date("H:i:s", strtotime($this->input->post('starting_time')));
		$data['ending_time'] = date("H:i:s", strtotime($this->input->post('ending_time')));

		$startingTime = strtotime($this->input->post('starting_time'));
		$endingTime = strtotime($this->input->post('ending_time'));
		$durationSeconds = $endingTime - $startingTime;

		if ($durationSeconds > 10800 || $durationSeconds < 60) {
			return ['error' => true, 'message' => 'Check times manualy Or Short leave time exceed from 3 hours.'];
		}

		$durationHours = floor($durationSeconds / 3600);
		$durationMinutes = floor(($durationSeconds % 3600) / 60);
		$data['leave_duration'] = $durationHours . " hrs " . $durationMinutes . " mins Short Leave";
		return $data;
	}
	private function handle_half_day_leave($data, $shift_times)
	{
		$half_day_period = $this->input->post('half_day_period');
		$startingTime = $half_day_period === "0" ? $shift_times["check_in"] : $shift_times["break_end"];
		$endingTime = $half_day_period === "0" ? $shift_times["break_start"] : $shift_times["check_out"];
		$half_day_period = $half_day_period === "0" ? "First Time" : "Second Time";

		$date_half = $this->input->post('date_half');
		$startingDate = date("Y-m-d", strtotime($date_half));
		$endingDate = date("Y-m-d", strtotime($date_half));
		if (strtotime($shift_times["check_in"]) > strtotime($shift_times["check_out"])) {
			$tempStartingDate = date("Y-m-d", strtotime($date_half));
			$tempEndingDate = date("Y-m-d", strtotime("+1 day", strtotime($tempStartingDate)));

			if ($half_day_period === "Second Half" && strtotime($startingTime) >= strtotime('00:00:00')) {
				$startingDate = $tempEndingDate;
			}
			if (strtotime($endingTime) >= strtotime('00:00:00')) {
				$endingDate = $tempEndingDate;
			}
		}
		$data['starting_date'] = $startingDate;
		$data['ending_date'] = $endingDate;
		$data['starting_time'] = date("H:i:s", strtotime($startingTime));
		$data['ending_time'] = date("H:i:s", strtotime($endingTime));
		$data['leave_duration'] = $half_day_period . " Half Day";
		return $data;
	}

	private function handle_full_day_leave($data, $shift_times)
	{
		// Set starting and ending times based on shift times
		$data['starting_time'] = date("H:i:s", strtotime($shift_times["check_in"]));
		$data['ending_time'] = date("H:i:s", strtotime($shift_times["check_out"]));

		// Retrieve form input for paid and unpaid days
		$paid_days = (int) $this->input->post('paid_days');
		$unpaid_days = (int) $this->input->post('unpaid_days');

		// Retrieve form input for starting and ending dates
		$starting_date = date("Y-m-d", strtotime($this->input->post('starting_date')));
		$ending_date = date("Y-m-d", strtotime($this->input->post('ending_date')));
		$data['starting_date'] = $starting_date;
		$data['ending_date'] = $ending_date;

		// Calculate total leave duration in days
		$total_days = (strtotime($ending_date) - strtotime($starting_date)) / (60 * 60 * 24) + 1;
		$data['leave_duration'] = $total_days . " Full Day/s";

		$Leaves = [];

		// Handle no paid or unpaid days
		if ($paid_days < 1 && $unpaid_days < 1) {
			$Leaves[] = $data;
		}

		// Handle paid leave
		if ($paid_days > 0) {
			$paid_leave_days = min($paid_days, $total_days);
			$paid_leave_data = $data;
			$paid_leave_data['paid'] = 0;
			$paid_leave_data['leave_duration'] = $paid_leave_days . " Full Day/s";
			$paid_leave_data['ending_date'] = date('Y-m-d', strtotime($starting_date . " + " . ($paid_leave_days - 1) . " days"));
			$Leaves[] = $paid_leave_data;
			$total_days -= $paid_leave_days;
		}

		// Handle unpaid leave
		if ($unpaid_days > 0 && $total_days > 0) {
			$unpaid_leave_days = min($unpaid_days, $total_days);
			$unpaid_leave_data = $data;
			$unpaid_leave_data['paid'] = 1;
			$unpaid_leave_data['starting_date'] = date('Y-m-d', strtotime($paid_leave_data['ending_date'] . " + 1 day"));
			$unpaid_leave_data['ending_date'] = date('Y-m-d', strtotime($unpaid_leave_data['starting_date'] . " + " . ($unpaid_leave_days - 1) . " days"));
			$unpaid_leave_data['leave_duration'] = $unpaid_leave_days . " Full Day/s";
			$Leaves[] = $unpaid_leave_data;
		}
		return $Leaves;
	}


	public function CreateNotification($step, $employee_id)
	{
		$user_id = get_user_id_from_employee_id($employee_id);
		$saas_id = $this->session->userdata('saas_id');
		$this->db->where('saas_id', $saas_id);
		$this->db->where('step_no', $step);
		$query = $this->db->get('leave_hierarchy');
		$rows = $query->result();
		foreach ($rows as &$row) {
			$step_group = $row->group_id;
			$step_groupArray[] = $row->group_id;
			$group = $this->ion_auth->group($step_group)->row();
			$groups_users[] = $this->ion_auth->users($step_group)->result();
		}
		$flattenedArray = [];
		foreach ($groups_users as $users) {
			$flattenedArray = array_merge($flattenedArray, $users);
		}
		return $flattenedArray;
	}

	public function manage($id)
	{
		if ($this->ion_auth->logged_in()  && is_module_allowed('leaves') && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->data['page_title'] = 'Leaves - ' . company_name();
			$this->data['main_page'] = 'Leaves Application';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data["report"] = $this->attendance_model->get_count_abs();
			if ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				$user_ids = array_merge($selected, [$this->session->userdata('user_id')]);
				$user_ids = array_unique($user_ids);
				$users = array_map(function ($user_id) {
					return $this->ion_auth->user($user_id)->row();
				}, $user_ids);
				$this->data['system_users'] = $users;
			}
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('leaves_type');
			$this->data['leave'] = $this->leaves_model->get_leaves_by_id($id);
			$this->data['durations'] = $this->leaves_model->get_leave_duration($id);
			$this->data['leaves_types'] = $query->result_array();
			$this->db->where('leave_id', $id);
			$logs_query = $this->db->get('leave_logs');
			$leaves_logs = $logs_query->result_array();
			foreach ($leaves_logs as &$leaves_log) {
				$leaves_log["created"] = $this->getTimeAgo($leaves_log["created"]);
				$group_id = $leaves_log["group_id"];
				$group = $this->ion_auth->group($group_id)->row();
				if ($leaves_log["status"] == -1) {
					$leaves_log["status"] = '' . $group->description . ' <strong class="text-info">Create</strong>';
					$leaves_log["class"] = 'info';
				} elseif ($leaves_log["status"] == 1) {
					$leaves_log["status"] = '' . $group->description . ' <strong class="text-success">Approve</strong>';
					$leaves_log["class"] = 'success';
				} else if ($leaves_log["status"] == 0) {
					$leaves_log["status"] = '' . $group->description . ' <strong class="text-primary">Created</strong>';
					$leaves_log["class"] = 'primary';
				} else {
					$leaves_log["status"] = '' . $group->description . ' <strong class="text-danger">Reject</strong>';
					$leaves_log["class"] = 'danger';
				}
			}
			$this->data['leaves_logs'] = $leaves_logs;
			// echo json_encode($this->data);
			$this->load->view('pages/leave/leaves-edit', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function create_leave()
	{

		if ($this->ion_auth->logged_in()  && is_module_allowed('leaves') && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->data['page_title'] = 'Leaves - ' . company_name();
			$this->data['main_page'] = 'Leaves Application';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data["report"] = $this->attendance_model->get_count_abs();
			if ($this->ion_auth->is_admin()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				$user_ids = array_merge($selected, [$this->session->userdata('user_id')]);
				$user_ids = array_unique($user_ids);
				$users = array_map(function ($user_id) {
					return $this->ion_auth->user($user_id)->row();
				}, $user_ids);
				$this->data['system_users'] = $users;
			}
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('leaves_type');
			$this->data['leaves_types'] = $query->result_array();
			$this->load->view('pages/leave/leaves-create', $this->data);
		} else {
			redirect_to_index();
		}
	}
	public function getTimeAgo($timestamp)
	{
		$timestampDateTime = new DateTime($timestamp);
		$currentDateTime = new DateTime();

		$interval = $currentDateTime->diff($timestampDateTime);

		if ($interval->y > 0) {
			return $interval->format("%y years ago");
		} elseif ($interval->m > 0) {
			return $interval->format("%m months ago");
		} elseif ($interval->d > 0) {
			return $interval->format("%d days ago");
		} elseif ($interval->h > 0) {
			return $interval->format("%h hours ago");
		} elseif ($interval->i > 0) {
			return $interval->format("%i minutes ago");
		} else {
			return "just now";
		}
	}
}
