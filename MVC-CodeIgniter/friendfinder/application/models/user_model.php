<?php

class User_model extends CI_Model
{
	public function get_user($user)
	{

		return $this->db->where('email', $user['email'])
					->where('password', $user['password'])
					->get("users")
					->row();
	}

	public function get_all()
	{
		return $this->db->get('users');
	}

	public function check_friend($id1, $id2)
	{
		return $this->db->get_where('friends', array('users_id' => $id1, 'friend_id' => $id2));
	}
	
	public function register_user($user)
	{
		return $this->db->insert("users", $user);
	}

	public function add_friend($id1, $id2)
	{
		$user = array('users_id' => $id1, 'friend_id' => $id2);
		$temp = $this->db->insert("friends", $user);
		$user = array('users_id' => $id2, 'friend_id' => $id1);
		$temp = $this->db->insert("friends", $user);
	}
}