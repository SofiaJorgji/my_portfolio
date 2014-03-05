<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	protected $view_data = array();
	protected $user_session = array();
	
	public function __construct()
	{
		parent::__construct();	
		$this->session->sess_destroy();
		$this->user_session = $this->session->userdata('user_session');	
	}

	public function index()
	{	
		$post_data = $this->input->post();
		if(!empty($post_data['action']))
		{
			$win_or_lose = 1;
	        $low = $post_data['low'];
	        $high = $post_data['high'];
	        if($post_data['action'] == 'farm')
	        {
	            $loc = 'Farm';
	        }
	        if($post_data['action'] == 'cave')
	        {
	            $loc = 'Cave';
	        }
	        if($post_data['action'] == 'house')
	        {
	            $loc = 'House';
	        }
	        if($post_data['action'] == 'casino')
	        {
                $loc = 'Casino';
                $try=rand(1,100);
                if($try<=70) $win_or_lose=1;
                else $win_or_lose=-1;
	        }
	        $gold_earned = rand($low, $high) * $win_or_lose;
	        $time = date('F jS Y i:s a');
	        if(!isset($this->user_session['gold_total']))
	        {
	            $this->user_session['gold_total'] = 0;
	        }
	        $this->user_session['gold_total'] += $gold_earned;
	        if(!isset($this->user_session['activities']))
	        {
	            $this->user_session['activities'] = array();
	        }
	        if($gold_earned > 0)
	        {
                $message = 'You entered a '.$loc.' and earned '.$gold_earned.' golds. '.'('.$time.')';
                $status = 'green';
	        }
	        else
	        {
                $message = 'You entered a '.$loc.' and lost '.$gold_earned.' golds... Ouch '.'('.$time.')';
                $status = 'red';
	        }
	        $gold_run = array('message' => $message,'status' => $status);
	        array_unshift($this->user_session['activities'], $gold_run);
	        $this->session->set_userdata('user_session', $this->user_session);	
	        $this->load->view('profile_view', $this->user_session);
		}
		else
		{
			$this->load->view('profile_view');	
		}		
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
					'firstname' => $user->firstname,
					'lastname' => $user->lastname,
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
				'firstname' => $post_data["firstname"],
				'lastname'	=> $post_data["lastname"],
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
			$this->view_data['user'] = $this->user_session;
			$this->load->view('welcome', $this->view_data);
		}
		else
			redirect(base_url());
	}

	public function login_page()
	{			
		$this->load->view('login_view', $this->view_data);
	}
	
	protected function is_login()
	{
		if($this->user_session['is_logged_in'] && is_numeric($this->user_session['user_id']))
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