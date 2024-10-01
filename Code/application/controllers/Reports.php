<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function attendance()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('reports_view')) && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Attendance Report - ' . company_name();
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query4 = $this->db->get('shift');
			$this->data['shifts'] = $query4->result_array();
			$this->db->where('saas_id', $saas_id);
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$this->data['main_page'] = 'Attendance Report';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if ($this->ion_auth->is_admin() || is_all_users()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}
			$this->load->view('pages/attendance/report/report-attendance', $this->data);
		} else {
			redirect_to_index();
		}
	}
	protected function user_duration($join_date)
	{
		$current_date = new DateTime();
		$join_date = new DateTime($join_date);
		$interval = $current_date->diff($join_date);
		$years = $interval->y;
		$months = $interval->m;
		return "{$years} years, {$months} months";
	}
	public function get_attendance_report()
	{
		$saas_id = $this->session->userdata('saas_id');
		$finger_config = '1';
		$active = '1';
		$start_from = date('Y-m-01');
		$end_date = date('Y-m-d');
		$get = $this->input->get();
		if (!empty($get['user_id'])) {
			$employees = $this->ion_auth->user($get['user_id'])->result();
		} else {
			$users = $this->ion_auth->members()->result();
			// Get desired department and shift from input
			$desired_department = isset($get['department']) ? $get['department'] : '';
			$desired_shift = isset($get['shifts']) ? $get['shifts'] : '';

			// Loop through each employee
			foreach ($users as $employee) {
				$match = true;
				if (!empty($desired_shift) && $employee->shift_id != $desired_shift) {
					$match = false;
				}
				if (!empty($desired_department) && $employee->department != $desired_department) {
					$match = false; 
				}
				if ($match) {
					$employees[] = $employee;
				}
			}
		}
		$detail = [];
		$header1 = ['ID', 'Name', 'Joining Date', 'Job Period'];
		$header2 = ['', '', '', ''];
		$leave_types = $this->att_model->get_db_leave_types2();
		foreach ($leave_types as $leave_type) {
			$header1[] = $leave_type->name;
			$header1[] = '';
			$header2[] = 'Allowed';
			$header2[] = 'Actual';
		}
		$header1 = array_merge($header1, ['Total Paid Leaves', 'Balance', 'Unpaid', 'Absents', 'Late Min']);
		$header2 = array_merge($header2, ['', '', '', '', '']);
		$detail[] = $header1;
		$detail[] = $header2;
		foreach ($employees as $employee) {
			if ($employee->active == $active && $employee->finger_config == $finger_config) {
				$employee_id = $employee->employee_id;
				$employee_leaves = [];
				$total_paid_consumed = 0;
				$total_remaining = 0;
				$unpaid_leaves = 0;
				foreach ($leave_types as $leave_type) {
					$paid_leaves = 0;
					$leave_total = $this->att_model->get_total_of_leave_type_for_user($leave_type, $employee, $end_date);
					$leaves = $this->att_model->get_db_leaves($employee_id, $start_from, $end_date, $leave_type->id);
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

					if ($leave_type->apply_on == 'all') {
						$employee_leaves[] = $leave_total;
					} elseif (($employee->gender == 'male' && $employee->martial_status == 'married') && $leave_type->apply_on == 'malemarried') {
						$employee_leaves[] = $leave_total;
					} elseif (($employee->gender == 'male' && $employee->martial_status == 'single') && $leave_type->apply_on == 'male') {
						$employee_leaves[] = $leave_total;
					} elseif (($employee->gender == 'female' && $employee->martial_status == 'married') && $leave_type->apply_on == 'femalemarried') {
						$employee_leaves[] = $leave_total;
					} elseif (($employee->gender == 'female' && $employee->martial_status == 'single') && $leave_type->apply_on == 'female') {
						$employee_leaves[] = $leave_total;
					} else {
						$leave_total = 0;
						$employee_leaves[] = 0;
					}
					$employee_leaves[] = $paid_leaves;
					$total_paid_consumed += $paid_leaves;
					$total_remaining += $leave_total - $paid_leaves;
				}

				$attendance = $this->att_model->get_attendance($employee_id, $start_from, $end_date);
				$late_min = $this->att_model->get_late_min($employee_id, $start_from, $end_date);
				$absents = $this->att_model->get_absents($employee_id, $start_from, $end_date, $attendance);
				$detail[] = array_merge([
					'<a href="#">' . $employee_id . '</a>',
					'<a href="#">' . $employee->first_name . ' ' . $employee->last_name . '</a>',
					date('d-m-Y', strtotime($employee->join_date)),
					$this->user_duration($employee->join_date),
				], $employee_leaves, [$total_paid_consumed], [$total_remaining], [$unpaid_leaves], [$absents], [$late_min]);
			}
		}
		echo json_encode($detail);
	}
	public function custom_report_attendance()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('reports_view')) && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Attendance Report - ' . company_name();
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query4 = $this->db->get('shift');
			$this->data['shifts'] = $query4->result_array();
			$this->db->where('saas_id', $saas_id);
			$query3 = $this->db->get('departments');
			$this->data['departments'] = $query3->result_array();
			$this->data['main_page'] = 'Attendance Report';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if ($this->ion_auth->is_admin() || is_all_users()) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (is_assign_users()) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}
			$this->load->view('pages/attendance/report/custom-report', $this->data);
		} else {
			redirect_to_index();
		}
	}


	public function leaves()
	{
		if ($this->ion_auth->logged_in()  && is_module_allowed('leaves') && ($this->ion_auth->in_group(1) || permissions('leaves_view'))) {
			$this->data['page_title'] = 'Leaves - ' . company_name();
			$this->data['main_page'] = 'Leaves Application';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			if ($this->ion_auth->is_admin() || permissions('leaves_view_all')) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (permissions('leaves_view_selected')) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}
			$saas_id = $this->session->userdata('saas_id');
			$this->db->where('saas_id', $saas_id);
			$query = $this->db->get('leaves_type');
			$this->data['leaves_types'] = $query->result_array();
			// echo json_encode($this->data["leaves_types"]);
			$this->load->view('leaves', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function timesheet()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Timesheet - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			// $userRow = $this->attendance_model->get_user_by_active();
			// $this->data['system_users'] = $userRow;
			if ($this->ion_auth->is_admin() || permissions('task_view_all')) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (permissions('task_view_selected')) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}

			if (($this->ion_auth->is_admin() || permissions('task_view_all') || permissions('task_view_selected'))) {
				if (isset($_GET['user']) && !empty($_GET['user']) && is_numeric($_GET['user'])) {
					$this->data['projects'] = $this->projects_model->get_projects($_GET['user']);
				} else {
					$this->data['projects'] = $this->projects_model->get_projects();
				}
			} else {
				$this->data['projects'] = $this->projects_model->get_projects($this->session->userdata('user_id'));
			}

			if ($this->ion_auth->is_admin() || permissions('task_view_all') || permissions('task_view_selected')) {
				if (isset($_GET['user']) && !empty($_GET['user']) && is_numeric($_GET['user'])) {
					$this->data['tasks'] = $this->projects_model->get_tasks($_GET['user']);
				} else {
					$this->data['tasks'] = $this->projects_model->get_tasks();
				}
			} else {
				$this->data['tasks'] = $this->projects_model->get_tasks($this->session->userdata('user_id'));
			}

			$this->load->view('report-timesheet', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function estimates()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Estimates - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['system_clients'] = $this->ion_auth->users(4)->result();
			$this->load->view('report-estimates', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function leads()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Leads - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->data['system_users'] = $this->ion_auth->members()->result();
			$this->load->view('report-leads', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function meetings()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Video Meetings - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('report-meetings', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function clients()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Clients - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->load->view('report-clients', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function team()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Team Members - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

			$this->load->view('report-team', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function tasks()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {

			$this->data['page_title'] = 'Tasks - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			// $userRow = $this->attendance_model->get_user_by_active();
			// $this->data['system_users'] = $userRow;
			if ($this->ion_auth->is_admin() || permissions('task_view_all')) {
				$this->data['system_users'] = $this->ion_auth->members()->result();
			} elseif (permissions('task_view_selected')) {
				$selected = selected_users();
				foreach ($selected as $user_id) {
					$users[] = $this->ion_auth->user($user_id)->row();
				}
				$users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
				$this->data['system_users'] = $users;
			}

			$this->data['projecr_users'] = $this->projects_model->get_project_users();

			$this->data['task_status'] = task_status();
			$this->data['task_priorities'] = priorities();

			$this->data['projects'] = $this->projects_model->get_projects();

			$this->load->view('report-tasks', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function projects()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {
			$this->data['page_title'] = 'Projects - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();

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
			$this->data['system_clients'] = $this->ion_auth->users(4)->result();

			$this->data['project_status'] = project_status();

			$this->data['projects_all'] = $this->projects_model->get_projects();

			$this->load->view('report-projects', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function expenses()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {
			$this->data['page_title'] = 'Expenses - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('report-expenses', $this->data);
		}
	}

	public function get_expenses()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			$results = $this->expenses_model->get_expenses_chart();
			$rows = array();
			$tempRow = array();
			if ($results) {
				if ($this->input->get('from')) {
					$from = format_date($this->input->get('from'), "Y-m-d");
				} else {
					$from = date("Y-m-d");
				}

				if ($this->input->get('too') != '') {
					$too = format_date($this->input->get('too'), "Y-m-d");
				} else {
					$too = date("Y-m-d");
				}
				foreach ($results as $result) {
					if ($result['date'] >= $from && $result['date'] <= $too) {
						$tempRow = $result;
						$tempRow['date'] = format_date($result['date'], system_date_format());
						$rows[] = $tempRow;
					}
				}

				print_r(json_encode($rows));
			} else {
				return '';
			}
		} else {
			return '';
		}
	}


	public function get_expenses_chart()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			if ($this->input->post('from')) {
				$from = new DateTime($this->input->post('from'));
			} else {
				$from = new DateTime();
			}

			if ($this->input->post('too')) {
				$too = new DateTime($this->input->post('too'));
			} else {
				$too = new DateTime();
			}

			$begin = $from;
			$end = $too;

			$end = $end->modify('+1 day');
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$dates = array();
			$dates_formated = array();
			foreach ($period as $dt) {
				$dates[] = $dt->format("Y-m-d");
				$dates_formated[] = $dt->format(system_date_format());
			}

			$expenses = $this->expenses_model->get_expenses_chart();
			foreach ($dates as $key => $date) {
				if ($expenses) {
					$expens[$key] = 0;
					foreach ($expenses as $expense) {
						if ($expense['date'] == $date) {
							$expens[$key] = $expense['amount'];
						}
					}
				} else {
					$expens[$key] = 0;
				}
			}

			$this->data['dates'] = $dates_formated;
			$this->data['expenses'] = $expens;
			echo json_encode($this->data);
		} else {
			$this->data['dates'] = array();
			$this->data['expenses'] = array();
			echo json_encode($this->data);
		}
	}

	public function income()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {
			$this->data['page_title'] = 'Income - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('report-income', $this->data);
		}
	}

	public function get_income($invoice_id = '')
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			$temp = array();
			$temprow = array();
			$invoices = $this->invoices_model->get_invoices($invoice_id, true);
			if ($invoices) {
				if ($this->input->get('from')) {
					$from = format_date($this->input->get('from'), "Y-m-d");
				} else {
					$from = date("Y-m-d");
				}

				if ($this->input->get('too') != '') {
					$too = format_date($this->input->get('too'), "Y-m-d");
				} else {
					$too = date("Y-m-d");
				}
				foreach ($invoices as $key => $invoice) {

					if ($invoice['payment_date'] >= $from && $invoice['payment_date'] <= $too) {
						$temp = $invoice;
						$temp['invoice_id'] = '<a href="' . (base_url('invoices/view/' . $invoice['id'])) . '" target="_blank"><strong>' . $invoice['invoice_id'] . '</strong></a>';
						$temp['to_id'] = $invoice['to_user'];
						$temp['due_date'] = format_date($invoice['due_date'], system_date_format());
						$temp['payment_date'] = $invoice['payment_date'] ? format_date($invoice['payment_date'], system_date_format()) : '';

						$amount = $invoice['amount'];

						if ($invoice['tax'] && $invoice['tax'] != '') {
							$total_tax_per = 0;
							if (is_numeric($invoice['tax'])) {
								$taxes = get_tax($invoice['tax']);
								if ($taxes) {
									$total_tax_per = $total_tax_per + $taxes[0]['tax'];
								}
							} else {
								foreach (explode(',', $invoice['tax']) as $tax_id) {
									$taxes = get_tax($tax_id);
									if ($taxes) {
										$total_tax_per = $total_tax_per + $taxes[0]['tax'];
									}
								}
							}
							if ($total_tax_per != 0) {
								$total_tax = $amount * $total_tax_per / 100;
							} else {
								$total_tax = 0;
							}
							$amount = $amount + $total_tax;
						}

						$projects = '';
						if (is_numeric($invoice['items_id'])) {
							$project = $this->projects_model->get_projects('', $invoice['items_id']);
							if ($project) {
								$projects .= '<a href="' . (base_url('projects/detail/' . $project[0]['id'])) . '" target="_blank">' . $project[0]['title'] . '</a><br>';
							}
						} else {
							foreach (explode(',', $invoice['items_id']) as $project_id) {
								$project = $this->projects_model->get_projects('', $project_id);
								if ($project) {
									$projects .= '<a href="' . (base_url('projects/detail/' . $project[0]['id'])) . '" target="_blank">' . $project[0]['title'] . '</a><br>';
								}
							}
						}

						if (!empty($projects)) {
							$temp['projects'] = $projects;
						} else {
							$temp['projects'] = $invoice['to_user'];
						}

						$temp['amount'] = round($amount);

						if ($invoice['status'] == 0 || $invoice['status'] == 2) {
							$temp['status'] = '<div class="badge badge-info">' . ($this->lang->line('pending') ? $this->lang->line('pending') : 'Pending') . '</div>';
						} elseif ($invoice['status'] == 1) {
							$temp['status'] = '<div class="badge badge-success">' . ($this->lang->line('paid') ? $this->lang->line('paid') : 'Paid') . '</div>';
						} elseif ($invoice['status'] == 3) {
							$temp['status'] = '<div class="badge badge-danger">' . ($this->lang->line('rejected') ? $this->lang->line('rejected') : 'Rejected') . '</div>';
						}
						$temprow[] = $temp;
					}
				}
				return print_r(json_encode($temprow));
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	public function get_income_chart()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			if ($this->input->post('from')) {
				$from = new DateTime($this->input->post('from'));
			} else {
				$from = new DateTime();
			}

			if ($this->input->post('too')) {
				$too = new DateTime($this->input->post('too'));
			} else {
				$too = new DateTime();
			}

			$begin = $from;
			$end = $too;

			$end = $end->modify('+1 day');
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$dates = array();
			$dates_formated = array();
			foreach ($period as $dt) {
				$dates[] = $dt->format("Y-m-d");
				$dates_formated[] = $dt->format(system_date_format());
			}

			$invoices = $this->invoices_model->get_invoices('', true);
			foreach ($dates as $key => $date) {

				if ($invoices) {
					$income[$key] = 0;
					foreach ($invoices as $invoice) {

						if ($invoice['payment_date'] == $date) {
							$amount = $invoice['amount'];

							if ($invoice['tax'] && $invoice['tax'] != '') {
								$total_tax_per = 0;
								if (is_numeric($invoice['tax'])) {
									$taxes = get_tax($invoice['tax']);
									if ($taxes) {
										$total_tax_per = $total_tax_per + $taxes[0]['tax'];
									}
								} else {
									foreach (explode(',', $invoice['tax']) as $tax_id) {
										$taxes = get_tax($tax_id);
										if ($taxes) {
											$total_tax_per = $total_tax_per + $taxes[0]['tax'];
										}
									}
								}
								if ($total_tax_per != 0) {
									$total_tax = $amount * $total_tax_per / 100;
								} else {
									$total_tax = 0;
								}
								$amount = $amount + $total_tax;
							}
							$income[$key] = round($amount);
						}
					}
				} else {
					$income[$key] = 0;
				}
			}

			$this->data['dates'] = $dates_formated;
			$this->data['income'] = $income;
			echo json_encode($this->data);
		} else {
			$this->data['dates'] = array();
			$this->data['income'] = array();
			echo json_encode($this->data);
		}
	}

	public function index()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))  && is_module_allowed('reports')) {
			$this->data['page_title'] = 'Income VS Expenses - ' . company_name();
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->load->view('report-income-vs-expenses', $this->data);
		} else {
			redirect_to_index();
		}
	}

	public function get_income_vs_expenses_chart()
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			if ($this->input->post('from')) {
				$from = new DateTime($this->input->post('from'));
			} else {
				$from = new DateTime();
			}

			if ($this->input->post('too')) {
				$too = new DateTime($this->input->post('too'));
			} else {
				$too = new DateTime();
			}

			$begin = $from;
			$end = $too;

			$end = $end->modify('+1 day');
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$dates = array();
			$dates_formated = array();
			foreach ($period as $dt) {
				$dates[] = $dt->format("Y-m-d");
				$dates_formated[] = $dt->format(system_date_format());
			}

			$invoices = $this->invoices_model->get_invoices('', true);
			$expenses = $this->expenses_model->get_expenses_chart();
			foreach ($dates as $key => $date) {
				if ($expenses) {
					$expens[$key] = 0;
					foreach ($expenses as $expense) {
						if ($expense['date'] == $date) {
							$expens[$key] = $expense['amount'];
						}
					}
				} else {
					$expens[$key] = 0;
				}
				if ($invoices) {
					$income[$key] = 0;
					foreach ($invoices as $invoice) {
						if ($invoice['payment_date'] == $date) {
							$amount = $invoice['amount'];

							if ($invoice['tax'] && $invoice['tax'] != '') {
								$total_tax_per = 0;
								if (is_numeric($invoice['tax'])) {
									$taxes = get_tax($invoice['tax']);
									if ($taxes) {
										$total_tax_per = $total_tax_per + $taxes[0]['tax'];
									}
								} else {
									foreach (explode(',', $invoice['tax']) as $tax_id) {
										$taxes = get_tax($tax_id);
										if ($taxes) {
											$total_tax_per = $total_tax_per + $taxes[0]['tax'];
										}
									}
								}
								if ($total_tax_per != 0) {
									$total_tax = $amount * $total_tax_per / 100;
								} else {
									$total_tax = 0;
								}
								$amount = $amount + $total_tax;
							}
							$income[$key] = round($amount);
						}
					}
				} else {
					$income[$key] = 0;
				}
			}

			$this->data['dates'] = $dates_formated;
			$this->data['income'] = $income;
			$this->data['expenses'] = $expens;
			echo json_encode($this->data);
		} else {
			$this->data['dates'] = array();
			$this->data['income'] = array();
			$this->data['expenses'] = array();
			echo json_encode($this->data);
		}
	}

	public function get_income_vs_expenses($send_array = false)
	{
		if ($this->ion_auth->logged_in() &&  ($this->ion_auth->is_admin() || permissions('reports_view'))) {
			$get = $this->input->get();

			if (isset($get['from'])) {
				$from = new DateTime($get['from']);
			} else {
				$from = new DateTime();
			}

			if (isset($get['too'])) {
				$too = new DateTime($get['too']);
			} else {
				$too = new DateTime();
			}

			$begin = $from;
			$end = $too;
			$end = $end->modify('+1 day');
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$dates = array();
			foreach ($period as $dt) {
				$dates[] = $dt->format("Y-m-d");
			}

			$temp = array();
			$rows = array();
			$invoices = $this->invoices_model->get_invoices('', true);
			$expenses = $this->expenses_model->get_expenses_chart();

			foreach ($dates as $key =>  $date) {
				if ($expenses) {
					$expens = 0;
					foreach ($expenses as $expense) {
						if ($expense['date'] == $date) {
							$expens += $expense['amount'];
						}
					}
				} else {
					$expens = 0;
				}
				if ($invoices) {
					$income = 0;
					foreach ($invoices as $invoice) {

						if ($invoice['payment_date'] == $date) {
							$amount = $invoice['amount'];

							if ($invoice['tax'] && $invoice['tax'] != '') {
								$total_tax_per = 0;
								if (is_numeric($invoice['tax'])) {
									$taxes = get_tax($invoice['tax']);
									if ($taxes) {
										$total_tax_per = $total_tax_per + $taxes[0]['tax'];
									}
								} else {
									foreach (explode(',', $invoice['tax']) as $tax_id) {
										$taxes = get_tax($tax_id);
										if ($taxes) {
											$total_tax_per = $total_tax_per + $taxes[0]['tax'];
										}
									}
								}
								if ($total_tax_per != 0) {
									$total_tax = $amount * $total_tax_per / 100;
								} else {
									$total_tax = 0;
								}
								$amount = $amount + $total_tax;
							}
							$income += round($amount);
						}
					}
				} else {
					$income = 0;
				}
				$temp['date'] = format_date($date, system_date_format());
				$temp['income'] = $income;
				$temp['expenses'] = $expens;
				$temp['profit'] = $income - $expens;

				$rows[] = $temp;
			}
			if ($send_array) {
				return $rows;
			} else {
				return print_r(json_encode($rows));
			}
		} else {
			return '';
		}
	}
}
