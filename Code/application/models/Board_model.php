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
}