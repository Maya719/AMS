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
        if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) {
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

    function get_leaves_by_id($id)
    {
        $where = "";
        $where .= " WHERE id = $id ";
        $where .= " AND saas_id = " . $this->session->userdata('saas_id');
        $query = $this->db->query("SELECT * FROM leaves " . $where);
        $results = $query->result_array();
        foreach ($results as &$value) {
            $query = $this->db->query("SELECT id FROM users WHERE employee_id = " . $value["user_id"]);
            $user = $query->row();
            $value["user_id"] = $user->id;
            $value["starting_date"] = format_date($value['starting_date'], system_date_format());
            $value["ending_date"] = format_date($value['ending_date'], system_date_format());
            $stepResult = $this->getStatusForword($id);
            $step = $stepResult["level"];
            $group = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->result();
            $current_group_id = $group[0]->id;
            $emppp = get_employee_id_from_user_id($user->id);
            $forword_result = $this->is_forworded($current_group_id, $step, $emppp);
            if ($value["status"] == 1) {
                $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-success mx-2" disabled>Approved</button>';
            } elseif ($value["status"] == 2) {
                $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-danger mx-2" disabled>Rejected</button>';
            } elseif ($forword_result["is_forworded"] && (permissions('leaves_status') || permissions('leaves_edit') || $this->ion_auth->is_admin())) {
                $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-primary mx-2" disabled>Forworded To ' . $forword_result["forworded_to"] . '</button>';
            } else {
                $value["btnHTML"] = '<button type="button" class="btn btn-edit-leave btn-block btn-primary mx-2">Save</button>';
                if (permissions('leaves_delete') || $this->ion_auth->is_admin()) {
                    $value["btnHTML"] .= '<button type="button" class="btn btn-delete-leave btn-block btn-danger">Delete</button>';
                }
            }
            $value["forword_result"] = $forword_result;
        }
        return $results;
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
        if (isset($get['leave_type']) &&  !empty($get['leave_type'])) {
            $type = $get["leave_type"];
            $where .= " AND l.type = " . $type;
        }
        if ($this->ion_auth->is_admin() || permissions('leaves_view_all')) {
            if (isset($get['user_id']) && !empty($get['user_id'])) {
                $where .= " AND l.user_id = " . $get['user_id'];
            }
        } else {
            if (permissions('leaves_view_selected')) {
                $selected = selected_users();
                foreach ($selected as $value) {
                    $selected[] = get_employee_id_from_user_id($value);
                }
                $selected[] = get_employee_id_from_user_id($this->session->userdata('user_id'));
                if (!empty($selected)) {
                    $userIdsString = implode(',', $selected);
                    $where .= " AND l.user_id IN ($userIdsString)";
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
            $step = $logs["level"];
            $Logstatus = $logs["status"];
            $forword_result = $this->is_forworded($current_group_id, $step, $leave['user_id']);
            if ($leave['status'] == 0) {
                if (($forword_result["is_forworded"]) && (permissions('leaves_status') || $this->ion_auth->is_admin())) {
                    $leave['btn'] = false;
                    if ($Logstatus == 1) {
                        $leave['status'] = '<span class="badge light badge-success">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Approved & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    } elseif ($Logstatus == 2) {
                        $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Rejected & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    } else {
                        $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Forworded to ' . $forword_result["forworded_to"]) . '</span>';
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
                    $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Rejected & Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                    $leave['btn'] = false;
                } else {
                    $leave['btn'] = false;
                    $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected') . '</span>';
                }
            }
        }
        return $results;
    }

    /*
    *
    *
    * Forworded To 
    */
    public function is_forworded($group_id, $step, $user_id)
    {
        $saas_id = $this->session->userdata('saas_id');
        $this->db->where('saas_id', $saas_id);
        $this->db->where('step_no', $step);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('leave_hierarchy');
        $array = [];
        if ($row = $query->row()) {
            $array = [
                'is_forworded' => false,
                'forworded_to' => null,
            ];
        } else {

            $this->db->where('saas_id', $saas_id);
            $this->db->where('step_no', $step);
            $query = $this->db->get('leave_hierarchy');
            if ($rows = $query->result()) {
                foreach ($rows as $row) {
                    $step_group = $row->group_id;
                    if ($step_group != $group_id) {
                        $group = $this->ion_auth->group($step_group)->row();
                        $assigned_users = json_decode($group->assigned_users);
                        foreach ($assigned_users as $assignee) {
                            $emp_id = get_employee_id_from_user_id($assignee);
                            if ($emp_id == $user_id) {
                                $array = [
                                    'is_forworded' => true,
                                    // 'forworded_to' => $step_group,
                                    'forworded_to' => $group->description,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $array;
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
    function user_leave_policy($data)
    {
        if ($this->db->insert('applied_policies', $data))
            return $this->db->insert_id();
        else
            return $this->db->last_query();;
    }
    function update_user_leave_policy($id, $data)
    {
        $this->db->where('user_id', $id);
        if ($this->db->update('applied_policies', $data))
            return true;
        else
            return false;
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

    public function get_leaves_count($result)
    {
        $user_id2 = isset($result['user_id']) ? $result['user_id'] : $this->session->userdata('user_id');
        $user_id = get_employee_id_from_user_id($user_id2);
        $saas_id = $this->session->userdata('saas_id');
        // get consume leaves
        $currentDate = date('Y-m-d');
        $currentYear = date('Y');
        $currentMonth = date('m');

        $from = $currentYear . '-01-01';
        $too = $currentYear . '-12-31';

        $this->db->from('leaves_type');
        $this->db->where('saas_id', $saas_id);
        $leaveTypes = $this->db->get();
        $leaves_types = $leaveTypes->result();
        foreach ($leaves_types as $type) {
            $consumed_leaves = 0;
            $paid_leaves = 0;
            $unpaid_leaves = 0;
            $this->db->from('leaves');
            $this->db->where('user_id', $user_id);
            $this->db->where('status', '1');
            $this->db->where('type', $type->id);
            $this->db->where('starting_date >=', $from);
            $this->db->where('starting_date <=', $too);
            $query = $this->db->get();
            $leaves = $query->result();
            foreach ($leaves as $leave) {
                $startDate = new DateTime($leave->starting_date);
                $endDate = new DateTime($leave->ending_date);
                $leaveDuration = $endDate->diff($startDate)->days + 1;
                if (strpos($leave->leave_duration, 'Full') !== false) {
                    $consumed_leaves += $leaveDuration;
                    if ($leave->paid == 0) {
                        $paid_leaves += $leaveDuration;
                    } else {
                        $unpaid_leaves += $leaveDuration;
                    }
                } elseif (strpos($leave->leave_duration, 'Half') !== false) {
                    $consumed_leaves += $leaveDuration * 0.5;
                    if ($leave->paid == 0) {
                        $paid_leaves += 0.5;
                    } else {
                        $unpaid_leaves += 0.5;
                    }
                }
            }
            $leavesArray[] = $leaves;
            $TotalLeaveArray[] = $type->leave_counts;
            $LeaveTypeArray[] = $type->name;
            $consumeArray[] = $consumed_leaves;
            $paidArray[] = $paid_leaves;
            $unpaidArray[] = $unpaid_leaves;
        }

        return array(
            'total_leaves' =>  $TotalLeaveArray,
            'leave_types' =>  $LeaveTypeArray,
            'consumed_leaves' => $consumeArray,
            'paidArray' => $paidArray,
            'unpaidArray' => $unpaidArray,
            'user_id' => $user_id,
            'leavesArray' => $leavesArray,
        );
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
}
