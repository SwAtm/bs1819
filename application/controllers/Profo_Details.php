<html>

<?php
class Profo_Details extends CI_Controller{
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
		$this->load->model('My_Profo_Summary_model');
		$this->load->model('My_Profo_Details_model');
		$this->load->model('Company_model');
		$this->load->model('Item_model');
		$this->load->model('Temp_details_model');
		
		$this->load->library('html2pdf');
	}
	
	public function details($id=null)
	{
	
		$crud = new grocery_CRUD();
		$crud->set_table('proforma_details')
				->fields('p_sum_id','item_id','quantity', 'o_i')
				->display_as('p_sum_id','Proforma Summary ID')
				->display_as('item_id','Item')
				->display_as('quantity','Quantity')
				->set_rules('item_id', 'Item', 'required')
				->set_theme('datatables');
		$sid=$this->uri->segment(4);
		$party=$this->My_Profo_Summary_model->profo_summary($sid);
		$party_id=$party['pid'];
		$o_i=$party['o_i'];
		$party_name=$party['name'];
		$date=$party['date'];
		$crud->unset_back_to_list();	
		$crud->field_type('p_sum_id','hidden', $sid);
		$crud->field_type('o_i','hidden', $o_i);
			if (strtoupper($o_i)=='IN'):
				if ($balance=$this->My_Profo_Details_model->get_balance($party_id)):
						foreach ($balance as $k=>$v):
						$balance[$k]['bal']=$v['qout']-$v['qin'];
							if ($balance[$k]['bal']==0):
								unset ($balance[$k]);
							endif;
						endforeach;
						if (count($balance)==0):
							Die ("Nothing from this Party. <a href=".site_url('Profo_Summary/summary').">Go to Proforma Summary</a>");
						endif;
					
						$balance1=array();
						foreach ($balance as $v):
						$balance1[$v['item_id']]=$v['title']." - ".$v['rate'].": ".$v['bal'];
						endforeach;
				else:
					die ("Nothing issued to this Party. <a href=".site_url('Profo_Summary/summary').">Go to Proforma Summary</a>");
				endif;
				
				$crud->field_type('item_id','dropdown',$balance1);
			//out				
			else:
				$crud->set_relation('item_id','item','{title}--{rate}');
				
			endif;	
		$crud->set_rules('quantity', 'Quantity', 'required|numeric|callback_check_qty');
		$crud->callback_before_insert(array($this, 'remove_oi'));
		$crud->set_lang_string('insert_success_message',
				 'Your data has been successfully stored into the database.<br/>Please wait while you are redirecting to the list page.
				 <script type="text/javascript">
				 window.location = "'.site_url(('Profo_Details/details/add/').($sid?$sid:$_POST['p_sum_id'])).'";
				 </script>
				 <div style="display:none">
				 ');	
			
		$output = $crud->render();
		$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center><a href = ".site_url('Profo_Summary/summary').">Go to Proforma List</a> </td></tr></table>";
		$output->extra1="<table align=center bgcolor=lightblue width=100%><tr><td align=center>".$party_name."|| Proforma Summary ID: ".strtoupper($o_i)."--".$sid." Date: ".$date."</td></tr></table>";
		$this->_example_output($output);           
	}
	
	public function id_details($sid=null)
		{
		$crud = new grocery_CRUD();
		$sid=$this->uri->segment(3);
		
		$crud->set_table('proforma_details')
				->set_subject('Item')
				->columns('id', 'p_sum_id', 'item_id','quantity')
				->display_as('id','ID')
				->display_as('p_sum_id','Summary ID')
				->display_as('item_id','Item')
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'numeric')
				->unset_print()
				->unset_add();
				//->edit_fields('summ_id','item_id','quantity')
				//->add_fields('item_id','quantity')
				$crud->field_type('p_sum_id','readonly');
				$crud->where('p_sum_id',$sid);
				$crud->order_by('id','desc');		
				$output = $crud->render();
				$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center colspan=3><a href = ".site_url('Profo_Summary/summary').">Go to Proforma List</a> </td><td align=center colspan=2><a href = ".site_url('Profo_Details/idprint/'.$sid).">Print</a> </td></tr></table>";
		/*echo "<pre>";
		print_r($output);
		echo "</pre>";*/
		
		$this->_example_output($output); 
		}

	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('profo_details/list.php',$output);   
		$this->load->view('templates/footer');
		//echo "<table align=center><tr><td align=center><a href = ".site_url('Trnf_Summary/summary').">Go to Transfer List</a> </td></tr></table>";
	}    
	
	function idprint($id=null)
	{
	$sid=$this->uri->segment(3);
	$profo_summary=$this->My_Profo_Summary_model->profo_summary($sid);
	$profo_details=$this->My_Profo_Details_model->profo_details($sid);
	$data['profo_summary']=$profo_summary;
	$data['profo_details']=$profo_details;
	$company = $this->Company_model->getall();
	$data['company']=$company;
	$count=count($profo_details);
	$folder=SAVEPATH;
	$filename="Profo_".$sid;
	$this->html2pdf->folder($folder);
	if ($count<3):
		$this->html2pdf->filename($filename."_a5.pdf");
		$this->html2pdf->paper('a5', 'landscape');
	else:
		$this->html2pdf->filename($filename."_a4.pdf");
		$this->html2pdf->paper('a4', 'portrait');
	endif;
	$this->html2pdf->html($this->load->view('profo_details/print', $data, true));
	$spath=$this->html2pdf->create('save');
	echo "File saved at as ".$spath."<br>";
	echo "<a href = ".site_url('Profo_Summary/summary').">Go to Proforma Summary</a>";
	
	}
	
					
	public function check_qty($qty){
	if ($qty<0):
		$this->form_validation->set_message('check_qty','Qty cannot be less than 0');
		return false;
	endif;
	if ($this->input->post('o_i')=='in'):
		$iid=$this->input->post('item_id');
		$p_sum_id=$this->input->post('p_sum_id');
		$pid=$this->My_Profo_Summary_model->profo_summary($p_sum_id)['pid'];	
		$qty_o_i=$this->My_Profo_Details_model->get_balance_iid($pid,$iid);
		if ($qty_o_i['qout']-$qty_o_i['qin']>=$qty):
			return true;
		else:
			//print_r($qty_o_i);
			//die();
			$this->form_validation->set_message('check_qty','Quantity cannot be more than balance');
			return false;
		endif;
	else:
	return true;
	endif;
	}

	function remove_oi($post){
	unset ($post['o_i']);
	return $post;
	}
	
	public function id_balance($id)
	{
	$id=$this->uri->segment(3);
	$party=$this->My_Profo_Summary_model->profo_summary($id);
	if (!$balance=$this->My_Profo_Details_model->get_balance($party['pid'])):
		die ("Nothing balance <a href = ".site_url('Profo_Summary/balance').">Go to Proforma Summary Balance list</a>");
	else:
		$tbal=0;
		foreach ($balance as $k=>$v):
			$balance[$k]['bal']=$v['qout']-$v['qin'];
			if ($balance[$k]['bal']==0):
				unset ($balance[$k]);
			endif;
		endforeach;
		$count=count($balance);
		if (count($balance)==0):
			die ("Nothing balance from this party.<a href = ".site_url('Profo_Summary/balance').">Go to Proforma Summary Balance list</a>");
		else:
			foreach ($balance as $k=>$v):
			$tbal=$tbal+($balance[$k]['bal']*$balance[$k]['rate']);
			endforeach;
		endif;
	$company = $this->Company_model->getall();
	$data['party']=$party;
	$data['balance']=$balance;
	$data['company']=$company;
	$data['tbalance']=$tbal;
	$this->load->view('templates/header');	
	$this->load->view('profo_details/balance', $data);
	endif;
	}

	public function convert()
	{
	$settleamt=$_POST['settleamt'];
	$tbalance=$_POST['tbalance'];
	$pid=$_POST['pid'];
	//print_r($pid);
	unset ($_POST['settleamt']);
	unset ($_POST['tbalance']);
	unset ($_POST['submit']);
	unset ($_POST['pid']);
	$tdiscount=$tbalance-$settleamt;
	$pdiscount=$tdiscount/$tbalance*100;
	$pdiscount=number_format($pdiscount,2);
	
	$list=array();
	$this->db->trans_start();
	foreach ($_POST as $k=>$v):
		$list[$k]['quantity']=$v['bal'];
		$list[$k]['item_id']=$v['item_id'];
		$list[$k]['discount']=$pdiscount;
		$list[$k]['cashdisc']=0;
		$this->Temp_details_model->adddata($list[$k]);
	endforeach;
		
	//get p_sum_ids for the party
	$p_s_ids=$this->My_Profo_Summary_model->get_ids_party($pid);
	
	
	//delet everthing for the party in profo_details
	foreach ($p_s_ids as $psid):
	$this->My_Profo_Details_model->delet_psid($psid['id']);
	endforeach;
	
	
	//delet everything for the party in profo_summary
	$this->My_Profo_Summary_model->delet_party($pid);
	$this->db->trans_complete();
	
	if ($this->db->trans_status()===false):
		echo "Could not convert.<a href=".site_url('home').">Go Home</a>";
	else:
		redirect (site_url('Temp_details/index'));
				
	endif;
	
	
	
	
	
	
	}


}
?>
</html>
