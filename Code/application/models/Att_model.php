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
    public function get_attendance($user_id = '', $start_from = '', $end_date = '', $shift = '', $department = '', $status = '1')
    {
        $this->db->select('attendance.*, CONCAT(users.first_name, " ", users.last_name) AS user');
        $this->db->from('attendance');
        $this->db->join('users', 'users.employee_id = attendance.user_id', 'left');

        if ($user_id != '') {
            $this->db->where('attendance.user_id', $user_id);
        }

        if ($shift != '') {
            $this->db->where('users.shift_id', $shift);
        }

        if ($department != '') {
            $this->db->where('users.department', $department);
        }

        if ($start_from != '' && $end_date != '') {
            $this->db->where('DATE(attendance.finger) >=', $start_from);
            $this->db->where('DATE(attendance.finger) <=', $end_date);
        }
        if ($status == '2') {
            $status = '0';
        }
        $this->db->where('users.active', $status);
        $this->db->order_by('attendance.finger', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_attendance($attendance, $users, $from, $too, $dateArray, $active, $user_id = '')
    {
        foreach ($users as $user) {
            if ($user->active == $active && $user->finger_config == 1) {
                $userLink = '<a href="#" onclick="openChildWindow(' . $user->employee_id . ')">' . $user->employee_id . '</a>';
                $userName = '<a href="#" onclick="openChildWindow(' . $user->employee_id . ')">' . $user->first_name . ' ' . $user->last_name . '</a>';
                $formattedData[$user->employee_id] = [
                    'user_id' => $user->employee_id,
                    'user' => $userLink,
                    'name' => $userName,
                    'dates' => [],
                ];
            }
        }

        foreach ($attendance as $entry) {
            $userId = $entry['user_id'];
            $createdDate = date("Y-m-d", strtotime($entry['finger']));
            $createdTime = date("H:i", strtotime($entry['finger']));
            $formattedData[$userId]['dates'][$createdDate][] = $createdTime;
        }

        foreach ($formattedData as &$userData) {
            if ($user_id == $user_id) {
                $userId = $userData['user_id'];
                $absents = $this->get_absents($userId, $from, $too);
                $late_min = $this->get_late_min($userId, $from, $too);
                $leaves = $this->get_leaves_counts($userId, $from, $too);
                foreach ($dateArray as $date) {
                    if (!isset($userData['dates'][$date]) || empty($userData['dates'][$date])) {
                        if ($this->checkLeave($userId, $date)) {
                            $userData['dates'][$date][] = '<span class="text-success">L</span>';
                        } elseif ($this->att_model->is_holiday($userId, $date)) {
                            $userData['dates'][$date][] = '<span class="text-primary">H</span>';
                        } else {
                            if ($this->check_joined_date($userId, $date)) {
                                $userData['dates'][$date][] = '<span class="text-danger">A</span>';
                            } else {
                                $userData['dates'][$date][] = '<span class="text-muted">--</span>';
                            }
                        }
                    }
                }
                $userData['summery'] = $absents . "/" . $leaves . "/" . $late_min;
            }
        }
        return $formattedData;
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
     * Check if a user has joined by a given date.
     * 
     * @param string $user_id The employee ID of the user.
     * @param string $date The date to check.
     * @return bool True if the user has joined on or before the date, otherwise false.
     */
    public function check_joined_date($user_id, $date)
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

        $attendance_by_date = [];
        foreach ($attendance_data as $entry) {
            $date = date('Y-m-d', strtotime($entry['finger']));
            $attendance_by_date[$date][] = $entry['finger'];
        }

        $current_date = $start_date;
        while ($current_date <= $end_date) {
            if (!isset($attendance_by_date[$current_date])) {
                if (!$this->is_holiday($user_id, $current_date) && !$this->full_day_leave($user_id, $current_date) && $this->check_joined_date($user_id, $current_date)) {
                    $absent_count++;
                }
            } else {
                if ($this->half_day_absent($user_id, $current_date, $attendance_by_date[$current_date])) {
                    $absent_count += 0.5;
                }
            }
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }

        return $absent_count;
    }

    public function half_day_absent($user_id, $current_date, $times = [])
    {
        if (empty($times)) {
            return false;
        }

        $check_in = date('H:i:s', strtotime($times[0]));
        $check_out = date('H:i:s', strtotime(end($times)));
        $shift = $this->shifts_model->get_shifts_by_id($this->shifts_model->get_user_shift($user_id)->id, $current_date);
        $half_day_in = $shift['half_day_check_in'] ?? '13:00:00';
        $half_day_out = $shift['half_day_check_out'] ?? '16:00:00';

        return $check_in == $check_out || $check_in > $half_day_in || $check_out < $half_day_out;
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
                    $first = intval(max(0, (strtotime($check_in) - strtotime($shift_start)) / 60));
                    $late_minutes += intval(max(0, (strtotime($check_in) - strtotime($shift_start)) / 60));
                }
                if (!$is_second_time_short_leave && !$this->second_time_halfDay($half_day_out, $check_out) && !$is_second_time_half_day_leave) {
                    $second = intval(max(0, (strtotime($shift_end) - strtotime($check_out)) / 60));
                    $late_minutes += (max(0, (strtotime($shift_end) - strtotime($check_out)) / 60));
                }
            }
            $array[] = [
                'date' => $date,
                'morning' => intval($first),
                'evening' => intval($second),
                'check_in' => $check_in,
                'check_out' => $check_out,
                'total_tail' => intval($late_minutes),
            ];
        }

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
        $this->db->where('status', 1);
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
    public function is_holiday($user_id, $date)
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
    /**
     * Check if a user is on full-day leave on a specific date.
     *
     * @param string $user_id The employee ID of the user.
     * @param string $date The date to check.
     * @return bool True if the user is on full-day leave, otherwise false.
     */
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
    /**
     * Check if a user is still on probation based on a given date.
     *
     * This method checks whether the provided date is before the user's probation end date.
     * If the probation end date is set and the provided date is before this end date, 
     * the method returns `true`, indicating that the user is still on probation.
     * Otherwise, it returns `false`.
     *
     * @param  object  $user  The user object containing probation data.
     * @param  string  $date  The date to compare against the user's probation end date.
     * @return bool  Returns `true` if the user is still on probation, `false` otherwise.
     */
    public function check_probation($user, $date)
    {
        $probation_date = $user->probation;
        if ($probation_date) {
            if (strtotime($date) < strtotime($probation_date)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Retrieve leave types from the database, optionally filtering by a specific ID.
     *
     * @param mixed $id Optional ID to filter the leave types. If provided, only the leave type with this ID will be returned.
     * 
     * @return array Returns an array of leave type objects from the database.
     */
    public function get_db_leave_types2()
    {
        $saas_id = $this->session->userdata('saas_id');
        $this->db->from('leaves_type');
        if (!empty($id)) {
            $this->db->where('id', $id);
        }
        $this->db->where('saas_id', $saas_id);
        $leaveTypes = $this->db->get();
        return $leaveTypes->result();
    }

    public function get_db_leave_types($id = '', $user)
    {
        $saas_id = $this->session->userdata('saas_id');
        $this->db->from('leaves_type');
        if (!empty($id)) {
            $this->db->where('id', $id);
        }
        $this->db->group_start();
        if ($user->gender == 'male' && $user->martial_status == 'married') {
            $this->db->or_where('apply_on', 'malemarried');
        }elseif ($user->gender == 'male' && $user->martial_status == 'single') {
            $this->db->or_where('apply_on', 'male');
        }elseif ($user->gender == 'female' && $user->martial_status == 'married') {
            $this->db->or_where('apply_on', 'femalemarried');
        }elseif ($user->gender == 'female' && $user->martial_status == 'single') {
            $this->db->or_where('apply_on', 'female');
        }
        $this->db->or_where('apply_on', 'all');
        $this->db->group_end(); 
        $this->db->where('saas_id', $saas_id);
        $leaveTypes = $this->db->get();
        return $leaveTypes->result();
    }

    public function get_total_of_leave_type_for_user($type, $user, $date)
    {
        // Check if the user is still on probation
        if ($this->check_probation($user, $date)) {
            return 0; // No leave count if the user is on probation
        }

        // Get the base leave count
        $leave_count = $type->leave_counts;
        $duration = $type->duration;

        // Get probation end date and current date
        $probation_end_date = new DateTime($user->probation);
        $current_date = new DateTime($date);

        // Initialize start and end of the current period
        $start_of_period = null;
        $end_of_period = null;

        // Calculate the start and end dates of the current duration
        switch ($duration) {
            case 'year':
                $start_of_period = new DateTime($current_date->format('Y-01-01'));
                $end_of_period = new DateTime($current_date->format('Y-12-31'));
                break;
            case '3_months':
                $start_of_period = (clone $current_date)->modify('-' . ($current_date->format('n') % 3) . ' months')->modify('first day of this month');
                $end_of_period = (clone $start_of_period)->modify('+2 months')->modify('last day of this month');
                break;
            case '4_months':
                $start_of_period = (clone $current_date)->modify('-' . ($current_date->format('n') % 4) . ' months')->modify('first day of this month');
                $end_of_period = (clone $start_of_period)->modify('+3 months')->modify('last day of this month');
                break;
            case '6_months':
                $start_of_period = (clone $current_date)->modify('-' . ($current_date->format('n') % 6) . ' months')->modify('first day of this month');
                $end_of_period = (clone $start_of_period)->modify('+5 months')->modify('last day of this month');
                break;
            default:
                // Default to a full year if no valid duration is provided
                $start_of_period = new DateTime($current_date->format('Y-01-01'));
                $end_of_period = new DateTime($current_date->format('Y-12-31'));
                break;
        }

        // Calculate the total number of days in the period
        $total_days_in_period = $end_of_period->diff($start_of_period)->days + 1;

        // Calculate the number of days after probation ends within the period
        if ($probation_end_date >= $start_of_period) {
            $days_after_probation = max(0, $end_of_period->diff($probation_end_date)->days + 1);
            $days_before_probation = $start_of_period->diff($probation_end_date)->days + 1;

            // Calculate the prorated leave count based on days after probation
            if ($days_before_probation > 0) {
                $leave_count = ($days_after_probation / $total_days_in_period) * $leave_count;
            }
        }

        // Return the prorated leave count
        return round($leave_count * 2) / 2;;
    }

    /**
     * Retrieve leave records from the database.
     *
     * @param int|string|null $user_id The ID of the user to filter by (optional).
     * @param string|null $from The start date for filtering leaves (optional).
     * @param string|null $too The end date for filtering leaves (optional).
     * @param int|string|null $type_id The type of leave to filter by (optional).
     * @return \Illuminate\Database\Eloquent\Collection The list of leave records that match the given criteria.
     */
    public function get_db_leaves($user_id = '', $from = '', $too = '', $type_id = '')
    {
        $this->db->from('leaves');
        if (!empty($user_id)) {
            $this->db->where('user_id', $user_id);
        }
        if (!empty($type_id)) {
            $this->db->where('type', $type_id);
        }
        $this->db->where('status', '1');
        $this->db->where('starting_date >=', $from);
        $this->db->where('starting_date <=', $too);
        $query = $this->db->get();
        return $query->result();
    }

    protected function get_leaves_counts($user_id, $from, $too)
    {
        $count_leaves = 0;
        $leaves = $this->att_model->get_db_leaves($user_id, $from, $too);
        foreach ($leaves as $leave) {
            $leaveDuration = (new DateTime($leave->ending_date))->diff(new DateTime($leave->starting_date))->days + 1;
            if (strpos($leave->leave_duration, 'Full') !== false) {
                $count_leaves += $leaveDuration;
            } elseif (strpos($leave->leave_duration, 'Half') !== false) {
                $count_leaves += 0.5;
            }
        }
        return $count_leaves;
    }
}
