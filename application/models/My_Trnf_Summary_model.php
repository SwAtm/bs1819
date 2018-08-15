<?php
class My_Trnf_Summary_model extends Grocery_crud_model{
	
	public function __construct()
		{		
		$this->load->database();
	}
	
	
	public function trnf_summary($id){
	//called by trnf_details/idprint
	$sql=$this->db->select('trnf_summary.id, date, from_id, to_id, l1.description as loc_from, l2.description as loc_to' );
	$sql=$this->db->from('trnf_summary');
	$sql=$this->db->join('locations as l1', 'l1.id=from_id');
	$sql=$this->db->join('locations as l2', 'l2.id=to_id');
	$sql=$this->db->where('trnf_summary.id',$id);
	$sql=$this->db->get();
	$res=$sql->row_array();
	return $res;
	
	}
}  
?>
