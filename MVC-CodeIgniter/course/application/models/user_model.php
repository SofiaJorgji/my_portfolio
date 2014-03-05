<?php

class User_model extends CI_Model
{
  function insert_entry($data)
  {
    $this->db->insert("courses", $data);
  }

  function update_entry($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('courses', $data); 
  }

  function get_all()
  {
  	return $this->db->get('courses');
  }

  function delete_entry($rec_id)
  {
    $this->db->delete('courses', array('id' => $rec_id)); 
  }
  
}