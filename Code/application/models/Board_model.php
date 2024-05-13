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
    public function moveTasksToBackLog($id)
    {
        $this->db->select('*');
        $this->db->from('issues_sprint');
        $this->db->where('sprint_id', $id);
        $query2 = $this->db->get();
        $rows = $query2->result_array();
        foreach ($rows as $row) {
            $issues_sprint_id = $row["id"];
            $issue_id = $row["issue_id"];
            $this->db->select('*');
            $this->db->from('tasks');
            $this->db->where('id', $issue_id);
            $query = $this->db->get();
            $row = $query->row();
            if ($row->status != '4') {
                $data = [
                    'sprint_id' => 0
                ];
                if ($this->update_issues_sprint($issues_sprint_id, $data)) {
                    $statuses[] = $issue_id;
                }
            }
        }
        return $statuses;
    }
    public function get_active_sprint()
    {
        $this->db->select('*');
        $this->db->from('sprints');
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        $this->db->where('status', 1);
        $query2 = $this->db->get();
        $row = $query2->row();

        if ($row) {
            if ($row->duration) {
                $created = $row->created;
                $duration = $row->duration;
                $end_date = date('Y-m-d', strtotime($created . ' + ' . $duration . ' week'));
                if (strtotime($end_date) < time()) {
                    return $row->id;
                }
            } else {
                $ending_date = $row->ending_date;
                if (strtotime($ending_date) < time()) {
                    return $row->id;
                }
            }
        }

        return null;
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

    public function update_status($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('tasks', $data))
            return true;
        else
            return false;
    }
    public function update_issues_sprint($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('issues_sprint', $data))
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
    public function get_project_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('id', $id);
        $query2 = $this->db->get();
        return $query2->row();
    }
    public function get_running_sprint($project_id)
    {
        $this->db->select('*');
        $this->db->from('sprints');
        $this->db->where('status', 1);
        $status_query = $this->db->get();
        return $status_query->row();
    }
}
