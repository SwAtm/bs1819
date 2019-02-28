<?php
class Summary_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	

	public function gettranno($tcode)
	//called by my_summary/get_trcode_etc, *Summary/get_trcode_etc
		{
		$query=$this->db->select_max('tr_no');
		$query=$this->db->from('summary');
		$query=$this->db->where('tr_code', $tcode);
		$query=$this->db->get();
		if ($query):
			$tr_no=$query->row()->tr_no;
			$tr_no=$tr_no+1;
		else:
			$tr_no=1;
		endif;
		
		return $tr_no;
	}

	
	
	public function getdescr($id)
	//called by my_summary/edit, Details/show, *Summary/check_editable, *Details/printbill, *Summary/check_addable, *Summary/check_det_editable
	{
		$sql=$this->db->select('*');
		$sql=$this->db->from('tran_type');
		$sql=$this->db->join('summary', 'summary.tr_code=tran_type.tr_code');
		$sql=$this->db->where('summary.id',$id);
		$res=$this->db->get();
		$trtype=$res->row();
		return $trtype;
	}
	
	
	
	public function toprint1($id)
	//called by *Details/printbill
	{
	$sql=$this->db->select('s.tr_code, s.tr_no, s.date, s.expenses, s.remark, s.p_status, p.name, p.city, p.st, p.gstno, t.location, t.descrip_1, t.descrip_2');
	$sql=$this->db->from ('summary as s');
	$sql=$this->db->join ('party as p', 's.party_id=p.id');
	$sql=$this->db->join ('tran_type as t', 't.tr_code=s.tr_code');
	$sql=$this->db->where('s.id',$id);
	$res=$this->db->get();
	$toprint1=$res->row();
	return $toprint1;
	}
	
	public function toprint2($id)
	//called by *Details/printbill
	{
	$sql=$this->db->select('d.quantity, d.discount, d.cashdisc, i.cat_id, i.code, i.rate, i.title, i.hsn, i.grate');
	$sql=$this->db->from ('details as d');
	$sql=$this->db->join ('item as i', 'd.item_id=i.id');
	$sql=$this->db->where('d.summary_id',$id);
	$res=$this->db->get();
	$toprint2=$res->result_array();
	return $toprint2;
}
	public function reports($sdate, $edate)
	//called by *Reports/reports, *Reports/gstreports
	{
	$sql=$this->db->select('s.id, s.tr_code, s.tr_no, s.date, s.party_id, s.expenses, s.p_status, p.code, p.name, p.city, p.st, p.gstno, d.item_id, d.quantity, d.discount, d.cashdisc, i.code as icode, i.rate, i.grate, i.hsn, t.location, t.descrip_1, t.descrip_2, i.cat_id');
	$sql=$this->db->from ('summary as s');
	$sql=$this->db->join ('party as p', 's.party_id=p.id');
	$sql=$this->db->join ('details as d', 's.id=d.summary_id');
	$sql=$this->db->join ('item as i', 'd.item_id=i.id');
	$sql=$this->db->join ('tran_type as t', 't.tr_code=s.tr_code');
	$sql=$this->db->where('date>=',$sdate);
	$sql=$this->db->where('date<=',$edate);
	$sql=$this->db->order_by('date');
	$sql=$this->db->get();
	$report=$sql->result_array();
	if ($report):
	return $report;
	else:
	return false;
	endif;
	}
	
	
	public function write_csv($header, $data, $file)
	//called by *Reports/gstreports
	{
	$fp=fopen(SAVEPATH.$file,'w');
	fputcsv($fp,$header,',');
	foreach ($data as $fields){
	fputcsv($fp,$fields,',');
	}
	fclose($fp);

	}
	
	/*public function repo_bill($reports):
	{
	foreach ($reposts as $k=>$v):
		$billwise[]['id']=$v['id'];
	}*/

	




//not reqd
/*
public function adddata($data)
	//called by my_summary/add
	{

	if ($this->db->insert('summary',$data)):
		return true;
	else:
		return false;
	endif;
	
	}
	
	public function getmaxid()
	//called by my_summary/add
	{
		$sql=$this->db->select_max('id');
		$sql=$this->db->from('summary');
		$sql=$this->db->get();
		$id=$sql->row()->id;
		return $id;
		

	}

	public function getdetails($id)
	//called by my_summary/edit
	{
		$sql=$this->db->select('*');
		$sql=$this->db->from('summary');
		$sql=$this->db->where('id',$id);
		$sql=$this->db->get();
		$row=$sql->row();
		return $row;
	}
	
	public function update($data)
	//called by My_Summary/edit
	{
	extract ($data);
	$this->db->where('id',$id);
	$this->db->update('summary',array('party_id'=>$party_id, 'expenses'=>$expenses,'remark'=>$remark,'date'=>$date));

	return true;	
		
	}

	public function cancel($id)
	//called by My_summary/delete
	{
	
	$this->db->where('id',$id);
	$this->db->update('summary',array('expenses'=>0,'remark'=>"Cancelled",'date'=>date('Y-m-d')));
	return true;
	}
	public function b_reports($sdate, $edate)
	{
	$sql=$this->db->query("select summary.tr_code, summary.tr_no, summary.date, summary.party_id, summary.expenses, party.name, party.city, party.st, party.gstno, party.status, details.summary_id, tran_type.descrip_2,
	round(sum(case when 
	item.grate=0 OR ((tran_type.descrip_2='Purchase' Or tran_type.descrip_2='Purchase Return') AND party.status!='REGD') 
	then 0 else 
	((details.quantity*(item.rate-details.cashdisc))- ((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/ (100+item.grate)*item.grate end),2) as gst,
	round(sum(((details.quantity*(item.rate-details.cashdisc))- ((details.quantity*(item.rate-details.cashdisc))*details.discount/100))),2) as amount
	from details join item on details.item_id=item.id 
	join item_cat on item.cat_id=item_cat.id 
	join summary on details.summary_id=summary.id 
	join party on summary.party_id=party.id 
	join tran_type on summary.tran_type_id=tran_type.id 
	where summary.date>='$sdate' and summary.date<='$edate'
	group by details.summary_id
	order by details.summary_id");
$res=$sql->result_array();
return $res;
}

	public function c_reports($id)
	{
	$sql=$this->db->query("select details.quantity, details.discount, details.cashdisc, item.hsn, item.title, item.code, item.grate, item.rate
	from details join item on details.item_id=item.id 
	join summary on details.summary_id=summary.id 
	where summary.id='$id'
	order by details.discount");
$res=$sql->result_array();
return $res;
}

*/
/*round(sum(case when 
	item_cat.name='Books' 
	then 
		case when ((tran_type.descrip_2='Purchase' Or tran_type.descrip_2='Purchase Return') AND party.status!='REGD')
		then
		(details.quantity*(item.rate-details.cashdisc))- 
		((details.quantity*(item.rate-details.cashdisc))*details.discount/100)
		else 
		((details.quantity*(item.rate-details.cashdisc))- 
		((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/
		(100+item.grate)*100
		end
	else 0 
	end  ),2)as tr_value_b,
 
	round(sum(case when item_cat.name='Articles' 
	then 
		case when ((tran_type.descrip_2='Purchase' Or tran_type.descrip_2='Purchase Return') AND party.status!='REGD')
		then
		(details.quantity*(item.rate-details.cashdisc))- 
		((details.quantity*(item.rate-details.cashdisc))*details.discount/100)
		else 
		((details.quantity*(item.rate-details.cashdisc))- 
		((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/
		(100+item.grate)*100
		end
	else 0 end),2)  as tr_value_r,
	
	round(sum( case when party.st='I'
				then
					case when (tran_type.descrip_2 NOT IN ('Purchase','Purchase Return') OR party.status='REGD')
					then
			
					((((details.quantity*(item.rate-details.cashdisc))- 
					((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/
					(100+item.grate)*grate)/2) 
					else 0 end
				else 0 end,2))as csgst,	
			
	
	round(sum( case when party.st!='I'
				then
					case when (tran_type.descrip_2 NOT IN ('Purchase','Purchase Return') OR party.status='REGD')
					then
			
					((((details.quantity*(item.rate-details.cashdisc))- 
					((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/
					(100+item.grate)*grate)) 
					else 0 end
				else 0 end,2))as igst,
				
				
				
round(case when 
	item.grate=0 OR ((tran_type.descrip_2='Purchase' Or tran_type.descrip_2='Purchase Return') AND party.status!='REGD') 
	then 0 else 
	((details.quantity*(item.rate-details.cashdisc))- ((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/ (100+item.grate)*item.grate end,2) as gst,
	round(((details.quantity*(item.rate-details.cashdisc))- ((details.quantity*(item.rate-details.cashdisc))*details.discount/100)),2) as amount
	select summary.tr_code, summary.tr_no, summary.date, summary.party_id, summary.expenses, party.name, party.city, party.st, party.gstno,  details.summary_id, 
	round(sum(case when item.grate=0 OR ((tran_type.descrip_2='Purchase' Or tran_type.descrip_2='Purchase Return') AND party.status!='REGD')
	then 0
	else
	((details.quantity*(item.rate-details.cashdisc))- 
		((details.quantity*(item.rate-details.cashdisc))*details.discount/100))/
		(100+item.grate)*item.grate end),0)
		as gst	
	
 from  details 
 join item on details.item_id=item.id
 join item_cat on item.cat_id=item_cat.id
 join summary on details.summary_id=summary.id
 join party on summary.party_id=party.id
 join tran_type on summary.tran_type_id=tran_type.id
 where summary.date>='04-01-2018' and summary.date<='07-06-2018'
 group by details.summary_id
 order by details.summary_id*/
}
?>

