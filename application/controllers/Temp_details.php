<?php
class Temp_details extends CI_Controller{
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

	public function temp_details()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('temp_details')
		     ->set_subject('Item')
			 ->columns('item_id', 'quantity', 'discount', 'cashdisc')
			 ->display_as('item_id','Item')
			 ->display_as('quantity','Quantity')
			 ->display_as('discount','% Discount')
			->display_as('cashdisc','Cash Discount')
			->fields('item_id','quantity','discount','cashdisc')
			->required_fields('item_id','quantity','discount','cashdisc');
			$crud->callback_add_field('quantity',array($this,'add_default_qty'));
			$crud->callback_add_field('discount',array($this,'add_default_disc'));
			$crud->callback_add_field('cashdisc',array($this,'add_default_cdisc'));
			

			//set relations:
		$crud->set_relation('item_id','item','{title}--{code}--{rate}');
		$output = $crud->render();
		$state = $crud->getState();
        if ($state=='list'||$state=='success'): 
			$output->extra = "<a href=".site_url('My_Summary/add').">Complete Transaction</a>";
        else:
			$output->extra = '';	
        endif;
		
		
		$this->_example_output($output);                

	}
	
		public function add_default_qty()
		{
		return '<input type="text" maxlength="50" value="1" name="quantity" >';
		
		}
		
		public function add_default_disc()
		{
		return '<input type="text" maxlength="50" value="0" name="discount" >';
		
		}
	
		public function add_default_cdisc()
		{
		return '<input type="text" maxlength="50" value="0" name="cashdisc" >';
		
		}
		function _example_output($output = null)
		{
		$this->load->view('templates/header');
		$this->load->view('trans_template.php',$output);    
		$this->load->view('templates/footer');
		}    

}
