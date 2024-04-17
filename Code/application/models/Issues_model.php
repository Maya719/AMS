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
        if ($this->db->insert('tasks', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function create_task_user($data)
    {
        if ($this->db->insert('task_users', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function edit_issue($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('tasks', $data))
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

    public function edit_issue_sprint($id, $data)
    {
        $this->db->where('issue_id', $id);
        if ($this->db->update('issues_sprint', $data))
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
        if ($this->db->delete('tasks'))
            return true;
        else
            return false;
    }
    public function get_issue_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tasks i');
        $this->db->where('i.id', $id);
        $query = $this->db->get();
        $issue = $query->row();
        $project_id = $issue->project_id;
        $priority_id = $issue->priority;
        
        $this->db->select('*');
        $this->db->from('priorities');
        $this->db->where('id', $priority_id);
        $query = $this->db->get();
        $priority = $query->row();

        $this->db->select('*');
        $this->db->from('issues_users');
        $this->db->where('issue_id', $id);
        $query = $this->db->get();
        $issue_user = $query->row();
        $user_id = $issue_user->user_id;
        $user = $this->ion_auth->user($user_id)->row();

        $this->db->select('*');
        $this->db->from('issues_sprint');
        $this->db->where('issue_id', $id);
        $query = $this->db->get();
        $issue_sprint = $query->row();
        $sprint_id = $issue_sprint->sprint_id;

        $this->db->select('*');
        $this->db->from('sprints');
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        $this->db->where('id', $sprint_id);
        $query = $this->db->get();
        $sprint = $query->row();
        if ($sprint->duration) {
            $duration = $sprint->duration;
            $created = $sprint->created;
            switch ($duration) {
                case '1':
                    $sprint->starting_date = format_date($created, "Y-m-d h:i:s");
                    $sprint->ending_date = date('Y-m-d h:i:s', strtotime($created . ' +1 week'));
                    break;
                case '2':
                    $sprint->starting_date = format_date($created, "Y-m-d h:i:s");
                    $sprint->ending_date = date('Y-m-d h:i:s', strtotime($created . ' +2 week'));
                    break;
                case '3':
                    $sprint->starting_date = format_date($created, "Y-m-d h:i:s");
                    $sprint->ending_date = date('Y-m-d h:i:s', strtotime($created . ' +3 week'));
                    break;
                case '4':
                    $sprint->starting_date = format_date($created, "Y-m-d h:i:s");
                    $sprint->ending_date = date('Y-m-d h:i:s', strtotime($created . ' +4 week'));
                    break;
            }
        }

        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('id', $project_id);
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        $query = $this->db->get();
        $project = $query->row();

        return array(
            "issue" => $issue,
            "project" => $project,
            "user" => $user,
            "sprint" => $sprint,
            "priority" => $priority,
        );
    }
    public function get_project_users($id)
    {
        $this->db->select('*');
        $this->db->from('project_users');
        $this->db->where('project_id', $id);
        $query = $this->db->get();
        $results = $query->result_array();
        $users = [];
        foreach ($results as $result) {
            $user_id = $result["user_id"];
            $users[] = $this->ion_auth->user($user_id)->row();
        }
        return $users;
    }

    public function get_project_dash($id)
    {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $results = $query->row();
        return $results->dash_type;
    }
    public function check_kanban_board($id)
    {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $results = $query->row();
        if ($results->dash_type == 0) {
            return true;
        }else{
            return false; 
        }
    }
}
