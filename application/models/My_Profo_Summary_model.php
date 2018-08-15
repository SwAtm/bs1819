<?php
class My_Profo_Summary_model extends Grocery_crud_model{
	
	public function __construct()
		{		
		$this->load->database();
	}
	
	
	public function profo_summary($id){
	//called by profo_details/details, idprint, check_qty, id_balance
	$sql=$this->db->select('proforma_summary.id, proforma_summary.o_i, date, party.id as pid, party.name, party.add1, party.city' );
	$sql=$this->db->from('proforma_summary');
	$sql=$this->db->join('party', 'party.id=proforma_summary.party_id');
	$sql=$this->db->where('proforma_summary.id',$id);
	$sql=$this->db->get();
	$res=$sql->row_array();
	return $res;
	
	}
	
	
	public function get_ids_party($pid){
		//called by profo_details/convert
	$sql=$this->db->select('id');
	$sql=$this->db->from('proforma_summary');
	$sql=$this->db->where('party_id',$pid);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	}
	
	public function delet_party($pid){
		//called by profo_details/convert
	$sql=$this->db->where('party_id',$pid);
	$sql=$this->db->delete('proforma_summary');
	}
	
}  
?>
