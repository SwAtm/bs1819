<?php
class temp_billwise_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function adddata($data)
//called by *Reports/reports
		{
		if ($this->db->insert_batch('temp_billwise',$data)):
		$sql=$this->db->select ('tr_code, tr_no, date, code, name, city, expenses, sum(amount_b) as amount_b, sum(amount_r) as amount_r, sum(igst) as igst, sum(cgst) as cgst, sum(sgst) as sgst, sum(total)+expenses as total');
		$sql=$this->db->from ('temp_billwise');
		$sql=$this->db->group_by(array('tr_code', 'tr_no'));
		$sql=$this->db->get();
		$res['details']=$sql->result_array();
		$sql=$this->db->select('temp_billwise.tr_code, location, descrip_1, descrip_2, expenses, sum(amount_b) as amount_b, sum(amount_r) as amount_r, sum(igst) as igst, sum(cgst) as cgst, sum(sgst) as sgst, sum(total)+expenses as total');
		$sql=$this->db->from ('temp_billwise');
		$sql=$this->db->join ('tran_type','temp_billwise.tr_code=tran_type.tr_code');
		$sql=$this->db->group_by ('tr_code');
		$sql=$this->db->get();
		$res1=$sql->result_array();
		$this->db->truncate('temp_billwise');
		$res['summary']=$res1;
		return $res;
		
	else:
		return false;
	endif;
	}

	}
?>


