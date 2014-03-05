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
					$this->view_data['success_message'] = $register_user['success_message'];
				else
					$this->view_data['error_message'] = $register_user['error_message'];
			}
			
			$this->view_data['submitted_form'] = $post_data["form_action"];
		}		
		
		$this->load->view('login_view', $this->view_data);
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
				// $this->User_model->add_friend($this->user_session['user_id'], $post_data['friend_id']);
				$this->User_model->add_friend($post_data['users_id'], $post_data['friend_id']);
			}
			$records = $this->User_model->get_all();	
			$record_result = $records->result();
			$sofia['users'] = array();
			foreach ($record_result as $value) 
			{
				$check = $this->User_model->check_friend($this->user_session['user_id'], $value->id);	// ?????
				// var_dump($check->result());
				$tmp0 = $check->result();
				if(empty($tmp0))
				{
					$flag = 0;
				}
				else
				{
					$flag = 1;
				}
				$temp = array($value, $flag);
				array_push($sofia['users'], $temp);	
			}
			$view_data['user']= $this->user_session;
			$view_data['users'] = $sofia['users'];
			// var_dump($view_data['users']);
			$this->load->view('welcome', $view_data);
		}
		else
			redirect(base_url());
	}
	
	protected function is_login()
	{
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