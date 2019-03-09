<?php
class Details_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function get_trans($id, $lid){
	//called by *Item/det_stock
	$sql=$this->db->query("select summary.tr_code, summary.tr_no, summary.date, party.code, party.name, party.city,  
	case when tran_type.descrip_2='Purchase' or tran_type.descrip_2= 'Sale Return' then quantity else quantity*-1 end as quantity  
	from details 
	join summary on details.summary_id=summary.id 
	join party on summary.party_id=party.id
	join tran_type on summary.tran_type_id=tran_type.id 
	join locations on tran_type.location=locations.description 
	where details.item_id='$id' and locations.id=$lid");
	//if ($sql and $sql->num_rows()>0):
	$trans=$sql->result_array();
	//else:
	//$sql=$this->db->query('select locations.id, locations.description, 0 as sales, 0 as purchase from locations');
	//$trans=$sql->result_array();
	//endif;
	return $trans;
	
	
	}
	public function adddata($details)
	//called by *Profo_Details/convert
	{
	$this->db->insert('details',$details);
		return true;
	}
	
	
	
	//these are not reqd
	/*
	

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
	*/
}
?>
