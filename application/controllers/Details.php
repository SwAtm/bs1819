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
		$this->load->library('grocery_CRUD');
		$this->load->model('Tran_type_model');
		$this->load->model('Party_model');
		$this->load->model('Summary_model');
		//$this->load->model('Temp_details_model');
		$this->load->model('Details_model');
		$this->load->model('Item_model');
		$this->load->model('Company_model');
		$this->load->library('html2pdf');
		$this->output->enable_profiler(TRUE);
}

	public function details($id)
	{
		//used to add details
			$id=$this->uri->segment(4);
			$crud = new grocery_CRUD();
			$crud->set_table('details')
				->set_subject('Detail')
				->display_as('item_id','Item')
				->display_as('quantity','Quantiti')
				->display_as('discount','Discount %')
				->display_as('cashdisc','Discount Cash')
				->unset_back_to_list()
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'required|numeric')
				->set_rules('item_id', 'Item', 'required')
				->fields('summary_id', 'item_id','quantity', 'discount', 'cashdisc' )
				->field_type('summary_id','hidden', $id)
				->order_by('id','desc');		
			$output = $crud->render();
			$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href = ".site_url('Summary/summary').">Go to Transaction List ".$id."</a> </td></tr></table>";
			$this->_example_output($output);   
		}
	
	function id_details($id=null)
	{
		//to edit details
		$crud = new grocery_CRUD();
		$id=$this->uri->segment(3);
	
	
		$crud->set_table('details')
				->set_subject('Detail')
				->columns('item_id','quantity', 'discount', 'cashdisc')
				->display_as('id','ID')
				->display_as('summary_id','Bill No')
				->display_as('item_id','Item')
				->display_as('quantity','Quantity')
				->display_as('discount','% Discount')
				->display_as('cashdisc','Cash Discount')
				->set_relation('item_id','item','{title}--{rate}')
				->set_relation('summary_id','summary','{tr_code}--{tr_no}')
				->set_rules('quantity', 'Quantity', 'numeric')
				->unset_print()
				->unset_add()
				->field_type('summary_id','readonly')
				->where('summary_id',$id)
				->order_by('id','desc');		
				$output = $crud->render();
				$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href = ".site_url('Summary/summary').">Go to Transaction List</a> </td></tr></table>";
				$this->_example_output($output); 
		}

	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('trans_template.php',$output);    
		$this->load->view('templates/footer');
	}    

	public function printbill($id)
		{
		$id=$this->uri->segment(3);
		print_r($id);
		$trantype=$this->Summary_model->getdescr($id);

		//What is allowed to be printed
		if ($trantype->remark=='Cancelled'):
				Die("Bill is already cancelled <a href=".site_url('Summary/summary').">Go to list</a>");
		endif;
		
		//Allowed to be printed
		$toprint1=$this->Summary_model->toprint1($id);
		$toprint2=$this->Summary_model->toprint2($id);
		
		//replace grate with 0 if purchase or purchase return and party is unregd
		if (($toprint1->descrip_2=="Purchase" OR $toprint1->descrip_2=="Purchase Return") AND $toprint1->p_status!=="REGD"):
		foreach ($toprint2 as $k=>$p):
			$toprint2[$k]['grate']=0;
		endforeach;
		endif;
		
		//work out transaction value and gst
		
		foreach ($toprint2 as $k=>$p):
			$val=($p['rate']-$p['cashdisc'])*$p['quantity']-(($p['rate']-$p['cashdisc'])*$p['quantity']*($p['discount']/100));
			if ($toprint1->st=='I'):
				$toprint2[$k]['cgrate']=$toprint2[$k]['sgrate']=$p['grate']/2;
				$toprint2[$k]['igrate']=0;
				$toprint2[$k]['cgst']=$toprint2[$k]['sgst']=round($val/(100+$p['grate'])*$p['grate']/2,2);
				$toprint2[$k]['igst']=0;
			else:
				$toprint2[$k]['cgrate']=$toprint2[$k]['sgrate']=0;
				$toprint2[$k]['igrate']=$p['grate'];
				$toprint2[$k]['igst']=round($val/(100+$p['grate'])*$p['grate'],2);
				$toprint2[$k]['cgst']=0;
				$toprint2[$k]['sgst']=0;
			endif;
			$toprint2[$k]['tr_val']=round($val-$toprint2[$k]['cgst']-$toprint2[$k]['sgst']-$toprint2[$k]['igst'],2);
			$toprint2[$k]['val']=$val;
			
		endforeach;
		
		
		
		//totals
		$cgst_total=array_sum(array_column($toprint2,'cgst'));
		$sgst_total=array_sum(array_column($toprint2,'sgst'));
		$igst_total=array_sum(array_column($toprint2,'igst'));
		$tr_val_total=array_sum(array_column($toprint2,'tr_val'));
		$val_total=array_sum(array_column($toprint2,'val'));
		$amountb=$amountr=0;
		foreach ($toprint2 as $k=>$p):
			if ($p['cat_id']==1):
				$amountb+=$p['tr_val'];
				
			else:
				$amountr+=$p['tr_val'];
			endif;
		endforeach;
		
		//workout grand total
		$gt=0;
		foreach ($toprint2 as $some):
			$gt+=$some['val'];
		endforeach;
		$gt=$gt+$toprint1->expenses;
		
		
		//put everything in data
		$data['toprint1']=$toprint1;
		$data['toprint2']=$toprint2;
		$data['gt']=$gt;
		$data['sgst_total']=$sgst_total;
		$data['cgst_total']=$cgst_total;
		$data['igst_total']=$igst_total;
		$data['amountb']=$amountb;
		$data['amountr']=$amountr;
		$data['tr_val_total']=$tr_val_total;
		$data['val_total']=$val_total;
		$count=count($toprint2);	
		//get the company info
		$company = $this->Company_model->getall();
		$data['company']=$company;
		
		//pdf
		$folder=SAVEPATH;
		$filename=$toprint1->tr_code."-".$toprint1->tr_no;
		$this->html2pdf->folder($folder);
		echo $folder;
		if ($count<3):
			$this->html2pdf->filename($filename."_a5.pdf");
			$this->html2pdf->paper('a5', 'landscape');
		else:
			$this->html2pdf->filename($filename."_a4.pdf");
			$this->html2pdf->paper('a4', 'portrait');
		endif;
		//$this->load->view('templates/header');
		$this->html2pdf->html($this->load->view('details/printbill', $data, true));
		$spath=$this->html2pdf->create('save');
		//$this->load->view('summary/printbill',$data);
		echo "File saved at as ".$spath;
		//$data['filename']=$filename;
		//$data['folder']=$folder;
		//echo $folder;
		$data['spath']=$spath;
		$this->load->view('details/printbill_1',$data);
		}


/*
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
	
	*/
	
	/*
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

	*/
	/*
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
	
	*/
	
	/*
	public function delete($id=null)
		{
		$id=$this->uri->segment(3);
		$this->Temp_details_model->delete_id($id);
		$list=$this->Temp_details_model->getall();
		$this->listall($list);
		}
	
	*/
	
/*	public function add()
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
	
	}*/
	
	
	/*
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
	
	*/
	
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
/*	
	public function show($id=null)
	{
	$id=$this->uri->segment(3);
	$data['summarydet']=$this->Summary_model->getdescr($id);
	$data['det_item']=$this->Details_model->det_item($id);
	$this->load->view('templates/header');
	$this->load->view('details/show',$data);
	//$this->load->view('templates/footer');
	}
*/


/*
		function details1($id){	
		$crud = new grocery_CRUD();
		$crud->set_table('details')
				->set_subject('whatever')
				->columns('summary_id', 'item_id','quantity', 'discount', 'cashdisc' )
				->display_as('summary_id','Bill No')
				->display_as('item_id','Item')
				->display_as('quantity','Quantiti')
				->display_as('discount','Discount %')
				->display_as('cashdisc','Discount Cash')
				->unset_back_to_list()
				->set_relation('summary_id','summary','{tr_code}--{tr_no}')
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'required|numeric')
				->set_rules('item_id', 'Item', 'required')
				//->unset_add();
				//->edit_fields('summ_id','item_id','quantity')
				//->add_fields('item_id','quantity')
				->fields('summary_id', 'item_id','quantity', 'discount', 'cashdisc' );
				$crud->field_type('summary_id','hidden', $id);
				
		$crud->order_by('id','desc');		
		$output = $crud->render();
		$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href = ".site_url('Summary/summary').">Go to Transaction List</a> </td></tr></table>";
		/*echo "<pre>";
		print_r($output);
		echo "</pre>";*/
		
		//$this->_example_output($output);   
		
		/*	
			$det=$this->Details_model->getdetails($id);
			foreach ($det as $row):
				$this->Temp_details_model->adddata($row);
			endforeach;
		//set session summary_id
		$this->session->set_userdata('sid',$id);
		
			$list=$this->Temp_details_model->getall();
		$this->listall($list);
		endif;
			
	

	}*/


}
