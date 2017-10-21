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
	



}
?>
