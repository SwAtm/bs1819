<?php
class Summary_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	

	public function gettranno($tcode)
	//called by my_summary/add
		{
		$query=$this->db->select_max('tr_no');
		$query=$this->db->from('summary');
		$query=$this->db->where('tr_code', $tcode);
		$query=$this->db->get();
		if ($query):
			$tr_no=$query->row()->tr_no;
			$tr_no=$tr_no+1;
		else:
			$tr_no=1;
		endif;
		
		return $tr_no;
	}

	public function adddata($data)
	//called by my_summary/add
	{

	if ($this->db->insert('summary',$data)):
		return true;
	else:
		return false;
	endif;
	
	}
	
	public function getmaxid()
	//called by my_summary/add
	{
		$sql=$this->db->select_max('id');
		$sql=$this->db->from('summary');
		$sql=$this->db->get();
		$id=$sql->row()->id;
		return $id+1;
		

	}


}
?>
