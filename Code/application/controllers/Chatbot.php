<?php defined('BASEPATH') or exit('No direct script access allowed');
class Chatbot extends CI_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        // Load the library
    }
    public function get_advice()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $text = $input['text'] ?? '';
            $text = strtolower($text);
            $keywords = $this->extract_keywords($text);
            $this->db->select('responses.response_message,responses.id');
            $this->db->from('questions');
            $this->db->join('responses', 'questions.response_id = responses.id');
            $this->db->group_start();
            foreach ($keywords as $keyword) {
                $this->db->or_like('questions.question', $keyword, 'both');
            }
            $this->db->group_end();
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $response = $query->row();
                $response_id = $response->id;
                $response_message = $response->response_message;
                $advice = $response_message;
                $question_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'response_id' => $response_id,
                    'question' => $text
                );
                $this->db->insert('chatbot_search', $question_data);
            } else {
                $advice = "I am sorry. I can't understand your question. Please rephrase your question and make sure it is related to this site. Thank you :)";
            }
            echo json_encode(array('slip' => array('advice' => $advice, 'id' => '1', 'question' => $text)));
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            $advice = "I am sorry. I can't understand your question. Please rephrase your question and make sure it is related to this site. Thank you :)";
            echo json_encode(array('slip' => array('advice' => $advice, 'id' => '1', 'question' => $text)));
        }
    }

    private function extract_keywords($text)
    {
        // Define common stop words
        $stopWords = ['i', 'want', 'to', 'the', 'a', 'and', 'of', 'in', 'for', 'on', 'with', 'is', 'it', 'that', 'this', 'at', 'by', 'from'];

        // Tokenize and normalize text
        $words = preg_split('/\s+/', strtolower($text));

        // Filter out stop words and count occurrences
        $keywords = array_diff($words, $stopWords);

        // Remove duplicates
        $keywords = array_unique($keywords);

        return $keywords;
    }


    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['page_title'] = 'FAQ`s - ' . company_name();
            $this->data['main_page'] = 'FAQ`s';
            $this->data['current_user'] = $this->ion_auth->user()->row();
            // Select the response message directly using a JOIN
            $this->db->select('responses.response_message,questions.question,questions.id');
            $this->db->from('questions');
            $this->db->join('responses', 'questions.response_id = responses.id');
            $query = $this->db->get();
            $this->data["response_messages"] = $query->result();
            $this->load->view('pages/saas/faq', $this->data);
        } else {
            redirect_to_index();
        }
    }
    public function create()
    {
        if ($this->ion_auth->logged_in() && is_saas_admin()) {
            $this->form_validation->set_rules('question', 'Question', 'required');
            $this->form_validation->set_rules('response', 'Response', 'required');

            if ($this->form_validation->run() == TRUE) {
                $question = $this->input->post('question');
                $response = $this->input->post('response');

                // Insert the response into the 'responses' table
                $response_data = array(
                    'response_message' => $response
                );
                $this->db->insert('responses', $response_data);
                $response_id = $this->db->insert_id();

                if ($response_id) {
                    $question_data = array(
                        'question' => $question,
                        'response_id' => $response_id
                    );
                    $this->db->insert('questions', $question_data);

                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('message', $this->lang->line('created_successfully') ? $this->lang->line('created_successfully') : "Created successfully.");
                        $this->session->set_flashdata('message_type', 'success');
                        $this->data['data'] = $this->input->post();
                        $this->data['error'] = false;
                        $this->data['message'] = "Question and response added successfully.";
                    } else {
                        $this->data['error'] = true;
                        $this->data['message'] = "Failed to add the question.";
                    }
                } else {
                    $this->data['error'] = true;
                    $this->data['message'] = "Failed to add the response.";
                }
            } else {
                $this->data['error'] = true;
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
        }

        echo json_encode($this->data);
    }
    public function edit()
    {
        if ($this->ion_auth->logged_in() && is_saas_admin()) {
            $this->form_validation->set_rules('update_id', 'Question ID', 'required');
            $this->form_validation->set_rules('question', 'Question', 'required');
            $this->form_validation->set_rules('response', 'Response', 'required');

            if ($this->form_validation->run() == TRUE) {
                $update_id = $this->input->post('update_id');
                $question = $this->input->post('question');
                $response = $this->input->post('response');

                // Retrieve the response_id based on the update_id
                $this->db->select('response_id');
                $this->db->from('questions');
                $this->db->where('id', $update_id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $response_id = $row->response_id;

                    // Update the response in the 'responses' table
                    $response_data = array(
                        'response_message' => $response
                    );
                    $this->db->where('id', $response_id);
                    $this->db->update('responses', $response_data);

                    if ($this->db->affected_rows() >= 0) {
                        $question_data = array(
                            'question' => $question
                        );
                        $this->db->where('id', $update_id);
                        $this->db->update('questions', $question_data);

                        if ($this->db->affected_rows() >= 0) {
                            $this->session->set_flashdata('message', $this->lang->line('updated_successfully') ? $this->lang->line('updated_successfully') : "Updated successfully.");
                            $this->session->set_flashdata('message_type', 'success');
                            $this->data['error'] = false;
                            $this->data['message'] = "Updated successfully.";
                        } else {
                            $this->data['error'] = true;
                            $this->data['message'] = "Failed to update the question.";
                        }
                    } else {
                        $this->data['error'] = true;
                        $this->data['message'] = "Failed to update the response.";
                    }
                } else {
                    $this->data['error'] = true;
                    $this->data['message'] = "Invalid question ID.";
                }
            } else {
                $this->data['error'] = true;
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
        }

        echo json_encode($this->data);
    }
    public function upload_image()
    {
        header('Content-Type: application/json');

        $target_dir = "assets/uploads/chatbot/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $response = array('location' => base_url($target_file));
                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'Sorry, there was an error uploading your file.']);
            }
        } else {
            echo json_encode(['error' => 'File is not an image.']);
        }
    }

    public function get_chat_by_id()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('id', 'id', 'trim|required|strip_tags|xss_clean|is_numeric');
            if ($this->form_validation->run() == TRUE) {
                $this->db->select('responses.response_message,questions.question,questions.id');
                $this->db->from('questions');
                $this->db->where('questions.id', $this->input->post('id'));
                $this->db->join('responses', 'questions.response_id = responses.id');
                $query = $this->db->get();
                $this->data['error'] = false;
                $this->data["response_messages"] = $query->row();
                echo json_encode($this->data);
            } else {
                $this->data['error'] = true;
                $this->data['message'] = validation_errors();
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }

    public function delete()
    {
        if ($this->ion_auth->logged_in()) {
            if (empty($id)) {
                $id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }

            if (!empty($id) && is_numeric($id)) {
                // Retrieve the response_id based on the question_id
                $this->db->select('response_id');
                $this->db->from('questions');
                $this->db->where('id', $id);
                $query = $this->db->get();
                $row = $query->row();
                $response_id = $row->response_id;

                $this->db->trans_start();
                $this->db->where('id', $id);
                $this->db->delete('questions');
                $this->db->where('id', $response_id);
                $this->db->delete('responses');
                $this->db->trans_complete();
                if ($this->db->trans_status() === TRUE) {
                    $this->session->set_flashdata('message', $this->lang->line('deleted_successfully') ? $this->lang->line('deleted_successfully') : "Deleted successfully.");
                    $this->session->set_flashdata('message_type', 'success');
                    $this->data['error'] = false;
                    $this->data['message'] = $this->lang->line('deleted_successfully') ? $this->lang->line('deleted_successfully') : "Deleted successfully.";
                    echo json_encode($this->data);
                }
            } else {

                $this->data['error'] = true;
                $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
    public function get_user_advices()
    {
        $user_id = $this->session->userdata('user_id');

        if ($user_id) {
            $this->db->select('chatbot_search.question, responses.response_message');
            $this->db->from('chatbot_search');
            $this->db->join('responses', 'chatbot_search.response_id = responses.id');
            $this->db->where('chatbot_search.user_id', $user_id);

            $query = $this->db->get();
            $result = $query->result();

            echo json_encode($result);
        } else {
            echo json_encode(array('error' => true, 'message' => 'User ID not found in session.'));
        }
    }
}
