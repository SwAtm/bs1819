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
	//called by my_summary/edit, Details/show
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
	
	public function toprint1($id)
	//called by My_summary/printbill
	{
	$sql=$this->db->select('a.tr_code, a.tr_no, a.date, a.party_id, a.expenses, a.remark, b.code, b.name, b.add1, b.add2, b.city, b.gstno');
	$sql=$this->db->from ('summary as a');
	$sql=$this->db->join ('party as b', 'a.party_id=b.id');
	$sql=$this->db->where('a.id',$id);
	$res=$this->db->get();
	$toprint1=$res->row();
	return $toprint1;
	}
	
	public function toprint2($id)
	//called by My_summary/printbill
	{
	$sql=$this->db->select('a.item_id, a.quantity, a.discount, a.cashdisc, b.cat_id, b.code, b.rate, b.title, b.hsn, b.grate');
	$sql=$this->db->from ('details as a');
	$sql=$this->db->join ('item as b', 'a.item_id=b.id');
	$sql=$this->db->where('a.summary_id',$id);
	$res=$this->db->get();
	$toprint2=$res->result();
	return $toprint2;
}
	


}
?>
