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
    /**
     * Insert a new record into the 'attendance' table.
     * 
     * This function inserts a new row in the 'attendance' table with the provided data.
     * If the insert operation is successful, it returns the ID of the newly inserted record.
     * If the operation fails, it returns `false`.
     * 
     * @param array $data The data to insert into the 'attendance' table.
     * @return int|false The ID of the newly inserted record on success, or `false` on failure.
     */
    public function create($data)
    {
        if ($this->db->insert('attendance', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    /**
     * Insert a new record into the 'offclock' table.
     * 
     * This function inserts a new row in the 'offclock' table with the provided data.
     * If the insert operation is successful, it returns the ID of the newly inserted record.
     * If the operation fails, it returns `false`.
     * 
     * @param array $data The data to insert into the 'offclock' table.
     * @return int|false The ID of the newly inserted record on success, or `false` on failure.
     */
    public function create_offclock($data)
    {
        if ($this->db->insert('offclock', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    /**
     * Update an existing record in the 'offclock' table.
     * 
     * This function updates a row in the 'offclock' table based on the provided ID.
     * If the update operation is successful, it returns `true`.
     * If the operation fails, it returns `false`.
     * 
     * @param int $id The ID of the record to update in the 'offclock' table.
     * @param array $data The new data to update the record with.
     * @return bool `true` on success, `false` on failure.
     */
    function edit_offclock($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('offclock', $data))
            return true;
        else
            return false;
    }
    /**
     * Delete a record from the 'offclock' table.
     * 
     * This function deletes a row from the 'offclock' table based on the provided ID.
     * If the delete operation is successful, it returns `true`.
     * If the operation fails, it returns `false`.
     * 
     * @param int $id The ID of the record to delete from the 'offclock' table.
     * @return bool `true` on success, `false` on failure.
     */
    function delete_offclock($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('offclock'))
            return true;
        else
            return false;
    }
    /**
     * Retrieve users based on their active/inactive status.
     * 
     * This function executes a query to fetch users based on their status:
     * - Status '1' returns active users.
     * - Status '2' returns inactive users.
     * 
     * Users are further filtered by their finger configuration and SaaS ID.
     * 
     * @param string $status The status of the users to retrieve ('1' for active, '2' for inactive).
     * @return array The resulting array of users matching the given status.
     */
    public function get_users_by_status($status)
    {
        if ($status == '1') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '1' AND finger_config = '1' AND saas_id = " . $this->session->userdata('saas_id'));
        }
        if ($status == '2') {
            $query = $this->db->query("SELECT * FROM users WHERE active = '0' AND finger_config = '1' AND saas_id = " . $this->session->userdata('saas_id'));
        }
        $results = $query->result_array();
        return $results;
    }
    /**
     * Retrieve users based on their department.
     * 
     * This function executes a query to fetch users who are active and have a specific department:
     * - If no department is provided, it returns all active users with finger configuration enabled.
     * - If a department is specified, it returns users matching that department.
     * 
     * @param string $department The department ID to filter users by.
     * @return array The resulting array of users matching the given department.
     */
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
    /**
     * Retrieve users based on their assigned shift.
     * 
     * This function executes a query to fetch users who are active and assigned to a specific shift:
     * - If no shift ID is provided, it returns all active users with finger configuration enabled.
     * - If a shift ID is specified, it returns users assigned to that shift.
     * 
     * @param string $shifts_id The shift ID to filter users by.
     * @return array The resulting array of users matching the given shift ID.
     */
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

    /**
     * Format attendance data for a single user over a specified date range.
     * 
     * This function processes attendance data and formats it for reporting. It performs the following steps:
     * 
     * 1. **Date Range Calculation**:
     *    - Converts the provided start and end dates into `DateTime` objects.
     *    - Creates a list of dates between the start and end dates using `DatePeriod`.
     * 
     * 2. **Attendance Data Formatting**:
     *    - Iterates through the attendance entries and organizes them by user ID and date.
     *    - Stores the time of each attendance entry for each date.
     * 
     * 3. **Status Determination**:
     *    - For each user and each date, determines the attendance status:
     *      - `L` for leave, if the user is on leave.
     *      - `H` for holiday, if the date is a holiday.
     *      - `A` for absent, if no attendance data is found and it's not a leave or holiday.
     *      - `HD L` for half-day leave.
     *      - `SL` for short leave.
     *      - `HD` for half-day absent.
     *      - `P` for present.
     *      - `OC` for off-clock.
     *    - Calculates late minutes and aggregates leave and absence counts.
     * 
     * 4. **Result Compilation**:
     *    - Compiles the formatted data into an array including the attendance status, check-in details, and summary of absences and late minutes.
     * 
     * @param array $attendance Array of attendance records.
     * @param array $get Array containing the 'from' and 'too' dates.
     * 
     * @return array Formatted attendance data for each user.
     */
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
                        $userData["checkin"][] = $min;
                    } else {
                        $min = $this->checkHalfDayLeavesAbsentsLateMin($userData['dates'][$date], $date, $user_id);
                        if ($min["shortLeave"]) {
                            $userData["status"][] = 'SL';
                        } elseif ($min["halfDay"]) {
                            $userData["status"][] = 'HD';
                            $absent = '' . floatval($absent) + floatval(1 / 2) . '';
                        } else {
                            if ($min["lateMinutes"]) {
                                $totalLateMinutes += $min["lateMinutes"];
                                $userData["status"][] = '' . $min["lateMinutes"] . '';
                            } else {
                                if ($min["checkoffclock"]) {
                                    $userData["status"][] = 'OC';
                                } else {
                                    $userData["status"][] = 'P';
                                }
                            }
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

    /**
     * Retrieve and format attendance data for the admin.
     * 
     * This method processes the attendance data based on the provided query parameters and returns the formatted result as JSON.
     * 
     * 1. **Retrieve Query Parameters**:
     *    - Uses `$this->input->get()` to get query parameters from the request.
     * 
     * 2. **Fetch Attendance Data**:
     *    - Calls `get_attendance_for_admin` with the query parameters to fetch the raw attendance data.
     * 
     * 3. **Format Data**:
     *    - Formats the retrieved attendance data using `formated_data`.
     * 
     * 4. **Return Response**:
     *    - Encodes the formatted data as JSON and outputs it.
     * 
     * @return void
     */
    public function get_attendance()
    {
        $get = $this->input->get();
        $attendance = $this->get_attendance_for_admin($get);
        $formated_data = $this->formated_data($attendance, $get);
        echo json_encode($formated_data);
    }

    /**
     * Format attendance data based on query parameters.
     * 
     * This method formats the attendance data for users based on the provided date range and other query parameters.
     * 
     * 1. **Parse Query Parameters**:
     *    - Extracts the `from` and `too` dates from the `$get` array and creates `DateTime` objects.
     * 
     * 2. **Determine User List**:
     *    - Depending on whether `user_id`, `department`, and `shifts` are provided, determines which users to include.
     *    - Filters users based on their department and shift if applicable.
     * 
     * 3. **Generate Date Range**:
     *    - Creates an array of dates between the `from` and `too` dates using `DatePeriod`.
     * 
     * 4. **Initialize Formatted Data**:
     *    - Initializes the `formattedData` array with user details and their attendance.
     * 
     * 5. **Process Attendance Entries**:
     *    - Maps attendance entries to the corresponding user and date, recording check-in times.
     * 
     * 6. **Calculate Attendance Status**:
     *    - Determines attendance status for each user and date, including handling leaves, holidays, absences, and late minutes.
     * 
     * 7. **Group Data by Month**:
     *    - Groups dates by month and counts the number of days in each month.
     * 
     * 8. **Prepare Output**:
     *    - Prepares the final output array with formatted data, month counts, raw attendance data, and query parameters.
     * 
     * @param array $attendance The raw attendance data.
     * @param array $get Query parameters including date range, user ID, department, and shifts.
     * @return array The formatted attendance data including summary and date ranges.
     */
    public function formated_data($attendance, $get)
    {
        $from = $get["from"];
        $too = $get["too"];
        $fromDate = new DateTime($from);
        $toDate = new DateTime($too);

        if (!empty($get['user_id'])) {
            $system_users = [$this->ion_auth->user($get['user_id'])->row()];
        } else {
            if ($this->ion_auth->is_admin()) {
                $system_users2 = $this->ion_auth->members_all()->result();
            } else {
                $selected = selected_users();
                foreach ($selected as $user_id) {
                    $users[] = $this->ion_auth->user($user_id)->row();
                }
                $users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
                $system_users2 = $users;
            }
            if (isset($get['department']) && !empty($get['department']) && isset($get['shifts']) && !empty($get['shifts'])) {
                foreach ($system_users2 as $user) {
                    if ($get['shifts'] == $user->shift_id && $get['department'] == $user->department) {
                        $system_users[] = $user;
                    }
                }
            } elseif (isset($get['department']) && !empty($get['department'])) {
                foreach ($system_users2 as $user) {
                    if ($get['department'] == $user->department) {
                        $system_users[] = $user;
                    }
                }
            } elseif (isset($get['shifts']) && !empty($get['shifts'])) {
                foreach ($system_users2 as $user) {
                    if ($get['shifts'] == $user->shift_id) {
                        $system_users[] = $user;
                    }
                }
            } else {
                $system_users = $system_users2;
            }
        }

        $dateArray = array();
        $interval = new DateInterval('P1D');
        $datePeriod = new DatePeriod($fromDate, $interval, $toDate->modify('+1 day'));

        foreach ($datePeriod as $date) {
            $dateArray[] = $date->format('Y-m-d');
        }

        $formattedData = [];
        $active = ($get["status"] == '1') ? 1 : 0;

        foreach ($system_users as $user) {
            if ($user->active == $active && $user->finger_config == 1) {
                $userjoin = new DateTime($user->join_date);
                if ($userjoin < $toDate || $userjoin < $fromDate) {
                    $userId = $user->employee_id;
                    $userLink = '<a href="#" onclick="openChildWindow(' . $userId . ')">' . $userId . '</a>';
                    $userName = '<a href="#" onclick="openChildWindow(' . $userId . ')">' . $user->first_name . ' ' . $user->last_name . '</a>';
                    $formattedData[$userId] = [
                        'user_id' => $userId,
                        'user' => $userLink,
                        'name' => $userName,
                        'dates' => [],
                    ];
                }
            }
        }

        foreach ($attendance as $entry) {
            $userId = $entry['user_id'];
            $createdDate = date("Y-m-d", strtotime($entry['finger']));
            $createdTime = date("H:i", strtotime($entry['finger']));
            $formattedData[$userId]['dates'][$createdDate][] = $createdTime;
        }

        foreach ($formattedData as &$userData) {
            $leave = '0';
            $absent = '0';
            $latemin = 0;
            $user_id = $userData['user_id'];
            foreach ($dateArray as $date) {
                if (!isset($userData['dates'][$date]) || empty($userData['dates'][$date])) {
                    if ($this->checkLeave($user_id, $date)) {
                        $leave++;
                        $userData['dates'][$date][] = '<span class="text-success">L</span>';
                    } elseif ($this->att_model->is_holiday($user_id, $date)) {
                        $userData['dates'][$date][] = '<span class="text-primary">H</span>';
                    } else {
                        if ($this->checkJoined($user_id, $date)) {
                            $userData['dates'][$date][] = '<span class="text-danger">A</span>';
                            $absent = '' . floatval($absent) + floatval(1) . '';
                        } else {
                            $userData['dates'][$date][] = '<span class="text-muted">--</span>';
                        }
                    }
                } else {
                    $attendancePageSummery = $this->checkHalfDayLeavesAbsentsLateMin($userData['dates'][$date], $date, $user_id);
                    if ($attendancePageSummery["halfDay"] && date('Y-m-d') != $date) {
                        $absent = '' . floatval($absent) + floatval(1 / 2) . '';
                        $userData['dates'][$date][] = '<span class="text-info">HD</span>';
                    }
                    if ($attendancePageSummery["halfDayLeave"] && date('Y-m-d') != $date) {
                        $leave = '' . floatval($leave) + floatval(1 / 2) . '';
                        $userData['dates'][$date][] = '<span class="text-info">HD L</span>';
                    } else {
                        $latemin = $latemin + $attendancePageSummery["lateMinutes"];
                    }
                }
            }
            $userData['summery'] = $absent . '/' . $leave . '/' . $latemin;
        }

        $groupedData = [];
        foreach ($dateArray as $date) {
            $monthYear = date('M Y', strtotime($date));
            if (!isset($groupedData[$monthYear])) {
                $groupedData[$monthYear] = [];
            }
            $groupedData[$monthYear][] = $date;
        }
        $monthCounts = array_map('count', $groupedData);

        $output = [
            'data' => array_values($formattedData),
            'range' => $monthCounts,
            'get' => $get,
        ];
        return $output;
    }
    /**
     * Check if a user has joined by a given date.
     * 
     * @param string $user_id The employee ID of the user.
     * @param string $date The date to check.
     * @return bool True if the user has joined on or before the date, otherwise false.
     */
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
    /**
     * Check if a given date is a holiday for a specific user.
     *
     * @param string $user_id The employee ID of the user.
     * @param string $date The date to check.
     * @return bool True if the date is a holiday for the user, otherwise false.
     */
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
        } else {
            return false;
        }
    }
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
    /**
     * Retrieve attendance records based on various filters provided in the input.
     *
     * This function builds a SQL query to fetch attendance data, filtered by
     * user ID, department, shift, active status, and date range. The query
     * also includes a join with the `users` table to retrieve user details.
     *
     * The function supports:
     * - Filtering by a specific user or by users assigned to the logged-in user.
     * - Filtering by department and shift.
     * - Filtering by the user's active status.
     * - Filtering by a specified date range.
     *
     * @param  array  $get  The input array containing the filter criteria.
     * @return array        The result set of attendance records.
     */
    public function get_attendance_for_admin($get)
    {
        if (!empty($get['user_id'])) {
            $employee_id = get_employee_id_from_user_id($get['user_id']);
            $where = " WHERE attendance.user_id = " . $employee_id;
        } else {
            if ($this->ion_auth->is_admin()) {
                $where = " WHERE attendance.id IS NOT NULL ";
            } elseif (is_assign_users()) {
                $selected = selected_users();
                if (!empty($selected)) {
                    foreach ($selected as $assignee) {
                        $sel[] = get_employee_id_from_user_id($assignee);
                    }
                    $userIdsString = implode(',', $sel);
                    $where = " WHERE attendance.user_id IN ($userIdsString)";
                }
            }
        }
        if (isset($get['department']) && !empty($get['department'])) {
            $department = $get['department'];
            $where .= " AND users.department = '$department'";
        }
        if (isset($get['shifts']) && !empty($get['shifts'])) {
            $shifts = $get['shifts'];
            $where .= " AND users.shift_id = '$shifts'";
        }
        if ($get['status'] == '1') {
            $where .= " AND users.active = '1'";
        } else {
            $where .= " AND users.active = '0'";
        }

        if (isset($get['from']) && !empty($get['from']) && isset($get['too']) && !empty($get['too'])) {
            $where .= " AND DATE(attendance.finger) BETWEEN '" . format_date($get['from'], "Y-m-d") . "' AND '" . format_date($get['too'], "Y-m-d") . "' ";
        }

        $leftjoin = "LEFT JOIN users ON attendance.user_id = users.employee_id";
        $where .= " AND users.saas_id=" . $this->session->userdata('saas_id') . " ";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user
        FROM attendance " . $leftjoin . $where . " AND users.finger_config=1");
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
        if ($this->ion_auth->is_admin()) {
            $where = " WHERE DATE(attendance.finger) = '" . $todayDate . "' ";
            $system_users = $this->ion_auth->members_all()->result();
        } elseif (is_assign_users()) {
            $selected = selected_users();
            foreach ($selected as $user_id) {
                $users[] = $this->ion_auth->user($user_id)->row();
            }
            $users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
            $system_users = $users;
            $where = " WHERE DATE(attendance.finger) = '" . $todayDate . "' ";
        } else {
            $where = '';
        }
        $leftjoin = " LEFT JOIN users ON attendance.user_id = users.employee_id";
        $query = $this->db->query("SELECT attendance.*, CONCAT(users.first_name, ' ', users.last_name) AS user 
        FROM attendance " . $leftjoin . $where);
        $results = $query->result_array();
        foreach ($system_users as $user) {
            if ($user->finger_config == '1' && $user->active == '1') {
                $total_staff++;
                $userPresent = false;
                foreach ($results as $attendance) {
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
        if ($this->ion_auth->is_admin() || is_assign_users()) {
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
        if ($this->ion_auth->is_admin() || is_assign_users()) {
            $where3 .= " ";
        } else {
            $user = $this->ion_auth->user()->row();
            $user_id = $user->id;
            $employee_id = get_employee_id_from_user_id($user_id);
            $where3 .= " AND biometric_missing.user_id = '" . $employee_id . "'";
        }
        $BioQuery = $this->db->query("SELECT biometric_missing.*, CONCAT(users.first_name, ' ', users.last_name) AS user FROM biometric_missing " . $leftjoin3 . $where3 . " AND biometric_missing.saas_id =" . $this->session->userdata('saas_id'));
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
        FROM attendance " . $leftjoin . $where . " AND users.finger_config=1");
        $results = $query->result_array();
        return $results;
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
        $shift = $this->shift_model->get_shift_log_by_id($shift_id, $date);
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
        $shortLeave = false;
        $halfDayLeave = false;
        $checkoffclock = false;
        $checkInDateTime = new DateTime($date . ' ' . $checkInTime);
        if ($checkInDateTime != $checkOutDateTime) {
            if ($this->checkHalfDayLeave($date, $employee_id, $date,)) {
                $halfDayLeave = true;
                $lateMinutes = 0;
            } else {
                if ($checkInDateTime > $halfDayStartDateTime || $checkOutDateTime < $halfDayEndDateTime) {
                    $halfDay = true;
                } else {
                    if ($checkInDateTime > $shiftStartDateTime) {
                        if ($this->checkFirstTimeShort($checkInTime, $shiftStartTime, $employee_id, $date)) {
                            $shortLeave = true;
                            $lateMinutes = 0;
                        } else {
                            if ($this->checkoffclock($employee_id, $date)) {
                                $checkoffclock = true;
                                $lateMinutes = 0;
                            } else {
                                $lateMinutes = $this->att_model->get_late_min($employee_id, $date, $date);
                            }
                        }
                    } elseif ($checkOutDateTime < $shiftEndDateTime) {
                        if ($this->checkSecondTimeShort($checkOutTime, $shiftEndTime, $employee_id, $date)) {
                            $shortLeave = true;
                            $lateMinutes = 0;
                        }
                    } else {
                        $lateMinutes = 0;
                    }
                }
            }
        } elseif ($date == date('Y-m-d')) {
        } else {
            $halfDay = true;
        }

        return [
            'checkInTime' => $checkInTime,
            'checkOutTime' => $checkOutTime,
            'shiftStartTime' => $shiftStartTime,
            'shiftEndTime' => $shiftEndTime,
            'halfDayCheckIn' => $halfDayCheckIn,
            'halfDayCheckOut' => $halfDayCheckOut,
            'halfDay' => $halfDay,
            'shortLeave' => $shortLeave,
            'halfDayLeave' => $halfDayLeave,
            'lateMinutes' => $lateMinutes,
            'checkoffclock' => $checkoffclock,
            'shift_id' => $shift_id,
            'shift' => $shift,
        ];
    }
    private function checkoffclock($employee_id, $date)
    {
        $this->db->select('*');
        $this->db->from('offclock');
        $this->db->where('user_id', $employee_id);
        $this->db->where('date', $date);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkFirstTimeShort($checkInTime, $shiftStartTime, $employee_id, $date)
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
            $leaveStart = $results->starting_time;
            if ($shiftStartTime >= $leaveStart) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    public function checkSecondTimeShort($checkOutTime, $shiftEndTime, $employee_id, $date)
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
