<?php
class Op_Invent_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function op_stock($id, $lid){
	//called by Item/det_stock
	$sql=$this->db->query("select locations.id, locations.description, opstck
	from locations 
	left join 
		(select location_id, sum(quantity) opstck
		from op_invent 
		where item_id=$id 
		group by location_id) as op
	on locations.id=op.location_id
	where locations.id=$lid");
	//if ($sql and $sql->num_rows()>0):
	$opstock=$sql->result_array();
	//else:
	//$sql=$this->db->query('select locations.id, locations.description, 0 as opstock from locations');
	//$opstock=$sql->result_array();
	//Die ("no luck");
	//endif;
	return $opstock;
	}
}	
