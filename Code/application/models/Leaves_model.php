<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leaves_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function delete($id)
    {
        if ($this->ion_auth->is_admin() || is_assign_users()) {
            $this->db->where('id', $id);
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        } else {
            $this->db->where('id', $id);
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if ($this->db->delete('leaves'))
            return true;
        else
            return false;
    }
    function deleteLeave($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('leaves'))
            return true;
        else
            return false;
    }
    function deleteLog($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('leave_logs'))
            return true;
        else
            return false;
    }

    function get_leaves_by_id($id)
    {
        $where = "";
        $where .= " WHERE id = $id ";
        $where .= " AND saas_id = " . $this->session->userdata('saas_id');
        $query = $this->db->query("SELECT * FROM leaves " . $where);
        $results = $query->result_array();
        foreach ($results as &$value) {
            $query = $this->db->query("SELECT * FROM users WHERE employee_id = " . $value["user_id"]);
            $user = $query->row();
            $value["user_id"] = $user->id;
            $active = $user->active;
            $value["starting_date"] = format_date($value['starting_date'], system_date_format());
            $value["ending_date"] = format_date($value['ending_date'], system_date_format());
            $stepResult = $this->getStatusForword($id);
            $step = $stepResult["level"];
            $group = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->result();
            $current_group_id = $group[0]->id;
            $emppp = get_employee_id_from_user_id($user->id);
            $forword_result = $this->is_forworded($current_group_id, $step, $emppp);
            $value["current_group_id"] = $current_group_id;
            $value["step"] = $step;
            if ($active == '1') {
                if ($value["status"] == 1) {
                    $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-success mx-2" disabled>Approved</button>';
                } elseif ($value["status"] == 2) {
                    $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-danger mx-2" disabled>Rejected</button>';
                } elseif ($forword_result["is_forworded"] && (permissions('leaves_status') || permissions('leaves_edit') || $this->ion_auth->is_admin())) {
                    $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-primary mx-2" disabled>Forworded To ' . $forword_result["forworded_to"] . '</button>';
                } else {
                    if (permissions('leaves_delete') || $this->ion_auth->is_admin()) {
                        $value["btnHTML"] = '<button type="button" class="btn btn-delete-leave btn-block col btn-danger mx-2">Delete</button>';
                    }
                    $value["btnHTML"] .= '<button type="button" class="btn btn-edit-leave btn-block col btn-primary ">Save</button>';
                }
            } else {
                $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-danger mx-2" disabled>User is deactive</button>';
            }
            $value["forword_result"] = $forword_result;
        }
        return $results;
    }
    function get_leave_duration($id)
    {
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        $query = $this->db->get('leaves');
        $value = $query->row_array();
        if ($value) {
            $starting_date = strtotime($value['starting_date']);
            $ending_date = strtotime($value['ending_date']);
            $leaveDurationInSeconds = $ending_date - $starting_date;
            $leaveDurationInDays = $leaveDurationInSeconds / 86400;
            return $leaveDurationInDays + 1;
        }
        return 0;
    }


    /*
    *
    *
    * Forworded To 
    */
    public function is_forworded($group_id, $step, $employee_id)
    {
        $step_groupArray = [];
        $user_id = get_user_id_from_employee_id($employee_id);
        $saas_id = $this->session->userdata('saas_id');
        $this->db->where('saas_id', $saas_id);
        $this->db->where('step_no', $step);
        $query = $this->db->get('leave_hierarchy');
        $rows = $query->result();
        foreach ($rows as &$row) {
            $step_group = $row->group_id;
            $step_groupArray[] = $row->group_id;
            $group = $this->ion_auth->group($step_group)->row();
            $assigned_users = json_decode($group->assigned_users);
            if ($step_group == $group_id) {
                $array = [
                    'is_forworded' => false,
                    'forworded_to' => null,
                ];
                break;
            } else {
                if ($assigned_users) {
                    if (in_array($user_id, $assigned_users)) {
                        $array = [
                            'is_forworded' => true,
                            'forworded_to' => $group->description,
                        ];
                        break;
                    }
                } else {
                    $array = [
                        'is_forworded' => true,
                        'forworded_to' => $group->description,
                    ];
                }
            }
        }
        return $array;
    }
    function getStatusForword($id)
    {
        $saas_id = $this->session->userdata('saas_id');
        $this->db->where('leave_id', $id);
        $this->db->order_by('level', 'DESC');
        $this->db->limit(1);
        $logs_query = $this->db->get('leave_logs');
        $latest_log = $logs_query->row_array();
        return $latest_log;
    }
    function get_leaves()
    {
        $get = $this->input->get();
        $fromDate = $get["from"];
        $toDate = $get["too"];
        $where = '';
        $where .= " WHERE l.saas_id = " . $this->session->userdata('saas_id');

        $where .= " AND ((DATE(l.starting_date) BETWEEN '{$fromDate}' AND '{$toDate}') OR (DATE(l.ending_date) BETWEEN '{$fromDate}' AND '{$toDate}')) ";
        if (isset($get['status']) &&  !empty($get['status'])) {
            $status = $get["status"];
            if ($status == '3') {
                $status = '0';
            }
            $where .= " AND l.status = " . $status;
        }
        if (isset($get['userstatus']) &&  !empty($get['userstatus'])) {
            $userstatus = $get["userstatus"];
            if ($userstatus == '1') {
                $active = '1';
            } else {
                $active = '0';
            }
            $where .= " AND u.active = " . $active;
        }

        if (isset($get['leave_type']) &&  !empty($get['leave_type'])) {
            $type = $get["leave_type"];
            $where .= " AND l.type = " . $type;
        }
        if ($this->ion_auth->is_admin()) {
            if (isset($get['user_id']) && !empty($get['user_id'])) {
                $where .= " AND l.user_id = " . $get['user_id'];
            }
        } else {
            if (is_assign_users()) {
                $selected = selected_users();
                foreach ($selected as $value) {
                    $selected[] = get_employee_id_from_user_id($value);
                }
                $selected[] = get_employee_id_from_user_id($this->session->userdata('user_id'));
                if (!empty($selected)) {
                    $userIdsString = implode(',', $selected);
                    $where .= " AND l.user_id IN ($userIdsString)";
                }
                if (isset($get['user_id']) && !empty($get['user_id'])) {
                    $where .= " AND l.user_id = " . $get['user_id'];
                }
            } else {
                $id = get_employee_id_from_user_id($this->session->userdata('user_id'));
                $where .= " AND l.user_id = " . $id;
            }
        }
        $LEFT_JOIN = " LEFT JOIN users u ON u.employee_id = l.user_id ";
        $LEFT_JOIN .= " LEFT JOIN leaves_type lt ON lt.id = l.type ";

        $query = $this->db->query("SELECT l.*, CONCAT(u.first_name, ' ', u.last_name) as user, lt.name FROM leaves l $LEFT_JOIN " . $where . " ORDER BY created DESC");
        $results = $query->result_array();
        usort($results, function ($a, $b) {
            return strtotime($b['created']) - strtotime($a['created']);
        });
        foreach ($results as &$leave) {
            $leave['starting_date'] = date('d M, Y', strtotime($leave['starting_date']));
            $leave['ending_date'] = date('d M, Y', strtotime($leave['ending_date']));
            $leave['starting_time'] = date('h:i A', strtotime($leave['starting_time']));
            $leave['ending_time'] = date('h:i A', strtotime($leave['ending_time']));
            $upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/leaves/';
            if ($leave['document']) {
                $leave['document'] = '<a class="btn btn-link btn-sm" href="' . base_url($upload_path . $leave['document']) . '" download><i class="fas fa-download"></i> click</a>';
            }
            if ($leave['paid'] == 0) {
                $leave['paid'] = ($this->lang->line('paid') ? htmlspecialchars($this->lang->line('paid')) : 'Paid Leave');
            } else {
                $leave['paid'] = ($this->lang->line('unpaid') ? htmlspecialchars($this->lang->line('unpaid')) : 'Unpaid Leave');
            }
            $group = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->result();
            $current_group_id = $group[0]->id;
            $logs = $this->getStatusForword($leave['id']);
            $leave['logs'] = $logs;
            $leave['step'] = $logs["level"];
            $step = $logs["level"];
            $Logstatus = $logs["status"];
            $forword_result = $this->is_forworded($current_group_id, $step, $leave['user_id']);

            $leave['current_group_id'] = $current_group_id;
            $leave['forword_result'] = $forword_result;
            if ($leave['status'] == 0) {
                if (($forword_result["is_forworded"]) && (permissions('leaves_status') || $this->ion_auth->is_admin())) {
                    $leave['btn'] = false;
                    if ($Logstatus == 1) {
                        $leave['status'] = '<span class="badge light badge-success">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) :  $forword_result["forworded_to"]) . '</span>';
                        // $leave['status'] = '<span class="badge light badge-success">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Approved & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    } elseif ($Logstatus == 2) {
                        $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : $forword_result["forworded_to"]) . '</span>';
                        // $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Rejected & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    } else {
                        $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : $forword_result["forworded_to"]) . '</span>';
                        // $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    }
                } else {
                    $leave['btn'] = true;
                    $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending') . '</span>';
                }
            } elseif ($leave['status'] == 1) {
                $leave['btn'] = false;
                $leave['status'] = '<span class="badge light badge-success">' . ($this->lang->line('approved') ? htmlspecialchars($this->lang->line('approved')) : 'Approved') . '</span>';
            } elseif ($leave['status'] == 2) {
                if ($forword_result["is_forworded"]) {
                    $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : $forword_result["forworded_to"]) . '</span>';
                    // $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Rejected & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    $leave['btn'] = false;
                } else {
                    $leave['btn'] = false;
                    $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected') . '</span>';
                }
            }
        }
        return $results;
    }




    function create($data)
    {
        if ($this->db->insert('leaves', $data))
            return $this->db->insert_id();
        else
            return $this->db->last_query();;
    }
    function createLog($data)
    {
        if ($this->db->insert('leave_logs', $data))
            return $this->db->insert_id();
        else
            return $this->db->last_query();;
    }
    function create_status($data)
    {
        if ($this->db->insert('leave_level', $data))
            return $this->db->insert_id();
        else
            return $this->db->last_query();;
    }

    function edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        if ($this->db->update('leaves', $data))
            return true;
        else
            return false;
    }

    public function get_department_time()
    {
        $query = $this->db->query("SELECT value FROM settings WHERE type='department_' ");
        $result = $query->result_array();

        if ($result) {
            return $result[0]['value'];
        } else {
            return false;
        }
    }



    function sandwich_rule($startDate, $endDate)
    {
        $oneDayBefore = clone $startDate;
        $oneDayBefore->sub(new DateInterval('P1D'));
        $oneDayAfter = clone $endDate;
        $oneDayAfter->add(new DateInterval('P1D'));
        $dayAfterIsWeekend = in_array($oneDayAfter->format('l'), ['Saturday', 'Sunday']);
        $dayBeforeIsWeekend = in_array($oneDayBefore->format('l'), ['Saturday', 'Sunday']);
        $days = 0;
        if ($dayBeforeIsWeekend || $dayAfterIsWeekend) {
            $days = 2;
        }

        $query = $this->db->get('holiday');
        $holidays = $query->result();

        foreach ($holidays as $holiday) {
            $starting_date = new DateTime($holiday->starting_date);
            $ending_date = new DateTime($holiday->ending_date);

            if ($starting_date == $oneDayAfter || $ending_date == $oneDayBefore) {
                $days += $starting_date->diff($ending_date)->days + 1;
            }
        }

        return $days;
    }
    public function leaveStep($current_user_step, $user_id)
    {
        $saas_id = $this->session->userdata('saas_id');
        $user_id = get_user_id_from_employee_id($user_id);
        $step = ($current_user_step ? $current_user_step : 0) + 1;

        // Get the highest step number from leave_hierarchy
        $this->db->where('saas_id', $saas_id);
        $this->db->select_max('step_no');
        $query = $this->db->get('leave_hierarchy');
        $row = $query->row_array();
        $highest_step = $row['step_no'];

        for ($i = $step; $i <= $highest_step; $i++) {
            $this->db->where('saas_id', $saas_id);
            $this->db->where('step_no', $i);
            $query = $this->db->get('leave_hierarchy');
            $rows = $query->result();
            foreach ($rows as $row) {
                $step_group = $row->group_id;
                $group = $this->ion_auth->group($step_group)->row();
                $assigned_users = json_decode($group->assigned_users);
                if ($assigned_users) {
                    if (in_array($user_id, $assigned_users)) {
                        return $i;
                    }
                } else {
                    return $i;
                }
            }
        }
        return $step;
    }
    public function handle_document_upload()
    {
        if (!empty($_FILES['documents']['name'])) {
            $upload_path = 'assets/uploads/f' . $this->session->userdata('saas_id') . '/leaves/';

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0775, true);
            }
            $config = [
                'upload_path' => $upload_path,
                'allowed_types' => '*',
                'overwrite' => false,
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0
            ];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('documents')) {
                return $this->upload->data('file_name');
            }
        }
        return '';
    }
    public function get_shift_times($user_id)
    {
        $shift_id_query = $this->db->select('shift_id')->get_where('users', ['id' => $user_id]);
        $shift_id = $shift_id_query->row()->shift_id;
        $shift_table = $this->db->get_where('shift', ['id' => $shift_id !== '0' ? $shift_id : 1]);
        $shift_row = $shift_table->row();

        return [
            'check_in' => $shift_row->starting_time,
            'break_start' => $shift_row->break_start,
            'break_end' => $shift_row->break_end,
            'check_out' => $shift_row->ending_time
        ];
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
    /**
     * Retrieve leave types from the database, optionally filtering by a specific ID.
     *
     * @param mixed $id Optional ID to filter the leave types. If provided, only the leave type with this ID will be returned.
     * 
     * @return array Returns an array of leave type objects from the database.
     */
    public function get_db_leave_types($id = '')
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
    
}
