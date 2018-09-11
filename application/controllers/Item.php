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
		$this->load->model('Op_Invent_model');
		$this->load->model('Details_model');
		$this->load->model('Grocery_crud_model');
		$this->load->model('My_Trnf_Details_model');
		$this->load->model('Item_model');

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
            $crud->add_action('View Details',base_url('application/view_details.png'),'Item/get_stock');
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
	
	function get_stock($id){
		//echo $id;
		$item=$this->Item_model->get_title($id);
		$stck_summ=$this->Item_model->stck_summ($id);
		
		$data['stck_summ']=$stck_summ;
		$data['item']=$item;
		$this->load->view('templates/header');
		$this->load->view('item/get_stck',$data);    
		$this->load->view('templates/footer');
	}

	function det_stck($id,$lid){
		$lid=$this->uri->segment('3');	
		$iid=$this->uri->segment('4');	
		//echo $lid."<br>";
		//echo  $iid;
		$item=$this->Item_model->get_title($iid);
		$opstock=$this->Op_Invent_model->op_stock($iid, $lid);
		$trans=$this->Details_model->get_trans($iid, $lid);
		$trnfs=$this->My_Trnf_Details_model->get_trnfs($iid, $lid);
		
		//$detstck=$this->Item_model->get_det_stck($iid, $lid);
		/*
		echo "<pre>";
		print_r($opstock);
		print_r($trans);
		print_r($trnfs);
		print_r($item);
		*/
		//print_r($trnfs);
		$show_stck=array();
		foreach ($opstock as $row):
		$show_stck[]=array('date'=>"0000-00-00",'party'=>"Opening Stock",'qty'=>$row['opstck'], 'balance'=>0);
		endforeach;
		foreach ($trans as $row):
		$show_stck[]=array('date'=>$row['date'], 'party'=>$row['tr_code']." ".$row['tr_no']." ".$row['code']." ".$row['name']." ".$row['city'], 'qty'=>$row['quantity'], 'balance'=>0);
		endforeach;
		
		foreach ($trnfs as $row):
		$show_stck[]=array('date'=>$row['tr_date'], 'party'=>$row['tr_id']." ".$row['description'], 'qty'=>$row['quantity'], 'balance'=>0);
		endforeach;
		/*print_r($show_stck);
		$data['opstock']=$opstock;
		$data['trans']=$trans;
		$data['trnfs']=$trnfs;*/
		$data['item']=$item;
		array_multisort(array_column($show_stck, 'date'), SORT_ASC, $show_stck);
		$stck_bal=0;
		foreach ($show_stck as $row=>$val):
			$show_stck[$row]['balance']=$stck_bal+$val['qty'];
			$stck_bal=$show_stck[$row]['balance'];
		endforeach;
		
			
		
		$data['show_stck']=$show_stck;
		$this->load->view('templates/header');
		$this->load->view('item/show_stck',$data);    
		$this->load->view('templates/footer');
	}
		
	
	
	
	

}
