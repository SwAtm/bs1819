<?php
class Summary extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		//$this->load->helper('security');
		$this->load->library('grocery_CRUD');
		$this->load->model('Tran_type_model');
		$this->load->model('Party_model');
		$this->load->model('Summary_model');
		$this->load->model('Temp_details_model');
		$this->output->enable_profiler(TRUE);
}



		public function summary()
	{
			$crud = new grocery_CRUD();
			$crud->set_table('summary')
				->set_subject('Summary')
				->columns('tran_type_id','tr_code','tr_no','date', 'party_id', 'expenses', 'remark')
				->display_as('tran_type_id','Transaction Type')
				->display_as('tr_code','Transaction Code')
				->display_as('tr_no','Transaction Number')
				->display_as('date','Date')
				->display_as('party_id','Party')
				->display_as('expenses','Exenses')
				->display_as('remark','Remark')
				->fields('tran_type_id','tr_code','tr_no','date','party_id','expenses','remark')
				->unset_add()
				//->callback_before_edit(array($this,'checkedit'))
				->unset_edit()
				->set_theme('datatables')
				->unset_delete()
				->add_action('Edit',base_url('application/pencil.png'), 'My_Summary/edit');
		
				$operation=$crud->getState();
				if($operation == 'edit' || $operation == 'update' || $operation == 'update_validation'):
				$crud->field_type('tran_type_id','readonly')
					->field_type('tr_no','readonly')
					->field_type('tr_code','readonly')
					->required_fields('date','party_id');

				endif;
		
			$crud->set_relation('tran_type_id','tran_type','{location}--{descrip_1}---{descrip_2}');
			$crud->set_relation('party_id','party','{name}--{city}');
			$output = $crud->render();
			$this->_example_output($output);                

	}

		public function checkedit($id)
		{
		$sql=$this->db->select('tran_type.descrip1');
		$sql=$this->db->from('tran_type');
		$sql=$this->db->join('summary', 'summary.tr_code=tran_type.tr_code');
		$sql=$this->db->where('sumamry.id',$id);
		$res=$this->db->get();
		$trtype=$res->row()->descrip1;
		$sql=$this->db->select('summary.date');
		$sql=$this->db->from('summary');
		$sql=$this->db->where('sumamry.id',$id);
		$res=$this->db->get();
		$dt=$res->row()->date;
	if ($trantype=='cash' AND $data!=date()):
		return false;
	else:
		return true;
	endif;
		}
			
		function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('our_template.php',$output);    
		$this->load->view('templates/footer');
	}    




}
?>
