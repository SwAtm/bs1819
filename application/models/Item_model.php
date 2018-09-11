<?php
class Item_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_title($id)
	//called by temp_details/index
	{
	$query=$this->db->select('*');
	$query=$this->db->from ('item');
	$query=$this->db->where('id',$id);
	$query=$this->db->get();
	//if ($query):
	$row=$query->row();	
	return $row;
	//else:
	//return '';
	//endif;
	
	
	}
	public function getall()
	//called by temp_details/add
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from('item');
	$sql=$this->db->get();
	if ($sql && $sql->num_rows()>0):
	return $sql->result_array();
	else:
	return false;
	endif;
	}
	
	
	public function stck_summ($id){
	//called by Item/get_stock
	$sql=$this->db->query("select l.id, l.description, op.opstck, dt.sales, dt.purchase, trn.qout, trn.qin
	from
	locations as l
	left join
		(select location_id, sum(quantity) opstck
		from op_invent 
		where item_id=$id
		group by location_id) as op
	on l.id=op.location_id
	left join
		(select locations.id as lid,
		sum(case when tran_type.descrip_2='Sales' or tran_type.descrip_2= 'Purchase Return' then quantity else 0 end) as sales,
		sum(case when tran_type.descrip_2='Purchase' or tran_type.descrip_2= 'Sale Return' then quantity else 0 end) as purchase  
		from details 
		join summary on details.summary_id=summary.id 
		join tran_type on summary.tran_type_id=tran_type.id 
		join locations on tran_type.location=locations.description 
		where details.item_id='$id' group by locations.id) as dt
	on l.id=dt.lid
	left join
		(select l1.id, t1.qout, t2.qin
		from
		locations as l1
		left join
			(select trnf_summary.from_id, sum(quantity) as qout
			from trnf_details
			join trnf_summary on trnf_details.summ_id=trnf_summary.id
			where trnf_details.item_id='$id'
			group by trnf_summary.from_id) as t1
		on l1.id=t1.from_id
		left join
			(select trnf_summary.to_id, sum(quantity)as qin
			from trnf_details
			join trnf_summary on trnf_details.summ_id=trnf_summary.id
			where trnf_details.item_id='$id'
			group by trnf_summary.to_id) as t2
		on l1.id=t2.to_id) as trn
	on l.id=trn.id");
//if ($sql and $sql->num_rows()>0):
	$res=$sql->result_array();
//else:
	//$sql=$this->db->query('select locations.id, locations.description, 0 as opstock, 0 as purchase, 0 as sales, 0 as qout, 0 //as qin from locations');
	//$res=$sql->result_array();
//endif;


return $res;
}




	
	
	
}
