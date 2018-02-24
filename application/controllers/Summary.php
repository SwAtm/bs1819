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
}



		public function summary()
	{
			$crud = new grocery_CRUD();
			$crud->set_table('summary')
				->set_subject('Summary')
				->order_by('id','desc')
				//->columns('tran_type_id','tr_code','tr_no','date', 'party_id', 'expenses', 'remark')
				->columns('id','tran_type_id','tr_code','tr_no','date', 'party_id', 'amount', 'remark')
				->display_as('tran_type_id','Transaction Type')
				->display_as('tr_code','Transaction Code')
				->display_as('tr_no','Transaction Number')
				->display_as('date','Date')
				->display_as('party_id','Party')
				//->display_as('expenses','Exenses')
				->display_as('amount','Amount')
				->display_as('remark','Remark')
				->fields('tran_type_id','tr_code','tr_no','date','party_id','expenses','remark')
				->unset_add()
				//->callback_before_edit(array($this,'checkedit'))
				->unset_edit()
				->set_theme('datatables')
				->unset_delete()
				->add_action('Edit Summary',base_url('application/pencil.png'), 'My_Summary/edit')
				//->add_action('Delete Summary',base_url('application/delete.jpeg'), 'My_Summary/delete')
				->add_action('Edit Details',base_url('application/pencil.png'),'Details/index')
				->add_action('Print',base_url('application/print.png'),'My_Summary/printbill')
				->add_action('Show Details',base_url('application/print.png'),'Details/show');
				$operation=$crud->getState();
				if($operation == 'edit' || $operation == 'update' || $operation == 'update_validation'):
				$crud->field_type('tran_type_id','readonly')
					->field_type('tr_no','readonly')
					->field_type('tr_code','readonly')
					->required_fields('date','party_id');

				endif;
		
			$crud->set_relation('tran_type_id','tran_type','{location}--{descrip_1}---{descrip_2}');
			$crud->set_relation('party_id','party','{name}--{city}');
			$crud->callback_column('amount',array($this,'_callback_amount'));
			$crud->callback_column('date',array($this,'_callback_date'));
			$output = $crud->render();
			$this->_example_output($output);                

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
*/			
		
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
		$this->load->view('our_template.php',$output);    
		$this->load->view('templates/footer');
	}    




}
?>
