<?php
class Tran_type_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}


	public function getall()
	//called by my_sumamry/add
	
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from ('tran_type');
	$sql=$this->db->get();
	return $sql->result_array();
	}


	public function gettrcode($tid)
	//called by my_summary/add
	{
	$sql=$this->db->select('tr_code');
	$sql=$this->db->from('tran_type');
	$sql=$this->db->where('id',$tid);
	$sql=$this->db->get();
	return $sql->row();
	
	
	}




}
?>
