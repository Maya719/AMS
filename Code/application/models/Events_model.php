<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    function create($data){
        if($this->db->insert('events', $data))
            return $this->db->insert_id();
        else
            return false; 
    }
    function edit($id, $data){
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        if($this->db->update('events', $data))
            return true;
        else
            return false;
    }
    function delete($id){
        $this->db->where('id', $id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        if($this->db->delete('events'))
            return true;
        else
            return false;
    }
}