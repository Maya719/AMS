<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    function delete($id){
         $this->db->where('id', $id);
        if($this->db->delete('holiday'))
            return true;
        else
            return false;
    }

    function get_holiday_by_id($id){
        $where = " WHERE id = $id ";

        $query = $this->db->query("SELECT * FROM holiday ".$where);
    
        $results = $query->result_array();  
        
        $results4["id"]=$results[0]["id"];
        $results4["apply"]=$results[0]["apply"];
        $results4["ending_date"]=$results[0]["ending_date"];
        $results4["holiday_duration"]=$results[0]["holiday_duration"];
        $results4["remarks"]=$results[0]["remarks"];
        $results4["starting_date"]=$results[0]["starting_date"];
        $results4["type"]=$results[0]["type"];
        $usersarray = json_decode($results[0]["users"]);
        if (count($usersarray) > 0) {
            foreach ($usersarray as $user) {
                $employeeIdQuery = $this->db->select('id')->get_where('users', array('employee_id' => $user));
                if ($employeeIdQuery->num_rows() > 0) {
                    $employeeIdRow = $employeeIdQuery->row();
                    $users[] = $employeeIdRow->id;
                }
            }
        $results4["users"] = implode(',', $users); 
        }
        
        $departmentarray = json_decode($results[0]["department"]);
        $results4["department"]= implode(',', $departmentarray);

        return $results4;
    }

    function get_holiday(){
        $saas_id = $this->session->userdata('saas_id');
        $query = $this->db->query("SELECT * FROM holiday WHERE saas_id = $saas_id ORDER BY starting_date DESC");
        $results = $query->result_array(); 
        $s_no=1; 
        foreach ($results as &$holiday) {
            $timestamp = strtotime($holiday["starting_date"]);
            $timestamp2 = strtotime($holiday["ending_date"]);
            $holiday["starting_date"] = date("d M Y", $timestamp);
            $holiday["ending_date"] = date("d M Y", $timestamp2);
            $type=$holiday["type"];
            if ($type == '0') {
                $holiday["type"] = 'National Day';
            }elseif ($type == '1') {
                $holiday["type"] = 'Rest Day';
            }elseif($type == '2'){
                $holiday["type"] = 'Weekend';
            }elseif($type == '4'){
                $holiday["type"] = 'Religious Day';
            }else{
                $holiday["type"] = 'Unplanned';
            }
            $holiday["sn"] = $s_no;
            $s_no++;
        }
        return $results;
    }

    function create($data){
        if($this->db->insert('holiday', $data))
            return $this->db->insert_id();
        else
            return $this->db->last_query();; 
    }

    function edit($id, $data){
        $this->db->where('id', $id);
        if($this->db->update('holiday', $data))
            return true;
        else
            return false;
    }

    public function get_department_time(){
        $query = $this->db->query("SELECT value FROM settings WHERE type='department_' ");
        $result = $query->result_array();
        
        if ($result) {
            return $result[0]['value'];
        } else {
            return false;
        }
    }

}


