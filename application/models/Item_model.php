<?php
class Item_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_title($id)
	//called by temp_details/index
	{
	$query=$this->db->select('*');
	$query=$this->db->from ('item');
	$query=$this->db->where('id',$id);
	$query=$this->db->get();
	//if ($query):
	$row=$query->row();	
	return $row;
	//else:
	//return '';
	//endif;
	
	
	}
	public function getall()
	//called by temp_details/add
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from('item');
	$sql=$this->db->get();
	if ($sql && $sql->num_rows()>0):
	return $sql->result_array();
	else:
	return false;
	endif;
	}
	
	
}
