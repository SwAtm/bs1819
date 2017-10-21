<?php
class Location extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->load->library('table');
		$this->load->library('grocery_CRUD');

	}

	public function locations()
	{
		$crud = new grocery_CRUD();
		$this->grocery_crud->set_table('locations');
		//$crud->set_table('contacts');
		$output = $this->grocery_crud->render();
 
		$this->_example_output($output);                
	}

	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('our_template.php',$output);    
		$this->load->view('templates/footer');
	}    


}
