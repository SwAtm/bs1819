<?php
class My_Trnf_Details_model extends Grocery_crud_model{
	
	public function __construct()
		{		
		$this->load->database();
	}

	public function trnf_details($id){
	//called by trnf_details/idprint
	$sql=$this->db->select('item.title, item.rate, quantity' );
	$sql=$this->db->from('trnf_details');
	$sql=$this->db->join('item', 'item.id=item_id');
	$sql=$this->db->where('trnf_details.summ_id',$id);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	
	}
	
	public function get_balance_by_id($p_summ_id){
	//called by Profo_Details/details
	$sql=$this->db->query('select pd.item_id, item.title, item.rate, sum(case when ps.o_i='out' then pd.quantity else 0 end) as qout, sum(case when ps.o_i='in' then pd.quantity else 0 end) as qin from proforma_details as pd join item on pd.item_id=item.id join proforma_summary as ps on pd.p_sum_id=ps.id group by pd.item_id order by pd.item_id where pd.
	}
}
