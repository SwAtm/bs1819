<?php
class Trnf_Details extends CI_Controller{
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
		$this->load->model('Grocery_crud_model');
		$this->load->model('My_Trnf_Summary_model');
		$this->load->model('My_Trnf_Details_model');
		$this->load->model('Company_model');
		$this->load->library('html2pdf');
	}
	
	public function details($id=null)
	{
	
		$crud = new grocery_CRUD();
		if ($crud->getState()=='add'||$crud->getState()=='insert'):
			$sid=$this->uri->segment(4);
		endif;
		$crud->set_table('trnf_details')
				->set_subject('Item')
				->columns('id', 'summ_id', 'item_id','quantity')
				->display_as('id','ID')
				->display_as('summ_id','Summary ID')
				->display_as('item_id','Item')
				->unset_back_to_list()
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'required|numeric')
				->set_rules('item_id', 'Item', 'required');
				//->unset_add();
				//->edit_fields('summ_id','item_id','quantity')
				//->add_fields('item_id','quantity')
				if ($crud->getState()=='add'||$crud->getState()=='insert'):
					$crud->field_type('summ_id', 'hidden', $sid);
				else:
					$crud->field_type('summ_id','readonly');
				endif;
		$crud->order_by('id','desc');		
		$output = $crud->render();
		$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href = ".site_url('Trnf_Summary/summary').">Go to Transfer List</a> </td></tr></table>";
		/*echo "<pre>";
		print_r($output);
		echo "</pre>";*/
		
		$this->_example_output($output);           
	
	}
		public function id_details($sid=null)
		{
		$crud = new grocery_CRUD();
		$sid=$this->uri->segment(3);
		
		$crud->set_table('trnf_details')
				->set_subject('Item')
				->columns('id', 'summ_id', 'item_id','quantity')
				->display_as('id','ID')
				->display_as('summ_id','Summary ID')
				->display_as('item_id','Item')
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'numeric')
				->unset_print()
				->unset_add();
				//->edit_fields('summ_id','item_id','quantity')
				//->add_fields('item_id','quantity')
				$crud->field_type('summ_id','readonly');
				$crud->where('summ_id',$sid);
				$crud->order_by('id','desc');		
				$output = $crud->render();
				$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center colspan=3><a href = ".site_url('Trnf_Summary/summary').">Go to Transfer List</a> </td><td align=center colspan=2><a href = ".site_url('Trnf_Details/idprint/'.$sid).">Print</a> </td></tr></table>";
		/*echo "<pre>";
		print_r($output);
		echo "</pre>";*/
		
		$this->_example_output($output); 
		}
		
		
	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('trnf_details/list.php',$output);   
		$this->load->view('templates/footer');
		//echo "<table align=center><tr><td align=center><a href = ".site_url('Trnf_Summary/summary').">Go to Transfer List</a> </td></tr></table>";
	}    

	function idprint($id=null)
	{
	$sid=$this->uri->segment(3);
	$trnf_summary=$this->My_Trnf_Summary_model->trnf_summary($sid);
	$trnf_details=$this->My_Trnf_Details_model->trnf_details($sid);
	$data['trnf_summary']=$trnf_summary;
	$data['trnf_details']=$trnf_details;
	$company = $this->Company_model->getall();
	$data['company']=$company;
	$count=count($trnf_details);
	$folder=SAVEPATH;
	$filename="Trnf_".$sid;
	$this->html2pdf->folder($folder);
	if ($count<3):
		$this->html2pdf->filename($filename."_a5.pdf");
		$this->html2pdf->paper('a5', 'landscape');
	else:
		$this->html2pdf->filename($filename."_a4.pdf");
		$this->html2pdf->paper('a4', 'portrait');
	endif;
	$this->html2pdf->html($this->load->view('trnf_details/print', $data, true));
	$spath=$this->html2pdf->create('save');
	echo "File saved at as ".$spath."<br>";
	echo "<a href = ".site_url('Trnf_Summary/summary').">Go to Trnf Summary</a>";
	
	}


}
