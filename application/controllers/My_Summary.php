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
		$this->load->model('Details_model');
		$this->output->enable_profiler(TRUE);
}

	
	public function add()
	{

	//set validation rules
	$this->form_validation->set_rules('tran_type_id', 'Tran Type ID', 'required');
	$this->form_validation->set_rules('party_id', 'Party ID', 'required');
	$this->form_validation->set_rules('date', 'Date', 'required');
	
	if (isset($_POST['cancel'])):
		$this->Temp_details_model->delete();
		redirect ('home','refresh');
	endif;	
	//new or failed
	if ($this->form_validation->run()==false):
		if(!$this->Temp_details_model->getall()):
		$this->load->view('templates/header');
		$data['message']='No details entered';
		$this->load->view('templates/message',$data);    
		$this->load->view('templates/footer');
		$this->output->_display();
		exit;
		endif;
	
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
		//print_r($trcode);
		$_POST['tr_code']=$trcode->tr_code;
		$trno=$this->Summary_model->gettranno($_POST['tr_code']);
		$_POST['tr_no']=$trno;
		$descr=$trcode->descrip_1;
		//for cash date should be today
		if ((strtoupper($descr)=="CASH")):
			$_POST['date']=date('Y-m-d');
		else:
			$_POST['date']=date('Y-m-d',strtotime($_POST['date']));
		endif;
		//for cash/bank party should be walk in 
		if ((strtoupper($descr)=="CASH")||(strtoupper($descr)=="BANK")):
		$_POST['party_id']=1048;
		endif;
		//print_r($_POST);
		//echo "Post<br>";
		if ($this->Summary_model->adddata($_POST)):
			$summary_id=$this->Summary_model->getmaxid();
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
				$det['summary_id']=$summary_id;
				endforeach;
				unset ($det['id']);
				$this->Details_model->adddata($det);
				//print_r($det);
				//echo "det<br>";
			endforeach;
			$this->Temp_details_model->delete();
			echo "Record added.<a href=".site_url('home').">Go Home</a>";
		else:
			echo "Record not added.<a href=".site_url('home').">Go Home</a>";
		
		endif;	
	endif;



}
	
	
	public function edit($id=null)
	{
	$this->form_validation->set_rules('tran_type_id', 'Tran Type ID', 'required');
	$this->form_validation->set_rules('party_id', 'Party ID', 'required');
	$this->form_validation->set_rules('date', 'Date', 'required');
	if ($this->form_validation->run()==false):
		$id=$this->uri->segment(3);
		$trantype=$this->Summary_model->getdescr($id);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
		if ($trantype->remark=='Cancelled'):
				echo "Bill is already cancelled <a href=".site_url('Summary/summary').">Go to list</a>";
		elseif (ucfirst($descr)=="Cash" and $date!=date("Y-m-d")):
			echo "Cannot edit earlier cash transactions <a href=".site_url('Summary/summary').">Go to list</a>";
		else:
			$party=$this->Party_model->getall();
			foreach ($party as $p):
				$party1[$p['id']]=$p['name']." ".$p['city'];
			endforeach;
			unset ($party);
			$data['party']=$party1;
			$data['trantype']=$trantype;
			$this->load->view('templates/header');
			$this->load->view('summary/edit_summary',$data);    
			$this->load->view('templates/footer');
		endif;
	else:
		unset($_POST['submit']);
		$data=$_POST;
		$data['date']=date('Y-m-d',strtotime($data['date']));
		$this->Summary_model->update($data);
		echo "Data updated<br><a href=".site_url('Summary/summary').">Go to list</a>";
	endif;
	}		
			
	public function delete($id=null)
	{
			
	$id=$this->uri->segment(3);
	$trantype=$this->Summary_model->getdescr($id);
	$descr=$trantype->descrip_1;
	$date=$trantype->date;
	
	if ($trantype->remark=='Cancelled'):
				echo "Bill is already cancelled <a href=".site_url('Summary/summary').">Go to list</a>";
	elseif (ucfirst($descr)=="Cash" and $date!=date("Y-m-d")):
		echo "Cannot delete earlier cash transactions <a href=".site_url('Summary/summary').">Go to list</a>";
	else:
		//print_r($trantype);
		if ($this->Details_model->deletedet($id) and $this->Summary_model->cancel($id)):
			
				echo "Deleted <a href=".site_url('Summary/summary').">Go to list</a>";
		else:
				echo "Could not delete	<a href=".('Summary/summary').">Go to list</a>";
	
		endif;
	
	endif;
	
		}	
		public function printbill($id)
		{
		$id=$this->uri->segment(3);
		$toprint1=$this->Summary_model->toprint1($id);
		$toprint2=$this->Summary_model->toprint2($id);
		$toprint3=$this->Summary_model->getdescr($id);
		
		$data['toprint1']=$toprint1;
		$data['toprint2']=$toprint2;
		$data['toprint3']=$toprint3;
		$this->load->view('summary/printbill',$data);
		}
			
}
