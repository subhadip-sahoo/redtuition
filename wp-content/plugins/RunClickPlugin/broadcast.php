<?php
//include('../../../wp-config.php');
global $wpdb;
$g_event_id = $_REQUEST['g_event_id'];
if($_POST['action']=="sendmail"){
?>
<b>Pls Wait.........</b> <br><br>Broadcast Email is under processing<br><br><br>
<?php	
	$g_event_id = $_REQUEST['g_event_id'];
	$post = get_post($g_event_id);
	

	$attribution_link = get_option('attribution_link');
	if($attribution_link=='1')
	{
		$afi_link = get_option('hangout_youtube_affiliate_link');
		$link='Powered By <a href='.$afi_link.' target="blank">Runclick.com </a>';
	} 
	else 
	{
		$link ='';
	}


$sitename = get_bloginfo('name');

$creatorEmail =get_bloginfo('admin_email');

$subj = $_POST['g_hangout_broadcast_subject']; 
$messeg = $_POST['g_hangout_broadcast_msg']; 
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$headers = 'From: '.$sitename.' <'.$creatorEmail.'>' . "\r\n\\";
$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 
	

$subj = str_replace("{time}",' Now',$subj);
$subj = str_replace("{sitename}",$sitename,$subj);
$subj = str_replace("{creatorEmail}",$creatorEmail,$subj);



$messeg = str_replace("{time}",' Now',$messeg);
$messeg = str_replace("{sitename}",$sitename,$messeg);

$upload_dir = wp_upload_dir(); 
$logo_url	=	$upload_dir['baseurl']."/".get_post_meta($post->ID,"ghanghout_logo",true);
if(get_post_meta($post->ID,'ghanghout_logo',true)==""){
	$logo_url=  plugins_url()."/RunClickPlugin/img/logo.png";
}

	
		$eventlinkURL = '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
		$eventName=$post->post_title;
		
		$subj = str_replace("{eventlinkURL}",$eventlinkURL,$subj);
		$messeg = str_replace("{eventlinkURL}",$eventlinkURL,$messeg);
		$subj = str_replace("{eventName}",$eventName,$subj);
		$messeg = str_replace("{eventName}",$eventName,$messeg);
		$messeg = str_replace("{creatorEmail}",$creatorEmail,$messeg);

		$result=$wpdb->get_results('SELECT distinct(email), name,add_email from '. $subscriber_table.' where g_event_id="'.$post->ID.'"');

		foreach($result as $output){
			$subject	=	$subj;
			$message	=	$messeg;
			$subject = str_replace("{name}",$output->name,$subject);
			$message = str_replace("{name}",$output->name,$message);

					$hangout_mail_date	=	explode("+",get_post_meta($post->ID,"hangout_timezone",true));
					
					if(count($hangout_mail_date) >1)
					{
						$hangout_mail_time	=	$hangout_mail_date[0];
					}
					else
					{
						$hangout_mail_date	=	explode("-",get_post_meta($post->ID,"hangout_timezone",true));
						$hangout_mail_time	=	$hangout_mail_date[0];
					}
					
					// Code to get the correct timezone when we click on link
					$tym_zon	=	get_post_meta($id,"hangout_time_zone",true);
					$tz = get_city_id($tym_zon);

					
					// Code to get the correct timezone when we click on link
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
											<div class="e_logo" style="display:block; float:left; width:160px;"><a href="'.get_permalink(get_the_ID()).'"><img src="'.$logo_url.'" alt="Runclick" /></a></div>
											
											<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
										</div>
										<!-- End header -->
	
										<div class="clear" style="margin:0; padding:0; height:0; clear:both;"></div>
										<!-- Start Content -->
										<div id="e_content" style="display:block; margin:0px; padding:0;">'.nl2br($message).'<br />'
										.get_post_meta($post->ID,"hangout_timezone",true).' '.get_post_meta($post->ID,"hangout_time_zone",true).'<a target="_blank" href="http://www.timeanddate.com/worldclock/fixedtime.html?msg='.str_replace(" ","+",get_the_title($post->ID)).'&amp;iso='.date('Ymd',strtotime($hangout_mail_time)).'T'.date('Hi',strtotime($hangout_mail_time)).'&amp;p1='.$tz.'">Check Time Zone Here</a>
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
			
			wp_mail( $output->email,$subject,$msg,$headers );
		}
	
	

echo '<b>Broadcast Email Successfully Sent</b> You can close this window';

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
} else {
?>
<form action="" method="post">
<h3>Broadcast Emails</h3>
<p><label>Subject</label><span><input type="text" value="<?php echo get_option('g_hangout_broadcast_subject'); ?>" name="g_hangout_broadcast_subject"/></span></p>
<p>
<label>Message</label><br>
<textarea name="g_hangout_broadcast_msg" cols="80" rows="10"><?php echo get_option('g_hangout_broadcast_msg'); ?></textarea><br>
<b>Available variable</b> {sitename}, {time}, {name}, {eventlinkURL},{eventName},{creatorEmail}
</p>
<br>
<input type="hidden" value="<?php echo $_REQUEST['g_event_id']; ?>" name="g_event_id">
<input type="hidden" value="sendmail" name="action">
<input type="submit" name="update_email" value="Send Mail"/>
</div>
</form>
<?php } ?>
