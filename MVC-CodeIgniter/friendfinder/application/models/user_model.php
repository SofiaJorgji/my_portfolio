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

	public function get_friends($user_id)
	{
		$this->db->select('users.id, users.first_name, users.last_name, users.email');
		$this->db->from('friends');
		$this->db->where('users_id', $user_id);
		$this->db->join('users', 'friends.friend_id = users.id');
		return $this->db->get();
	}	

	public function get_notifications($user_id)
	{
		$this->db->select('users.id, users.first_name, users.last_name');
		$this->db->from('notifiers');
		$this->db->where('users_id', $user_id);
		$this->db->join('users', 'notifiers.notifier_id = users.id');
		return $this->db->get();
	}	

	public function check_friend($id1, $id2)
	{
		return $this->db->get_where('friends', array('users_id' => $id1, 'friend_id' => $id2));
	}

	public function check_notified($id1, $id2)
	{
		return $this->db->get_where('notifiers', array('notifier_id' => $id1, 'users_id' => $id2));
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

	public function notify_friend($id1, $id2)
	{
		$user = array('users_id' => $id1, 'notifier_id' => $id2);
		$temp = $this->db->insert("notifiers", $user);
	}	

	public function delete_notification($id1, $id2)
	{
		$this->db->delete('notifiers', array('users_id' => $id1, 'notifier_id' => $id2));
	}
}