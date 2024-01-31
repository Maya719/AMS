<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biometric_missing_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    function delete($user_id, $id){
        if($this->ion_auth->is_admin() || permissions('biometric_request_view_all') || permissions('biometric_request_view_selected')){
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }else{
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
        }
        if($this->db->delete('biometric_missing'))
            return true;
        else
            return false;
    }

    function get_biometric_by_id($id){
        $where = "";
    
        if($this->ion_auth->is_admin() || permissions('biometric_request_view_all') || permissions('biometric_request_view_selected')){
            $where .= " WHERE bm.id = $id ";
        }else{
            $where .= " WHERE bm.user_id = ".$this->session->userdata('user_id');
            $where .= " AND bm.id = $id ";
        }
    
        $where .= " AND bm.saas_id = ".$this->session->userdata('saas_id');
    
        $query = $this->db->query("
            SELECT bm.*, u.id as user
            FROM biometric_missing bm
            LEFT JOIN users u ON bm.user_id = u.employee_id
            $where
        ");
    
        $results = $query->result_array();  
    
        return $results;
    }
    

    function get_biometric() {
        $get = $this->input->get();
        $where = '';
    
        if ($this->ion_auth->is_admin() || permissions('biometric_request_view_all')) {
            if (isset($get['user_id']) && !empty($get['user_id'])) {
                $where .= " WHERE bm.user_id = ".$get['user_id'];
            } else {
                $where .= " WHERE bm.id != ''";
            }
        } else {
            if (permissions('biometric_request_view_selected')) {
                if (isset($get['user_id']) && !empty($get['user_id'])) {
                    $where .= " WHERE bm.user_id = ".$get['user_id'];
                } else {
                    $selected = selected_users();
                    $selected[] = $this->session->userdata('employee_id');
                
                    if (!empty($selected)) {
                        $userIdsString = implode(',', $selected);
                        $where = " WHERE bm.user_id IN ($userIdsString)";
                    }
                }
            }else{
                $where .= " WHERE bm.user_id = ".$this->session->userdata('employee_id');
            }
        }
        
        if (isset($get['status']) && !empty($get['status'])) {
            if ($get['status'] == "3") {
               $get['status']='0';
            }
            $where .= " AND bm.status = ".$get['status'];
        }
    
        $where .= " AND bm.saas_id = ".$this->session->userdata('saas_id');
        $where .= " AND (DATE(bm.date) BETWEEN '{$get["from"]}' AND '{$get["too"]}')  ";

        
        $LEFT_JOIN = " LEFT JOIN users u ON u.employee_id = bm.user_id ";
    
        $query = $this->db->query("SELECT bm.*, CONCAT(u.first_name, ' ', u.last_name) as user FROM biometric_missing bm $LEFT_JOIN ".$where);
        $results = $query->result_array();
        foreach ($results as &$request) {
            if ($request['status'] == 0 && ($this->ion_auth->is_admin() || permissions('biometric_request_status'))) {
                $request['btn'] =true;
                $request['status'] = '<span class="badge light badge-info">' . ($this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending') . '</span>';
            } elseif ($request['status'] == 1) {
                $request['btn'] =false;
                $request['status'] = '<span class="badge light badge-success">' . ($this->lang->line('approved') ? htmlspecialchars($this->lang->line('approved')) : 'Approved') . '</span>';
            } else {
                $request['btn'] =true;
                $request['status'] = '<span class="badge light badge-danger">' . ($this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected') . '</span>';
            }

            $time = DateTime::createFromFormat('H:i:s', $request["time"]);
            $formattedTime = $time->format('h:i A');
            $request['time'] = $formattedTime;
        }
        return $results;
    
    }

    function create($data){
        if($this->db->insert('biometric_missing', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function edit($id, $data){
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        if($this->db->update('biometric_missing', $data))
            return true;
        else
            return false;
    }

    function get_shift_time($result){
        $user_id = isset($result['user_id']) ? $result['user_id'] : $this->session->userdata('user_id');
        $shift_query = $this->db->query("SELECT * FROM users WHERE id = $user_id");
        $shift_result = $shift_query->row_array();
        $shift_id = $shift_result['shift_id'];
        $sqlQuery = $this->db->last_query();

        if ($shift_id == 0) {
            return array(
                'check_in' => '09:00 AM',
                'check_out' => '06:00 PM'
            );
        } else {
            $shift_query = $this->db->query("SELECT * FROM shift WHERE id = $shift_id");
            $shift_result = $shift_query->row_array();
            $sqlQuery = $this->db->last_query();
            return array(
                'check_in' => $shift_result['starting_time'],
                'check_out' => $shift_result['ending_time']
            );
        }  
        
    }

}
