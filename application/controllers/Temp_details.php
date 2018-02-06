<?php
class Temp_details extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->helper('security');
		//$this->load->library('grocery_CRUD');
		$this->load->model('Temp_details_model');
				$this->load->model('Item_model');
		$this->output->enable_profiler(TRUE);
}

	public function index()
	{
	if(!$list=$this->Temp_details_model->getall()):
		$this->load->view('templates/header');
		$data['message']='No details entered';
		$this->load->view('templates/message',$data);    
		$this->load->view('templates/footer');
		$this->output->_display();
		exit;
	else:
		foreach ($list as $k=>$v):
			//unset ($list[$k]['id']);
			unset ($list[$k]['summary_id']);
			$row=$this->Item_model->get_title($v['item_id']);
			//$list[$k]['item_id']=$row->title;
			$list[$k]['item_id']=$row->title."-".$row->rate;
			//unset ($list[$k]['item_id']);
		endforeach;
	
		$data['list']=$list;
		$data['header']=array('Bk_title','quantity','discount','cashdis');		
		//print_r($data);
		$this->load->view('templates/header');
		$this->load->view('temp_details/list_all',$data);
		//$this->load->view('templates/footer');
	endif;
	}
	
	public function add()
	{
		if(!$this->Item_model->getall()):
		$this->load->view('templates/header');
		$data['message']='No Items to display';
		$this->load->view('templates/message',$data);    
		$this->load->view('templates/footer');
		$this->output->_display();
		exit;
		endif;
		//set validation rules
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		//$this->form_validation->set_rules('discount', 'Discount', 'required');
		//$this->form_validation->set_rules('cashdisc', 'Cash Discount', 'required');
		if ($this->form_validation->run()==false):
			$det=$this->Item_model->getall();
			foreach ($det as $k):
				$item[$k['id']]=$k['title']."--".$k['rate'];
			endforeach;
			$data['item']=$item;
			$data['quantity']=1;
			$data['discount']=0;
			$data['cashdisc']=0;
		
			$this->load->view('templates/header');
			$this->load->view('temp_details/add',$data);
			//$this->load->view('templates/footer');
		elseif ($_POST['save']):
			unset ($_POST['save']);
			//print_r($_POST);
			if ($this->Temp_details_model->adddata($_POST)):
				redirect ('Temp_details/add','refresh');
			else:
				die ("Could not update.<a href=home>Go Home</a>");
			endif;
		elseif ($_POST['golist']):
			redirect ('Temp_details/index');
		endif;
	
	}

		public function edit($id=null)
		{
		
		if (!$id=$this->uri->segment(3)):
		$id=$_POST['id'];
		endif;
		print $id;
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		//$this->form_validation->set_rules('discount', 'Discount', 'required');
		//$this->form_validation->set_rules('cashdisc', 'Cash Discount', 'required');
		if ($this->form_validation->run()==false):
			//get temp_details row
			$row=$this->Temp_details_model->getrow($id);
			print_r($row);
			//get item name-rate from item model
			//$row=$this->Item_model->get_title($v['item_id']);
			//populate data make
			$det=$this->Item_model->getall();
			foreach ($det as $k):
				$item[$k['id']]=$k['title']."--".$k['rate'];
			endforeach;
			$data['item']=$item;
			$data['quantity']=$row->quantity;
			$data['discount']=$row->discount;
			$data['cashdisc']=$row->cashdisc;
			$data['id']=$id;
			$data['defa']=$row->item_id;
			$this->load->view('templates/header');
			$this->load->view('temp_details/edit',$data);
			//$this->load->view('templates/footer');
		elseif ($_POST['save']):
			unset ($_POST['save']);
			if ($this->Temp_details_model->update($_POST)):
				redirect ('Temp_details/index');
			else:
				die ("Could not update.<a href=home>Go Home</a>");
			endif;
		elseif ($_POST['golist']):
			redirect ('Temp_details/index');
		endif;
		}
		
		
		public function delete($id=null)
		{
		$id=$this->uri->segment(3);
		$this->Temp_details_model->delete_id($id);
		redirect ('Temp_details/index');
		}
		
		
		
		
/*	public function temp_details()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('temp_details')
		     ->set_subject('Item')
			 ->columns('item_id', 'quantity', 'discount', 'cashdisc')
			 ->display_as('item_id','Item')
			 ->display_as('quantity','Quantity')
			 ->display_as('discount','% Discount')
			->display_as('cashdisc','Cash Discount')
			->fields('item_id','quantity','discount','cashdisc')
			->required_fields('item_id','quantity','discount','cashdisc');
			$crud->callback_add_field('quantity',array($this,'add_default_qty'));
			$crud->callback_add_field('discount',array($this,'add_default_disc'));
			$crud->callback_add_field('cashdisc',array($this,'add_default_cdisc'));
			

			//set relations:
		$crud->set_relation('item_id','item','{title}--{code}--{rate}');
		$output = $crud->render();
		$state = $crud->getState();
        if ($state=='list'||$state=='success'): 
			$output->extra = "<a href=".site_url('My_Summary/add').">Complete Transaction</a>";
        else:
			$output->extra = '';	
        endif;
		
		
		$this->_example_output($output);                

	}
	
		public function add_default_qty()
		{
		return '<input type="text" maxlength="50" value="1" name="quantity" >';
		
		}
		
		public function add_default_disc()
		{
		return '<input type="text" maxlength="50" value="0" name="discount" >';
		
		}
	
		public function add_default_cdisc()
		{
		return '<input type="text" maxlength="50" value="0" name="cashdisc" >';
		
		}
		function _example_output($output = null)
		{
		$this->load->view('templates/header');
		$this->load->view('trans_template.php',$output);    
		$this->load->view('templates/footer');
		}    
*/
}
