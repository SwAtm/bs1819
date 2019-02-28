<?php
require_once(APPPATH.'libraries/MPDF57/mpdf.php');
$mpdf=NEW mPDF();
//include ('/var/www/html/bs1718/application/views/summary/printbill.php');
//$html=ob_get_contents();
//ob_end_clean();
$html=$this->load->view('summary/printbill.php');
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
