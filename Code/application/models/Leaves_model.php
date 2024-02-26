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
        if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) {
            $where .= " WHERE id = $id ";
        } else {
            $where .= " WHERE id = $id ";
        }

        $where .= " AND saas_id = " . $this->session->userdata('saas_id');

        $query = $this->db->query("SELECT * FROM leaves " . $where);

        $results = $query->result_array();
        foreach ($results as &$value) {
            $query = $this->db->query("SELECT id FROM users WHERE employee_id = " . $value["user_id"]);
            $user = $query->row();
            $value["user_id"] = $user->id;
        }
        return $results;
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
                $selected[] = $this->session->userdata('user_id');

                if (!empty($selected)) {
                    $userIdsString = implode(',', $selected);
                    $where = " AND l.user_id IN ($userIdsString)";
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
            if ($leave['paid'] == 0) {
                $leave['paid'] = ($this->lang->line('paid') ? htmlspecialchars($this->lang->line('paid')) : 'Paid Leave');
            } else {
                $leave['paid'] = ($this->lang->line('unpaid') ? htmlspecialchars($this->lang->line('unpaid')) : 'Unpaid Leave');
            }
            if ($leave['status'] == 0) {
                $group = $this->ion_auth->get_users_groups($this->session->userdata('user_id'))->result();
                $current_group_id = $group[0]->id;
                $step = $leave['step'];
                $forword_result = $this->is_forworded($current_group_id, $step);
                if ($forword_result["is_forworded"]) {
                    $leave['btn'] = false;
                    $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('forworded') ? htmlspecialchars($this->lang->line('forworded')) : 'Forworded to ' . $forword_result["forworded_to"]) . '</span>';
                } else {
                    $leave['btn'] = true;
                    $leave['status'] = '<span class="badge light badge-info">' . ($this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending') . '</span>';
                }
            } elseif ($leave['status'] == 1) {
                $leave['btn'] = true;
                $leave['status'] = '<span class="badge light badge-success">' . ($this->lang->line('approved') ? htmlspecialchars($this->lang->line('approved')) : 'Approved') . '</span>';
            } else {
                $leave['btn'] = false;
                $leave['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected') . '</span>';
            }
        }

        return $results;
    }

    public function is_forworded($group_id, $step)
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
            if ($row = $query->row()) {
                $step_group = $row->group_id;
                if ($step_group != $group_id) {
                    $group = $this->ion_auth->group($step_group)->row();
                    $array = [
                        'is_forworded' => true,
                        'forworded_to' => $group->description,
                    ];
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

        $total_leaves = 0;
        $consumed_leaves = 0;
        $remaining_leaves = 0;
        $type = $result['type'];
        $user_id2 = isset($result['user_id']) ? $result['user_id'] : $this->session->userdata('user_id');
        $user_id = get_employee_id_from_user_id($user_id2);
        // get consume leaves
        $currentDate = date('Y-m-d');
        $currentYear = date('Y');
        $currentMonth = date('m');

        $from = $currentYear . '-01-01';
        $too = $currentYear . '-12-31';

        $this->db->from('leaves');
        $this->db->where('user_id', $user_id);
        $this->db->where('type', $type);
        $this->db->where('status', '1');
        $this->db->where('starting_date >=', $from);
        $this->db->where('starting_date <=', $too);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result();
            foreach ($result as $leave) {
                $startDate = new DateTime($leave->starting_date);
                $endDate = new DateTime($leave->ending_date);
                $leaveDuration = $endDate->diff($startDate)->days + 1;
                if (strpos($leave->leave_duration, 'Full') !== false) {
                    $consumed_leaves += $leaveDuration;
                } elseif (strpos($leave->leave_duration, 'Half') !== false) {
                    $consumed_leaves += $leaveDuration * 0.5;
                }
            }
        }
        $this->db->where('id', $type);
        $query3 = $this->db->get('leaves_type');
        $leave_type = $query3->row();
        $total_leaves = $leave_type->leave_counts;
        $duration = $leave_type->duration;
        // get user probation
        $probation_query = $this->db->select('probation')->from('users')->where('id', $user_id2)->get();
        $probation_data = $probation_query->row();
        $probation = $probation_data->probation;
        $probationYear = date('Y', strtotime($probation));
        $probationMonth = date('n', strtotime($probation));
        if ($probation > date('Y-m-d')) {
            $total_leaves = 0;
            $remaining_leaves = 0;
        } elseif ($probationYear < $currentYear) {
            if($duration == '3_months'){
                if ($currentMonth >= 1 && $currentMonth <= 3) {
                    $slice = 4;
                } elseif ($currentMonth >= 4 && $currentMonth <= 6) {
                    $slice =3;

                } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
                    $slice =2;

                } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
                    $slice =1;
                }
            }elseif($duration == '4_months'){

                if ($currentMonth >= 1 && $currentMonth <= 4) {
                    $slice =3;
                } elseif ($currentMonth >= 5 && $currentMonth <= 8) {
                    $slice =2;

                } elseif ($currentMonth >= 9 && $currentMonth <= 12) {
                    $slice =1;
                }

            }elseif($duration == '6_months'){

                if ($currentMonth >= 1 && $currentMonth <= 6) {
                    $slice =2;
                } elseif ($currentMonth >= 7 && $currentMonth <= 12) {
                    $slice =1;
                }

            }elseif($duration == 'year'){
                if ($currentMonth >= 1 && $currentMonth <= 12) {
                    $slice =1;
                }
            }
            $total_leaves = $total_leaves*$slice;
            $remaining_leaves =  $total_leaves-$consumed_leaves;
        } elseif ($probationYear === $currentYear) {
            $total_leaves =0;
            $remaining_leaves =  0;
        }
        return array(
            'total_leaves' =>  $total_leaves,
            'consumed_leaves' => $consumed_leaves,
            'remaining_leaves' => $remaining_leaves,
            'slice' => $slice,
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
