<?php
class Summary extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->load->library('table');
		//$this->load->helper('security');
		$this->load->library('grocery_CRUD');
		$this->output->enable_profiler(TRUE);
}

	public function index()
	{
	echo "Summary Home";
	}

	public function summary()
	{

			$crud = new grocery_CRUD();
			$crud->set_table('summary')
				->set_subject('Summary')
				->columns('tr_code','tr_no','date', 'party_id', 'expenses', 'remark')
				->display_as('tr_code','Transaction Type')
				->display_as('tr_no','Transaction Number')
				->display_as('date','Date')
				->display_as('party_id','Party')
				->display_as('expenses','Exenses')
				->display_as('remark','Remark')
				->fields('tr_code','date','party_id','expenses','remark','tr_no')
				->field_type('tr_no','invisible')
				->required_fields('tr_code','date','party_id');
				$crud->callback_before_insert(array($this,'get_tr'));
				$crud->callback_before_update(array($this,'get_trcode'));
			//$crud->callback_add_field('discount',array($this,'add_default_disc'));
			//$crud->callback_add_field('cashdisc',array($this,'add_default_cdisc'));
			//set relations:
			$crud->set_relation('tr_code','tran_type','{location}--{descrip_1}--{descrip_2}');
			$crud->set_relation('party_id','party','{name}--{city}');
			$output = $crud->render();
			$this->_example_output($output);                
}
			
			
		public function edit()
		{
		echo "Summary";
		
		}	
			
		function get_tr($post_array)
		{
			$query=$this->db->select('tr_code');
			$query=$this->db->from('tran_type');
			$query=$this->db->where('id', $post_array['tr_code']);
			$query=$this->db->get();
			$tr_code=$query->row()->tr_code;
			$post_array['tr_code']=$tr_code;
			
			
			
			$query=$this->db->select_max('tr_no');
			$query=$this->db->from('summary');
			$query=$this->db->where('tr_code', $post_array['tr_code']);
			$query=$this->db->get();
			if ($query):
				$tr_no=$query->row()->tr_no;
				$tr_no=$tr_no+1;
			else:
				$tr_no=1;
			endif;
			$post_array['tr_no']=$tr_no;
			
			
			return $post_array;
			
			
		}	
			
		function get_trcode($post_array)
		{
			$query=$this->db->select('tr_code');
			$query=$this->db->from('tran_type');
			$query=$this->db->where('id', $post_array['tr_code']);
			$query=$this->db->get();
			$tr_code=$query->row()->tr_code;
			$post_array['tr_code']=$tr_code;
				return $post_array;
			}	
			
			
			function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('our_template.php',$output);    
		$this->load->view('templates/footer');
	}    




}
