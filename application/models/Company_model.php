<?php
class Company_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function getall()
	//Details/printbill
	{
		$sql=$this->db->select('*');
		$sql=$this->db->from('company');
		$sql=$this->db->get();
		$row=$sql->row();
		return $row;
	
	}
	
}
