<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {
	protected $user_session = array();
	public function __construct()
	{
		parent::__construct();		
		$this->user_session = $this->session->userdata('user_session');
	}

	public function index()
	{	
		$post_data = $this->input->post();
		$this->load->model('User_model');
		if(isset($post_data['action']) && $post_data['action'] === 'add_course')
		{
			foreach ($post_data as $key => $value) 
			{
				if(empty($value))
				{
					$this->user_session['error'][$key] = $key . ' cannot be blank!';
				}
			}
			if(!isset($this->user_session['error']))
			{
				$data = array(
					'name' => $post_data['course_name'],
					'description' => $post_data['description'],
					'created_at' => date("Y-m-d H:i:s")
					);
				$this->User_model->insert_entry($data);
			}
		}
		if(isset($post_data['delete_form']) && $post_data['delete_form'] === 'remove')
		{
			$rec_id=$post_data['remove_rec'];
			$this->User_model->delete_entry($rec_id);
		}		
		if(isset($post_data['update']) && $post_data['update'] === 'submit')
		{
			$rec_id=$post_data['rec_id'];
			$data = array(
					'name' => $post_data['course_name'],
					'description' => $post_data['description'],
					'updated_at' => date("Y-m-d H:i:s")
					);
			$this->User_model->update_entry($rec_id, $data);
		}				
		$records = $this->User_model->get_all();
		$this->user_session['records'] = $records->result();
		$this->session->set_userdata('user_session', $this->user_session);

		$this->load->view('course_view', $this->user_session);
	}
}