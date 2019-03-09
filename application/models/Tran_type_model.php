<?php
class Tran_type_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}


	public function gettrcode($tid)
	//called by my_summary/get_trcode_etc, *Summary/get_trcode_etc, *Profo_Details/convert
	{
	$sql=$this->db->select('tr_code, descrip_1');
	$sql=$this->db->from('tran_type');
	$sql=$this->db->where('id',$tid);
	$sql=$this->db->get();
	return $sql->row();
	}
	
	public function salescode()
	//*called by Profo_Details/id_balance
	{
	$sql=$this->db->select('id, descrip_1, descrip_2, location');
	$sql=$this->db->from('tran_type');
	$sql=$this->db->where('descrip_2','Sales');
	$sql=$this->db->get();
	return $sql->result_array();
	}


	//not reqd
	/*
	public function getall()
	//called by my_sumamry/add
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from ('tran_type');
	$sql=$this->db->get();
	return $sql->result_array();
	}
	*/



}
?>
