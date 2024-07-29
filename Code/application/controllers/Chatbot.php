<?php defined('BASEPATH') or exit('No direct script access allowed');
class Chatbot extends CI_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        // Load the library
    }
    public function get_advice($text = '')
    {
        // Select the response message directly using a JOIN
        $this->db->select('responses.response_message');
        $this->db->from('questions');
        $this->db->join('responses', 'questions.response_id = responses.id');
        $this->db->like('questions.question', $text);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Fetch the response message directly
            $response_message = $query->row()->response_message;
            $advice = $response_message;
        } else {
            $advice = "I am sorry. I can't understand your question. Please rephrase your question and make sure it is related to this site. Thank you :)";
        }

        // Return the response in JSON format
        echo json_encode(array('slip' => array('advice' => $advice, 'id' => '1')));
    }
}
