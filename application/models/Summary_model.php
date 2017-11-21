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
		return $id;
		

	}

	public function getdetails($id)
	//called by my_summary/edit
	{
		$sql=$this->db->select('*');
		$sql=$this->db->from('summary');
		$sql=$this->db->where('id',$id);
		$sql=$this->db->get();
		$row=$sql->row();
		return $row;
	}
	
	public function getdescr($id)
	//called by my_summary/edit
	{
		$sql=$this->db->select('*');
		$sql=$this->db->from('tran_type');
		$sql=$this->db->join('summary', 'summary.tr_code=tran_type.tr_code');
		$sql=$this->db->where('summary.id',$id);
		$res=$this->db->get();
		$trtype=$res->row();
		return $trtype;
	}
	
	public function update($data)
	//called by My_Summary/edit
	{
	extract ($data);
	$this->db->where('id',$id);
	$this->db->update('summary',array('party_id'=>$party_id, 'expenses'=>$expenses,'remark'=>$remark,'date'=>$date));

	return true;	
		
	}

	public function cancel($id)
	//called by My_summary/delete
	{
	
	$this->db->where('id',$id);
	$this->db->update('summary',array('expenses'=>0,'remark'=>"Cancelled",'date'=>date('Y-m-d')));
	return true;
	
	
	}

}
?>
