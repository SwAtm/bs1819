<?php
class My_Profo_Details_model extends Grocery_crud_model{
	
	public function __construct()
		{		
		$this->load->database();
	}

	public function profo_details($id){
	//called by profo_details/idprint
	$sql=$this->db->select('item.title, item.rate, quantity' );
	$sql=$this->db->from('proforma_details');
	$sql=$this->db->join('item', 'item.id=item_id');
	$sql=$this->db->where('proforma_details.p_sum_id',$id);
	$sql=$this->db->get();
	$res=$sql->result_array();
	return $res;
	
	}

	public function get_balance($pid){
		//called by profo_details/id_balance, details
	$res="select pd.item_id, item.title, item.rate, 
	sum(case when ps.o_i='out' then pd.quantity else 0 end) as qout, 
	sum(case when ps.o_i='in' then pd.quantity else 0 end) as qin 
	from proforma_details as pd 
	join item on pd.item_id=item.id 
	join proforma_summary as ps on pd.p_sum_id=ps.id 
	where ps.party_id=".$pid."
	group by pd.item_id order by pd.item_id";
	$result=$this->db->query($res);
	if ($result and $result->num_rows()>0):
	$result=$result->result_array();
	return $result;
	else:
	return false;
	endif;
	}
	
	public function get_balance_iid($pid,$iid){
		//called by Profo_Details/check_qty
	$res="select pd.item_id, item.title, item.rate, 
	sum(case when ps.o_i='out' then pd.quantity else 0 end) as qout, 
	sum(case when ps.o_i='in' then pd.quantity else 0 end) as qin 
	from proforma_details as pd 
	join item on pd.item_id=item.id 
	join proforma_summary as ps on pd.p_sum_id=ps.id 
	where ps.party_id=".$pid."
	and item.id=".$iid."
	group by pd.item_id";
	$result=$this->db->query($res);
	if ($result and $result->num_rows()>0):
	$result=$result->row_array();
	return $result;
	else:
	return false;
	endif;
	}
	
	
	public function delet_psid($psid){
		//called by profo_details/convert
	$sql=$this->db->where('p_sum_id',$psid);
	$sql=$this->db->delete('proforma_details');
	
	}
}
