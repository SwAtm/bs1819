<?php
class Profo_Summary extends CI_Controller{
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
		$this->load->model('Grocery_crud_model');
		//$this->load->model('Custom_query_model');
		$this->output->enable_profiler(TRUE);
	}
	
	public function summary()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('proforma_summary')
				->set_subject('Proforma')
				->columns('id','date','party_id','o_i')
				->display_as('id', 'ID')
				->display_as('date', 'Date')
				->display_as('party_id', 'Party')
				->display_as('o_i', 'Type')
				->set_relation('party_id','party','{name}-{add1}-{city}')
				->unset_delete()
				//->unset_edit()
				->unset_edit_fields('o_i')
				->set_rules('date', 'Date', 'required')
				->set_rules('party_id', 'Party', 'required')
				->set_rules('party_id', 'Party', 'callback_check_o_i')
				->set_rules('o_i', 'Proforma Type', 'required')
				->callback_add_field('date',array($this,'_add_default_date_value'))
				->field_type('o_i','dropdown',array('out'=>'Out','in'=>'In'))
				->add_action('View Details',base_url('application/view_details.png'), 'Profo_Details/id_details')
				->add_action('Add Details',base_url('application/add_details.png'), 'Profo_Details/details/add')
				->add_action('Print',base_url('application/print.png'),'Profo_Details/idprint')
				//->set_theme('datatables')
				->order_by('id','desc');
				//$crud->callback_before_update(array($this,'check_o_i'));
		$output = $crud->render();
		$this->_example_output($output);  
				
			}
			
	function balance()
	{
	$crud = new grocery_CRUD();
		$crud->set_table('proforma_summary');
				$crud->set_model('Custom_query_model');
				$crud->basic_model->set_custom_query('select party_id, id from proforma_summary group by party_id');
				$crud->columns('party_id');
				$crud->display_as('party_id', 'Party')
				->unset_read()
				->unset_delete()
				->unset_edit()
				->unset_add()
				->callback_column('party_id', array($this, '_callback_party_details'))
				->order_by('id','desc')
				->add_action('View Details',base_url('application/view_details.png'), 'Profo_Details/id_balance');
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
	
	function check_o_i($post){
	$type=$this->input->post('o_i');	
	$type1='out';
	$res=$this->db->query('select * from proforma_summary where party_id='.$post);
	$count1=count($res->result_array());
	
	if ($type=='out'||$count1):
		return true; 
	else:
		$this->form_validation->set_message('check_o_i', 'Nothing issued to this party ');
		return false;
	endif;
}
	function _callback_party_details($id, $row){
		$sql=$this->db->query('select ps.id, ps.party_id, party.name, party.add1, party.city from proforma_summary as ps join party on ps.party_id=party.id where ps.id='.$row->id);
		$res=$sql->row();
		$party_n_a=$res->name.", ".$res->add1.", ".$res->city;
		return $party_n_a;
	}
}
?>
