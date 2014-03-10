<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	protected $view_data = array();
	protected $user_session = array();
	
	public function __construct()
	{
		parent::__construct();		
		$this->user_session = $this->session->userdata('user_session');
	}

	public function index()
	{	
		$post_data = $this->input->post();
		// var_dump($post_data);
		
		if($this->is_login())
			redirect(base_url('/login/welcome'));
		else
		{	
			if($post_data["form_action"] === 'login')
			{			
				$user_login = $this->user_login();
				
				if($user_login['status'] === TRUE)
					redirect(base_url("/login/welcome"));
				else
					$this->view_data['error_message'] = $user_login['error_message'];
			}
			else if($post_data["form_action"] === 'register')
			{	
				$register_user = $this->user_registration();
				
				if($register_user['status'] === TRUE)
				{
					$this->view_data['success_message'] = $register_user['success_message'];
					$this->load->view('login_view', $this->view_data);
				}
				else
				{
					$this->view_data['error_message'] = $register_user['error_message'];
				}
				
			}
			
			$this->view_data['submitted_form'] = $post_data["form_action"];
		}	
		if(isset($this->user_session['page']) && $this->user_session['page'] === 'login')
		{
			$this->load->view('login_view', $this->view_data);
		}	
		else if(!isset($this->view_data['success_message']))
		{
			$this->load->view('register_view', $this->view_data);
		}
//		if(!isset($this->view_data['success_message']) && isset() $this->user_session['page'] !== 'login')
//		{
//			$this->load->view('register_view', $this->view_data);
//		}	
//		else if($this->user_session['page'] === 'login')
//		{
//			$this->load->view('login_view', $this->view_data);
//		}
	}
	
	protected function user_login()
	{	
		$post_data = $this->input->post();
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if($this->form_validation->run() === FALSE)
		{
			$data['status'] = FALSE;
			$data['error_message'] = validation_errors();
		}
		else
		{		
			$user = array(
				'email' => $post_data["email"], 
				'password' => md5(HASH_START . $post_data["password"] . HASH_END)
			);
			
			$this->load->model('User_model');
			$user = $this->User_model->get_user($user);
			
			if(count($user) > 0)
			{
				$user_data = array(
					'user_id' => $user->id,
					'email' => $user->email,
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
					'is_logged_in' => TRUE
				);
				
				$this->session->set_userdata('user_session', $user_data);
				$this->user_session = $this->session->userdata('user_session');

				$data['status'] = TRUE;
			}
			else
			{
				$data['status'] = FALSE;
				$data["error_message"] = "Invalid email and Password! Please Try Again!";
			}
		}
		
		return $data;
	}

	protected function user_registration()
	{	
		$post_data = $this->input->post();
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('re_password', 'Confirm Password', 'trim|required|matches[password]');
		
		if($this->form_validation->run() === FALSE)
		{
			$data['status'] = FALSE;
			$data['error_message'] = validation_errors();
		}
		else
		{
			$user = array(
				'email'	=> $post_data["email"],
				'password' => md5(HASH_START . $this->input->post("password") . HASH_END),
				'first_name' => $post_data["firstname"],
				'last_name'	=> $post_data["lastname"],
				'created_at' => date("Y-m-d H:i:s")
			);
			$this->load->model('User_model');
			$register_user = $this->User_model->register_user($user);	
			
			if($register_user)
			{
				$data["status"] = TRUE;
				$data["success_message"] = "Registration successful! You can now login!";
			}
			else
			{
				$data["status"] = FALSE;
				$data["error_message"] = "Registration failed! Please Try Again!";
			}	
		}
		return $data;
	}
	
	public function welcome()
	{		
		if($this->is_login())
		{	
			$post_data = $this->input->post();
			$this->load->model('User_model');

			if(isset($post_data['action']) && $post_data['action'] === 'add_friend')
			{
				//var_dump($post_data);
				$this->User_model->notify_friend($post_data['friend_id'], $this->user_session['user_id']);
			}


			if(isset($post_data['accept_form']) && $post_data['accept_form'] === 'accept')
			{
				//var_dump($post_data);
				$this->User_model->add_friend($post_data['new_fr_id'], $this->user_session['user_id']);
				$this->User_model->delete_notification($this->user_session['user_id'],$post_data['new_fr_id']);
			}

			if(isset($post_data['ignore_form']) && $post_data['ignore_form'] === 'ignore')
			{
				$this->User_model->delete_notification($this->user_session['user_id'],$post_data['ignore_id']);
			}

			$notifications = $this->User_model->get_notifications($this->user_session['user_id']);
			$notes = $notifications->result();
			$view_data['notes']=$notes;
			//var_dump($notes);

			$records = $this->User_model->get_all();	
			$record_result = $records->result();
			$recs['users'] = array();
			$nfriends=0;
			foreach ($record_result as $value) 
			{
				$check1 = $this->User_model->check_friend($this->user_session['user_id'], $value->id);
				$tmp1=$check1->result();
				if(empty($tmp1))
				{
					$flag = -1;
					$check2 = $this->User_model->check_notified($this->user_session['user_id'], $value->id);
					$tmp2=$check2->result();
					if(empty($tmp2))
					{
						$flag = 0;
					}
				}
				else
				{
					$nfriends += 1;
					$flag = 1;
				}
				$check3 = $this->User_model->check_notified($value->id,$this->user_session['user_id']);
				$tmp3=$check3->result();
				if(!empty($tmp3))
				{
					$flag = 1;
				}
				$temp = array($value, $flag);
				array_push($recs['users'], $temp);	
			}
			$view_data['nfriends'] = $nfriends;
			$view_data['user']= $this->user_session;
			$view_data['users'] = $recs['users'];
			$this->load->view('welcome', $view_data);			
		}
		else
			redirect(base_url());
	}

	public function friends_page()
	{		
		if($this->is_login())
		{	
			$this->load->model('User_model');
			$records = $this->User_model->get_friends($this->user_session['user_id']);
			$friends = $records->result();
			$view_data['friends']=$friends;
			$view_data['user']= $this->user_session;
			$this->load->view('friends_view', $view_data);
		}
		else
			redirect(base_url());
	}


	public function login_page()
	{		
		// var_dump($this->view_data);	
		//$this->load->view('login_view', $this->view_data);
		$this->user_session['page'] = 'login';
		$this->index();


	}
	
	protected function is_login()
	{
		// var_dump($this->user_session);
		if(isset($this->user_session['is_logged_in']) && $this->user_session['is_logged_in'] && is_numeric($this->user_session['user_id']))
			return TRUE;
		else
			return FALSE;
	}

	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}