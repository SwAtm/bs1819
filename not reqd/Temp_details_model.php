<?php
class Temp_details_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function delete()
	//called by my_summary/add
	{
	$sql=$this->db->empty_table('temp_details');
	return true;
	}

	public function getall()
	//called by my_summary/add, temp_details/index, my_summary/editdet
	{
	
	$sql=$this->db->select('*');
	$sql=$this->db->from('temp_details');
	$sql=$this->db->get();
	if ($sql && $sql->num_rows()>0):
	return $sql->result_array();
	else:
	return false;
	endif;
	
	}
	
	public function adddata($data)
	//called by temp_details/add, my_summary/editdet
	{
		if ($this->db->insert('temp_details',$data)):
		return true;
	else:
		return false;
	endif;

	}

	public function getrow($id)
	//called by temp_details/edit
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from('temp_details');
	$sql=$this->db->where('id',$id);
	$sql=$this->db->get();
	$row=$sql->row();
	return $row;
	}
	
	public function update($data)
	//called by temp_details/edit
	{
		if ($this->db->replace('temp_details',$data)):
		return true;
	else:
		return false;
	endif;

	}
	
	public function delete_id($id)
	//called by temp_details/delete
	{
	$query=$this->db->where('id',$id);
	$query=$this->db->delete('temp_details');
	return true;
	}
	
	
}
?>
