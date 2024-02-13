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
                    'user_id' => $userId,
                    'user' => '<a href="' . base_url('attendance/user_attendance/' . $userId) . '">' . $userId . '</a>',
                    'name' => '<a href="' . base_url('attendance/user_attendance/' . $userId) . '">' . $user . '</a>',
                    'dates' => [],
                ];
            }

            if (!isset($formattedData[$userId]['dates'][$createdDate])) {
                $formattedData[$userId]['dates'][$createdDate] = [];
            }
            $formattedData[$userId]['dates'][$createdDate][] = date('h:i A', strtotime($createdTime));
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
                    if ($this->checkLeave($user_id, $date)) {
                        $userData['dates'][$date][] = '<span class="text-success">Leave</span>';
                    } elseif ($this->holidayCheck($user_id, $date)) {
                        $userData['dates'][$date][] = '<span class="text-primary">Holiday</span>';
                    } else {
                        $userData['dates'][$date][] = '<span class="text-danger">Absent</span>';
                    }
                }
            }
        }

        $groupedData = array();

        foreach ($dateArray as $date) {
            $monthYear = date('M Y', strtotime($date));

            if (!isset($groupedData[$monthYear])) {
                $groupedData[$monthYear] = array();
            }

            $groupedData[$monthYear][] = $date;
        }


        $monthCounts = array_map('count', $groupedData);

        $output = [
            'data' => array_values($formattedData),
            'range' => $monthCounts
        ];
        return $output;
    }

    public function holidayCheck($user_id, $date)
    {
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
                } elseif ($holiday["apply"] == '1') {
                    $user = $this->ion_auth->user($user_id)->row();
                    $department = $user->department;
                    $appliedDepart =  json_decode($holiday["department"]);
                    if (in_array($department, $appliedDepart)) {
                        return true;
                    }
                } elseif ($holiday["apply"] == '2') {
                    $appliedUser =  json_decode($holiday["users"]);
                    if (in_array($user_id, $appliedUser)) {
                        return true;
                    }
                }
            }
        } else {
            return false;

            // $dayOfWeek = date('N', strtotime($date));
            // if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            //     return true;
            // } else {
            //     return false;
            // }
        }
    }
    public function checkLeave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $user_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
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
        } else {
            $where = '';
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
                    } else {
                        $abs++;
                    }
                }
            }
        }

        $firstDayOfMonth = new DateTime('first day of ' . $currentDate->format('Y-m'));
        $fromDate = $firstDayOfMonth->format('Y-m-d');
        $leftjoin2 = " LEFT JOIN users ON leaves.user_id = users.employee_id";

        $where2 = " WHERE users.active= '1' AND users.finger_config='1' AND users.saas_id=" . $this->session->userdata('saas_id');
        $where2 .= " AND leaves.starting_date >= '" . $fromDate . "' AND leaves.ending_date <= '" . $todayDate . "'";
        if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
            $where2 .= " ";
        } else {
            $user = $this->ion_auth->user()->row();
            $user_id = $user->id;
            $employee_id = get_employee_id_from_user_id($user_id);
            $where2 .= " AND leaves.user_id = '" . $employee_id . "'";
        }
        $leaveQuery = $this->db->query("SELECT leaves.*, CONCAT(users.first_name, ' ', users.last_name) AS user  FROM leaves " . $leftjoin2 . $where2 . "");
        $leavesresult = $leaveQuery->result_array();
        foreach ($leavesresult as $leavesResult) {
            if ($leavesResult["status"] == '1') {
                $leaves_approved++;
            } elseif ($leavesResult["status"] == '0') {
                $leave_pending++;
            } elseif ($leavesResult["status"] == '2') {
                $leave_rejected++;
            }
        }

        $leftjoin3 = " LEFT JOIN users ON biometric_missing.user_id = users.employee_id";

        $where3 = " WHERE biometric_missing.date BETWEEN '" . $fromDate . "' AND '" . $todayDate . "'";
        if ($this->ion_auth->is_admin() || permissions('attendance_view_all')) {
            $where3 .= " ";
        } else {
            $user = $this->ion_auth->user()->row();
            $user_id = $user->id;
            $employee_id = get_employee_id_from_user_id($user_id);
            $where3 .= " AND biometric_missing.user_id = '" . $employee_id . "'";
        }
        $BioQuery = $this->db->query("SELECT biometric_missing.*, CONCAT(users.first_name, ' ', users.last_name) AS user FROM biometric_missing " . $leftjoin3 . $where3);
        $BioResults = $BioQuery->result_array();
        foreach ($BioResults as $BioResult) {
            if ($BioResult["status"] == '1') {
                $bio_approved++;
            } elseif ($BioResult["status"] == '0') {
                $bio_pending++;
            } elseif ($BioResult["status"] == '2') {
                $bio_rejected++;
            }
        }

        return $array = [
            // "system_users" => $system_users,
            "total_staff" => $total_staff,
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
        }
        if ($department != '') {
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
            $attendance = $this->get_single_attendance_for_admin($get["user_id"], $get["from"], $get["too"]);
            $formated_data = $this->format_single_user_attendance($attendance, $get);
        } else {
            $id = $this->ion_auth->user()->row()->employee_id;
            $attendance = $this->get_single_attendance_for_admin($id, $get["from"], $get["too"]);
            $formated_data = $this->format_single_user_attendance($attendance, $get);
        }
        return $formated_data;
    }

    public function get_single_attendance_for_admin($user_id, $from, $too)
    {
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

            $formattedData[$userId]['dates'][$createdDate][] = date('H:i', strtotime($createdTime));
        }

        $leave = '0.0';
        $absent = '0.0';
        $totalLateMinutes = 0;

        foreach ($formattedData as &$userData) {
            $user_id = $userData['user_id'];
            foreach ($dateArray as $date) {
                if (!isset($userData['dates'][$date]) || empty($userData['dates'][$date])) {
                    if ($this->checkLeave($user_id, $date)) {
                        $userData['dates'][$date][] = '--';
                        $userData["status"][] = 'L';
                        $leave++;
                    } elseif ($this->holidayCheck($user_id, $date)) {
                        $userData['dates'][$date][] = '--';
                        $userData["status"][] = 'H';
                    } else {
                        $userData['dates'][$date][] = '--';
                        $userData["status"][] = 'A';
                        $absent++;
                    }
                } else {
                    if ($this->checkHalfDayLeave($date, $user_id)) {
                        $min = $this->checkHalfDayLeavesAbsentsLateMin($userData['dates'][$date], $date, $user_id);
                        if ($min["halfDayLeave"]) {
                            $leave = '' . floatval($leave) + floatval(1 / 2) . '';
                        }
                        $userData["status"][] = 'HD L';
                        $totalLateMinutes += $min["lateMinutes"];
                        $userData["checkin"][] = $min;
                    } else {
                        $min = $this->checkHalfDayLeavesAbsentsLateMin($userData['dates'][$date], $date, $user_id);
                        if ($min["halfDay"]) {
                            $userData["status"][] = 'HD';
                            $totalLateMinutes += $min["lateMinutes"];
                            $absent = '' . floatval($absent) + floatval(1 / 2) . '';
                        } else {
                            if ($min["lateMinutes"]) {
                                $totalLateMinutes += $min["lateMinutes"];
                            }
                            $userData["status"][] = 'P';
                        }
                        $userData["checkin"][] = $min;
                    }
                }
            }
            $userData["text"] = 'A/ ' . $absent . ' <br>L/ ' . $leave . ' <br>L min/ ' . $totalLateMinutes;
        }

        $resultArray = array_values($formattedData);
        return $resultArray;
    }


    public function checkHalfDayLeavesAbsentsLateMin($data, $date, $employee_id)
    {
        $smallestTime = PHP_INT_MAX;
        $greatestTime = PHP_INT_MIN;

        foreach ($data as $time) {
            $currentTimestamp = strtotime($time);

            if ($currentTimestamp < $smallestTime) {
                $smallestTime = $currentTimestamp;
            }

            if ($currentTimestamp > $greatestTime) {
                $greatestTime = $currentTimestamp;
            }
        }

        $checkInTime = date('H:i:s', $smallestTime);
        $checkOutTime = date('H:i:s', $greatestTime);

        $user_id = get_user_id_from_employee_id($employee_id);
        $user = $this->ion_auth->user($user_id)->row();
        $shift_id = $user->shift_id;
        $shift = $this->shift_model->get_shift_by_id($shift_id);
        $shiftStartTime = $shift["starting_time"];
        $shiftStartTime = $shift["starting_time"];
        $shiftEndTime = $shift["ending_time"];

        $halfDayCheckIn = $shift["half_day_check_in"];
        $halfDayCheckOut = $shift["half_day_check_out"];

        $halfDayStartDateTime = new DateTime($date . ' ' . $halfDayCheckIn);
        $halfDayEndDateTime = new DateTime($date . ' ' . $halfDayCheckOut);

        $shiftEndDateTime = new DateTime($date . ' ' . $shiftEndTime);
        $checkOutDateTime = new DateTime($date . ' ' . $checkOutTime);

        $shiftStartDateTime = new DateTime($date . ' ' . $shiftStartTime);

        $halfDay = false;
        $halfDayLeave = false;
        $checkInDateTime = new DateTime($date . ' ' . $checkInTime);
        if ($checkInDateTime != $checkOutDateTime) {
            if ($this->checkHalfDayLeave($date, $employee_id)) {
                $halfDayLeave = true;
                $lateMinutes = 0;

            }
            if (($halfDayStartDateTime >= $checkInDateTime && $halfDayEndDateTime >= $checkOutDateTime) || ($halfDayStartDateTime <= $checkInDateTime && $halfDayEndDateTime <= $checkOutDateTime) ) {
                $halfDay = true;
                $lateMinutes = 0;
            } else {
                if ($checkInDateTime > $shiftStartDateTime) {
                    $lateMinutes = $checkInDateTime->diff($shiftStartDateTime)->format('%i');
                } else {
                    $lateMinutes = 0;
                }
            }
            if ($date !== date('Y-m-d')) {
                if ($shiftEndDateTime > $checkOutDateTime && !$halfDayLeave) {
                    $lateMinutes2 = $shiftEndDateTime->diff($checkOutDateTime)->format('%i');
                    $lateMinutes += $lateMinutes2;
                }
            }
        }

        return [
            'checkInTime' => $checkInTime,
            'checkOutTime' => $checkOutTime,
            'shiftStartTime' => $shiftStartTime,
            'shiftEndTime' => $shiftEndTime,
            'halfDayCheckIn' => $halfDayCheckIn,
            'halfDayCheckOut' => $halfDayCheckOut,
            'halfDay' => $halfDay,
            'halfDayLeave' => $halfDayLeave,
            'lateMinutes' => $lateMinutes
        ];
    }
    public function checkHalfDayLeave($date, $user_id)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $user_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
        $this->db->where('leave_duration LIKE', '%Half%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function connect()
    {
        $datetime = new DateTime();
        $timezone = new DateTimeZone('Asia/Karachi');
        $datetime->setTimezone($timezone);
        $cdate = $datetime->format('Y-m-d H:i:s');
        $devices = $this->db->query("SELECT * FROM devices");
        $devicesresults = $devices->result_array();
        foreach ($devicesresults as $device) {
            $ip = $device["device_ip"];
            $zk = new ZKLib($ip, 27010);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->setTime($cdate);
                $users = $zk->getUser();
                $attendance = $zk->getAttendance();
                $zk->clearAttendance();
                $zk->enableDevice();
                $zk->disconnect();
                foreach ($attendance as $key => $attendances) {
                    $userid = $attendances['id'];
                    $timestamp = $attendances['timestamp'];
                    $query = $this->db->query("SELECT * FROM attendance WHERE user_id = '$userid' AND finger ='$timestamp'");
                    $results = $query->result_array();
                    $query2 = $this->db->query("SELECT * FROM users WHERE employee_id = '$userid'");
                    $result2 = $query2->row();
                    if ($result2) {
                        $id = $result2->id;
                        $email = $result2->email;
                        $name = $result2->first_name . ' ' . $result2->last_name;
                        $dateTime = new DateTime($timestamp);
                        $time = $dateTime->format("h:i A");
                        $numRows = $query->num_rows();
                        if ($numRows == 0) {
                            $data = [
                                'user_id' => $userid,
                                'finger' => $timestamp
                            ];
                            $this->db->insert('attendance', $data);
                            $notification_data = array(
                                'notification' => 'Your Punch recorded at ' . $timestamp,
                                'type' => 'attendance',
                                'type_id' => '11',
                                'from_id' => $id,
                                'to_id' => $id
                            );
                            $notification_id = $this->notifications_model->create($notification_data);

                            $template_data['NAME'] = $name;
                            $template_data['TIME'] = $time;
                            $template_data['DASHBOARD_URL'] = 'https://pms.mobipixels.com';
                            $email_template = render_email_template('biometric', $template_data);
                            send_mail($email, $email_template[0]['subject'], $email_template[0]['message']);
                        }
                    }
                }
                echo json_encode($attendance);
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
    }
}
