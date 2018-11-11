<?php
class Po_Summary extends CI_Controller{
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
//		$this->load->model('po_summary');
	}
	
	public function summary(){
	
	$crud = new grocery_CRUD();
			$crud->set_table('po_summary')
				->set_subject('Purchase Order')
				->columns('id','date', 'party_id', 'remarks')
				->display_as('id','Purchase Order No')
				->display_as('date','Date')
				->display_as('party_id','Party')
				->display_as('remarks','Remark')
				->set_rules('date', 'Date', 'required')
				->set_rules('party_id', 'Party', 'required')
				->fields('date','party_id','remarks')
				//->set_theme('datatables')
				->unset_delete()
				//->unset_read()
				->callback_add_field('date',array($this,'_add_default_date_value'))
				->add_action('View Details',base_url('application/view_details.png'), 'Po_Details/id_details')
				->add_action('Add Details',base_url('application/add_details.png'), 'Po_Details/details')
				->add_action('Print',base_url('application/print.png'),'Po_Details/idprint')
				->set_relation('party_id','party','{name}--{city}');
				$output = $crud->render();
				$this->_example_output($output);                

	}
	
	
	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('our_template.php',$output);    
		$this->load->view('templates/footer');
	}   

	
	function _add_default_date_value(){
        $value = !empty($value) ? $value : date("d/m/Y");
        $return = '<input type="text" name="date" value="'.$value.'">';
        $return .= "(dd/mm/yyyy)";
        return $return;
	}		
	
}	
?>
