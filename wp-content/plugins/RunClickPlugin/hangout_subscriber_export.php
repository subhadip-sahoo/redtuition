<?php
ob_clean();
global $wpdb;
$where='';
if($_GET['g_event_id']!=''){
	$where = ' where g_event_id="'.$_GET['g_event_id'].'"';
}
$post_table = $wpdb->prefix . "google_hangout_subscriber"; 
$result=$wpdb->get_results('SELECT distinct(email), name, add_email from '. $post_table . $where);
$i = 0;
$csv_output ='';
$csv_output .= "Name, Email, Additiona Email, ";
$csv_output .= "\n";


foreach($result as $output){
	$csv_output .= 	$output->name.", ";
	$csv_output .= 	$output->email.", ";
	$csv_output .= 	$output->add_email.", ";
	$csv_output .= "\n";
}

$filename = 'g_hangout_subscriber'."_".date("Y-m-d_H-i",time());
header('Content-type: application/csv');
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>