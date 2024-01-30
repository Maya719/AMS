<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->data['page_title'] = 'Dashboard - '.company_name();
			$this->data['main_page'] = 'Dashboard ';
			$this->data['current_user'] = $this->ion_auth->user()->row();
			$this->data['system_users'] = $this->ion_auth->users(array(1,2,4))->result();
			$this->data['project_status'] = project_status();
			$this->data['task_status'] = task_status();
			if($this->ion_auth->in_group(3)){
				$this->data['plans'] = $this->plans_model->get_plans();
				$this->data['transaction_chart'] = $this->plans_model->get_transaction_chart();
				$this->load->view('saas-home',$this->data);
			}else{
				$system_users = $this->ion_auth->members_all()->result();
				$this->data["report"] = $this->attendance_model->get_count_abs();
				$this->data["events"] = $this->home_model->Get_events();
				$this->load->view('home',$this->data);
			}
		}else{
			redirect('auth', 'refresh');
		}
	}
	public function get_home_attendance(){

		$get = $this->input->get();
		$dateRec = $get["date"];
		$dateObject = date_create($dateRec);
		$date = $dateObject->format('Y-m-d');
		if($this->ion_auth->is_admin() || permissions('attendance_view_all') || permissions('attendance_view_selected')){
			$attendance = $this->home_model->get_home_attendance_for_admin($date);
			$count = $this->home_model->filter_count_abs($date);
		}
		
		echo json_encode(array(
			'attendance'=>$attendance,
			'counts'=>$count
		));
	}


}

