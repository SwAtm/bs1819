<?php
class My_Summary extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		//$this->load->helper('security');
		//$this->load->library('grocery_CRUD');
		$this->load->model('Tran_type_model');
		$this->load->model('Party_model');
		$this->load->model('Summary_model');
		$this->load->model('Temp_details_model');
		$this->output->enable_profiler(TRUE);
}

	public function index()
	{
	echo "Summary Home";
	}

		public function summary()
	{
	echo "Summary Home";
	}

	public function add()
	{

	//set validation rules
	$this->form_validation->set_rules('tran_type_id', 'Tran Type ID', 'required');
	$this->form_validation->set_rules('party_id', 'Party ID', 'required');
	$this->form_validation->set_rules('date', 'Date', 'required');
	//new or failed
	if ($this->form_validation->run()==false):
		$trantype=$this->Tran_type_model->getall();
		foreach ($trantype as $v):
		$transact[$v['id']]=$v['location']." ".$v['descrip_1']." ".$v['descrip_2'];
		endforeach;
		unset ($trantype);
		$data['transact']=$transact;
		
		
		$party=$this->Party_model->getall();
		foreach ($party as $p):
		$party1[$p['id']]=$p['name']." ".$p['city'];
		endforeach;
		unset ($party);
		$data['party']=$party1;
		$this->load->view('templates/header');
		$this->load->view('summary/add',$data);    
		$this->load->view('templates/footer');
	else:
	//valid
		echo "valid";
		unset ($_POST['submit']);
		$tid=$_POST['tran_type_id'];
		$trcode=$this->Tran_type_model->gettrcode($tid);
		$_POST['tr_code']=$trcode->tr_code;
		$trno=$this->Summary_model->gettranno($_POST['tr_code']);
		$_POST['tr_no']=$trno;
		
		//$_POST['tr_no']=$trcode_no[1];
		print_r($_POST);
		$_POST['date']=date('Y-m-d',strtotime($_POST['date']));
		if ($this->Summary_model->adddata($_POST)):
			$this->Temp_details_model->delete();
			echo "Record added.<a href=".site_url('home').">Go Home</a>";
		else:
				echo "Record not added.<a href=".site_url('home').">Go Home</a>";
		endif;
			
	
	
	
	endif;





/*			$crud = new grocery_CRUD();
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
				->field_type('tr_no','invisible')
				->field_type('tr_code','invisible')
				->required_fields('tran_type_id','date','party_id');
				$crud->callback_before_insert(array($this,'get_tr'));
				$operation=$crud->getState();
				if($operation == 'edit' || $operation == 'update' || $operation == 'update_validation'):
				$crud->field_type('tran_type_id','readonly')
					->required_fields('date','party_id');

				endif;
				//$crud->callback_before_update(array($this,'get_trcode'));
			//$crud->callback_add_field('discount',array($this,'add_default_disc'));
			//$crud->callback_add_field('cashdisc',array($this,'add_default_cdisc'));
			//set relations:
			$crud->set_relation('tran_type_id','tran_type','{location}--{descrip_1}---{descrip_2}');
			$crud->set_relation('party_id','party','{name}--{city}');
			$output = $crud->render();
			$this->_example_output($output);                
*/
}
			
			
		public function edit()
		{
		echo "Summary";
		
		}	
			
		function get_tr($post_array)
		{
			$query=$this->db->select('tr_code');
			$query=$this->db->from('tran_type');
			$query=$this->db->where('id', $post_array['tran_type_id']);
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
			$query=$this->db->where('id', $post_array['tran_type_id']);
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
