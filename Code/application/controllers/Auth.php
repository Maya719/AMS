<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	/**
	 * Redirect if needed
	 */
	public function index()
	{
		if ($this->ion_auth->logged_in()) {
			redirect('home', 'refresh');
		} else {
			$this->data['page_title'] = 'Login - ' . company_name();
			$this->load->view('login', $this->data);
		}
	}

	/**
	 * Redirect if needed
	 */
	public function confirmation()
	{
		if ($this->ion_auth->logged_in()) {
			redirect('home', 'refresh');
		} else {
			$this->data['page_title'] = 'Confirmation - ' . company_name();
			$this->load->view('confirmation', $this->data);
		}
	}
	public function create_profile($saas_id = '')
	{
		if ($this->ion_auth->logged_in()) {
			redirect('home', 'refresh');
		} else {
			$saas_id = $this->ion_auth->decryptId($saas_id, 'GeekForGeek');
			$this->data['saas_id'] = $saas_id;
			$this->data['page_title'] = 'Create Profile - ' . company_name();
			$this->load->view('companyProfile/create-profile', $this->data);
		}
	}

	public function purchase_plan($saas_id = '')
	{
		if ($this->ion_auth->logged_in()) {
			redirect('home', 'refresh');
		} else {

			$saas_id = $this->ion_auth->decryptId($saas_id, 'GeekForGeek');
			$this->data['saas_id'] = $saas_id;
			$query = $this->db->select('*')
				->from('users')
				->where('saas_id', $saas_id)
				->get();
			$this->data['user'] = $query->row();
			$this->data['plans'] = $this->plans_model->get_plans();
			$this->data['page_title'] = 'Create Profile - ' . company_name();
			$this->load->view('companyProfile/purchase-plan', $this->data);
		}
	}

	/**
	 * login_as_admin
	 */
	public function login_as_admin()
	{

		$this->form_validation->set_rules('id', 'User ID', 'trim|required|strip_tags|xss_clean|is_numeric');

		if ($this->form_validation->run() === TRUE) {
			$user = $this->ion_auth->user($this->input->post('id'))->row();
			if ($user && ($this->ion_auth->in_group(3) || ($this->ion_auth->is_admin() && $this->session->userdata('saas_id') == $user->saas_id))) {

				if ($this->ion_auth->login_as_admin($user->email)) {
					$this->data['error'] = false;
					$this->data['message'] = $this->ion_auth->messages();
					echo json_encode($this->data);
					return false;
				} else {
					$this->data['error'] = true;
					$this->data['message'] = $this->ion_auth->errors();
					echo json_encode($this->data);
					return false;
				}
			} else {
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('access_denied') ? htmlspecialchars($this->lang->line('access_denied')) : "Access Denied";
				echo json_encode($this->data);
				return false;
			}
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied') ? htmlspecialchars($this->lang->line('access_denied')) : "Access Denied";
			echo json_encode($this->data);
			return false;
		}
	}

	/**
	 * Log the user in
	 */
	public function login()
	{
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE) {
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), true)) {
				$this->data['error'] = false;
				$this->data['message'] = $this->ion_auth->messages();
				echo json_encode($this->data);
			} else {
				$this->data['error'] = true;
				$this->data['message'] = $this->ion_auth->errors();
				echo json_encode($this->data);
			}
		} else {
			$this->data['error'] = true;
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			echo json_encode($this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";
		$this->ion_auth->logout();
		redirect_to_index();
	}

	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE) {
			// ANCHOR  display the form
			// ANCHOR  set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// ANCHOR  render
			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				// ANCHOR if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		// ANCHOR  setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE) {
			$this->data['error'] = true;
			$this->data['data'] = '';
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			echo json_encode($this->data);
			return false;
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity)) {
				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->data['error'] = true;
				$this->data['data'] = '';
				$this->data['message'] = $this->ion_auth->errors();
				echo json_encode($this->data);
				return false;
			}

			// ANCHOR  run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				$this->data['error'] = false;
				$this->data['data'] = '';
				$this->data['message'] = $this->ion_auth->messages();
				echo json_encode($this->data);
			} else {
				$this->data['error'] = true;
				$this->data['data'] = '';
				$this->data['message'] = $this->ion_auth->errors();
				echo json_encode($this->data);
				return false;
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code) {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth", 'refresh');
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// ANCHOR  if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE) {
				$this->data['page_title'] = 'Reset Password - ' . company_name();
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['user_id'] = [
					'user_id' => $user->id,
				];
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				$this->load->view('reset', $this->data);
			} else {
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				// ANCHOR  finally change the password
				$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

				if ($change) {
					$this->ion_auth->activate($user->id);

					// ANCHOR  if the password was successfully changed
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('message_type', 'success');
					redirect("auth", 'refresh');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/reset_password/' . $code, 'refresh');
				}
			}
		} else {
			// ANCHOR  if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth", 'refresh');
		}
	}

	public function delete_user($id = '')
	{
		$id = !empty($id) ? $id : $this->input->post('id');

		if (empty($id) || !is_numeric($id)) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('invalid_user_id') ? $this->lang->line('invalid_user_id') : "Invalid User ID";
			echo json_encode($this->data);
			return false;
		}

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !permissions('user_delete') && !permissions('client_edit') && !$this->ion_auth->in_group(3))) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('you_must_be_an_administrator_to_take_this_action') ? $this->lang->line('you_must_be_an_administrator_to_take_this_action') : "You must be an administrator to take this action.";
			echo json_encode($this->data);
			return false;
		}

		if ($this->ion_auth->delete_user($id)) {

			$this->projects_model->delete_project_users('', $id);
			$this->projects_model->delete_task_users('', $id);
			$this->projects_model->delete_task_comment('', $id);
			$this->notifications_model->delete('', '', '', $id); // ANCHOR  set noti delete
			$this->notifications_model->delete('', '', '', '', $id); // ANCHOR  received noti delete

			$project_files = $this->projects_model->get_project_files('', $id);
			if ($project_files) {
				foreach ($project_files as $project_file) {
					$this->projects_model->delete_project_files($project_file['id']);
				}
			}

			$task_files = $this->projects_model->get_tasks_files('', $id);
			if ($task_files) {
				foreach ($task_files as $task_file) {
					$this->projects_model->delete_task_files($task_file['id']);
				}
			}

			$this->support_model->delete('', $id);
			$this->support_model->delete_support_message('', $id);

			if ($id == $this->session->userdata('user_id')) {
				$this->ion_auth->logout();
			}

			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data['message'] = $this->ion_auth->messages();
			echo json_encode($this->data);
			return false;
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->ion_auth->errors();
			echo json_encode($this->data);
			return false;
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate($id = '', $code = FALSE)
	{
		$id = !empty($id) ? $id : $this->input->post('id');

		if (empty($id) || !is_numeric($id)) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('invalid_user_id') ? $this->lang->line('invalid_user_id') : "Invalid User ID";
			echo json_encode($this->data);
			return false;
		}

		if ($code !== FALSE) {
			if ($this->ion_auth->activate($id, $code)) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_flashdata('message_type', 'success');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->session->set_flashdata('message_type', 'success');
			}
			$saas_id = $this->ion_auth->encryptId($id, 'GeekForGeek');
			redirect("auth/create_profile/" . $saas_id, 'refresh');
		}

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !permissions('user_edit') && !permissions('client_edit') && !$this->ion_auth->in_group(3))) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('you_must_be_an_administrator_to_take_this_action') ? $this->lang->line('you_must_be_an_administrator_to_take_this_action') : "You must be an administrator to take this action.";
			echo json_encode($this->data);
			return false;
		}

		if ($this->ion_auth->activate($id)) {

			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data['message'] = $this->ion_auth->messages();
			echo json_encode($this->data);
			return false;
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->ion_auth->errors();
			echo json_encode($this->data);
			return false;
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		$id = !empty($id) ? $id : $this->input->post('id');

		if (empty($id) || !is_numeric($id)) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('invalid_user_id') ? $this->lang->line('invalid_user_id') : "Invalid User ID";
			echo json_encode($this->data);
			return false;
		}

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !permissions('user_edit') && !permissions('client_edit') && !$this->ion_auth->in_group(3))) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('you_must_be_an_administrator_to_take_this_action') ? $this->lang->line('you_must_be_an_administrator_to_take_this_action') : "You must be an administrator to take this action.";
			echo json_encode($this->data);
			return false;
		}

		if ($this->ion_auth->deactivate($id)) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data['message'] = $this->ion_auth->messages();
			echo json_encode($this->data);
			return false;
		} else {
			$this->data['error'] = true;
			$this->data['message'] = $this->ion_auth->errors();
			echo json_encode($this->data);
			return false;
		}
	}

	public function register()
	{
		if (!$this->ion_auth->logged_in() && !turn_off_new_user_registration()) {
			$this->data['page_title'] = 'Register - ' . company_name();
			$this->load->view('register', $this->data);
		} else {
			redirect('home', 'refresh');
		}
	}

	/**
	 * Create or login
	 */
	public function social_auth()
	{

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// ANCHOR  validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|strip_tags|xss_clean|valid_email');

		if ($this->input->post('email') && $this->ion_auth->login_as_admin($this->input->post('email'))) {
			$this->data['error'] = false;
			$this->data['message'] = $this->ion_auth->messages();
			echo json_encode($this->data);
			return false;
		}

		if ($this->form_validation->run() === TRUE) {
			$identity = strtolower($this->input->post('email'));
			$password = uniqid(rand(), true);

			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			];
			$group = array(1);
		}

		$recaptcha_secret_key = get_google_recaptcha_secret_key();
		if ($recaptcha_secret_key) {
			$token = $this->input->post('token');
			$action = $this->input->post('action');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https:// ANCHOR www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret_key, 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);

			if ($arrResponse["success"] != '1' || $arrResponse["action"] != $action || $arrResponse["score"] <= 0.6) {
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
				echo json_encode($this->data);
				return false;
			}
		}

		if ($this->form_validation->run() === TRUE && $new_user_id = $this->ion_auth->register($identity, $password, $identity, $additional_data, $group)) {

			$plan = $this->plans_model->get_plans(1);
			$dt = strtotime(date("Y-m-d"));

			if ($plan[0]['billing_type'] == "One Time" && $plan[0]['price'] < 1) {
				$date = NULL;
			} elseif ($plan[0]['billing_type'] == "Monthly" && $plan[0]['price'] < 1) {
				$date = date("Y-m-d", strtotime("+1 month", $dt));
			} elseif ($plan[0]['billing_type'] == "Yearly" && $plan[0]['price'] < 1) {
				$date = date("Y-m-d", strtotime("+1 year", $dt));
			} elseif ($plan[0]['billing_type'] == "three_days_trial_plan") {
				$date = date("Y-m-d", strtotime("+3 days", $dt));
			} elseif ($plan[0]['billing_type'] == "seven_days_trial_plan") {
				$date = date("Y-m-d", strtotime("+7 days", $dt));
			} elseif ($plan[0]['billing_type'] == "fifteen_days_trial_plan") {
				$date = date("Y-m-d", strtotime("+15 days", $dt));
			} elseif ($plan[0]['billing_type'] == "thirty_days_trial_plan") {
				$date = date("Y-m-d", strtotime("+1 month", $dt));
			} else {
				$date = date("Y-m-d", strtotime("-1 day", $dt));
			}

			$users_plans_data = array(
				'saas_id' => $new_user_id,
				'plan_id' => 1,
				'start_date' => date("Y-m-d"),
				'end_date' => $date,
			);
			$this->plans_model->create_users_plans($users_plans_data);

			// ANCHOR  notification to the saas admins
			$saas_admins = $this->ion_auth->users(array(3))->result();
			foreach ($saas_admins as $saas_admin) {
				$data = array(
					'notification' => 'New user registered.',
					'type' => 'new_user',
					'type_id' => $new_user_id,
					'from_id' => $new_user_id,
					'to_id' => $saas_admin->user_id,
				);
				$notification_id = $this->notifications_model->create($data);
			}

			$update_saas_id_data = [
				'saas_id' => $new_user_id,
			];

			$this->ion_auth->update($new_user_id, $update_saas_id_data);

			$this->ion_auth->login_as_admin($identity);

			$this->data['error'] = false;
			$this->data['message'] = $this->ion_auth->messages();
			echo json_encode($this->data);
			return false;
		} else {
			$this->data['error'] = true;
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			echo json_encode($this->data);
			return false;
		}
	}

	/**
	 * Create a new user
	 */

	public function create_saas_admin()
	{
		if (!my_plan_features('users') && !is_saas_admin()) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
			echo json_encode($this->data);
			return false;
		}

		$this->data['title'] = $this->lang->line('create_user_heading');

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required|strip_tags|xss_clean');

		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|strip_tags|xss_clean|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->input->post('new_register')) {
			$this->form_validation->set_rules('agree', $this->lang->line('i_agree_to_the_terms_and_conditions') ? htmlspecialchars($this->lang->line('i_agree_to_the_terms_and_conditions')) : 'I agree to the terms and conditions', 'trim|required|strip_tags|xss_clean');
		}

		if ($this->form_validation->run() === TRUE) {
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');

			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
			];
			$group = array($this->input->post('groups') ? $this->input->post('groups') : '2');
		}

		$recaptcha_secret_key = get_google_recaptcha_secret_key();
		if ($recaptcha_secret_key && $this->input->post('new_register')) {
			$token = $this->input->post('token');
			$action = $this->input->post('action');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret_key, 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);

			if ($arrResponse["success"] != '1' || $arrResponse["action"] != $action || $arrResponse["score"] <= 0.6) {
				$this->data['error'] = true;
				$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
				echo json_encode($this->data);
				return false;
			}
		}

		if ($this->form_validation->run() === TRUE && $new_user_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {

			if ($this->ion_auth->is_admin()  || permissions('user_create') || permissions('client_create') || $this->input->post('create_saas_admin')) {
				$update_saas_id_data = [
					'saas_id' => $this->session->userdata('saas_id'),
				];
			} else {

				$update_saas_id_data = [
					'saas_id' => $new_user_id,
				];

				$plan = $this->plans_model->get_plans(1);
				$dt = strtotime(date("Y-m-d"));

				if ($plan[0]['billing_type'] == "One Time" && $plan[0]['price'] < 1) {
					$date = NULL;
				} elseif ($plan[0]['billing_type'] == "Monthly" && $plan[0]['price'] < 1) {
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				} elseif ($plan[0]['billing_type'] == "Yearly" && $plan[0]['price'] < 1) {
					$date = date("Y-m-d", strtotime("+1 year", $dt));
				} elseif ($plan[0]['billing_type'] == "three_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+3 days", $dt));
				} elseif ($plan[0]['billing_type'] == "seven_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+7 days", $dt));
				} elseif ($plan[0]['billing_type'] == "fifteen_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+15 days", $dt));
				} elseif ($plan[0]['billing_type'] == "thirty_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				} else {
					$date = date("Y-m-d", strtotime("-1 day", $dt));
				}

				$users_plans_data = array(
					'saas_id' => $new_user_id,
					'plan_id' => 1,
					'start_date' => date("Y-m-d"),
					'end_date' => $date,
				);
				$this->plans_model->create_users_plans($users_plans_data);

				//   notification to the saas admins
				$saas_admins = $this->ion_auth->users(array(3))->result();
				foreach ($saas_admins as $saas_admin) {
					$data = array(
						'notification' => 'New user registered.',
						'type' => 'new_user',
						'type_id' => $new_user_id,
						'from_id' => $new_user_id,
						'to_id' => $saas_admin->user_id,
					);
					$notification_id = $this->notifications_model->create($data);
				}
			}

			$this->ion_auth->update($new_user_id, $update_saas_id_data);


			if ($this->input->post('company')) {
				$cdata_json = array(
					'company_name' => $this->input->post('company'),
					'address' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zip_code' => '',
				);
				$cdata = array(
					'value' => json_encode($cdata_json)
				);
				$csetting_type = 'company_' . $new_user_id;
				$this->settings_model->save_settings($csetting_type, $cdata);
			}

			if (email_activation()) {

				$this->ion_auth->deactivate($new_user_id);
				$this->ion_auth_model->clear_messages();

				$activation_code = $this->ion_auth_model->activation_code;

				$template_data = array();
				$template_data['EMAIL_CONFIRMATION_LINK'] = base_url('auth/activate/' . $new_user_id . '/' . $activation_code);
				$template_data['NAME'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
				$email_template = render_email_template('email_verification', $template_data);
				send_mail($this->input->post('email'), $email_template[0]['subject'], $email_template[0]['message']);

				if ($this->ion_auth->logged_in()) {
					$msg = $this->lang->line('make_sure_to_activate_the_account_or_ask_the_user_to_confirm_the_email_address') ? $this->lang->line('make_sure_to_activate_the_account_or_ask_the_user_to_confirm_the_email_address') : "Make sure to activate the account or ask the user to confirm the email address.";
				} else {

					$msg = $this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account') ? $this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account') : "Please check your inbox and confirm your email address to activate your account.";
				}
			} else {
				if ($this->input->post('new_register')) {
					$msg = $this->lang->line('user_registered_successfully_go_to_the_login_page_and_login_with_your_credentials') ? $this->lang->line('user_registered_successfully_go_to_the_login_page_and_login_with_your_credentials') : "User registered successfully. Go to the login page and login with your credentials.";
				} else {
					$msg = $this->ion_auth->messages();
				}
			}

			$template_data = array();
			$template_data['LOGIN_EMAIL'] = $this->input->post('email');
			$template_data['LOGIN_PASSWORD'] = $this->input->post('password');
			$email_template = render_email_template('new_user_registration', $template_data);

			if ($this->input->post('delete_lead')) {
				$this->leads_model->delete($this->input->post('delete_lead'));
				$this->notifications_model->delete('', 'new_lead', $this->input->post('delete_lead'));
			}

			$this->session->set_flashdata('message', $msg);
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data['message'] = $msg;
			echo json_encode($this->data);
		} else {
			$this->data['error'] = true;
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			echo json_encode($this->data);
			return false;
		}
	}
	public function create_user()
	{
		if (!my_plan_features('users') && !$this->ion_auth->in_group(3)) {
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
			echo json_encode($this->data);
			return false;
		}

		$this->data['title'] = $this->lang->line('create_user_heading');

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// ANCHOR  validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required|strip_tags|xss_clean');

		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|strip_tags|xss_clean|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->input->post('new_register')) {
			$this->form_validation->set_rules('agree', $this->lang->line('i_agree_to_the_terms_and_conditions') ? htmlspecialchars($this->lang->line('i_agree_to_the_terms_and_conditions')) : 'I agree to the terms and conditions', 'trim|required|strip_tags|xss_clean');
		}

		if ($this->form_validation->run() === TRUE) {
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');


			if ($this->input->post('finger_config')) {
				$finger_config = '1';
				$devices = $this->input->post('device') ? $this->input->post('device') : '';
				$device_ids_str = '["' . $devices . '"]';
			} else {
				$device_ids_str = '[]';
				$finger_config = '';
			}
			if ($this->input->post('probation_period') && $this->input->post('probation_period') == '' && $this->input->post('join_date')) {
				$probition_period = $this->input->post('probation_period');
				$joinDate = date("Y-m-d", strtotime($this->input->post('join_date')));
				if ($probition_period >= 1 && $probition_period <= 3) {
					$joinDate = new DateTime($joinDate);
					$joinDate->modify("+$probition_period months");
					$period = $joinDate->format('Y-m-d');
				}
			} else {
				$period = '';
			}

			$document_paths = array();
			if (!empty($_FILES['files']['name'])) {
				$upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/documents/';
				if (!is_dir($upload_path)) {
					mkdir($upload_path, 0775, true);
				}

				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'pdf|doc|docx|txt';
				$config['overwrite'] = false;
				$config['max_size'] = 0;
				$config['max_width'] = 0;
				$config['max_height'] = 0;
				$this->load->library('upload', $config);

				// ANCHOR  Loop through the uploaded files
				foreach ($_FILES['files']['name'] as $key => $document_name) {
					if (!empty($document_name)) {
						// ANCHOR  Define a unique field name for each file
						$field_name = 'files[' . $key . ']';
						$_FILES[$field_name] = array(
							'name' => $_FILES['files']['name'][$key],
							'type' => $_FILES['files']['type'][$key],
							'tmp_name' => $_FILES['files']['tmp_name'][$key],
							'error' => $_FILES['files']['error'][$key],
							'size' => $_FILES['files']['size'][$key]
						);

						if ($this->upload->do_upload($field_name)) {
							$uploaded_data = $this->upload->data('file_name');
							$document_paths[] = $uploaded_data;
						}
					}
				}
			}


			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'father_name' => $this->input->post('father_name') ? $this->input->post('father_name') : '',
				'phone' => $this->input->post('phone'),
				'martial_status' => $this->input->post('martial_status') ? $this->input->post('martial_status') : '',
				'gender' => $this->input->post('gender') ? $this->input->post('gender') : '',
				'cnic' => $this->input->post('cnic') ? $this->input->post('cnic') : '',
				'desgnation' => $this->input->post('desgnation') ? $this->input->post('desgnation') : '',
				'department' => $this->input->post('department') ? $this->input->post('department') : '',
				'join_date' => $this->input->post('join_date') ? date("Y-m-d", strtotime($this->input->post('join_date'))) : '',
				'emg_person' => $this->input->post('emg_person') ? $this->input->post('emg_person') : '',
				'emg_number' => $this->input->post('emg_number') ? $this->input->post('emg_number') : '',
				'employee_id' => $this->input->post('employee_id') ? $this->input->post('employee_id') : '',
				'blood_group' => $this->input->post('blood_group') ? $this->input->post('blood_group') : '',
				'device_id' => $device_ids_str,
				'probation' => $period,
				'documents' => json_encode($document_paths),
				'address' => $this->input->post('address') ? $this->input->post('address') : '',
				'DOB' => $this->input->post('date_of_birth') ? date("Y-m-d", strtotime($this->input->post('date_of_birth'))) : '',
				'finger_config' => $finger_config,
				'shift_id' => $this->input->post('type') ? $this->input->post('type') : '1',
			];

			$group = array($this->input->post('groups') ? $this->input->post('groups') : '2');
		}

		$recaptcha_secret_key = get_google_recaptcha_secret_key();
		// if ($recaptcha_secret_key && $this->input->post('new_register')) {
		// 	$token = $this->input->post('token');
		// 	$action = $this->input->post('action');
		// 	$ch = curl_init();
		// 	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		// 	curl_setopt($ch, CURLOPT_POST, 1);
		// 	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret_key, 'response' => $token)));
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 	$response = curl_exec($ch);
		// 	curl_close($ch);
		// 	$arrResponse = json_decode($response, true);

		// 	if ($arrResponse["success"] != '1' || $arrResponse["action"] != $action || $arrResponse["score"] <= 0.6) {
		// 		$this->data['error'] = true;
		// 		$this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
		// 		echo json_encode($this->data);
		// 		return false;
		// 	}
		// }

		if ($this->form_validation->run() === TRUE && $new_user_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
			if ($this->ion_auth->is_admin()  || permissions('user_create') || permissions('client_create') || $this->input->post('create_saas_admin')) {
				$update_saas_id_data = [
					'saas_id' => $this->session->userdata('saas_id'),
				];
			} else {
				if ($recaptcha_secret_key && $this->input->post('new_register')) {
					// Create department data
					$departmentData = array(
						array('saas_id' => $new_user_id, 'company_name' => 'ABC', 'department_name' => 'Administration'),
						array('saas_id' => $new_user_id, 'company_name' => 'ABC', 'department_name' => 'HR Manager')
					);

					// Insert department data
					foreach ($departmentData as $data) {
						$this->department_model->create($data);
					}

					// Create role data
					$roleData = array(
						array(
							'saas_id' => $new_user_id,
							'name' => str_replace(' ', '_', strtolower('employee')),
							'description' => 'Employee',
							'descriptive_name' => 'Employee',
							'permissions' => '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88"]',
							'change_permissions_of' => '',
							'assigned_users' => ''
						),
						array(
							'saas_id' => $new_user_id,
							'name' => str_replace(' ', '_', strtolower('HR Manager')),
							'description' => 'HR Manager',
							'descriptive_name' => 'HR Manager',
							'permissions' => '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88"]',
							'change_permissions_of' => '',
							'assigned_users' => ''
						),
						array(
							'saas_id' => $new_user_id,
							'name' => str_replace(' ', '_', strtolower('client')),
							'description' => 'Clients',
							'descriptive_name' => '',
							'permissions' => '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88"]',
							'change_permissions_of' => '',
							'assigned_users' => ''
						),
						array(
							'saas_id' => $new_user_id,
							'name' => str_replace(' ', '_', strtolower('CEO')),
							'description' => 'CEO',
							'descriptive_name' => 'CEO',
							'permissions' => '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88"]',
							'change_permissions_of' => '',
							'assigned_users' => ''
						)
					);


					// Insert role data
					foreach ($roleData as $data) {
						$setting["type"] = $data["name"] . '_permissions_' . $new_user_id;
						if ($data["name"] == 'client') {
							$setting['value'] = '{"project_view":0,"project_create":0,"project_edit":0,"project_delete":0,"task_view":0,"task_create":0,"task_edit":0,"task_delete":0,"user_view":0,"client_view":0,"setting_view":0,"setting_update":0,"todo_view":0,"notes_view":0,"chat_view":0,"chat_delete":0,"team_members_and_client_can_chat":1,"task_status":0,"project_budget":0,"gantt_view":0,"gantt_edit":0,"calendar_view":0,"lead_view":0,"lead_create":0,"lead_edit":0,"lead_delete":0}';
						} else {
							$setting['value'] = '{"attendance_view":0,"attendance_view_all":0,"leaves_view":0,"leaves_create":0,"leaves_edit":0,"leaves_delete":0,"leaves_status":0,"leaves_view_all":0,"biometric_request_view":0,"biometric_request_create":0,"biometric_request_edit":0,"biometric_request_delete":0,"biometric_request_status":0,"biometric_request_view_all":0,"biometric_request_view_selected":0,"project_view":1,"project_create":1,"project_edit":1,"project_delete":0,"project_view_all":0,"task_view":1,"task_create":1,"task_edit":1,"task_delete":0,"task_status":0,"task_view_all":0,"device_view":1,"device_create":0,"device_edit":0,"device_delete":0,"departments_view":0,"departments_create":0,"departments_edit":0,"departments_delete":0,"shift_view":0,"shift_create":0,"shift_edit":0,"shift_delete":0,"plan_holiday_view":0,"plan_holiday_create":0,"plan_holiday_edit":0,"plan_holiday_delete":0,"time_schedule_view":0,"time_schedule_edit":0,"user_view":1,"user_edit":0,"client_view":0,"setting_view":0,"setting_update":0,"todo_view":1,"notes_view":1,"chat_view":1,"chat_delete":0,"project_budget":0,"gantt_view":0,"gantt_edit":0,"calendar_view":0,"meetings_view":0,"meetings_create":0,"meetings_edit":0,"meetings_delete":0,"lead_view":0,"lead_create":0,"lead_edit":0,"lead_delete":0,"attendance_view_selected":0,"leaves_view_selected":0,"project_view_selected":0,"task_view_selected":0,"reports_view":0,"client_create":0,"client_edit":0,"client_delete":0,"user_create":0,"user_view_selected":0,"user_delete":0,"user_view_all":0,"leave_type_view":0,"leave_type_create":0,"leave_type_edit":0,"leave_type_delete":0,"general_view":0,"company_view":0,"support_view":0,"notification_view_all":0,"notification_view_pms":0,"team_members_and_client_can_chat":0,"general_edit":0,"company_edit":0}';
						}
						$this->db->insert('settings', $setting);
						$this->settings_model->roles_create($data);
					}
				}

				$this->data["saas_id"] = $this->ion_auth->encryptId($new_user_id, 'GeekForGeek');
				$update_saas_id_data = [
					'saas_id' => $new_user_id,
				];

				$plan = $this->plans_model->get_plans(1);
				$dt = strtotime(date("Y-m-d"));

				if ($plan[0]['billing_type'] == "One Time" && $plan[0]['price'] < 1) {
					$date = NULL;
				} elseif ($plan[0]['billing_type'] == "Monthly" && $plan[0]['price'] < 1) {
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				} elseif ($plan[0]['billing_type'] == "Yearly" && $plan[0]['price'] < 1) {
					$date = date("Y-m-d", strtotime("+1 year", $dt));
				} elseif ($plan[0]['billing_type'] == "three_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+3 days", $dt));
				} elseif ($plan[0]['billing_type'] == "seven_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+7 days", $dt));
				} elseif ($plan[0]['billing_type'] == "fifteen_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+15 days", $dt));
				} elseif ($plan[0]['billing_type'] == "thirty_days_trial_plan") {
					$date = date("Y-m-d", strtotime("+1 month", $dt));
				} else {
					$date = date("Y-m-d", strtotime("-1 day", $dt));
				}

				$users_plans_data = array(
					'saas_id' => $new_user_id,
					'plan_id' => 1,
					'start_date' => date("Y-m-d"),
					'end_date' => $date,
				);
				$this->plans_model->create_users_plans($users_plans_data);

				$saas_admins = $this->ion_auth->users(array(3))->result();
				foreach ($saas_admins as $saas_admin) {
					$data = array(
						'notification' => 'New user registered.',
						'type' => 'new_user',
						'type_id' => $new_user_id,
						'from_id' => $new_user_id,
						'to_id' => $saas_admin->user_id,
					);
					$notification_id = $this->notifications_model->create($data);
				}
			}

			$this->ion_auth->update($new_user_id, $update_saas_id_data);


			if ($this->input->post('company')) {
				$cdata_json = array(
					'company_name' => $this->input->post('company'),
					'address' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zip_code' => '',
				);
				$cdata = array(
					'value' => json_encode($cdata_json)
				);
				$csetting_type = 'company_' . $new_user_id;
				$this->settings_model->save_settings($csetting_type, $cdata);
			}

			if (email_activation()) {

				$this->ion_auth->deactivate($new_user_id);
				$this->ion_auth_model->clear_messages();

				$activation_code = $this->ion_auth_model->activation_code;

				$template_data = array();
				$template_data['EMAIL_CONFIRMATION_LINK'] = base_url('auth/activate/' . $new_user_id . '/' . $activation_code);
				$template_data['NAME'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
				$email_template = render_email_template('email_verification', $template_data);
				send_mail($this->input->post('email'), $email_template[0]['subject'], $email_template[0]['message']);

				if ($this->ion_auth->logged_in()) {
					$msg = $this->lang->line('make_sure_to_activate_the_account_or_ask_the_user_to_confirm_the_email_address') ? $this->lang->line('make_sure_to_activate_the_account_or_ask_the_user_to_confirm_the_email_address') : "Make sure to activate the account or ask the user to confirm the email address.";
				} else {
					$msg = $this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account') ? $this->lang->line('please_check_your_inbox_and_confirm_your_eamil_address_to_activate_your_account') : "Please check your inbox and confirm your email address to activate your account.";
				}
			} else {
				if ($this->input->post('new_register')) {
					$msg = $this->lang->line('user_registered_successfully_go_to_the_login_page_and_login_with_your_credentials') ? $this->lang->line('user_registered_successfully_go_to_the_login_page_and_login_with_your_credentials') : "User registered successfully. Go to the login page and login with your credentials.";
				} else {
					$msg = $this->ion_auth->messages();
				}
			}

			$template_data = array();
			$template_data['LOGIN_EMAIL'] = $this->input->post('email');
			$template_data['LOGIN_PASSWORD'] = $this->input->post('password');
			$email_template = render_email_template('new_user_registration', $template_data);

			if ($this->input->post('delete_lead')) {
				$this->leads_model->delete($this->input->post('delete_lead'));
				$this->notifications_model->delete('', 'new_lead', $this->input->post('delete_lead'));
			}

			$this->session->set_flashdata('message', $msg);
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data['message'] = $msg;
			echo json_encode($this->data);
		} else {
			$this->data['error'] = true;
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			echo json_encode($this->data);
			return false;
		}
	}

	/**
	 * Redirect a user checking if is admin
	 */
	public function redirectUser()
	{
		if ($this->ion_auth->is_admin()) {
			redirect_to_index();
		}
		redirect('/', 'refresh');
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user()
	{
		$id = $this->input->post('update_id');

		if (!$this->is_valid_user_id($id) || !$this->has_permission($id)) {
			$this->send_error_message('invalid_user_id');
			return false;
		}

		$user = $this->ion_auth->user($id)->row();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		$this->set_form_validation_rules();

		if ($this->form_validation->run() === TRUE) {
			if ($this->input->post('password') && !$this->validate_old_password($user->password)) {
				$this->send_error_message('Old password incorrect.');
				return false;
			}

			$profile_pic = $this->handle_file_upload('profile', 'assets/uploads/f' . $this->session->userdata('saas_id') . '/profiles/');
			$document_paths = $this->handle_multiple_file_upload('files', 'assets/uploads/f' . $this->session->userdata('saas_id') . '/documents/');
			$this->delete_old_documents();

			$data = $this->prepare_user_data($user, $profile_pic, $document_paths);

			if ($this->update_user($user->id, $data, $currentGroups)) {
				$this->update_company_details($user->id);
				$this->update_user_plan($user->id);

				$this->send_success_message();
				return false;
			} else {
				$this->send_error_message($this->ion_auth->errors());
				return false;
			}
		}

		$this->send_error_message(validation_errors() ?: $this->ion_auth->errors() ?: $this->session->flashdata('message'));
		return false;
	}

	private function is_valid_user_id($id)
	{
		return !empty($id) && is_numeric($id);
	}

	private function has_permission($id)
	{
		return $this->ion_auth->logged_in() &&
			($this->ion_auth->is_admin() ||
				permissions('user_edit') ||
				permissions('client_edit') ||
				$this->ion_auth->in_group(3) ||
				$this->ion_auth->user()->row()->id == $id);
	}

	private function send_error_message($message_key)
	{
		$this->data['error'] = true;
		$this->data['message'] = $this->lang->line($message_key) ?: $message_key;
		echo json_encode($this->data);
	}

	private function set_form_validation_rules()
	{
		$this->form_validation->set_rules('update_id', 'User ID', 'trim|required|strip_tags|xss_clean|is_numeric');
		$this->form_validation->set_rules('plan_id', 'Plan ID', 'trim|strip_tags|xss_clean|is_numeric');
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|strip_tags|xss_clean');

		if ($this->input->post('password')) {
			$this->form_validation->set_rules('old_password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
			$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
		}
	}

	private function validate_old_password($hash_password_db)
	{
		$old_password = $this->input->post('old_password');
		return $this->ion_auth->verify_password($old_password, $hash_password_db);
	}

	private function handle_file_upload($field_name, $upload_path)
	{
		$profile_pic = '';

		if (!empty($_FILES[$field_name]['name'])) {
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0775, true);
			}

			$config = [
				'upload_path'   => $upload_path,
				'allowed_types' => 'jpg|png|',
				'overwrite'     => false,
				'max_size'      => 0,
				'max_width'     => 0,
				'max_height'    => 0
			];

			$this->load->library('upload', $config);

			if ($this->upload->do_upload($field_name)) {
				$profile_pic = $this->upload->data('file_name');
				if ($this->input->post('old_profile_pic')) {
					$unlink_path = $upload_path . $this->input->post('old_profile_pic');
					unlink($unlink_path);
				}
			}
		}

		return $profile_pic;
	}

	private function handle_multiple_file_upload($field_name, $upload_path)
	{
		$document_paths = [];

		if (!empty($_FILES[$field_name]['name'])) {
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0775, true);
			}

			$config = [
				'upload_path'   => $upload_path,
				'allowed_types' => '*',
				'overwrite'     => false,
				'max_size'      => 0,
				'max_width'     => 0,
				'max_height'    => 0
			];

			$this->load->library('upload', $config);

			foreach ($_FILES[$field_name]['name'] as $key => $document_name) {
				if (!empty($document_name)) {
					$field_name = "{$field_name}[{$key}]";
					$_FILES[$field_name] = [
						'name'     => $_FILES[$field_name]['name'],
						'type'     => $_FILES[$field_name]['type'],
						'tmp_name' => $_FILES[$field_name]['tmp_name'],
						'error'    => $_FILES[$field_name]['error'],
						'size'     => $_FILES[$field_name]['size']
					];

					if ($this->upload->do_upload($field_name)) {
						$document_paths[] = $this->upload->data('file_name');
					}
				}
			}
		}

		return $document_paths;
	}

	private function delete_old_documents()
	{
		$upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/documents/';
		foreach ($this->input->post('documents') as $value) {
			$unlink_path = $upload_path . $value;
			unlink($unlink_path);
		}
	}

	private function prepare_user_data($user, $profile_pic, $document_paths)
	{
		$probation_period = $this->input->post('probation_period');
		$joinDate = date("Y-m-d", strtotime($this->input->post('join_date')));
		if ($probation_period >= 1 && $probation_period <= 3) {
			$joinDate = (new DateTime($joinDate))->modify("+$probation_period months")->format('Y-m-d');
		}

		$resigned = $this->input->post('resigned') == 'on';
		$resign_date = $resigned ? date("Y-m-d", strtotime($this->input->post('resign_date'))) : null;

		return [
			'first_name'      => $this->input->post('first_name'),
			'last_name'       => $this->input->post('last_name'),
			'company'         => $this->input->post('company'),
			'father_name'     => $this->input->post('father_name') ?: '',
			'phone'           => $this->input->post('phone'),
			'gender'          => $this->input->post('gender') ?: '',
			'martial_status'  => $this->input->post('martial_status'),
			'cnic'            => $this->input->post('cnic') ?: '',
			'desgnation'      => $this->input->post('desgnation') ?: '',
			'department'      => $this->input->post('department') ?: '',
			'join_date'       => $this->input->post('join_date') ?: $user->join_date,
			'emg_person'      => $this->input->post('emg_person') ?: '',
			'emg_number'      => $this->input->post('emg_number') ?: '',
			'employee_id'     => $this->input->post('employee_id') ?: '',
			'blood_group'     => $this->input->post('blood_group') ?: '',
			'device_id'       => $this->input->post('device') ? json_encode([$this->input->post('device')]) : '[]',
			'remarks'         => $resigned ? ($this->input->post('remarks') ?: '') : '',
			'probation'       => $probation_period >= 1 && $probation_period <= 3 ? $joinDate : '',
			'resign_date'     => $resign_date,
			'address'         => $this->input->post('address') ?: '',
			'DOB'             => $this->input->post('date_of_birth') ? date("Y-m-d", strtotime($this->input->post('date_of_birth'))) : '',
			'finger_config'   => $this->input->post('finger_config') ? '1' : '0',
			'documents'       => json_encode($document_paths),
			'shift_id'        => $this->input->post('type') ?: '1',
			'profile'         => $profile_pic,
			'password'        => $this->input->post('password')
		];
	}

	private function update_user($user_id, $data, $currentGroups)
	{
		if ($this->ion_auth->update($user_id, $data)) {
			$groupData = $this->input->post('groups');
			if ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3)) {
				if (!empty($groupData) && $currentGroups[0]->id != $groupData) {
					$this->ion_auth->remove_from_group('', $user_id);
					$this->ion_auth->add_to_group($groupData, $user_id);
				}
			}
			return true;
		}
		return false;
	}

	private function update_company_details($user_id)
	{
		if ($this->input->post('company')) {
			$company_details = company_details('', $user_id);
			$cdata_json = [
				'company_name' => $this->input->post('company') ?: ($company_details->company_name ?? ''),
				'address'      => $company_details->address ?? '',
				'city'         => $company_details->city ?? '',
				'state'        => $company_details->state ?? '',
				'country'      => $company_details->country ?? '',
				'zip_code'     => $company_details->zip_code ?? ''
			];

			$this->settings_model->save_settings('company_' . $user_id, ['value' => json_encode($cdata_json)]);
		}
	}

	private function update_user_plan($user_id)
	{
		if ($this->input->post('plan_id')) {
			$plan = $this->plans_model->get_plans($this->input->post('plan_id'));

			$users_plans_data = [
				'plan_id' => $this->input->post('plan_id'),
				'end_date' => $plan[0]['billing_type'] == "One Time" ? NULL : format_date($this->input->post('end_date'), "Y-m-d"),
				'expired' => $plan[0]['billing_type'] == "One Time" ? 1 : (date("Y-m-d") > format_date($this->input->post('end_date'), "Y-m-d") ? 0 : 1)
			];

			$this->plans_model->update_users_plans($user_id, $users_plans_data);
		}
	}

	private function send_success_message()
	{
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		$this->session->set_flashdata('message_type', 'success');

		$this->data['error'] = false;
		$this->data['message'] = $this->ion_auth->messages();
		echo json_encode($this->data);
	}


	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect_to_index();
		}

		// ANCHOR  validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// ANCHOR  check to see if we are creating the group
				// ANCHOR  redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		} else {
			// ANCHOR  display the create group form
			// ANCHOR  set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = [
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			];
			$this->data['description'] = [
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			];

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// ANCHOR  bail if no group id given
		if (!$id || empty($id)) {
			redirect_to_index();
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect_to_index();
		}

		$group = $this->ion_auth->group($id)->row();

		// ANCHOR  validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
					'description' => $_POST['group_description']
				));

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// ANCHOR  set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// ANCHOR  pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = [
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
		];
		if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
			$this->data['group_name']['readonly'] = 'readonly';
		}

		$this->data['group_description'] = [
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		];

		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return [$key => $value];
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		if ($returnhtml) {
			return $view_html;
		}
	}
	public function create_company()
	{
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
		if ($this->form_validation->run() == TRUE) {
			$setting_type = 'company_' . $this->input->post('saas_id');
			$data_json = array(
				'company_name' => $this->input->post('company_name'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country'),
				'zip_code' => $this->input->post('zip_code'),
			);

			$data = array(
				'value' => json_encode($data_json)
			);
			if ($this->settings_model->save_settings($setting_type, $data)) {
				$this->data['error'] = false;
				$this->data['data'] = $data_json;
				$this->data["saas_id"] = $this->ion_auth->encryptId($this->input->post('saas_id'), 'GeekForGeek');
				$this->data['message'] = $this->lang->line('company_setting_saved') ? $this->lang->line('company_setting_saved') : "Company Setting Saved.";
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
	}
	public function save_departments()
	{
		$this->form_validation->set_rules('department_name[]', 'Department Name', 'trim|required|strip_tags|xss_clean');
		if ($this->form_validation->run() == TRUE) {
			$departments = $this->input->post('department_name');
			foreach ($departments as $department) {
				$data = array(
					'saas_id' => $this->input->post('saas_id'),
					'company_name' => '',
					'department_name' => $department,
				);
				$id = $this->department_model->create($data);
			}
			$this->data['error'] = false;
			$this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
			$this->session->set_flashdata('message_type', 'success');
			$this->data["saas_id"] = $this->ion_auth->encryptId($this->input->post('saas_id'), 'GeekForGeek');
			$this->data['message'] = $this->lang->line('company_setting_saved') ? $this->lang->line('company_setting_saved') : "Company Setting Saved.";
			echo json_encode($this->data);
		} else {
			$this->data['error'] = true;
			$this->data['message'] = validation_errors();
			echo json_encode($this->data);
		}
	}
	public function save_roles()
	{
		$this->form_validation->set_rules('description[]', 'Name', 'trim|required|strip_tags|xss_clean');
		$this->form_validation->set_rules('descriptive_name[]', 'Description', 'trim|strip_tags|xss_clean');

		$permissions = '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88"]';

		$change_permissions_of = $this->input->post('change_permissions_of') ? $this->input->post('change_permissions_of') : 0;
		$change_permissions_of = json_encode($change_permissions_of);

		if ($this->form_validation->run() == TRUE) {
			$descriptions = $this->input->post('description');
			$descriptive_name = $this->input->post('descriptive_name');
			foreach ($descriptions as $key => $description) {
				$data = array(
					'saas_id' => $this->input->post('saas_id'),
					'name' => str_replace(' ', '_', strtolower($description)),
					'description' => $description,
					'descriptive_name' => $descriptive_name[$key],
					'permissions' => $permissions,
					'assigned_users' => '',
					'change_permissions_of' => '',
				);

				$id = $this->settings_model->roles_create($data);

				$data_json = array(
					'project_view' => 0,
					'project_create' => 0,
					'project_edit' => 0,
					'project_delete' => 0,
					'task_view' => 0,
					'task_create' => 0,
					'task_edit' => 0,
					'task_delete' => 0,
					'user_view' => 0,
					'user_edit' => 0,
					'client_view' => 0,
					'setting_view' => 0,
					'setting_update' => 0,
					'todo_view' => 0,
					'notes_view' => 0,
					'chat_view' => 0,
					'chat_delete' => 0,
					'team_members_and_client_can_chat' => 0,
					'task_status' => 0,
					'project_budget' => 0,
					'gantt_view' => 0,
					'gantt_edit' => 0,
					'calendar_view' => 0,
					'meetings_view' => 0,
					'meetings_create' => 0,
					'meetings_edit' => 0,
					'meetings_delete' => 0,
					'lead_view' => 0,
					'lead_create' => 0,
					'lead_edit' => 0,
					'lead_delete' => 0,
				);

				$data = array(
					'value' => json_encode($data_json)
				);
				$setting_type = str_replace(' ', '_', strtolower($description)) . '_permissions_' . $this->input->post('saas_id');

				$this->settings_model->save_settings($setting_type, $data);
			}
			$this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
			$this->session->set_flashdata('message_type', 'success');
			$this->data['error'] = false;
			$this->data["saas_id"] = $this->ion_auth->encryptId($this->input->post('saas_id'), 'GeekForGeek');
			$this->data['message'] = $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.";
			echo json_encode($this->data);
		} else {
			$this->data['error'] = true;
			$this->data['message'] = validation_errors();
			echo json_encode($this->data);
		}
	}
}
