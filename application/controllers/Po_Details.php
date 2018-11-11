<?php
class Po_Details extends CI_Controller{
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
		$this->load->model('My_Po_summary_model');
		$this->load->model('Item_model');
		$this->load->model('Po_Details_model');
		$this->load->library('html2pdf');
}


	public function details($id=null){
		$sid=$this->uri->segment(3);
		$party=$this->My_Po_summary_model->po_summary($sid);
		$party_id=$party['pid'];
		$poid=$party['id'];
		if (!$item_p=$this->Item_model->get_by_party($party_id)):
			Die("No items from this party, <a href=".site_url('home').">Go Home</a>");
		endif;	
		$order=$this->Po_Details_model->po_details($poid);
		//print_r($order);
		//print_r($item_p);
		if (count($order)>0):
			foreach ($order as $o):
				foreach ($item_p as $k=>$i):
					if ($o['id']==$i['id']):
						unset ($item_p[$k]);
					endif;
				//print_r($item_p);
				endforeach;
			endforeach;
		endif;
		//print_r($item_p);
		if (count($item_p)==0):
			Die ("All items from this party are ordered. Use view option to edit. <a href=".site_url('home').">Go Home</a>");
		endif;
		
		
		
		foreach ($item_p as $k=>$item):
			$po[$k]['code']=$item['code'];
			$po[$k]['rate']=$item['rate'];
			$po[$k]['item_id']=$item['id'];
			$po[$k]['title']=$item['title'];
			$stock=$this->Item_model->stck_summ($item['id']);
			foreach ($stock as $key=>$val):
				$po[$k][$val['description']]=$val['opstck']+$val['purchase']+$val['qin']-$val['sales']-$val['qout'];
			endforeach;
					
		endforeach;
		//sort as per code+rate
		foreach ($po as $key=>$val):
			$rate[$key]=$val['rate'];
			$code[$key]=$val['code'];
		endforeach;
		array_multisort($code, SORT_ASC, $rate, SORT_ASC, $po);
		
		$data['party']=$party;
		$data['po']=$po;
		
		
		$this->load->view('templates/header');
		$this->load->view('po_details/po',$data);
		$this->load->view('templates/footer');
	}
	
	
	function details_add(){
		$post=$this->input->post();
		$porder=array();
		foreach ($post as $k=>$v):
			if ($k=='Party'):
				continue;
			endif;
			if($v==0||!is_numeric($v)||$v<0):
				continue;
			endif;
		$item=$this->Item_model->get_title($k);
		$porder[]=array('code'=>$item->code, 'rate'=>$item->rate, 'title'=>$item->title, 'quantity'=>$v);
		endforeach;
		//add to po_details table
		if (count($porder)>0):
		$po_det=array();
		$po_summ_id=$post['Party']['id'];
			foreach ($post as $k=>$v):
				if ($k=='submit'||$k=='Party'):
				continue;
				endif;
				if ($v==0):
				continue;
				endif;
			$po_det[]=array('po_summ_id'=>$po_summ_id, 'item_id'=>$k, 'quantity'=>$v);
			endforeach;
			if ($this->Po_Details_model->adddata($po_det)):
				echo "All well <a href=".site_url('home').">Go Home</a>";
			else:
				Die ("Failed to Add data to Po_Details Tabe");
			endif;
		
		else:
		echo "Nothing to Add <a href=".site_url('home').">Go Home</a>";
		endif;
	}
		
		
		function id_details($id=null){
		//echo "Coming Soon. <a href=".site_url('home').">GO Home</a>";
		$sid=$this->uri->segment(3);
		$crud = new grocery_CRUD();
		$crud->set_table('po_details')
				//->set_subject('Item')
				->columns('id', 'po_summ_id', 'item_id','quantity')
				->display_as('id','ID')
				->display_as('po_summ_id','PO Summary ID')
				->display_as('item_id','Item')
				->display_as('quantity','Quantity')
				->set_relation('item_id','item','{title}--{rate}')
				->set_rules('quantity', 'Quantity', 'numeric')
				->unset_print()
				->unset_add()
				->edit_fields('po_summ_id','item_id','quantity');
				//->add_fields('item_id','quantity')
				$crud->field_type('po_summ_id','readonly');
				$crud->field_type('item_id','readonly');
				$crud->where('po_summ_id',$sid);
				$crud->order_by('id','desc');		
				$output = $crud->render();
				$output->extra="<table align=center bgcolor=lightblue width=100%><tr><td align=center colspan=2><a href = ".site_url('Po_Summary/summary').">Go to PO List</a> </td><td align=center colspan=2><a href = ".site_url('Po_Details/idprint/'.$sid).">Print</a> </td></tr></table>";
		/*echo "<pre>";
		print_r($output);
		echo "</pre>";*/
		
		$this->_example_output($output); 
	
	
	
	
	
	
	}

	function _example_output($output = null)
	{
		$this->load->view('templates/header');
		$this->load->view('po_details/list.php',$output);    
		$this->load->view('templates/footer');
	} 
		
		public function idprint($id=null){
		//print 
		$sid=$this->uri->segment(3);
		$po_summary=$this->My_Po_summary_model->po_summary($id);
		$po_details=$this->Po_Details_model->po_details($id);
		if (count($po_details)>0):
		$data['porder']=$po_details;
		$data['party']=$po_summary;
		//$Party=$post['Party'];
		$folder=SAVEPATH;
		$filename="PO_No_".$po_summary['id'];
		$this->html2pdf->folder($folder);
		$this->html2pdf->filename($filename.".pdf");
		$this->html2pdf->paper('a4', 'portrait');
		$this->html2pdf->html($this->load->view('po_details/po_print',$data, true));
		$spath=$this->html2pdf->create('save');
		echo "File saved at as ".$spath;
		echo "<a href=".site_url('home').">Go Home</a>";
		else:
		echo "No Records. <a href=".site_url('home').">GO Home</a>";
		endif;
	}

	 



}
