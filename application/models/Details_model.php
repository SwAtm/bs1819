<?php
class Details_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function adddata($details)
	{
	
	$this->db->insert('details',$details);
		return true;
	}

	public function getdetails($id)
	//called by My_Summary/editdet
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from ('details');
	$sql=$this->db->where('summary_id',$id);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	}
	
	public function deletedet($id)
	//called by My_summary/delete, details/complete
	{
	$sql=$this->db->where('summary_id',$id);
	$sql=$this->db->delete('details');
	
	if ($sql):
		return true;
	else:
		return false;
	endif;
	}

	public function det_item($id=null)
	//called by Details/show
	{
	$sql=$this->db->select('details.id, item.code, item.rate,item.title,details.quantity,details.cashdisc,details.discount,item.grate,item.hsn');	
	$sql=$this->db->from('details');
	$sql=$this->db->join('item','item.id=details.item_id');
	$sql=$this->db->where('details.summary_id',$id);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	}
}
?>
