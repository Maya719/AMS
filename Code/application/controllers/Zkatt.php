<?php defined('BASEPATH') or exit('No direct script access allowed');
class Zkatt extends CI_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_attendance()
    {
        $start_from = date('Y-08-07');
        $end_date = date('Y-08-10');
        $data = $this->att_model->get_attendance('170', $start_from, $end_date);
        echo json_encode($data);
    }

    public function single_user_attendance()
    {
        $start_from = date('Y-01-01');
        $end_date = date('Y-m-d');
        $data = $this->att_model->get_attendance('1995', $start_from, $end_date);
        $late_min = $this->att_model->get_late_min('1995', $start_from, $end_date,$data);
        $absents = ($this->att_model->get_absents('1995', $start_from, $end_date,$data));
        $leaves = $this->leaves_model->get_db_leaves('1995', $start_from, $end_date);
        echo json_encode(array('late_min'=>$late_min,'absents'=> $absents,'leaves'=>$leaves));
    }
    public function get_late_min()
    {
        $start_from = date('Y-03-11');
        $end_date = date('Y-04-30');
        $late_min = $this->att_model->get_late_min('1980', $start_from, $end_date);
        echo $late_min;
    }

    public function get_leaves()
    {
        $absents = 0;
        $start_from = date('Y-01-01');
        $end_date = date('Y-m-d');
        $absents = $this->leaves_model->get_db_leaves('1615', $start_from, $end_date);
        echo json_encode($absents);
    }
    public function get_absents()
    {
        $absents = 0;
        $start_from = date('Y-01-01');
        $end_date = date('Y-01-10');
        $absents = $this->att_model->get_absents('1859', $start_from, $end_date);
        echo json_encode($absents);
    }
    public function get_shifts()
    {
        $start_date = date('Y-m-d');
        $shift_id = $this->shifts_model->get_user_shift('1859')->id;
        echo json_encode($this->shifts_model->get_shifts_by_id($shift_id, $start_date));
    }

    public function get_absents_today()
    {
        $start_from = date('Y-m-d');
        $end_date = $start_from;
        $absents = 0;

        if ($this->ion_auth->is_admin()) {
            $system_users = $this->ion_auth->members_all()->result();
        } elseif (is_assign_users()) {
            $selected_user_ids = selected_users();
            $current_user_id = $this->session->userdata('user_id');
            $user_ids = array_merge($selected_user_ids, [$current_user_id]);
            $system_users = array_map(function ($user_id) {
                return $this->ion_auth->user($user_id)->row();
            }, $user_ids);
        } else {
            $employee_id = $this->ion_auth->user()->row()->employee_id;
            $system_users = [$employee_id];
            $start_from = date('Y-01-01');
        }

        if (isset($employee_id)) {
            $absents = count($this->att_model->get_absents($employee_id, $start_from, $end_date));
        } else {
            foreach ($system_users as $user) {
                $user_id = $user->employee_id;
                if ($user->active == 1 && $user->finger_config == 1) {
                    $absents += count($this->att_model->get_absents($user_id, $start_from, $end_date));
                }
            }
        }

        echo $absents;
    }
}
