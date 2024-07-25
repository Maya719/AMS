<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function delete_chat()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->form_validation->set_rules('opposite_user_id', 'Chat ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			
			if($this->form_validation->run() == TRUE){

				if($this->chat_model->delete_chat($this->session->userdata('user_id'),$this->input->post('opposite_user_id'))){
					
					$this->session->set_flashdata('message', $this->lang->line('chat_deleted_successfully')?$this->lang->line('chat_deleted_successfully'):"Chat deleted successfully.");
					$this->session->set_flashdata('message_type', 'success');

					$this->data['error'] = false;
					$this->data['message'] = $this->lang->line('chat_deleted_successfully')?$this->lang->line('chat_deleted_successfully'):"Chat deleted successfully.";
					echo json_encode($this->data);
				}else{
					$this->data['error'] = true;
					$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
					echo json_encode($this->data);
				}

			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	public function chat_mark_read()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->form_validation->set_rules('opposite_user_id', 'Chat ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			
			if($this->form_validation->run() == TRUE){

				if($this->chat_model->chat_mark_read($this->session->userdata('user_id'),$this->input->post('opposite_user_id'))){
					$this->data['error'] = false;
					$this->data['message'] = 'Successful';
					echo json_encode($this->data);
				}else{
					$this->data['error'] = true;
					$this->data['message'] = 'Not Successful';
					echo json_encode($this->data);
				}

			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	public function get_chat()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->form_validation->set_rules('opposite_user_id', 'Chat ID', 'trim|required|strip_tags|xss_clean|is_numeric');
			
			if($this->form_validation->run() == TRUE){

				$data = $this->chat_model->get_chat($this->session->userdata('user_id'),$this->input->post('opposite_user_id'));

				foreach($data as $key => $task){
					$temp[$key] = $task;
					$encryptionKey = 'J9$#qP&6aHd@Ys#R';
					$temp[$key]['text'] = openssl_decrypt($task['message'], 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
					// $temp[$key]['text'] = $task['message'];
					$temp[$key]['position'] = $this->session->userdata('user_id') == $task['from_id']?'right':'left';
				}
				$Chat = $temp;

				$this->data['error'] = false;
				$this->data['data'] = $Chat;
				$opposite_user = $this->ion_auth->user($this->input->post('opposite_user_id'))->row();
				if($opposite_user->profile){
					if(file_exists('assets/uploads/profiles/'.$opposite_user->profile)){
						$file_upload_path = 'assets/uploads/profiles/'.$opposite_user->profile;
					  }else{
						$file_upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/profiles/'.$opposite_user->profile;
					}
					$opposite_user->profile = base_url($file_upload_path);
				}
				$this->data['opposite_user'] = $opposite_user;
				$this->data['message'] = 'Successful';
				echo json_encode($this->data);
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data);
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data);
		}
	}

	public function create()
	{
		if ($this->ion_auth->logged_in())
		{
			if (empty($_FILES['attachment']['name'])){
				$this->form_validation->set_rules('message', 'Message', 'trim|required|strip_tags|xss_clean');
			}
			$this->form_validation->set_rules('to_id', 'User', 'trim|required|strip_tags|xss_clean');
			
			if($this->form_validation->run() == TRUE){
				if (!empty($this->input->post('message'))){
					$encryptionKey = 'J9$#qP&6aHd@Ys#R'; 
					$encryptedMessage = openssl_encrypt($this->input->post('message'), 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);

					$data = array(
						'type' => 'chat',
						'from_id' => $this->session->userdata('user_id'),
						'to_id' => $this->input->post('to_id'),
						'message' => $encryptedMessage, 
					);
	
					$Chat_id = $this->chat_model->create($data);
				}
				
				if (!empty($_FILES['attachment']['name'])){

					if(!is_storage_limit_exceeded()){
						$this->data['error'] = true;
						$this->data['message'] = $this->lang->line('storage_limit_exceeded')?$this->lang->line('storage_limit_exceeded'):'Storage Limit Exceeded';
						echo json_encode($this->data);
						return false;
					}

					$upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/chats/';
					if(!is_dir($upload_path)){
						mkdir($upload_path,0775,true);
					}
	
					$config['upload_path']          = $upload_path;
					$config['allowed_types']        = file_upload_format();
					$config['overwrite']            = false;
					$config['max_size']             = 5012;
					$config['max_width']            = 0;
					$config['max_height']           = 0;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('attachment')){
						$data = array(
							'type' => 'chat',
							'type_id' => $this->input->post('to_id'),
							'user_id' => $this->session->userdata('user_id'),
							'file_name' => $this->upload->data('file_name'),
							'file_type' => $this->upload->data('file_ext'),		
							'file_size' => $this->upload->data('file_size'),		
						);

						if($this->projects_model->upload_files($data)){
							$attachmentLink = '<i class="fas fa-file">&nbsp;&nbsp;</i><a href="' . base_url($upload_path . $this->upload->data('file_name')) . '" download style="color:inherit; text-decoration: underline;">' . $this->upload->data('file_name') . '</a>';
							$encryptionKey = 'J9$#qP&6aHd@Ys#R'; 
							$encryptedAttachmentLink = openssl_encrypt($attachmentLink, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
							$data = array(
								'type' => 'chat',
								'from_id' => $this->session->userdata('user_id'),
								'to_id' => $this->input->post('to_id'),
								'message' => $encryptedAttachmentLink,
							);
							$this->chat_model->create($data);
							$this->data['error'] = false;
							$this->data['message'] = $this->lang->line('chat_created_successfully')?$this->lang->line('chat_created_successfully'):"Chat created successfully.";
							echo json_encode($this->data);
						}else{
							$this->data['error'] = true;
							$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
							echo json_encode($this->data);
						}
					}
					else{
						$this->data['error'] = true;
						$this->data['message'] = $this->upload->display_errors();
						echo json_encode($this->data); 
						return false;
					}
				}
				else{
					if($Chat_id){
						$this->data['error'] = false;
						$this->data['message'] = $this->lang->line('chat_created_successfully')?$this->lang->line('chat_created_successfully'):"Chat created successfully.";
						echo json_encode($this->data); 
					}else{
						$this->data['error'] = true;
						$this->data['message'] = $this->lang->line('something_wrong_try_again')?$this->lang->line('something_wrong_try_again'):"Something wrong! Try again.";
						echo json_encode($this->data);
					}
				}
			}else{
				$this->data['error'] = true;
				$this->data['message'] = validation_errors();
				echo json_encode($this->data); 
			}
		}else{
			$this->data['error'] = true;
			$this->data['message'] = $this->lang->line('access_denied')?$this->lang->line('access_denied'):"Access Denied";
			echo json_encode($this->data); 
		}
	}

	public function index()
	{
		if ($this->ion_auth->logged_in() && is_module_allowed('chat') && !$this->ion_auth->in_group(3) && ($this->ion_auth->is_admin() || permissions('chat_view')))
		{
			$this->data['page_title'] = 'Chat - '.company_name();
			$this->data['main_page'] = 'Chat';
			$this->data['current_user'] = $this->ion_auth->user()->row();

			if($this->ion_auth->is_admin()){
				if(clients_permissions('chat_view') && users_permissions('chat_view')){
					$system_users = $this->ion_auth->users()->result();
				}elseif(clients_permissions('chat_view')){
					$system_users = $this->ion_auth->users(array(1,4))->result();
				}elseif(users_permissions('chat_view')){
					$system_users = $this->ion_auth->all_roles()->result();
				}else{
					$system_users = $this->ion_auth->users(array(1))->result();
				}
			}elseif($this->ion_auth->in_group(4)){
				// Client
				if(permissions('team_members_and_client_can_chat') && users_permissions('chat_view')){
					$system_users = $this->ion_auth->all_roles()->result();
				}else{
					$system_users = $this->ion_auth->users(array(1))->result();
				}
			}else{
				// Team members
				if(permissions('team_members_and_client_can_chat') && clients_permissions('chat_view')){
					$system_users = $this->ion_auth->users()->result();
				}else{
					$system_users = $this->ion_auth->all_roles()->result();
				}
			}

			foreach ($system_users as $system_user) {
				if($this->session->userdata('saas_id') == $system_user->saas_id && $system_user->active == '1'){
					$tempRow['is_read'] = count($this->chat_model->get_chat($this->session->userdata('user_id'),$system_user->user_id, 1));
					$tempRow['id'] = $system_user->user_id;
					$tempRow['email'] = $system_user->email;
					$tempRow['active'] = $system_user->active;
					$tempRow['first_name'] = $system_user->first_name;
					$tempRow['last_name'] = $system_user->last_name;
					$tempRow['phone'] = $system_user->phone!=0?$system_user->phone:'No Number';

					$tempRow['profile'] = '';
					if($system_user->profile){
						if(file_exists('assets/uploads/profiles/'.$system_user->profile)){
							$file_upload_path = 'assets/uploads/profiles/'.$system_user->profile;
						  }else{
							$file_upload_path = 'assets/uploads/f'.$this->session->userdata('saas_id').'/profiles/'.$system_user->profile;
						}
						$tempRow['profile'] = base_url($file_upload_path);
					}

					$tempRow['short_name'] = mb_substr($system_user->first_name, 0, 1, "utf-8").''.mb_substr($system_user->last_name, 0, 1, "utf-8");
					$group = $this->ion_auth->get_users_groups($system_user->user_id)->result();
					$tempRow['role'] = ucfirst($group[0]->name);
					$tempRow['group_id'] = $group[0]->id;
					$tempRow['projects_count'] = get_count('id','project_users','user_id='.$system_user->user_id);
					$tempRow['tasks_count'] = get_count('id','task_users','user_id='.$system_user->user_id);
					$rows[] = $tempRow;
				}
			}
			function customSort($a, $b) {
				if ($a['is_read'] >= 1 && $b['is_read'] < 1) {
					return -1; 
				} elseif ($a['is_read'] < 1 && $b['is_read'] >= 1) {
					return 1;
				} else {
					return 0; 
				}
			}
			
			usort($rows, 'customSort');
			$this->data['chat_users'] = $rows;

			$this->load->view('chat',$this->data);
		}else{
			redirect_to_index();
		}
	}

}
