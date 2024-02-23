<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    // function delete_chat($from_id, $to_id){
    //     if($this->db->query("DELETE FROM messages WHERE type='chat' AND ((from_id=$from_id AND to_id=$to_id) OR (from_id=$to_id AND to_id=$from_id))")){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
    
    function delete_chat($from_id, $to_id){
        $delete_query = $this->db->query("DELETE FROM messages WHERE type='chat' AND ((from_id=$from_id AND to_id=$to_id) OR (from_id=$to_id AND to_id=$from_id))");
        
        if ($delete_query) {
            $query = $this->db->query('SELECT * FROM media_files WHERE type="chat" AND ((type_id='.$to_id .' AND user_id='.$from_id.') OR (type_id='.$from_id .' AND user_id='.$to_id.'))');
            $datas = $query->result_array();
            
            if (!empty($datas)) {
                foreach ($datas as $data) {
                    if (file_exists('assets/uploads/chats/'.$data['file_name'])) {
                        $file_upload_path = 'assets/uploads/chats/'.$data['file_name'];
                    } else {
                        $file_upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/chats/'.$data['file_name'];
                    }
    
                    if (unlink($file_upload_path)) {
                        $this->db->delete('media_files', array('id' => $data['id']));
                    } 
                }
            }
            
            return true;
        } else {
            return false; 
        }
    }

    function get_chat($from_id, $to_id, $is_read = ''){
        if($is_read){
            $query = $this->db->query("SELECT * FROM messages WHERE type='chat' AND is_read=0 AND from_id=$to_id AND to_id=$from_id");
        }else{
            $query = $this->db->query("SELECT * FROM messages WHERE type='chat' AND ((from_id=$from_id AND to_id=$to_id) OR (from_id=$to_id AND to_id=$from_id))");
        }
        return $query->result_array();
    }

    function get_unread_msg_count($user_id){
        $query = $this->db->query("SELECT * FROM messages WHERE type='chat' AND is_read=0 AND to_id=$user_id");
        return $query->result_array();
    }
    
    function get_unread_msg_count_numeric($user_id) {
        $query = $this->db->query("SELECT COUNT(*) AS unread_count FROM messages WHERE type='chat' AND is_read=0 AND to_id=$user_id");
        $result = $query->row_array(); // Fetch the single row
        return $result['unread_count']; // Return the unread count
    }

    function chat_mark_read($from_id, $to_id){
        if($this->db->query("UPDATE messages SET is_read=1 WHERE type='chat' AND from_id=$to_id AND to_id=$from_id")){
            return true;
        }else{
            return false;
        }
    }

    function create($data){
        if($this->db->insert('messages', $data))
            return $this->db->insert_id();
        else
            return false; 
    }
}