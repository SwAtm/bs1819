<?php
class Reports extends CI_Controller{
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
		$this->load->model('Summary_model');
		$this->load->model('temp_billwise_model');
		
		/*
		$this->load->model('Temp_details_model');
		$this->load->model('Tran_type_model');
		$this->load->model('Party_model');
		$this->load->model('Details_model');
		//$this->load->model('temp_bill_model');
		$this->load->model('Company_model');*/
		$this->output->enable_profiler(TRUE);
		//$this->load->helper('pdf_helper');
		$this->load->library('html2pdf');
}


public function reports()
		{
		//set validation rules
		$this->form_validation->set_rules('sdate', 'Starting_Date', 'required');
		$this->form_validation->set_rules('edate', 'Ending_Date', 'required');
		//first run/failed
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('reports/reports');
		//submitted and valid
		else:
			//chck if starting date is earlier than ending date
			$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$sdate=strtotime($sdate);
			$edate=strtotime($edate);
			if ($sdate>$edate):
				echo "Starting date cannot be earlier than ending date<br>";
				echo "<a href=".site_url('Reports/reports').">Go back</a>";
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
									$this->html2pdf->html($this->load->view('reports/billwise', $data, true));
									$spath=$this->html2pdf->create('save');
									echo "File saved as ".$spath."<br><a href=".site_url('home/index').">Go Home</a><br>";
								//bill_c is empty
								else:
								echo "NO transactions";
								endif;
							
							
								
				//data exists?		
				else:			
					echo "No Data <a href=".site_url('home/index').">Go Home</a><br>";
					echo "<br>".$sdate;
					echo "<br>".$edate;
				endif;
			//dates alright?
			endif;
		//failed/submitted?
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
			$this->load->view('reports/gstreports');
		//submitted and valid
		else:
			//chck if starting date is earlier than ending date
			$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$sdate=strtotime($sdate);
			$edate=strtotime($edate);
			if ($sdate>$edate):
				echo "Starting date cannot be earlier than ending date<br>";
				echo "<a href=".site_url('Reports/gstreports').">Go back</a>";
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
					echo "<a href=".site_url('Reports/gstreports').">File written</a>";
				//no data fetched by Summary_model->reports
				else:
					echo "No Data Fetched. <a href=".site_url('Reports/gstreports').">Go Back</a>";
				endif;
			
			//sdate<edate
			endif;
		
		//first run/failed validation
		endif;
		}
		
	}
