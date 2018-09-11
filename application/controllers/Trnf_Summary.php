<?php
class Trnf_Summary extends CI_Controller{
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
		$this->output->enable_profiler(TRUE);
	}
	
	public function summary()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('trnf_summary')
				->set_subject('Transfer')
				->columns('id', 'date', 'from_id','to_id')
				->display_as('id','Transfer ID')
				->display_as('date','Date')
				->display_as('from_id','Location From')
				->display_as('to_id','Location To')
				->unset_delete()
				->set_rules('date', 'Date', 'required')
				->set_rules('from_id', 'Location From', 'required')
				->set_rules('to_id', 'Location To', 'required')
				->set_rules('to_id', 'Location To', 'callback_check_location')
				->add_action('View Details',base_url('application/view_details.png'), 'Trnf_Details/id_details')
				->add_action('Add Details',base_url('application/add_details.png'), 'Trnf_Details/details/add')
				->set_relation('from_id','locations','{description}')
				->set_relation('to_id','locations','{description}')
				->order_by('id','desc');
				//$crud->unset_clone();
				$crud->callback_add_field('date',array($this,'_add_default_date_value'));
		$output = $crud->render();
		$this->_example_output($output);           
	
	}
	
	function check_location($str)
	{
	$from_id=$this->input->post('from_id');
	if ($str==$from_id):
		$this->form_validation->set_message('check_location', 'Both locations cannot be same');
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

	

	function _add_default_date_value(){
        $value = !empty($value) ? $value : date("d/m/Y");
        $return = '<input type="text" name="date" value="'.$value.'">';
        $return .= "(dd/mm/yyyy)";
        return $return;
	}
	
	function get_stock($id){
		return $id;
	}

}
?>
