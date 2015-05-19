<?php

global $wpdb;

$hangout = $_POST['eid'];
$selval  = $_POST['selval'];
$option_number  = $_POST['option_number'];
$ip      = $_SERVER['REMOTE_ADDR'];


$vote_count = $wpdb->get_var("SELECT COUNT(*) FROM hangout_vote WHERE ipaddress='".$ip."' and hangout_id='".$hangout."' and option_number='".$option_number."' ");

if($vote_count == 0)
{
	$sql     = 'INSERT INTO hangout_vote (`hangout_id`, `answer`, `ipaddress`,`option_number`) VALUES("'.$hangout.'", "'.$selval.'", "'.$ip.'","'.$option_number.'")';
	$wpdb->query($sql);
	$lastid = $wpdb->insert_id;
	if($lastid)
	{
		echo "<strong>Your Vote is Successfully Saved</strong>";
	}
	else
	{
		echo "<strong>Internal Server Error</strong>";
	}
}
else
{
	echo "<strong>You Have Already Voted</strong>";
}
