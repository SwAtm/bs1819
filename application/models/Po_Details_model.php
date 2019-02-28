<?php
class Po_Details_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
}
public function adddata($details)
	//called by *Po_Details/details_add
	{
	$this->db->insert_batch('po_details',$details);
		return true;
	}
	
	
	
public function po_details($id){
	//called by *Po_Details/idprint, *Po_Details/details
	$sql=$this->db->select('item.id, item.code, item.rate, item.title, po_details.quantity' );
	$sql=$this->db->from('item');
	$sql=$this->db->join('po_details', 'item.id=po_details.item_id');
	$sql=$this->db->where('po_details.po_summ_id',$id);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	}
}	
