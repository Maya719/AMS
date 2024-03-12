<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
    }
    
    function get_unread_support_msg_count($user_id){
        
        if(is_saas_admin()){
            $query = $this->db->query("SELECT id FROM support_messages WHERE from_id != $user_id AND is_read = 0");
            return $query->result_array();
        }

        $tmpcount = array();
        $query = $this->db->query("SELECT to_id FROM support_messages WHERE from_id = $user_id GROUP BY to_id
        ");
        $results = $query->result_array();
        
        if($results){
            foreach($results as $result){
                $tmpcount[] = $result['to_id'];
            }
        }else{
            return false;
        }

        if($tmpcount){
            $in_ids = implode(',',array_values($tmpcount));
            $query1 = $this->db->query("SELECT id FROM support_messages WHERE to_id IN($in_ids) AND from_id != $user_id AND is_read = 0");
            return $query1->result_array();
        }else{
            return false;
        }
    }

    function get_my_unread_support_messages_by_ticked_id($ticket_id){

        $where = " WHERE is_read = 0 ";
        $where .= " AND from_id != ".$this->session->userdata('user_id');
        $where .= " AND to_id = ".$ticket_id;
        
        $query = $this->db->query("SELECT * FROM support_messages ".$where);
    
        $results = $query->result_array();  

        return $results;
    }

    function create($data){
        if($this->db->insert('support', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function create_support_message($data){
        if($this->db->insert('support_messages', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function delete_support_message($ticket_id = '', $user_id = ''){
        if($ticket_id){
            $this->db->where('to_id', $ticket_id);
        }

        if($user_id){
            $this->db->where('from_id', $user_id);
        }

        if($this->db->delete('support_messages'))
            return true;
        else
            return false;
    }

    function get_support_messages_by_ticket_id($id){
 
        // to_id = ticket id
        // from_id = user id

        $where = " WHERE a.to_id = ".$id;
        
		$LEFT_JOIN = " LEFT JOIN users u ON u.id=a.from_id ";

        $query = $this->db->query("SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as user FROM support_messages a $LEFT_JOIN ".$where);
    
        $results = $query->result_array();  

        return $results;
    }

    function mark_as_read_support_messages_by_user_id($user_id, $ticket_id){
        $data['is_read'] = 1;
        $this->db->where('from_id != ', $user_id);
        $this->db->where('to_id', $ticket_id);
        $this->db->where('is_read', 0);
        if($this->db->update('support_messages', $data))
            return true;
        else
            return false;
    }

    function get_support_by_id($id){
 
        $where = " WHERE a.id = ".$id;

        if($this->ion_auth->is_admin() || permissions('support_view')){
            $where .= " AND a.user_id = ".$this->session->userdata('user_id');
        }
        
		$LEFT_JOIN = " LEFT JOIN users u ON u.id=a.user_id ";

        $query = $this->db->query("SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as user, CONCAT('#', LPAD(a.id,6,'0')) as ticket_id FROM support a $LEFT_JOIN ".$where);
    
        $results = $query->result_array();  

        return $results;
    }

    function get_support(){
 
        $get = $this->input->get();
        if(is_saas_admin()){
            if(isset($get['user_id']) && !empty($get['user_id'])){
                $where = " WHERE a.user_id = ".$get['user_id'];
            }else{
                $where = " WHERE a.id IS NOT NULL ";
            }
        }else{
            // if($this->ion_auth->is_admin() || permissions('support_view')){
            //     $where = " WHERE a.saas_id = ".$this->session->userdata('saas_id');
            // } else{
                $where = " WHERE a.user_id = ".$this->session->userdata('user_id');
            // }  
        }
       

        if(isset($get['status']) && !empty($get['status'])){
            $where .= " AND a.status = ".$get['status'];
        }

        if(isset($get['from']) && !empty($get['from']) && isset($get['too']) && !empty($get['too'])){
            $where .= " AND DATE(a.created) BETWEEN '".format_date($get['from'],"Y-m-d")."' AND '".format_date($get['too'],"Y-m-d")."' ";
        }
    
		$LEFT_JOIN = " LEFT JOIN users u ON u.id=a.user_id ";

        $query = $this->db->query("SELECT COUNT('a.id') as total FROM support a $LEFT_JOIN ".$where);
    
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }
        
        $query = $this->db->query("SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as user, CONCAT('#', LPAD(a.id,6,'0')) as ticket_id FROM support a $LEFT_JOIN ".$where);
    
        $results = $query->result_array();  
    
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($results as $result) {
				$tempRow = $result;

                if($this->get_my_unread_support_messages_by_ticked_id($result['id'])){
                    $tempRow['ticket_id'] = '<span class="beep"></span><a href="'.(base_url('support/chat/'.$result['id'])).'">'.$result['ticket_id'].'</a>';
                }else{
                    $tempRow['ticket_id'] = '<a href="'.(base_url('support/chat/'.$result['id'])).'">'.$result['ticket_id'].'</a>';
                }

                $tempRow['created'] = format_date($result['created'],system_date_format()." ".system_time_format());

                if($result['status'] == 1){
                    if(is_saas_admin()){
                        $tempRow['status'] = '<div class="badge badge-danger">'.($this->lang->line('received')?htmlspecialchars($this->lang->line('received')):'Received').'</div>';
                    }else{
                        $tempRow['status'] = '<div class="badge badge-danger">'.($this->lang->line('sent')?htmlspecialchars($this->lang->line('sent')):'Sent').'</div>';
                    }
                }elseif($result['status'] == 2){
                    $tempRow['status'] = '<div class="badge badge-info">'.($this->lang->line('opened_and_resolving')?htmlspecialchars($this->lang->line('opened_and_resolving')):'Opened and Resolving').'</div>';
                }elseif($result['status'] == 3){
                    $tempRow['status'] = '<div class="badge badge-success">'.($this->lang->line('resolved_and_closed')?htmlspecialchars($this->lang->line('resolved_and_closed')):'Resolved and Closed').'</div>';
                }
                
                if(is_saas_admin()){

                    $tempRow['action'] = '<div class="d-flex">
                     <span class="badge light badge-primary"><a href="'.(base_url('support/chat/'.$result['id'])).'" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-comments"></i></a></span>
                     <span class="badge light badge-primary ms-2"><a href="javascript:void()"  data-id="'.$result['id'].'" data-bs-toggle="modal" data-bs-target="#edit-support-modal" class="text-primary modal-edit-support" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pen"></i></a></span>
                    <span class="badge light badge-danger ms-2"><a href="javascript:void()" data-id="'.$result['id'].'" class="text-danger delete_support" data-bs-toggle="tooltip" data-placement="top" title="'.($this->lang->line('delete')?htmlspecialchars($this->lang->line('delete')):'Delete').'"><i class="fas fa-trash"></i></a></span>
                    </div>';
                }else{
                    $tempRow['action'] = '<span class="d-flex"><a href="'.(base_url('support/chat/'.$result['id'])).'" class="btn btn-icon btn-sm btn-primary mr-1" data-toggle="tooltip" title="'.($this->lang->line('chat')?htmlspecialchars($this->lang->line('chat')):'Chat').'"><i class="fas fa-comments"></i></a></span>';
                }
                

                $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function edit($data, $id = '', $user_id = ''){
        if(!empty($id)){
            $this->db->where('id', $id);
        }
        
        if(!empty($user_id)){
            $this->db->where('user_id', $user_id);
        }

        if($id = '' && $user_id = ''){
            return false;
        }

        if($this->db->update('support', $data))
            return true;
        else
            return false;
    }

    function delete($id = '', $user_id = ''){
        if($id){
            $this->db->where('id', $id);
        }

        if($user_id){
            $this->db->where('user_id', $user_id);
        }

        if($id = '' && $user_id = ''){
            return false;
        }

        if($this->db->delete('support'))
            return true;
        else
            return false;
    }


}