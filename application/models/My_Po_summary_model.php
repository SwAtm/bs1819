<?php
class My_Po_summary_model extends Grocery_crud_model{
	
	public function __construct()
		{		
		$this->load->database();
	}
	
	
	public function po_summary($id){
	//called by *Po_details/details, *Po_details/idprint
	$sql=$this->db->select('po_summary.id, date, party.id as pid, party.name, party.add1, party.city' );
	$sql=$this->db->from('po_summary');
	$sql=$this->db->join('party', 'party.id=po_summary.party_id');
	$sql=$this->db->where('po_summary.id',$id);
	$sql=$this->db->get();
	$res=$sql->row_array();
	return $res;
	
	}
}
