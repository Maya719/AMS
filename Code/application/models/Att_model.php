<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Att_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Retrieve attendance records for a user within a specified date range.
     *
     * This function queries the attendance records from the database, filtering by user ID and date range if provided.
     * It returns the attendance records ordered by date in ascending order.
     *
     * @param int $user_id The ID of the user (default is an empty string).
     * @param string $start_from The start date for the attendance records (in 'Y-m-d' format, default is an empty string).
     * @param string $end_date The end date for the attendance records (in 'Y-m-d' format, default is an empty string).
     * @return array Returns an array of attendance records, where each record is an associative array representing a row from the `attendance` table.
     */
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

    public function group_attendance($attendance)
    {

        foreach ($attendance as $record) {
            $date = date('Y-m-d', strtotime($record['finger']));
            $createdTime = date("H:i", strtotime($record['finger']));
            $attendance_by_date[$date][] = $createdTime;
        }
        return $attendance_by_date;
    }
    /**
     * Retrieve a list of dates when a user was absent within a specified date range.
     *
     * This function checks the user's attendance records to determine which dates they were absent.
     * It considers holidays as non-absent days and returns a list of dates when the user was neither
     * present nor on holiday.
     *
     * @param int $user_id The ID of the user (default is an empty string).
     * @param string $start_date The start date for the absence check (in 'Y-m-d' format, default is an empty string).
     * @param string $end_date The end date for the absence check (in 'Y-m-d' format, default is an empty string).
     * @return array Returns an array of dates (in 'Y-m-d' format) when the user was absent.
     */
    public function get_absents($user_id = '', $start_date = '', $end_date = '', $attendance_data = '')
    {
        $absent_count = 0;
        if (empty($attendance_data)) {
            $attendance_data = $this->get_attendance($user_id, $start_date, $end_date);
        }
        $present_dates = [];
        foreach ($attendance_data as $entry) {
            $date = date('Y-m-d', strtotime($entry['finger']));
            $present_dates[$date] = true;
        }

        $absent_dates = [];
        $current_date = $start_date;
        while ($current_date <= $end_date) {
            if (!isset($present_dates[$current_date]) && !$this->is_holiday($user_id, $current_date) && !$this->full_day_leave($user_id, $current_date)) {
                $absent_dates[] = $current_date;
                $absent_count++;
            }
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }

        return $absent_count;
    }
    protected function half_day_absent($user_id, $current_date, $attendance_data = '')
    {
        if (empty($attendance_data)) {
            $attendance_data = $this->get_attendance($user_id, $current_date, $current_date);
        }
        foreach ($attendance_data as $record) {
            $date = date('Y-m-d', strtotime($record['finger']));
            $attendance_by_date[$date][] = $record['finger'];
        }
        foreach ($attendance_by_date as $date => $times) {
            $check_in = date('H:i:s', strtotime($times[0]));
            $check_out = date('H:i:s', strtotime(end($times)));
            $shift = $this->shifts_model->get_shifts_by_id($this->shifts_model->get_user_shift($user_id)->id, $date);
            $half_day_in = $shift['half_day_check_in'] ?? '13:00:00';
            $half_day_out = $shift['half_day_check_out'] ?? '16:00:00';
            if (($check_in == $check_out || $check_in > $half_day_in || $check_out < $half_day_out)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Calculate the total late minutes for a user based on attendance data.
     *
     * This function retrieves the user's shift details and attendance records, then calculates
     * the total number of minutes the user was late for both check-in and check-out times.
     * It takes into account any approved short leave, half-day leave, and other leave conditions.
     *
     * @param int $user_id The ID of the user.
     * @param string $start_date The start date for the attendance check (in 'Y-m-d' format).
     * @param string $end_date The end date for the attendance check (in 'Y-m-d' format).
     * @return int Returns the total number of late minutes as an integer.
     */
    public function get_late_min($user_id, $start_date = '', $end_date = '', $attendance_data = '')
    {
        $attendance_by_date = [];
        $late_minutes = 0;

        if (empty($attendance_data)) {
            $attendance_data = $this->get_attendance($user_id, $start_date, $end_date);
        }

        foreach ($attendance_data as $record) {
            $date = date('Y-m-d', strtotime($record['finger']));
            $attendance_by_date[$date][] = $record['finger'];
        }

        foreach ($attendance_by_date as $date => $times) {
            $first = 0;
            $second = 0;
            $check_in = date('H:i:s', strtotime($times[0]));
            $check_out = date('H:i:s', strtotime(end($times)));
            $shift = $this->shifts_model->get_shifts_by_id($this->shifts_model->get_user_shift($user_id)->id, $date);

            $shift_start = $shift['starting_time'] ?? '09:00:00';
            $shift_end = $shift['ending_time'] ?? '18:00:00';
            $half_day_in = $shift['half_day_check_in'] ?? '13:00:00';
            $half_day_out = $shift['half_day_check_out'] ?? '16:00:00';

            if ($check_in != $check_out && !$this->Offclock($user_id, $date)) {
                $is_first_time_half_day_leave = $this->first_time_half_day_leave($user_id, $date);
                $is_second_time_half_day_leave = $this->second_time_half_day_leave($user_id, $date);
                $is_first_time_short_leave = $this->first_time_short_leave($user_id, $date, $shift_start);

                $is_second_time_short_leave = $this->second_time_short_leave($user_id, $date, $shift_end, $check_out);

                if (!$is_first_time_short_leave && !$this->first_time_halfDay($half_day_in, $check_in) && !$is_first_time_half_day_leave) {
                    $first = max(0, (strtotime($check_in) - strtotime($shift_start)) / 60);
                    $late_minutes += (max(0, (strtotime($check_in) - strtotime($shift_start)) / 60));
                }
                if (!$is_second_time_short_leave && !$this->second_time_halfDay($half_day_out, $check_out) && !$is_second_time_half_day_leave) {
                    $second = max(0, (strtotime($shift_end) - strtotime($check_out)) / 60);
                    $late_minutes += (max(0, (strtotime($shift_end) - strtotime($check_out)) / 60));
                }
            }
            $array[] = [
                'date' => $date,
                'morning' => intval($first),
                'evening' => intval($second),
                'check_in' => $check_in,
                'check_out' => $check_out,
                'shift_start' => $shift_start,
                'shift_end' => $shift_end,
            ];
        }
        $array[] = ['total' => intval($late_minutes)];

        return intval($late_minutes);
    }

    /**
     * Check if an employee has taken a second-time half-day leave on a specific date.
     *
     * This function verifies whether the employee has an approved second-time half-day leave 
     * on the specified date.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the user has a second-time half-day leave on the specified date, false otherwise.
     */
    protected function second_time_half_day_leave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('user_id', $user_id);
        $this->db->where('leave_duration LIKE', '%Second Time Half Day%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Check if an employee has taken a first-time half-day leave on a specific date.
     *
     * This function verifies whether the employee has an approved first-time half-day leave 
     * on the specified date.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the user has a first-time half-day leave on the specified date, false otherwise.
     */
    protected function first_time_half_day_leave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('user_id', $user_id);
        $this->db->where('leave_duration LIKE', '%First Time Half Day%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Check if an employee has taken a half-day leave on a specific date.
     *
     * This function verifies whether the employee has an approved half-day leave 
     * on the specified date.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the user has a half-day leave on the specified date, false otherwise.
     */
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
    /**
     * Check if an employee has taken a full-day leave on a specific date.
     *
     * This function verifies whether the employee has an approved full-day leave 
     * on the specified date.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the user has a full-day leave on the specified date, false otherwise.
     */
    protected function full_day_leave($user_id, $date)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->where('leave_duration LIKE', '%Full%');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Check if an employee has taken a short leave during the first half of the day.
     *
     * This function verifies whether the employee has an approved, paid short leave on the specified date,
     * and if the shift start time is within the permissible leave start time.
     *
     * @param int $employee_id The ID of the employee.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @param string $shiftStartTime The scheduled start time of the employee's shift (in 'H:i:s' format).
     * @return bool Returns true if the shift start time is within the approved short leave period, false otherwise.
     */
    protected function first_time_short_leave($employee_id, $date, $shiftStartTime)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $employee_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
        $this->db->where('paid', 0);
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
    /**
     * Check if an employee has taken a short leave during the second half of the day.
     *
     * This function verifies whether the employee has an approved short leave on the specified date,
     * and if the checkout time is within the permissible leave time frame relative to the shift end time.
     *
     * @param int $employee_id The ID of the employee.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @param string $shiftEndTime The scheduled end time of the employee's shift (in 'H:i:s' format).
     * @param string $checkOutTime The actual checkout time to compare (in 'H:i:s' format).
     * @return bool Returns true if the employee's checkout time aligns with the approved short leave period, false otherwise.
     */
    protected function second_time_short_leave($employee_id, $date, $shiftEndTime, $checkOutTime)
    {
        $this->db->select('*');
        $this->db->from('leaves');
        $this->db->where('user_id', $employee_id);
        $this->db->where('starting_date <=', $date);
        $this->db->where('ending_date >=', $date);
        $this->db->where('status', 1);
        $this->db->where('paid', 0);
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
    /**
     * Determine if the given date is a holiday for the specified user.
     *
     * This function checks if the provided date falls within any holiday period.
     * It considers holidays that apply to all users, specific departments, or specific users.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the date is a holiday for the user, false otherwise.
     */
    protected function is_holiday($user_id, $date)
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
                    $appliedDepart = json_decode($holiday["department"]);
                    if (in_array($department, $appliedDepart)) {
                        return true;
                    }
                } elseif ($holiday["apply"] == '2') {
                    $appliedUser = json_decode($holiday["users"]);
                    if (in_array($user_id, $appliedUser)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    /**
     * Check if the user is off the clock on a specific date.
     *
     * This function checks the 'offclock' table to determine if the user was off the clock
     * on the given date.
     *
     * @param int $user_id The ID of the user.
     * @param string $date The date to check (in 'Y-m-d' format).
     * @return bool Returns true if the user is off the clock on the specified date, false otherwise.
     */
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
    /**
     * Determine if the checkout time is within the second half of the day.
     *
     * This function checks if the provided checkout time is on or after the specified half-day out time.
     *
     * @param string $half_day_out The time representing the half-day out (in 'H:i:s' format).
     * @param string $check_out The checkout time to compare (in 'H:i:s' format).
     * @return bool Returns true if the checkout time is on or after the half-day out time, false otherwise.
     */
    protected function second_time_halfDay($half_day_out, $check_out)
    {
        return strtotime($check_out) <= strtotime($half_day_out);
    }
    /**
     * Determine if the check-in time is within the first half of the day.
     *
     * This function checks if the provided check-in time is on or after the specified half-day in time.
     *
     * @param string $half_day_in The time representing the half-day in (in 'H:i:s' format).
     * @param string $check_in The check-in time to compare (in 'H:i:s' format).
     * @return bool Returns true if the check-in time is on or after the half-day in time, false otherwise.
     */
    protected function first_time_halfDay($half_day_in, $check_in)
    {
        return strtotime($check_in) >= strtotime($half_day_in);
    }
}
