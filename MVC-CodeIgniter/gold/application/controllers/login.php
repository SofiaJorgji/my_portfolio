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
}