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
		$this->load->model('temp_bill_model');
		$this->load->model('temp_billwise_model');
		$this->load->model('Company_model');
		$this->output->enable_profiler(TRUE);
		//$this->load->helper('pdf_helper');
		$this->load->library('html2pdf');
}

	
	public function add()
	{

	//set validation rules
	$this->form_validation->set_rules('tran_type_id', 'Tran Type ID', 'required');
	$this->form_validation->set_rules('party_id', 'Party ID', 'required');
	//date will be always today
	//$this->form_validation->set_rules('date', 'Date', 'required');
	
	if (isset($_POST['cancel'])):
		$this->Temp_details_model->delete();
		redirect ('home','refresh');
	endif;	
	//unsubmitted or failed
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
		//$this->load->view('templates/footer');
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
		//date should be today
		//if ((strtoupper($descr)=="CASH")):
			$_POST['date']=date('Y-m-d');
		//else:
			//$_POST['date']=date('Y-m-d',strtotime($_POST['date']));
		//endif;
		
		//for cash/bank party should be walk in 
		if ((strtoupper($descr)=="CASH")||(strtoupper($descr)=="BANK")):
		$_POST['party_id']=1048;
		endif;
		
		//party status may change over time. Need to get the present status and add it to summary row.
		$party=$this->Party_model->getdetails($_POST['party_id']);
		print_r($party);
		if (!$party->status or null==$party->status):
			$party->status='UNRD';
		endif;
		$_POST['p_status']=$party->status;
		//print_r($_POST);
		//echo "Post<br>";
		$this->db->trans_start();
		$this->Summary_model->adddata($_POST);
		$summary_id=$this->Summary_model->getmaxid();
		$details=$this->Temp_details_model->getall();
		foreach ($details as $row):
			foreach ($row as $k=>$v):
				$det[$k]=$v;
				$det['summary_id']=$summary_id;
			endforeach;
				unset ($det['id']);
				$this->Details_model->adddata($det);
		endforeach;
		$this->Temp_details_model->delete();
		$this->db->trans_complete();
		if ($this->db->trans_status()===false):
			echo "Record not added.<a href=".site_url('home').">Go Home</a>";
		else:
			redirect (site_url('My_Summary/printbill/'.$summary_id));
				
		endif;
		
	endif;



}
	
	
	public function edit($id=null)
	{
	$this->form_validation->set_rules('tran_type_id', 'Tran Type ID', 'required');
	$this->form_validation->set_rules('party_id', 'Party ID', 'required');
	$this->form_validation->set_rules('date', 'Date', 'required|callback__chkdt', array('callback__chkdt'=>'Invalid month'));
	$this->form_validation->set_message('_chkdt','submitted month is');

	if ($this->form_validation->run()==false):
		$id=$this->uri->segment(3);
		$trantype=$this->Summary_model->getdescr($id);
		$descr=$trantype->descrip_1;
		$date=$trantype->date;
			
		//What is allowed to be edited
		if ($trantype->remark=='Cancelled'):
				echo "Bill is already cancelled <a href=".site_url('Summary/summary').">Go to list</a>";
		elseif ((ucfirst($descr)=="Cash" and $date!=date("Y-m-d")) OR (ucfirst($descr)!=="Cash" and Date("m",strtotime($date))!=Date("m"))):
			echo "Beyond Date scope. Cash - only today, Others - Only curent month <a href=".site_url('Summary/summary').">Go to list</a>";
		else:
			$party=$this->Party_model->getall();
			foreach ($party as $p):
				$party1[$p['id']]=$p['name']." ".$p['city'];
			endforeach;
			unset ($party);
			//$party=$this->Party_model->getdetails($trantype->party_id);
			//$data['party']=$party->id."-".$party->name;
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
		$this->html2pdf->html($this->load->view('summary/printbill', $data, true));
		$spath=$this->html2pdf->create('save');
		//$this->load->view('summary/printbill',$data);
		echo "File saved at as ".$spath;
		//$data['filename']=$filename;
		//$data['folder']=$folder;
		//echo $folder;
		$data['spath']=$spath;
		$this->load->view('summary/printbill_1',$data);
		}
		
		public function _chkdt($ckdt)
		//called by edit
		{
			$subm_date=strtotime($ckdt);
			$sub_m=Date("m",$subm_date);
			$tod_m=Date("m");
			$sub_d=Date("d",$subm_date);
			$tod_d=Date("d");
			if (($sub_m==$tod_m) and ($sub_d<=$tod_d)):
			return true;
			else:
			$this->form_validation->set_message('_chkdt','submitted month is not current month or date is later than today');
			return false;
			endif;
		}
				
			
			
		public function reports()
		{
		//set validation rules
		$this->form_validation->set_rules('sdate', 'Starting_Date', 'required');
		$this->form_validation->set_rules('edate', 'Ending_Date', 'required');
		//first run/failed
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('summary/reports');
		//submitted and valid
		else:
			//chck if starting date is earlier than ending date
			$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$sdate=strtotime($sdate);
			$edate=strtotime($edate);
			if ($sdate>$edate):
				echo "Starting date cannot be earlier than ending date<br>";
				echo "<a href=".site_url('My_Summary/reports').">Go back</a>";
			else:
			//all well.
			$sdate=Date("Y-m-d",$sdate);
			$edate=Date("Y-m-d",$edate);
				
				//get all details from various tables
				if ($report=$this->Summary_model->reports($sdate,$edate)):
							//create an array with calculated fields. While creating filter cash/other
							foreach ($report as $rep=>$val):
								if (($this->input->post('cs_ot')=="Cash") and ($val['descrip_1']!=="Cash")):
									continue;
								elseif (($this->input->post('cs_ot')=="Other") and ($val['descrip_1']=="Cash")):
									continue;
								endif;
									
									$bill_c[$rep]['tr_code']=$val['tr_code'];
									$bill_c[$rep]['tr_no']=$val['tr_no'];
									$bill_c[$rep]['date']=$val['date'];
									if ($val['descrip_1']=="Cash"):
										$bill_c[$rep]['code']=" ";
										$bill_c[$rep]['name']=" ";
									else:
										$bill_c[$rep]['code']=$val['code'];
										$bill_c[$rep]['name']=$val['name'];
									endif;
									$bill_c[$rep]['expenses']=$val['expenses'];
									$bill_c[$rep]['city']=$val['city'];
									//if purchse/purchase return is from not registered party, gst should be 0
									if(($val['descrip_2']=="Purchase" or $val['descrip_2']=='Purchase Return') and $val['p_status']!=="REGD"):
										$val['grate']=0;
									endif;
									
									
									$amount_disc=($val['rate']-$val['cashdisc'])*$val['quantity']-(($val['rate']-$val['cashdisc'])*$val['quantity']*($val['discount']/100));
									
									$gst=round($amount_disc/(100+$val['grate'])*$val['grate'],2);
									//$gst=$amount_disc-$amount_net;
									if ($val['st']!=="I"):
									$bill_c[$rep]['igst']=$gst;
									$bill_c[$rep]['cgst']=0;
									$bill_c[$rep]['sgst']=0;
									else:
									$bill_c[$rep]['igst']=0;
									$bill_c[$rep]['cgst']=round($gst/2,2);
									$bill_c[$rep]['sgst']=round($gst/2,2);
									endif;
									
									//$amount_net=$amount_disc/(100+$val['grate'])*100;
									$amount_net=$amount_disc-$bill_c[$rep]['igst']-$bill_c[$rep]['cgst']-$bill_c[$rep]['sgst'];
									if($val['cat_id']==1):
									$bill_c[$rep]['amount_b']=$amount_net;
									$bill_c[$rep]['amount_r']=0;
									else:
									$bill_c[$rep]['amount_r']=$amount_net;
									$bill_c[$rep]['amount_b']=0;
									endif;
									$bill_c[$rep]['total']=$amount_disc;	
							endforeach;
								//add to a temp table, then get back the data gouped on code+bill_no as also summary for each tran type
								if (!empty($bill_c)):
									$bill_wise=$this->temp_billwise_model->adddata($bill_c);
									$data['billwise']=$bill_wise;
									$data['sdate']=date("d-m-Y",strtotime($sdate));
									$data['edate']=date("d-m-Y",strtotime($edate));
									$data['cs_ot']=$this->input->post('cs_ot');
									//pdf
									$count=count($bill_wise['details'])+count($bill_wise['summary']);
									$folder=SAVEPATH;
									$filename="Billwise_".$this->input->post('cs_ot');;
									$this->html2pdf->folder($folder);
									if ($count<3):
										$this->html2pdf->filename($filename."_a5.pdf");
										$this->html2pdf->paper('a5', 'landscape');
									else:
										$this->html2pdf->filename($filename."_a4.pdf");
										$this->html2pdf->paper('a4', 'portrait');
									endif;
									$this->html2pdf->html($this->load->view('summary/billwise', $data, true));
									$spath=$this->html2pdf->create('save');
									echo "File saved as ".$spath."<br><a href=".site_url('home/index').">Go Home</a><br>";
								//bill_c is empty
								else:
								echo "NO transactions";
								endif;
							
							
								
						
				else:			
					echo "No Data <a href=".site_url('home/index').">Go Home</a><br>";
					echo "<br>".$sdate;
					echo "<br>".$edate;
				endif;
			
			endif;
		endif;
		}
		
		public function gstreports()
		{
		//set validation rules
		$this->form_validation->set_rules('sdate', 'Starting_Date', 'required');
		$this->form_validation->set_rules('edate', 'Ending_Date', 'required');
		//first run/failed
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('summary/gstreports');
		//submitted and valid
		else:
			//chck if starting date is earlier than ending date
			$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$sdate=strtotime($sdate);
			$edate=strtotime($edate);
			if ($sdate>$edate):
				echo "Starting date cannot be earlier than ending date<br>";
				echo "<a href=".site_url('My_Summary/gstreports').">Go back</a>";
			else:
			//all well.	
			$sdate=Date("Y-m-d",$sdate);
			$edate=Date("Y-m-d",$edate);
				
				//get all details from various tables
				if ($report=$this->Summary_model->reports($sdate,$edate)):
					//create an array with calculated fields. 
					foreach ($report as $rep=>$val):
							$bill_c[$rep]['Type']=$val['descrip_2'];
							$bill_c[$rep]['tr_code']=$val['tr_code'];
							$bill_c[$rep]['tr_no']=$val['tr_no'];
							$bill_c[$rep]['date']=$val['date'];
							$bill_c[$rep]['quantity']=$val['quantity'];
							$bill_c[$rep]['icode']=$val['icode'];
							$bill_c[$rep]['rate']=round($val['rate'],2);
							$bill_c[$rep]['discount']=$val['discount'];
							$bill_c[$rep]['cashdisc']=$val['cashdisc'];
							$bill_c[$rep]['code']=$val['code'];
							$bill_c[$rep]['name']=$val['name'];
							//$bill_c[$rep]['expenses']=$val['expenses'];
							$bill_c[$rep]['st']=$val['st'];
							$bill_c[$rep]['city']=$val['city'];
							$bill_c[$rep]['status']=$val['p_status'];
							$bill_c[$rep]['gstno']=$val['gstno'];
							$bill_c[$rep]['hsn']=$val['hsn'];
							
						
							
							//gst rate should be zero in some cases
							if(($val['descrip_2']=="Purchase" or $val['descrip_2']=='Purchase Return') and $val['p_status']!=="REGD"):
								$val['grate']=0;
							endif;
							$bill_c[$rep]['grate']=$val['grate'];		
							$amount_disc=($val['rate']-$val['cashdisc'])*$val['quantity']-(($val['rate']-$val['cashdisc'])*$val['quantity']*($val['discount']/100));
							//$bill_c[$rep]['value']=$amount_disc;
							
							//gst and tr_value 
							$gst=round($amount_disc/(100+$val['grate'])*$val['grate'],2);
							if ($val['st']!=="I"):
								$bill_c[$rep]['igst']=$gst;
								$bill_c[$rep]['cgst']=0;
								$bill_c[$rep]['sgst']=0;
							else:
								$bill_c[$rep]['igst']=0;
								$bill_c[$rep]['cgst']=round($gst/2,2);
								$bill_c[$rep]['sgst']=round($gst/2,2);
							endif;
							
							$amount_net=$amount_disc-$bill_c[$rep]['igst']-$bill_c[$rep]['cgst']-$bill_c[$rep]['sgst'];
							$bill_c[$rep]['tr_val']=$amount_net;
							$bill_c[$rep]['total']=$amount_disc;
					endforeach;
					//print_r($bill_c);
					//add headers
					$header=array('Type','Tr_code', 'Tr_no', 'Date','Quantity','I_Code','Rate','Discount','C disc','P_code','P_name','State','City','Status','GST No','HSN','GST Rate', 'IGST','CGST','SGST','Tr_Value','Total');
					$fname="GST_Rep_".$sdate." - ".$edate;
					$this->Summary_model->write_csv($header, $bill_c, $fname);
					echo "<a href=".site_url('My_Summary/gstreports').">File written</a>";
				//no data fetched by Summary_model->reports
				else:
					echo "No Data Fetched. <a href=".site_url('My_Summary/gstreports').">Go Back</a>";
				endif;
			
			//sdate<edate
			endif;
		
		//first run/failed validation
		endif;
		}

		public function b_reports(){
		$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$sdate=date("Y-m-d",strtotime($sdate));
			$edate=date("Y-m-d",strtotime($edate));
		$b_reports=$this->Summary_model->c_reports($sdate,$edate);
		foreach ($b_reports as $key=>$value):
			if ($b_reports[$key]['st']=='I'):
				$b_reports[$key]['igst']=0;
				$b_reports[$key]['cgst']=round($value['gst']/2,2);
				$b_reports[$key]['sgst']=round($value['gst']/2,2);
			else:
				$b_reports[$key]['igst']=$value['gst'];
				$b_reports[$key]['cgst']=0;
				$b_reports[$key]['sgst']=0;
			endif;
			
			if ($b_reports[$key]['gst']==0):
				$b_reports[$key]['tr_value']=0;
			else:
				$b_reports[$key]['tr_value']=$b_reports[$key]['amount']-$b_reports[$key]['cgst']-$b_reports[$key]['sgst']-$b_reports[$key]['igst'];
			endif;
		endforeach;
			
		echo "<pre>";
		print_r($b_reports);
		echo "</pre>";
		
		
		
		
		
		
		}


}
