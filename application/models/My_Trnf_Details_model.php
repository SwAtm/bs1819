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
	
	/*public function get_balance_by_id($p_summ_id){
	//called by Profo_Details/details
	$sql=$this->db->query('select pd.item_id, item.title, item.rate, sum(case when ps.o_i='out' then pd.quantity else 0 end) as qout, sum(case when ps.o_i='in' then pd.quantity else 0 end) as qin from proforma_details as pd join item on pd.item_id=item.id join proforma_summary as ps on pd.p_sum_id=ps.id group by pd.item_id order by pd.item_id where pd.
	}*/
	
	public function get_trnfs($id, $lid){
	//called by Item/det_stock
	$sql=$this->db->query("select tr.tr_id, tr.tr_date, locations.description, tr.quantity from
	locations
	join
		(select trnf_summary.id as tr_id, trnf_summary.date as tr_date, 
		case when trnf_summary.from_id=$lid then trnf_summary.to_id else trnf_summary.from_id end as to_from, 
		case when trnf_summary.from_id=$lid then trnf_details.quantity*-1 else trnf_details.quantity end as quantity
		from
		trnf_details join
		trnf_summary on trnf_details.summ_id=trnf_summary.id
		where trnf_details.item_id=$id and
		(trnf_summary.from_id=$lid OR trnf_summary.to_id=$lid)) as tr
	on locations.id=tr.to_from"); 
	//if ($sql and $sql->num_rows()>0):
	$trans=$sql->result_array();
	//else:
	//$sql=$this->db->query('select locations.id, locations.description, 0 as qout, 0 as qin from locations');
	//$trans=$sql->result_array();
	//endif;
	return $trans;
	
	
	
	
	}
}
