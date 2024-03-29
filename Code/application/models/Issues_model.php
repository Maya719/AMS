<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Issues_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function create_issue($data)
    {
        if ($this->db->insert('issues', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function edit_issue($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('issues', $data))
            return true;
        else
            return false;

    }
    public function create_issue_sprint($data)
    {
        if ($this->db->insert('issues_sprint', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function edit_issue_sprint($id,$data)
    {
        $this->db->where('issue_id', $id);
        if($this->db->update('issues_sprint', $data))
            return true;
        else
            return false;
    }
    public function delete_issue($id)
    {
        $this->db->where('issue_id', $id);
        $this->db->delete('issues_users');

        $this->db->where('issue_id', $id);
        $this->db->delete('issues_sprint');
        $this->db->where('id', $id);
        if ($this->db->delete('issues'))
            return true;
        else
            return false;
    }
}