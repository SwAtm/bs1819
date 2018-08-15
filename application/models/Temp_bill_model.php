<?php
//this seems unnecessary. May be, it was used and then discarded.
class temp_bill_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function adddata($data)
//called by My_summary/printbill
		{
		if ($this->db->insert_batch('temp_bill',$data)):
		$sql=$this->db->select ('grate, sum(tr_val) as tr_val, sum(val) as val, sum(gst) as gst');
		$sql=$this->db->from ('temp_bill');
		$sql=$this->db->group_by('grate');
		$sql=$this->db->get();
		$res=$sql->result_array();
		$this->db->truncate('temp_bill');
		return $res;
		
	else:
		return false;
	endif;
	}

	}
?>

