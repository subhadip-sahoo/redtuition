<?php
include('../../../wp-config.php');
require_once('google_hangout_plugin_connector.php');
global $wpdb;

$sitename = get_bloginfo('name');

$creatorEmail =get_option('g_hangout_reminder_from');

if(empty($creatorEmail))
	$creatorEmail	=	get_option('admin_email');

add_filter( 'wp_mail_content_type', 'set_html_content_type' );
 $headers = 'From: '.$sitename.' <'.$creatorEmail.'>' . "\r\n\\";
$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 
//echo $now;
$reminders	=	$wpdb->get_results("select * from ".$wpdb->prefix."reminder where reminder_type='follow'");
$attribution_link = get_option('attribution_link');
					if($attribution_link=='1'){
						
						if(get_option('hangout_affiliate_text')==''){
							$hangout_affiliate_text = 'Powered By RunClick';
						}else{
							$hangout_affiliate_text=get_option('hangout_affiliate_text');
						}
						$link1 = get_option('hangout_youtube_affiliate_link');
						if(get_option('hangout_youtube_affiliate_link')==''){
							$link1 = 'http://runclick.com';
						}
						$link='<a href="'.$link1.'" target="_blank">'.$hangout_affiliate_text.'</a>';
					}
foreach($reminders as $reminder)
{
	echo "<pre>";
	print_r($reminder);
	$arr = explode('-',$reminder->reminder_time);
	$msgday ='';
	if($arr[0]>0){
		$msgday .= $arr[0].' Day ';
	}
	if($arr[1]>0){
		$msgday .= $arr[1].' Hour ';
	}
	$minut = $arr[2] - 15;
	$msgday .= $arr[2].' Minute';
	

	
	$curtime = mktime(date('H')-$arr[1],date('i')-$arr[2],date('s'),date('m'),date('d')-$arr[0],date('Y'));
	
	$curtime5 = mktime(date('H')-$arr[1],date('i')-$minut,date('s'),date('m'),date('d')-$arr[0],date('Y'));
	
	
	
	$minutes_posts	=	query_posts(array('post_type'=>'ghangout','meta_query' => array(
		array(
			'key' => 'hangout_server_end_time',
			'value' => array( $curtime, $curtime5 ),
			'type' => 'numeric',
			'compare' => 'BETWEEN'
		)
	)));

		 $subj = $reminder->subject; 


		$subj = str_replace("{sitename}",$sitename,$subj);
		$subj = str_replace("{creatorEmail}",$creatorEmail,$subj);

		$messe = $reminder->body;


		$messe = str_replace("{sitename}",$sitename,$messe);
		$messe = str_replace("{creatorEmail}",$creatorEmail,$messe);
	
	if(count($minutes_posts)>0) {
		while (have_posts()) : the_post();
			$subject = $subj;
			$message = $messe;

			 $eventlinkURL = '<a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a>';
			$eventName=get_the_title();
			$time_zone	=	get_post_meta(get_the_ID(),'hangout_time_zone',true);
			
			
			$id = get_the_ID();
			$result=$wpdb->get_results('SELECT distinct(email), name,add_email from '.$subscriber_table.' where g_event_id="'.$id.'"');
			$tym_zon	=	get_post_meta(get_the_ID(),"hangout_time_zone",true);
			$tz = get_city_id($tym_zon);
			if(count($result)>0){
			foreach($result as $output){
				$subject = $subj;
				$message = $messe;
				$subject = str_replace("{eventlinkURL}",$eventlinkURL,$subject);
				$subject = str_replace("{eventName}",$eventName,$subject);
				$subject = str_replace("{time}",' '.$msgday.' '.$time_zone,$subject);
				$message = str_replace("{eventName}",$eventName,$message);
				$message = str_replace("{eventlinkURL}",$eventlinkURL,$message);
				$message = str_replace("{creatorEmail}",$creatorEmail,$message);
				$message = str_replace("{time}",' '.$msgday.' '.$time_zone,$message);
				$subject = str_replace("{name}",$output->name,$subject);
				$message = str_replace("{name}",$output->name,$message);
				
				
					// Code to get the correct timezone when we click on link
						$hangout_mail_date	=	explode("+",get_post_meta($id,"hangout_timezone",true));
						
						if(count($hangout_mail_date) >1)
						{
							$hangout_mail_time	=	$hangout_mail_date[0];
						}
						else
						{
							$hangout_mail_date	=	explode("-",get_post_meta($id,"hangout_timezone",true));
							$hangout_mail_time	=	$hangout_mail_date[0];
						}
						
						$upload_dir = wp_upload_dir(); 
							$logo_url	=	$upload_dir['baseurl']."/".str_replace(' ','%20',get_post_meta($id,'ghanghout_logo',true));
						if(get_post_meta($id,'ghanghout_logo',true)==""){
								$logo_url=  plugins_url()."/RunClickPlugin/img/logo.png";
							}
						if(get_post_meta($id,"hangout_timezone",true)!=""){
						$newdate=explode(" ",get_post_meta($id,"hangout_timezone",true));

							$day_month=explode('/' ,$newdate[0]);
							//print_r($day_month);
							$new_date_for_database=$day_month[1].'/'.$day_month[0].'/'.$day_month[2].' '.$newdate[1];
								}							
						$msg	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
									<html xmlns="http://www.w3.org/1999/xhtml">
									<head>
									<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
									<title>Welcome to Google Hangout</title>
										<!-- Fonts +++++++++++++ -->	
										<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">
										<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet" type="text/css"> 
										<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
										<style type="text/css">
											body, html {  }
											a:active, a:focus { text-decoration:none; outline:none; }
											a { color:#fb9337; text-decoration:none; }
											a:hover { color:#365C75; }
										</style>
									</head>
									<body style="margin:0px; padding:0px; font: 14px/18px "Source Sans Pro"; background:#F3F2E9; color:#666;">
										<!-- Start Wrapper -->
										<div id="e_wrapper" style="display:block; margin:0px auto; padding:0; width:600px;">		
											<!-- Start Top Head -->
											<div id="e_top_head" style="display:block; margin:0; padding:10px 0px;">

												<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
											</div>
											<!-- End top Head -->
											<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
											<!-- Start Header -->
											<div id="e_header" style="display:block; margin:0; padding:10px;  border:solid 1px #ddd;  background:#fff; position:relative; z-index:2;">
												<div class="e_logo" style="display:block; float:left; width:160px;"><a href="#"><img src="'.$logo_url.'" alt="hangout" /></a></div>
												
												<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
											</div>
											<!-- End header -->
		
											<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
											<!-- Start Content -->
											<div id="e_content" style="display:block; margin:0px; padding:0;">'.nl2br($message).'<br />'
											.$new_date_for_database.' '.get_post_meta($id,"hangout_time_zone",true).'<a target="_blank" href="http://www.timeanddate.com/worldclock/fixedtime.html?msg='.str_replace(" ","+",get_the_title($id)).'&amp;iso='.date('Ymd',strtotime($hangout_mail_time)).'T'.date('Hi',strtotime($hangout_mail_time)).'&amp;p1='.$tz.'"> Check Time Zone Here</a>
											</div>
											<!-- End Content -->
											<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
		
											<!-- Start Footer -->
											<div id="footer" style="display:block; margin-top:20px; padding:10px;  border:solid 1px #ddd;  background:#fff; position:relative; z-index:2; text-align:center;">
												<span style="display:block; color:#fb9337; margin:0; padding:10px;">'.$link.'</span>
											</div>
											<!-- End Footer -->
		
										</div>
										<!-- End Wrapper -->
									</body>
									</html>';
									echo $subject;
				if(get_post_meta($id,'hangout_send_notifications',true) == "1")
				{
					wp_mail( $output->email, $subject, $msg,$headers );
				}	
				update_post_meta($id,'minute_cron_mail_send','1');
			}
			}
		
		endwhile;
	}



}