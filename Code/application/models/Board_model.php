<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Board_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function create_sprint($data)
    {
        if ($this->db->insert('sprints', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function status_change_sprint($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('sprints', $data))
            return true;
        else
            return false;
    }
    public function update_sprint($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('sprints', $data))
            return true;
        else
            return false;
    }
    public function delete_sprint($id)
    {
        $this->db->where('sprint_id', $id);
        $this->db->delete('issues_sprint');
        $this->db->where('id', $id);
        if ($this->db->delete('sprints'))
            return true;
        else
            return false;
    }

    public function get_sprint_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('sprints');
        $this->db->where('id', $id);
        $query2 = $this->db->get();
        return $query2->row();
    }
}
