<?php
class Party_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}


public function getall()
	//called by my_sumamry/add
	
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from ('party');
	$sql=$this->db->order_by('name','ASC');
	$sql=$this->db->get();
	return $sql->result_array();
	}

	public function getdetails($id)
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from ('party');
	$sql=$this->db->where ('id', $id);
	$sql=$this->db->get();
	$res=$sql->row();
	return $res;
	}	




}
?>
