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
        $start_from = date('Y-m-01');
        $end_date = date('Y-m-d');
        $data = $this->att_model->get_attendance('1859', $start_from, $end_date);
        echo json_encode($data);
    }

    public function get_absents()
    {
        $start_from = date('Y-01-01');
        $end_date = date('Y-01-01');
        $data = $this->att_model->get_absents('1950', $start_from, $end_date);
        echo json_encode($data);
    }

    public function get_late_min()
    {
        $late_min = 0;
        $start_from = new DateTime(date('Y-01-01'));
        $end_date = new DateTime(date('Y-08-12'));
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start_from, $interval, $end_date);
        $shift_id = $this->shift_model->get_user_shift('952')->id;
        foreach ($period as $date) {
            $formatted_date = $date->format('Y-m-d');
            $shift = $this->shift_model->get_shift_log_by_id($shift_id, $formatted_date);
            $shift_start = $shift["starting_time"];
            $shift_end = $shift["ending_time"];
            $late_min += $this->att_model->get_late_min('952', $formatted_date, $formatted_date, $shift_start, $shift_end);
        }
        echo json_encode($late_min);
    }
}
