<?php
class Details_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}

	public function adddata($details)
	{
	
	$this->db->insert('details',$details);
		return true;
	}





}
?>
