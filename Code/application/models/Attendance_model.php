<?php
defined('BASEPATH') or exit('No direct script access allowed');
use AgileBM\ZKLib\ZKLib;

require '../vendor/autoload.php';

class Attendance_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        if ($this->db->insert('attendance', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }

    }

    public function my_att_running($user_id)
    {

        $where = " WHERE user_id = " . $user_id;

        $where .= " AND saas_id = " . $this->session->userdata('saas_id');

        $where .= " AND check_out IS NULL ";

        $query = $this->db->query("SELECT * FROM attendance " . $where);

        $results = $query->result_array();

        return $results;
    }

    public function get_attendance_by_id($id)
    {

        $query = $this->db->query("SELECT * FROM attendance WHERE id = $id");

        $results = $query->result_array();

        return $results;
    }

    public function get_attendance()
    {
        $get = $this->input->get();
        $attendance_view_all = permissions('attendance_view_all') || permissions('attendance_view_selected');
        if ($this->ion_auth->is_admin() || $attendance_view_all) {
            $attendance = $this->get_attendance_for_admin($get);
            $formated_data = $this->formated_data($attendance, $get);
        } else {
            // $attendance = $this->get_attendance_for_user($attendance);
            $leaves = [];
            $formated_data = [];
        }
        
        echo json_encode($formated_data);
    }

    public function formated_data($attendance, $get)
    {
        $from = $get["from"];
        $too = $get["too"];
        $fromDate = new DateTime($from);
        $toDate = new DateTime($too);

        $dateArray = array();
        $interval = new DateInterval('P1D');
        $datePeriod = new DatePeriod($fromDate, $interval, $toDate->modify('+1 day'));

        foreach ($datePeriod as $date) {
            $dateArray[] = $date->format('Y-m-d');
        }

        $formattedData = [];

        foreach ($attendance as $entry) {
            $userId = $entry['user_id'];
            $user = $entry['user'];
            $finger = $entry['finger'];
            $createdDate = date("Y-m-d", strtotime($finger));
            $createdTime = date("H:i:s", strtotime($finger));

            if (!isset($formattedData[$userId])) {
                $formattedData[$userId] = [
                    'user_id'=>$userId,
                    'user' => '<a href="' . base_url('attendance/user_attendance/' . $userId) . '">' . $userId . '</a>',
                    'name' => '<a href="' . base_url('attendance/user_attendance/' . $userId) . '">' . $user . '</a>',
                    'dates' => [],
                ];
            }

            if (!isset($formattedData[$userId]['dates'][$createdDate])) {
                $formattedData[$userId]['dates'][$createdDate] = [];
            }
            $formattedData[$userId]['dates'][$createdDate][] = date('H:i A', strtotime($createdTime));
        }

        foreach ($dateArray as $date) {
            foreach ($formattedData as &$userData) {
                if (!isset($userData['dates'][$date])) {
                    $userData['dates'][$date] = [];
                }
            }
        }

        foreach ($formattedData as &$userData) {
            foreach ($dateArray as $date) {
                if (!isset($userData['dates'][$date]) || empty($userData['dates'][$date])) {
                    $user_id = $userData['user_id'];
                    // check leave
                    if($this->checkLeave($user_id, $date)){
                        $userData['dates'][$date][] = '<span class="text-success">Leave</span>';
                    }elseif ($this->holidayCheck($user_id, $date)) {
                        $userData['dates'][$date][] = '<span class="text-primary">Holiday</span>';
                    }else{
                        $userData['dates'][$date][] = '<span class="text-danger">Absent</span>';
                    }
                }
            }
        }

        $resultArray = array_values($formattedData);
        return $resultArray;
    }

    public function holidayCheck($user_id, $date){
        $this->db->select('*');
        $this->db->from('holiday');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $holidays = $query->result_array();
            foreach ($holidays as $holiday) {
                if ($holiday["apply"] == '0') {
                    return true;
                }elseif ($holiday["apply"] == '1') {
                    $user = $this->ion_auth->user($user_id)->row();
                    $department = $user->department;
                    $appliedDepart =  json_decode($holiday["department"]);
                    if (in_array($department, $appliedDepart)) {
                        return true;
                    }
                }elseif ($holiday["apply"] == '2') {
                    $appliedUser =  json_decode($holiday["users"]);
                    if (in_array($user_id, $appliedUser)) {
                        return true;
                    }
                }else{
                    
                }
            }
        } else {
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                return true;
            }else{
                return false;
            }
        }
    }
    public function checkLeave($user_id, $date){
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $user_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('paid', 0);
        $this->db->where('leave_duration NOT LIKE', '%Half%');
        $this->db->where('leave_duration NOT LIKE', '%Short%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_attendance_for_admin($get)
    {
        if (isset($get['user_id']) && !empty($get['user_id'])) {
            $user = $this->ion_auth->user($get['user_id'])->row();
            $employee_id = $user->employee_id;
            $where = " WHERE attendance.user_id = " . $employee_id;
        } else {
            $where = " WHERE attendance.id IS NOT NULL ";
        }
        if (isset($get['department']) && !empty($get['department'])) {
            $department = $get['department'];
            $where .= " AND users.department = '$department'";
        }
        if (isset($get['shifts']) && !empty($get['shifts'])) {
            $shifts = $get['shifts'];
            $where .= " AND users.shift_id = '$shifts'";
        }
        if (isset($get['from']) && !empty($get['from']) && isset($get['too']) && !empty($get['too'])) {
            $where .= " AND DATE(attendance.finger) BETWEEN '" . format_date($get['from'], "Y-m-d") . "' AND '" . format_date($get['too'], "Y-m-d") . "' ";
        }
        $leftjoin = "LEFT JOIN users ON attendance.user_id = users.employee_id";
        $where .= " AND users.saas_id=" . $this->session->userdata('saas_id') . " ";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user
        FROM attendance " . $leftjoin . $where . " AND users.active=1 AND users.finger_config=1");
        $results = $query->result_array();
        return $results;
    }


    public function get_count_abs()
    {
        $total_staff = 0;
        $abs = 0;
        $leaves = 0;
        $present = 0;
        $leave_pending = 0;
        $leave_rejected = 0;
        $leaves_approved = 0;
        $bio_pending = 0;
        $bio_approved = 0;
        $bio_rejected = 0;
        $currentDate = new DateTime();
        $todayDate = $currentDate->format('Y-m-d');
        if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
            $where = " WHERE DATE(attendance.finger) = '" . $todayDate . "' ";
        }
        $leftjoin = " LEFT JOIN users ON attendance.user_id = users.employee_id";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user 
        FROM attendance " . $leftjoin . $where);        
        $results = $query->result_array();
        $system_users = $this->ion_auth->members_all()->result();
        foreach ($system_users as $user) {
            if ($user->finger_config == '1' && $user->active == '1') {
                $total_staff++;
                $userPresent = false;
                foreach ($results as  $attendance) {
                    if ($user->employee_id == $attendance["user_id"]) {
                        $present++;
                        $userPresent = true;
                        break; 
                    }
                }
                if (!$userPresent) {
                    if ($this->checkLeave($user->id, $todayDate)) {
                        $leaves++;
                    }else {
                        $abs++;
                    }
                }
            }
        }

        $firstDayOfMonth = new DateTime('first day of ' . $currentDate->format('Y-m'));
        $fromDate = $firstDayOfMonth->format('Y-m-d');
        $leftjoin2 = " LEFT JOIN users ON leaves.user_id = users.employee_id";
        $where2 = " WHERE users.active= '1' AND users.finger_config='1' AND users.saas_id=".$this->session->userdata('saas_id');
        $where2 .= " AND leaves.starting_date >= '" . $fromDate . "' AND leaves.ending_date <= '" . $todayDate . "'";
        $leaveQuery = $this->db->query("SELECT leaves.*, CONCAT(users.first_name, ' ', users.last_name) AS user  FROM leaves ".$leftjoin2.$where2." AND leaves.leave_duration NOT LIKE '%Half%' AND leaves.leave_duration NOT LIKE '%Short%'");
        $leavesresult = $leaveQuery->result_array();
        foreach ($leavesresult as $leavesResult) {
            if ($leavesResult["status"] == '1') {
                $leaves_approved++;
            }elseif ($leavesResult["status"] == '0') {
                $leave_pending++;
            }elseif($leavesResult["status"] == '2'){
                $leave_rejected++;
            }
        }

        $leftjoin3 = " LEFT JOIN users ON biometric_missing.user_id = users.employee_id";
        $where3 = " WHERE biometric_missing.date BETWEEN '" . $fromDate . "' AND '" . $todayDate . "'";
        $BioQuery = $this->db->query("SELECT biometric_missing.*, CONCAT(users.first_name, ' ', users.last_name) AS user FROM biometric_missing " . $leftjoin3 . $where3);
        $BioResults = $BioQuery->result_array();
        foreach ($BioResults as $BioResult) {
            if ($BioResult["status"] == '1') {
                $bio_approved++;
            }elseif ($BioResult["status"] == '0') {
                $bio_pending++;
            }elseif($BioResult["status"] == '2'){
                $bio_rejected++;
            }
        }

        return $array = [
            // "system_users" => $system_users,
            "total_staff"=>$total_staff,
            "abs" => $abs,
            "leave" => $leaves,
            "present" => $present,
            "leave_pending" => $leave_pending,
            "leave_approved" => $leaves_approved,
            "leave_rejected" => $leave_rejected,
            "bio_pending" => $bio_pending,
            "bio_approved" => $bio_approved,
            "bio_rejected" => $bio_rejected,
        ];
    }

    public function get_users_by_department($department)
    {
        if ($department == '') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '1' AND finger_config = '1'");
        }if ($department != '') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '1' AND department= '$department' AND finger_config = '1'");
        }
        $results = $query->result_array();
        return $results;
    }
    public function get_users_by_shifts($shifts_id)
    {
        if ($shifts_id == '') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '1' AND finger_config = '1'");
        }
        if ($shifts_id != '') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '1' AND shift_id= '$shifts_id' AND finger_config = '1'");
        }
        $results = $query->result_array();
        return $results;
    }

    public function get_single_user_attendance($get)
    {
        $attendance_view_all = permissions('attendance_view_all') || permissions('attendance_view_selected');
        if ($this->ion_auth->is_admin() || $attendance_view_all) {
            $attendance = $this->get_single_attendance_for_admin($get["user_id"],$get["from"],$get["too"]);
            $formated_data = $this->format_single_user_attendance($attendance, $get);
        } else {
            $leaves = [];
            $formated_data = [];
        }
        return $formated_data;
    }

    public function get_single_attendance_for_admin($user_id,$from,$too){
        if (isset($user_id) && !empty($user_id)) {
            $where = " WHERE attendance.user_id = " . $user_id;
        } else {
            $where = " WHERE attendance.id IS NOT NULL ";
        }
        if (isset($from) && !empty($from) && isset($too) && !empty($too)) {
            $where .= " AND DATE(attendance.finger) BETWEEN '" . format_date($from, "Y-m-d") . "' AND '" . format_date($too, "Y-m-d") . "' ";
        }
        $leftjoin = "LEFT JOIN users ON attendance.user_id = users.employee_id";
        $where .= " AND users.saas_id=" . $this->session->userdata('saas_id') . " ";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user
        FROM attendance " . $leftjoin . $where . " AND users.active=1 AND users.finger_config=1");
        $results = $query->result_array();
        return $results;
    }

    public function format_single_user_attendance($attendance, $get)
{
    $from = $get["from"];
    $too = $get["too"];
    $fromDate = new DateTime($from);
    $toDate = new DateTime($too);

    $dateArray = array();
    $interval = new DateInterval('P1D');
    $datePeriod = new DatePeriod($fromDate, $interval, $toDate->modify('+1 day'));

    foreach ($datePeriod as $date) {
        $dateArray[] = $date->format('Y-m-d');
    }

    $formattedData = [];
    foreach ($attendance as $entry) {
        $userId = $entry['user_id'];
        $user = $entry['user'];
        $finger = $entry['finger'];
        $createdDate = date("Y-m-d", strtotime($finger));
        $createdTime = date("H:i:s", strtotime($finger));

        if (!isset($formattedData[$userId])) {
            $formattedData[$userId] = [
                'user_id' => $userId,
                'dates' => [],
            ];
        }

        if (!isset($formattedData[$userId]['dates'][$createdDate])) {
            $formattedData[$userId]['dates'][$createdDate] = [];
        }

        $formattedData[$userId]['dates'][$createdDate][] = date('H:iA', strtotime($createdTime));
    }

    $leave=0;
    $absent=0;
    foreach ($formattedData as &$userData) {
        foreach ($dateArray as $date) {
            if (!isset($userData['dates'][$date]) || empty($userData['dates'][$date])) {
                $user_id = $userData['user_id'];
                if ($this->checkLeave($user_id, $date)) {
                    $userData['dates'][$date][] = '--';
                    $userData["status"][]='L';
                    $leave++;
                } elseif ($this->holidayCheck($user_id, $date)) {
                    $userData['dates'][$date][] = '--';
                    $userData["status"][]='H';
                } else {
                    $userData['dates'][$date][] = '--';
                    $userData["status"][]='A';
                    $absent++;
                }
            }else{
                $min = $this->checkHalfDayLeavesAbsentsLateMin($userData['dates'][$date]);
                $userData["ckeck_in"][]=$min;
                $userData["status"][]='P';
            }
        } 
    }

    $resultArray = array_values($formattedData);
    return $resultArray;
}


public function checkHalfDayLeavesAbsentsLateMin($data)
{
    $timestamps = array_map(function ($time) {
        return strtotime($time);
    }, $data);
    $smallestTimestamp = min($timestamps);
    $smallestTime = date('h:iA', $smallestTimestamp);
    return $timestamps;
}


















































}