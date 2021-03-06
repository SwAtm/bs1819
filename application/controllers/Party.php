<?php
class Party extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->load->library('table');
		//$this->output->enable_profiler(TRUE);
		$this->load->library('grocery_CRUD');

	}

	public function party()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('party')
		     ->set_subject('Party')
			 ->columns('code', 'name', 'city', 'i_e', 'st', 'gstno')
			 ->display_as('code','Party Code')
			->display_as('name','Party Name')
			->display_as('city','City')
			->display_as('i_e','Branch')
			->display_as('st','State')
			->display_as('gstno','GST No')
			->display_as('status', 'Status')
			->unique_fields(array('code'))
			->field_type('i_e','dropdown',array('I'=>'Inter Branch', 'E'=>'External'))
			->field_type('st','dropdown',array('I'=>'Inside State','O'=>'Outside State'))
			->field_type('status', 'dropdown', array('REGD'=>'Registered', 'UNRD'=>'Un Registered', 'COMP'=>'Composition Dealer'))
			->set_lang_string('delete_error_message', 'This data cannot be deleted, because there are still a constrain data, please delete that constrain data first.');
			$crud->callback_before_delete(array($this,'delete_check'));
			

			
			$operation=$crud->getState();
			if( $operation == 'add' || $operation == 'insert' || $operation == 'insert_validation'):
				$crud->required_fields('name','code', 'city', 'i_e', 'st', 'status');
				$crud->callback_before_insert(array($this,'toupper'));
				//$crud->set_rules('code', 'Party Code', 'trim|required|is_unique[party.code]');
			elseif($operation == 'edit' || $operation == 'update' || $operation == 'update_validation'):
				if ($this->check_in_use($crud->getStateInfo()->primary_key)):
					$crud->required_fields('city');
					$crud->callback_before_update(array($this,'toupper'));
					$crud->field_type('gstno', 'readonly');
					$crud->field_type('i_e', 'readonly');
					$crud->field_type('code', 'readonly');
					$crud->field_type('name', 'readonly');
					$crud->field_type('st', 'readonly');
					$crud->field_type('status', 'readonly');
				else:
					$crud->required_fields('name', 'code', 'city', 'i_e', 'st', 'status');
					$crud->callback_before_update(array($this,'toupper'));
					//$crud->set_rules('code', 'Party Code', 'trim|required|is_unique[party.code]');
				endif;
			
			
			endif;
            
            //$crud->unset_jquery();
			//$crud->unset_jquery_ui();
		
		$output = $crud->render();
		$this->_example_output($output);                
	}

	
	public function toupper($post_array)
	{
	foreach ($post_array as $k=>$v):
	$post_array[$k]=strtoupper($v);
	//$post_array['title']=strtoupper($post_array['title']);
	endforeach;
	return $post_array;
	
	
	}
	
	public function check_in_use($id)
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from('item');
	$sql=$this->db->where('party_id',$id);
	$res=$this->db->get();
	if ($res && $res->num_rows()>0):
		return true;
	else:
		$sql=$this->db->select('*');
		$sql=$this->db->from('summary');
		$sql=$this->db->where('party_id',$id);
		$res=$this->db->get();
			if ($res && $res->num_rows()>0):
			return true;
			else:
			return false;
			endif;
	endif;
	}
	
	public function delete_check($primary_key)
	{
	if ($this->check_in_use($primary_key)):
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
