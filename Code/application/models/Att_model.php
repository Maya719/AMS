<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Att_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_attendance($user_id = '', $start_from = '', $end_date = '')
    {
        $this->db->select('*');
        $this->db->from('attendance');
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($start_from != '' && $end_date != '') {
            $this->db->where('DATE(finger) >=', $start_from);
            $this->db->where('DATE(finger) <=', $end_date);
        }
        $this->db->order_by('finger', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_absents($user_id = '', $start_from = '', $end_date = '')
    {
        $attendance_data = $this->get_attendance($user_id, $start_from, $end_date);
        $grouped_data = [];
        $absent = 0;
        foreach ($attendance_data as $attendance) {
            $date = date('Y-m-d', strtotime($attendance['finger'])); // Assuming 'finger' is the timestamp column
            if (!isset($grouped_data[$date])) {
                $grouped_data[$date] = [];
            }
            $grouped_data[$date][] = $attendance;
        }
        $final_data = [];

        $current_date = strtotime($start_from);
        $end_date = strtotime($end_date);

        while ($current_date <= $end_date) {
            $date_str = date('Y-m-d', $current_date);

            if (isset($grouped_data[$date_str])) {
                $final_data[$date_str] = [
                    'status' => $this->checkHalfDay($user_id, $date_str, $grouped_data[$date_str]),
                    'date' => $date_str
                ];
            } else {
                if ($this->is_holiday($user_id, $date_str)) {
                    $final_data[$date_str] = [
                        'status' => 'Holiday',
                        'date' => $date_str
                    ];
                } else {
                    $final_data[$date_str] = [
                        'status' => 'Absent',
                        'date' => $date_str
                    ];
                }
            }
            $current_date = strtotime('+1 day', $current_date);
        }

        return $final_data;
    }

    public function checkHalfDay($user_id, $date, $fingers)
    {
        $smallestTime = PHP_INT_MAX;
        $greatestTime = PHP_INT_MIN;

        foreach ($fingers as $time) {
            $currentTimestamp = strtotime($time->finger);

            if ($currentTimestamp < $smallestTime) {
                $smallestTime = $currentTimestamp;
            }

            if ($currentTimestamp > $greatestTime) {
                $greatestTime = $currentTimestamp;
            }
        }

        $checkInTime = date('H:i:s', $smallestTime);
        $checkOutTime = date('H:i:s', $greatestTime);
        return $fingers;
    }
    public function get_late_min($user_id = '', $start_date = '', $end_date = '', $shift_start = '09:00:00', $shift_end = '18:00:00')
    {
        $attendance_data = $this->get_attendance($user_id, $start_date, $end_date);
        $attendance_by_date = [];
        $late_minutes = 0;
        if ($attendance_data) {
            foreach ($attendance_data as $record) {
                $date = date('Y-m-d', strtotime($record['finger']));
                if (!isset($attendance_by_date[$date])) {
                    $attendance_by_date[$date] = [];
                }
                $attendance_by_date[$date][] = $record['finger'];
            }
            foreach ($attendance_by_date as $date => $times) {
                $check_in = date('H:i:s', strtotime($times[0]));
                $check_out = date('H:i:s', strtotime(end($times)));
                if ($check_in != $check_out && !$this->OffClock($user_id, $date) && !$this->half_day_leave($user_id, $date)) {
                    if (!$this->first_time_short_leave($user_id, $date, $shift_start)) {
                        $late_minutes = max(0, (strtotime($check_in) - strtotime($shift_start)) / 60);
                    }
                    if (!$this->second_time_short_leave($user_id, $date, $shift_end, $check_out)) {
                        $late_minutes += max(0, (strtotime($shift_end) - strtotime($check_out)) / 60);
                    }
                }
            }
        }

        return intval($late_minutes);
    }

    public function checkJoined($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('employee_id =', $user_id);
        $query = $this->db->get();
        $user = $query->row();
        $userJoinDate = strtotime($user->join_date);
        $userResignDate = strtotime($user->resign_date);
        $providedDate = strtotime($date);

        if ($userJoinDate === false || $providedDate === false || $userResignDate) {
            return false;
        }

        if ($providedDate < $userJoinDate) {
            return false;
        }
        return true;
    }
    protected function is_holiday($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('holiday');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $holidays = $query->result_array();
        }
    }
    protected function Offclock($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('offclock');
        $this->db->where('date', $date);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    protected function full_day_leave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('user_id', $user_id);
        $this->db->where('leave_duration LIKE', '%Full%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    protected function half_day_leave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('user_id', $user_id);
        $this->db->where('leave_duration LIKE', '%Half%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    protected function first_time_short_leave($employee_id, $date, $shiftStartTime)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $employee_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
        $this->db->where('paid', 1);
        $this->db->where('leave_duration LIKE', '%Short%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->row();
            $leaveStart = $results->starting_time;
            if ($shiftStartTime >= $leaveStart) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    protected function second_time_short_leave($employee_id, $date, $shiftEndTime, $checkOutTime)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $employee_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
        $this->db->where('leave_duration LIKE', '%Short%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->row();
            $ending_time = $results->ending_time;
            if ($checkOutTime <= $shiftEndTime) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
