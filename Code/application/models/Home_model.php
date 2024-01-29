<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_home_attendance_for_admin($date)
    {
        $get = [
            "from" => $date,
            "too" => $date,
        ];
        
        $get_data = $this->get_attendance_for_admin($get);
        $format = $this->formated_data($get_data, $get);
        return $format;
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
    public function formated_data($attendance, $get)
    {
        $from = $get["from"];
        $too = $get["too"];
        $dateArray = [$from];
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
    
        $system_users = $this->ion_auth->members_all()->result();
        foreach ($system_users as $user) {
            if ($user->finger_config == '1' && $user->active == '1') {
                // Check if the user is in formattedData
                if (!isset($formattedData[$user->employee_id])) {
                    $formattedData[$user->employee_id] = [
                        'user_id' => $user->employee_id,
                        'user' => '<a href="' . base_url('attendance/user_attendance/' . $user->employee_id) . '">' . $user->employee_id . '</a>',
                        'name' => '<a href="' . base_url('attendance/user_attendance/' . $user->employee_id) . '">' . $user->first_name.' ' .$user->last_name. '</a>',
                        'dates' => [],
                    ];
                }
                if (!isset($formattedData[$user->employee_id]['dates'][$from])) {
                    if ($this->checkLeave($user->employee_id,$from)) {
                        $formattedData[$user->employee_id]['dates'][$from][] = '<span class="text-success">Leave</span>';
                    }else{
                        $formattedData[$user->employee_id]['dates'][$from][] = '<span class="text-danger">Absent</span>';
                    }
                }
            }
        }
    
        $resultArray = array_values($formattedData);
        return $resultArray;
    }
    public function filter_count_abs($date)
    {
        $abs = 0;
        $leaves = 0;
        $present = 0;
        if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
            $where = " WHERE DATE(attendance.finger) = '" . $date . "' ";
        }
    
        $leftjoin = " LEFT JOIN users ON attendance.user_id = users.employee_id";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user 
            FROM attendance " . $leftjoin . $where);
    
        $results = $query->result_array();
        $system_users = $this->ion_auth->members_all()->result();
    
        foreach ($system_users as $user) {
            $userPresent = false; // Reset for each user
            if ($user->finger_config == '1' && $user->active == '1') {
                foreach ($results as $attendance) {
                    if ($user->employee_id == $attendance["user_id"]) {
                        $present++;
                        $userPresent = true;
                        break;
                    }
                }
                if (!$userPresent) {
                    if ($this->checkLeave($user->employee_id, $date)) {
                        $leaves++;
                    } else {
                        $abs++;
                    }
                }
            }
        }
    
        return [
            "abs" => $abs,
            "leave" => $leaves,
            "present" => $present,
        ];
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

    public function Get_events(){
        $currentDate = date('Y-m-d');
        $nextTwoMonths = date('Y-m-d', strtotime('+3 months', strtotime($currentDate)));
        $array = [];
        $system_users = $this->ion_auth->members_all()->result();
        foreach ($system_users as $user) {
            if ($user->finger_config == '1' && $user->active == '1') {
                $join_date = $user->join_date;
                $date_of_birth = $user->DOB;
                $formattedDateOfBirth = date('j F', strtotime($date_of_birth));
                $formattedJoinDate = date('j F', strtotime($join_date));
                
                if (date('m-d', strtotime($date_of_birth)) >= date('m-d', strtotime($currentDate)) 
                    && date('m-d', strtotime($date_of_birth)) <= date('m-d', strtotime($nextTwoMonths))) {
                    $formattedDateOfBirth = date('j F', strtotime($date_of_birth));
                    $array[] = [
                        'user' => $user->first_name.' '.$user->last_name,
                        'profile' => $user->profile,
                        'short'=> strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)),
                        'event' => 'Birthday',
                        'date' =>$formattedDateOfBirth
                    ];
                }

                if (date('m-d', strtotime($join_date)) >= date('m-d', strtotime($currentDate)) 
                    && date('m-d', strtotime($join_date)) <= date('m-d', strtotime($nextTwoMonths))) {
                    $formattedJoinDate = date('j F', strtotime($join_date));
                    $array[] = [
                        'user' => $user->first_name.' '.$user->last_name,
                        'profile' => $user->profile,
                        'short'=> strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)),
                        'event' => 'Anniversary',
                        'date' =>$formattedDateOfBirth                
                    ];
                }
            }
        }
        usort($array, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        return $array;
    }
}
