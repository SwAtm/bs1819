<?php
class Summary extends CI_Controller{
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
		$this->load->model('Tran_type_model');
		$this->load->model('Party_model');
		$this->load->model('Summary_model');
		$this->load->model('Temp_details_model');
		$this->output->enable_profiler(TRUE);
		$this->load->library('user_agent');

}



		public function summary()
	{
			$crud = new grocery_CRUD();
			$crud->set_table('summary')
				->set_subject('Transaction')
				->order_by('id','desc')
				->columns('id','tran_type_id','tr_code','tr_no','date', 'party_id', 'amount', 'remark')
				->display_as('tran_type_id','Transaction Type')
				->display_as('tr_code','Transaction Code')
				->display_as('tr_no','Transaction Number')
				->display_as('date','Date')
				->display_as('party_id','Party')
				->display_as('amount','Amount')
				->display_as('remark','Remark')
				->unset_delete()
				->unset_edit()
				->unset_print()
				->set_relation('tran_type_id','tran_type','{location}--{descrip_1}---{descrip_2}')
				->set_relation('party_id','party','{name}--{city}')
				->callback_column('amount',array($this,'_callback_amount'))
				->callback_column('date',array($this,'_callback_date'))						
				->add_fields('tran_type_id', 'tr_code', 'tr_no', 'date','party_id','expenses','remark', 'p_status')
				//->callback_add_field('date',array($this,'_add_default_date_value'))	
				->field_type('tr_code','invisible')
				->field_type('tr_no','invisible')
				->field_type('p_status','invisible')
				->field_type('date','invisible')
				->callback_before_insert(array($this,'get_trcode_etc'))
				->add_action('Edit Summary',base_url('application/edit_summary.png'),'', '', array($this,'check_editable'))
				->add_action('Add Details',base_url('application/add_details.png'),'', '', array($this,'check_addable'))
				->add_action('Edit Details',base_url('application/edit_details.png'),'', '', array($this,'check_det_editable'))
				->add_action('Print',base_url('application/print.png'),'Details/printbill');
				$output = $crud->render();
				$output->extra='';
				$this->_example_output($output);                

	}
	
		public function summary1()
	{
		//for editing
			$crud = new grocery_CRUD();
			$crud->set_table('summary')
				->set_subject('Transaction')
				->display_as('tran_type_id','Transaction Type')
				->display_as('tr_code','Transaction Code')
				->display_as('tr_no','Transaction Number')
				->display_as('date','Date')
				->display_as('party_id','Party')
				->display_as('amount','Amount')
				->display_as('remark','Remark')
				->change_field_type('tr_code','readonly')
				->field_type('tr_no','readonly')
				->field_type('p_status','invisible')
				->field_type('tran_type_id','readonly')
				->field_type('date','readonly')
				->unset_back_to_list()
				->unset_delete()
				->set_relation('tran_type_id','tran_type','{location}--{descrip_1}---{descrip_2}')
				->set_relation('party_id','party','{name}--{city}')
				->callback_edit_field('date',array($this,'_callback_date'))						
				->edit_fields('tran_type_id', 'tr_code', 'tr_no', 'date','party_id','expenses','remark', 'p_status');
				$output = $crud->render();
				$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href=".site_url('Summary/summary').">Go to List</a></td></tr></table>";
				$this->_example_output($output);    
			}

		public function _callback_amount($id, $row)
		{
		$sql=$this->db->select('SUM(quantity*(rate-cashdisc)-((quantity*(rate-cashdisc)))*discount/100) AS amount',false);
		$sql=$this->db->from ('details');
		$sql=$this->db->join('item', 'item.id=details.item_id');
		$sql=$this->db->where('details.summary_id',$row->id);
		//$sql=$this->db->group_by('details.summary_id');
		$res=$this->db->get();
		$amount=$res->row()->amount;
		$amount=$amount+$row->expenses;
		return number_format($amount,2,'.','');
		}
		
		
		public function _callback_date($id, $row)
		{
		return date('d/m/Y', strtotime($id));
		}
		
		
		function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('trans_template.php',$output);    
		$this->load->view('templates/footer');
	}    


	function get_trcode_etc($post){
	
	//party status may change over time. Need to get the present status and add it to summary row.
		$party=$this->Party_model->getdetails($post['party_id']);
		if (!$party->status or null==$party->status):
			$party->status='UNRD';
		endif;
		$post['p_status']=$party->status;
		
		//get tr_code for this tr_type_id
		$tid=$post['tran_type_id'];
		$trcode=$this->Tran_type_model->gettrcode($tid);
		$post['tr_code']=$trcode->tr_code;
		
		//get tr_no for this tr_code
		$trno=$this->Summary_model->gettranno($post['tr_code']);
		$post['tr_no']=$trno;
		
		//add today's date
		$post['date']=date("Y-m-d");
		
		return $post;
	
	}
		
		function check_editable($pk, $row){
		//check whether a transaction is editable
		$editable=1;
		if ($row->remark=='Cancelled'):
		$editable=0;
		endif;
		$trantype=$this->Summary_model->getdescr($pk);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
		if ((ucfirst($descr)=="Cash" and $date!=date("Y-m-d")) OR (ucfirst($descr)!=="Cash" and Date("m",strtotime($date))!=Date("m"))):
		$editable=0;
		endif;
		if ($editable):
		return site_url('Summary/summary1/edit/'.$pk);
		else:
		return 'javascript:void()';
		endif;
		}
		
		
		function check_addable($pk, $row){
		//check whether details can be added to a transaction
		$addable=1;
		if ($row->remark=='Cancelled'):
		$addable=0;
		endif;
		$trantype=$this->Summary_model->getdescr($pk);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
		if ((ucfirst($descr)=="Cash" and $date!=date("Y-m-d")) OR (ucfirst($descr)!=="Cash" and Date("m",strtotime($date))!=Date("m"))):
		$addable=0;
		endif;
		if ($addable):
		return site_url('Details/details/add/'.$pk);
		else:
		return 'javascript:void()';
		endif;
		}


		function check_det_editable($pk, $row){
		//check whether details can be edited
		$det_edtable=1;
		if ($row->remark=='Cancelled'):
		$det_edtable=0;
		endif;
		$trantype=$this->Summary_model->getdescr($pk);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
		if ((ucfirst($descr)=="Cash" and $date!=date("Y-m-d")) OR (ucfirst($descr)!=="Cash" and Date("m",strtotime($date))!=Date("m"))):
		$det_edtable=0;
		endif;
		if ($det_edtable):
		return site_url('Details/id_details/'.$pk);
		else:
		return 'javascript:void()';
		endif;
		}
		
		

	/*	public function checkedit($id)
		{
		$sql=$this->db->select('tran_type.descrip1');
		$sql=$this->db->from('tran_type');
		$sql=$this->db->join('summary', 'summary.tr_code=tran_type.tr_code');
		$sql=$this->db->where('sumamry.id',$id);
		$res=$this->db->get();
		$trtype=$res->row()->descrip1;
		$sql=$this->db->select('summary.date');
		$sql=$this->db->from('summary');
		$sql=$this->db->where('sumamry.id',$id);
		$res=$this->db->get();
		$dt=$res->row()->date;
	if ($trantype=='cash' AND $data!=date()):
		return false;
	else:
		return true;
	endif;
		}

	function _add_default_date_value(){
        $value = !empty($value) ? $value : date("d/m/Y");
        $return = '<input type="text" name="date" value="'.$value.'">';
        $return .= "(dd/mm/yyyy)";
        return $return;
	}



*/			

}
?>
