<?php
class Item extends CI_Controller{
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
//		$this->output->enable_profiler(TRUE);

	}

	public function item()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('item')
		     ->set_subject('Item')
			 ->columns('cat_id', 'code', 'rate', 'title','party_id', 'hsn', 'grate')
			 ->display_as('cat_id','Category')
			 ->display_as('code','Item Code')
			 ->display_as('rate','Rate')
			 ->display_as('title','Title')
			->display_as('party_id','Party')
			->display_as('hsn','HSN Code')
			->display_as('grate','GST Rate')
			->set_language('english');
			//set relations:
			$crud->set_relation('cat_id','item_cat','name');
			$crud->set_relation('party_id','party','{name}--{city}');			
			
			//set required fields while adding and editing
			
			$operation=$crud->getState();
			if( $operation == 'add' || $operation == 'insert' || $operation == 'insert_validation'):
				$crud->required_fields('cat_id','rate','title','party_id','hsn','grate');
				$crud->callback_before_insert(array($this,'toupper'));
				$crud->set_rules('code', 'Item Code', 'required|callback_unique_code');
			elseif($operation == 'edit' || $operation == 'update' || $operation == 'update_validation'):
				$state_info=$crud->getStateInfo();
				if ($this->check_in_details($state_info->primary_key)):
				$crud->required_fields('title');
				$crud->field_type('cat_id', 'readonly');
				$crud->field_type('code', 'readonly');
				$crud->field_type('rate', 'readonly');
				$crud->field_type('party_id', 'readonly');
				$crud->field_type('hsn', 'readonly');
				$crud->field_type('grate', 'readonly');
				else:
				$crud->required_fields('cat_id','rate','title','party_id','hsn','grate');
				$crud->callback_before_update(array($this,'toupper'));
				$crud->set_rules('code', 'Item Code', 'required|callback_unique_code');
				endif;
				
			endif;
            //$pk=$crud->getStateInfo()->primary_key;
            //$crud->callback_before_delete(array($this,'delete_check['.$pk.']'));
            //$crud->unset_jquery();
            //$crud->unset_jquery_ui();
            $crud->set_lang_string('delete_error_message','This data cannot be deleted, it is used');
            $crud->callback_before_delete(array($this,'delete_check'));
			
		
		$output = $crud->render();
		$this->_example_output($output);                
	}

	public function unique_code($code)
	{
	$id=$this->uri->segment(4);
	
	$rate=$this->input->post('rate');
	$sql=$this->db->select('*');
	$sql=$this->db->from('item');
	$sql=$this->db->where('code',$code);
	$sql=$this->db->where('rate',$rate);
	if (!empty($id) && is_numeric($id)):
	$sql=$this->db->where('id !=',$id);
	endif;
	$res=$this->db->get();
	if ($res and $res->num_rows()>0):
		$this->form_validation->set_message('unique_code','There is already an entry for same Code and Rate');
		return false;
    else:
		return true;
	endif;
          
	
	
	}

	public function toupper($post_array)
	{
	$post_array['code']=strtoupper($post_array['code']);
	$post_array['title']=strtoupper($post_array['title']);
	return $post_array;
	
	}


	public function check_in_details($id)
	{
	
	$sql=$this->db->select('*');
	$sql=$this->db->from('details');
	$sql=$this->db->where('item_id',$id);
	$res=$this->db->get();
	if ($res && $res->num_rows()>0):
	return true;
	else:
	return false;
	endif;
	}

	public function delete_check($primary_key)
	{
	//return false;
	if ($this->check_in_details($primary_key)):
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
