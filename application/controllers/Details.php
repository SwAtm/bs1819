<?php
class Details extends CI_Controller{
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
		$this->load->model('Details_model');
		$this->load->model('Item_model');
		$this->output->enable_profiler(TRUE);
}

		public function index($id)
	{
	if($this->Temp_details_model->getall()):
		echo "You have incomplete bill. Pl complete it and come back. <a href=".site_url('Summary/summary').">Go to list</a>";
	else:
		$id=$this->uri->segment(3);
		//check whether editable
		$trantype=$this->Summary_model->getdescr($id);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
		if ($trantype->remark=='Cancelled'):
				echo "Bill is already cancelled <a href=".site_url('Summary/summary').">Go to list</a>";
		elseif ((ucfirst($descr)=="Cash" and $date!=date("Y-m-d")) OR (ucfirst($descr)!=="Cash" and Date("m",strtotime($date))!=Date("m"))):
			echo "Beyond Date scope. Cash - only today, Others - Only curent month <a href=".site_url('Summary/summary').">Go to list</a>";
		else:
			$det=$this->Details_model->getdetails($id);
			foreach ($det as $row):
				$this->Temp_details_model->adddata($row);
			endforeach;
		//set session summary_id
		$this->session->set_userdata('sid',$id);
		
			$list=$this->Temp_details_model->getall();
		$this->listall($list);
		endif;
			
	endif;

	}
	
	
	public function listall($list)
		{
		//print_r($list);
		//echo count($list);
		$sid=$this->session->userdata('sid');
		if (!empty($list)):
			foreach ($list as $k=>$v):
			//unset ($list[$k]['id']);
			unset ($list[$k]['summary_id']);
			$row=$this->Item_model->get_title($v['item_id']);
			//$list[$k]['item_id']=$row->title;
			$list[$k]['item_id']=$row->title."-".$row->rate;
			//unset ($list[$k]['item_id']);
			endforeach;
			$trantype=$this->Summary_model->getdescr($sid);
			$data['trantype']=$trantype;
			$data['list']=$list;
			$data['header']=array('Bk_title','quantity','discount','cashdis');		
			//print_r($data);
			$this->load->view('templates/header');
			$this->load->view('details/listall',$data);
			//$this->load->view('templates/footer');
		else:
			
			if ($this->Details_model->deletedet($sid) and $this->Summary_model->cancel($sid)):
			
				echo "No details, Bill Deleted <a href=".site_url('Summary/summary').">Go to list</a>";
			else:
				echo "Could not delete	<a href=".('Summary/summary').">Go to list</a>";
	
			endif;
			
		endif;
		}

	public function edit($id=null)
	{
	$id=$this->uri->segment(3);
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
			$this->load->view('details/edit',$data);
			//$this->load->view('templates/footer');
		elseif ($_POST['save']):
			unset ($_POST['save']);
			if ($this->Temp_details_model->update($_POST)):
				$list=$this->Temp_details_model->getall();
				$this->listall($list);
			else:
				die ("Could not update.<a href=home>Go Home</a>");
			endif;
		endif;
	   
	
	}
	
	
	public function delete($id=null)
		{
		$id=$this->uri->segment(3);
		$this->Temp_details_model->delete_id($id);
		$list=$this->Temp_details_model->getall();
		$this->listall($list);
		}
	
	public function add()
	{
	//set validation rules
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		//$this->form_validation->set_rules('discount', 'Discount', 'required');
		//$this->form_validation->set_rules('cashdisc', 'Cash Discount', 'required');
		if ($this->form_validation->run()==false):
			$det=$this->Item_model->getall();
			$item['_dummy']="Select Item";
			foreach ($det as $k):
				$item[$k['id']]=$k['title']."--".$k['rate'];
			endforeach;
			$data['item']=$item;
			$data['quantity']=1;
			$data['discount']=0;
			$data['cashdisc']=0;
		
			$this->load->view('templates/header');
			$this->load->view('details/add',$data);
			//$this->load->view('templates/footer');
		elseif ($_POST['save']):
			unset ($_POST['save']);
			//print_r($_POST);
			if ($_POST['item_id']=="_dummy"):
				unset ($_POST['item_id']);
			else:
			$this->Temp_details_model->adddata($_POST);
			endif;
				$list=$this->Temp_details_model->getall();
				$this->listall($list);
			
		endif;
	
	}
	
	public function complete()
	{
		$sid=$this->session->userdata('sid');
		$this->Details_model->deletedet($sid);
		$details=$this->Temp_details_model->getall();
			//print_r($details);
			//echo "Details<br>";
			//print $summary_id;
			//echo "summary_id<br>";
		foreach ($details as $row):
				//print_r($row);
				//echo "row<br>";
			foreach ($row as $k=>$v):
				$det[$k]=$v;
				$det['summary_id']=$sid;
			endforeach;
			unset ($det['id']);
			$this->Details_model->adddata($det);
				//print_r($det);
				//echo "det<br>";
		endforeach;
		$this->session->unset_userdata('sid');
		$this->Temp_details_model->delete();
		echo "Record added.<a href=".site_url('Summary/summary').">Go to List</a><br>";
	}
/*	public function detlist()
	{
	$list=$this->Temp_details_model->getall();
	$id=$list[0]['summary_id'];
	print_r($list);	
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
			$data['sid']=$id;
			print_r($data);
			$this->load->view('templates/header');
			$this->load->view('details/editdet_list',$data);
			$this->load->view('templates/footer');
	
	
	
	}
	public function update($id=null)
	{
	$id=$this->uri->segment(3);
	print_r($id);
	echo "<br>edit update <a href=".site_url('Summary/summary').">Go to list</a><br>";
	print_r($_POST);
	}

*/
	public function show($id=null)
	{
	$id=$this->uri->segment(3);
	$data['summarydet']=$this->Summary_model->getdescr($id);
	$data['det_item']=$this->Details_model->det_item($id);
	$this->load->view('templates/header');
	$this->load->view('details/show',$data);
	//$this->load->view('templates/footer');
	}







}
