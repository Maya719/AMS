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
        $start_from = $this->input->get("from");
        $end_date = $this->input->get("too");

        // Fetch attendance data once
        $attendance_data = $this->att_model->get_attendance(
            '',
            $start_from,
            $end_date,
            $this->input->get("shift"),
            $this->input->get("department"),
            $this->input->get("status")
        );

        // Get users
        $users = $this->system_users($this->input->get());
        $active = ($this->input->get("status") == '1') ? 1 : 0;

        // Format attendance data
        $dateArray = $this->get_date_range($start_from, $end_date);
        $formattedData = $this->att_model->set_attendance($attendance_data, $users, $start_from, $end_date, $dateArray, $active);

        // Prepare the output
        $monthCounts = $this->get_monthly_counts($dateArray);

        $output = [
            'data' => array_values($formattedData),
            'range' => $monthCounts,
            'users' => $users,
        ];

        echo json_encode($output);
    }

    // Function to get date range array
    private function get_date_range($start_from, $end_date)
    {
        $dateArray = [];
        $fromDate = new DateTime($start_from);
        $toDate = new DateTime($end_date);
        $interval = new DateInterval('P1D');
        $datePeriod = new DatePeriod($fromDate, $interval, $toDate->modify('+1 day'));

        foreach ($datePeriod as $date) {
            $dateArray[] = $date->format('Y-m-d');
        }

        return $dateArray;
    }

    // Function to get monthly counts
    private function get_monthly_counts($dateArray)
    {
        $groupedData = [];

        foreach ($dateArray as $date) {
            $monthYear = date('M Y', strtotime($date));
            if (!isset($groupedData[$monthYear])) {
                $groupedData[$monthYear] = [];
            }
            $groupedData[$monthYear][] = $date;
        }

        return array_map('count', $groupedData);
    }

    public function system_users($get)
    {
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
        return $system_users;
    }
    public function single_user_attendance()
    {
        $start_from = date('Y-08-01');
        $end_date = date('Y-m-d');
        $attendance = $this->att_model->get_attendance('1995', $start_from, $end_date);
        $grouped_data = $this->att_model->group_attendance($attendance);
        $late_min = $this->att_model->get_late_min('1995', $start_from, $end_date, $attendance);
        $absents = ($this->att_model->get_absents('1995', $start_from, $end_date, $attendance));
        $leaves = $this->leaves_model->get_db_leaves('1995', $start_from, $end_date);
        echo json_encode(array('late_min' => $late_min, 'absents' => $absents, 'leaves' => $leaves, 'attendance' => $grouped_data));
    }
    public function get_late_min()
    {
        $start_from = date('Y-07-07');
        $end_date = date('Y-08-07');
        $late_min = $this->att_model->get_late_min('1859', $start_from, $end_date);
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
        $start_from = date('Y-08-01');
        $end_date = date('Y-m-d');
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
    public function check_probation()
    {
        $too = date('Y-m-d');
        $user = $this->ion_auth->user()->row();
        $probation = $this->att_model->check_probation($user, $too);
        echo json_encode($probation);
    }
    public function get_db_leave_types()
    {
        $from = date('Y-01-01');
        $too = date('Y-m-d');
        $leave_types = $this->att_model->get_db_leave_types();
        $user = $this->ion_auth->user('33')->row();

        $leave_summary = []; // Initialize an array to store the leave summaries

        foreach ($leave_types as $leave_type) {
            $paid_leaves = 0;
            $unpaid_leaves = 0;
            $leaves = $this->att_model->get_db_leaves($user->employee_id, $from, $too, $leave_type->id);

            foreach ($leaves as $leave) {
                $leaveDuration = (new DateTime($leave->ending_date))->diff(new DateTime($leave->starting_date))->days + 1;

                if (strpos($leave->leave_duration, 'Full') !== false) {
                    if ($leave->paid == 0) {
                        $paid_leaves += $leaveDuration;
                    } else {
                        $unpaid_leaves += $leaveDuration;
                    }
                } elseif (strpos($leave->leave_duration, 'Half') !== false) {
                    if ($leave->paid == 0) {
                        $paid_leaves += 0.5;
                    } else {
                        $unpaid_leaves += 0.5;
                    }
                }
            }

            $leave_summary[] = [
                'leave_type_name' => $leave_type->name,
                'total_leaves' => $this->att_model->get_total_of_leave_type_for_user($leave_type, $user, $too),
                'paid_leaves' => $paid_leaves,
                'unpaid_leaves' => $unpaid_leaves,
            ];
        }
        echo json_encode($leave_summary);
    }
    public function get_leaves_counts()
    {
        $start_from = date('Y-08-20');
        $leaves = $this->att_model->half_day_absent('952', $start_from);
        echo $leaves;
    }
}
