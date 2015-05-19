<?php
global $wpdb;
$ID	=	get_the_ID(); 
$page_title	=	get_post_meta( $ID, 'thanks_page_title',true );
 $hangout_title	=	get_the_TITLE();

$video	=	get_post_meta( $ID, 'thanks_page_video', true);
$sidebar_title	=	get_post_meta( $ID, 'thanks_sidebar_title', true);
$sidebar_sub_title	=	get_post_meta( $ID, 'thanks_sidebar_sub_title', true);
$sidebar_image	=	get_post_meta( $ID, 'thanks_sidebar_image', true);
$sidebar_heading_color	=	get_post_meta( $ID, 'thanks_sidebar_heading_color', true);
$sidebar_heading_box_color	=	get_post_meta( $ID, 'thanks_sidebar_heading_box_color', true);
$chat_reg_off_thakyou	=	get_post_meta( $ID, 'chat_reg_off_thakyou', true);
if($sidebar_heading_box_color == "")
{
	$sidebar_heading_box_color	=	'#FB9337';
}
$title	=	get_the_title($ID);
$URL		=	get_permalink($ID);
$date_time	=	get_post_meta( $ID, 'hangout_timezone', true);

	$timedata = explode(" ", $date_time);
	
	$daymonth=explode('/',$timedata[0]);
	 $timezone = $daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2]." ".$timedata[1]." ".$timedata[2]." GMT ".$timedata[3];
$date_array	=	explode(" ",$date_time);
	
$daymonth=explode('/',$date_array[0]);
$date	=	$daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2];
$time	=	$date_array[1]." ".$date_array[2];

$hits	=	get_post_meta($ID, "ghanghout_thankyou_hits", true);
// code for Stats
$ip_addr = $_SERVER['REMOTE_ADDR'];
$stat_result	=	$wpdb->get_results("select * from ".$wpdb->prefix."ghangout_stats where IP='".$ip_addr."' and thankyou='1' and post_id='".get_the_ID()."'");
if(count($stat_result) <= 0 )
{
	$wpdb->query("INSERT INTO ".$wpdb->prefix."ghangout_stats Values('','".$ID."','".$ip_addr."','0','1','0','0')");	
}
// code for Stats
$curr_hit	=	$hits+1;
update_post_meta($ID,'ghanghout_thankyou_hits',$curr_hit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo get_post_meta(get_the_ID(), "add_meta_tag", true); ?>
<title><?php echo $title; ?></title>

<!-- Fonts +++++++++++++ -->	
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Kristi|Crafty+Girls|Yesteryear|Finger+Paint|Press+Start+2P|Spirax|Bonbon|Over+the+Rainbow" />	
<!-- Style +++++++++++++ -->
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('RunClickPlugin/custom-style.css')?>">
    <link rel="stylesheet" href="<?php echo plugins_url('RunClickPlugin/css/font-awesome.css')?>">
    <!--[if IE 7]>
	<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
	<![endif]-->

<!-- Js +++++++++++++ -->

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url('RunClickPlugin/js/jquery.countdown.js')?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('RunClickPlugin/js/hangout_custom.js')?>"></script>
    
<link rel='stylesheet' id='prefix-style-countdown-css-css'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/countdown.css?ver=3.5.1' type='text/css' media='all' />
<link rel='stylesheet' id='hangout-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<link rel='stylesheet' id='g_hangout_skin-css'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/skins/basic/style.min.css?ver=3.5.1' type='text/css' media='all' />
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/comment-reply.min.js?ver=3.5.1'></script>

<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/jquery.easing.min.js?ver=3.5.1'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/jquery.autosize.min.js?ver=3.5.1'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/cookie.min.js?ver=3.5.1'></script>

<script type='text/javascript'>
/* <![CDATA[ */
var g_hangout = {"ajaxurl": "<?php echo site_url(); ?>\/wp-admin\/admin-ajax.php","plugin_url":"<?php echo site_url(); ?>\/wp-content\/plugins\/RunClickPlugin","tr_no_one_online":"No one is online","tr_logout":"Logout","tr_sending":"Sending","tr_in_chat_header":"Now Chatting","tr_offline_header":"Contact us","use_css_anim":"1","delay":"2","is_admin":"","is_op":"1"};
var site_url	=	"<?php echo site_url(); ?>";
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/App.min.js?ver=3.5.1'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo site_url();?>/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo site_url();?>/wp-includes/wlwmanifest.xml" /> 

	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<style type="text/css" media="print">#wpadminbar { display:none; }</style>


<link rel='stylesheet' id='g_hangout_inline_style'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/g_hangout_inline_style.css?ver=4.0.3' type='text/css' media='all' />


<!-- new video code added by Arun Srivastava on 11/4/14 -->
<link rel="stylesheet" href="<?php echo plugins_url('RunClickPlugin/css/reveal.css');?>">
<script type="text/javascript">
var PLUGIN_URL = "<?php echo plugins_url('RunClickPlugin/');?>";
var eid        = "<?php echo $post->ID;?>";
</script>
<script src="<?php echo plugins_url('RunClickPlugin/js/jquery.reveal.js');?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('RunClickPlugin/js/modernizr.custom.js');?>" type="text/javascript" ></script>
<script src="http://afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script src="<?php echo plugins_url('RunClickPlugin/js/videoplayer_custom.js');?>" type="text/javascript"></script>
<!-- new video code added by Arun Srivastava on 11/4/14 -->
	
<!-- Developed By Varun Srivastava 7 June 2013 -->
    
</head>
<?php   
		$layout		=	get_post_meta($post->ID, "g_hangout_layout_type", true);
		$uploads = wp_upload_dir();
		$uploads_dir = $uploads['baseurl'];
if($layout == '1')
{
	echo "<body>";
}
else
{
	$full_banner=get_post_meta($post->ID, "ghanghout_full_banner_image", true); ?>
	<body style="background:url('<?php echo $uploads_dir.'/'. $full_banner; ?>') center center fixed no-repeat; 
-moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover;">
	<?php } 
		
		$enable_header=get_post_meta($post->ID, "ghanghout_thankyou_enable_header", true);
		$enable_sharing=get_post_meta($post->ID, "ghanghout_thankyou_enable_sharing", true);

		$logo_src=get_post_meta($post->ID, "ghanghout_thankyou_logo", true);
		if($logo_src!=''){
			$logo =  $uploads_dir.'/'.$logo_src;
		}
		$logo_text=get_post_meta($post->ID, "ghanghout_thankyou_logo_text", true);
		$logo_family=get_post_meta($post->ID, "ghanghout_thankyou_logo_family", true);
		$logo_size=get_post_meta($post->ID, "ghanghout_thankyou_logo_size", true);
		$logo_style=get_post_meta($post->ID, "ghanghout_thankyou_logo_style", true);
		$logo_color=get_post_meta($post->ID, "ghanghout_thankyou_logo_color", true);
		$logo_height=get_post_meta($post->ID, "ghanghout_thankyou_logo_height", true);
		$logo_spacing=get_post_meta($post->ID, "ghanghout_thankyou_logo_spacing", true);
		$logo_shadow=get_post_meta($post->ID, "ghanghout_thankyou_logo_shadow", true);

		if($logo_style=='Normal')$logo_style='normal';$logo_weight='normal';
		if($logo_style=='Italic')$logo_style='italic';$logo_weight='normal';
		if($logo_style=='Bold')$logo_style='normal';$logo_weight='bold';
		if($logo_style=='Bold/Italic')$logo_style='italic';$logo_weight='bold';

		if($logo_shadow=='Small'){$logo_shadow="1px 1px #777";}
		elseif($logo_shadow=='Medium'){$logo_shadow="2px 2px #777";}
		elseif($logo_shadow=='Large'){$logo_shadow="3px 3px #777";}
		else{$logo_shadow = 'false';}
	?>	
	<?php include "ghangout-style.php"; ?>
	<style type="text/css">
		.logoText {
			font-family:<?php echo $logo_family; ?>; font-size:<?php echo $logo_size; ?>; font-weight:<?php echo $logo_weight; ?>; text-shadow:<?php echo $logo_shadow; ?>; line-height:<?php echo $logo_height; ?>; letter-spacing:<?php echo $logo_spacing; ?>px; color:<?php echo $logo_color; ?>;
		}
		.ho_right h3{
			color:<?php echo $sidebar_heading_color;?>; background:<?php echo $sidebar_heading_box_color;?>;
		}
		
	</style>
	<div id="wrap">
	<!-- Start Header -->
	<div id="ho_header">
		<div class="container">
			<div class="row-fluid">
				<div class="span4">
					<?php if($logo){ ?>
							<?php if($enable_header == "checked"){ ?>
						  		<img border="0" src="<?php echo $logo; ?>">
						  	<?php } ?>		
						<?php }
						if($enable_header == "checked" and $logo=='') { ?>
						  <div class="logoText"><?php echo $logo_text; ?></div>
					<?php } ?>
				</div>
				<div class="span8">
					<!-- AddThis Button BEGIN -->
					<div class="ho_social_shear">
					<?php if($enable_sharing=='checked'){?>
							  <div class="sharing">
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(get_the_ID()); ?>" data-lang="en" data-related="anywhereTheJavascriptAPI">Tweet</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								
									<!-- Facebook share button Start -->
									<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo get_permalink(get_the_ID());?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									<!-- Facebook share button End -->
								
									<div class="g-plusone" data-href="<?php the_permalink(get_the_ID()); ?>" data-annotation="none" data-size="medium"></div>
									<script type="text/javascript">
									  window.___gcfg = {parsetags: 'onload'};
									  (function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script>
								</div>
							<?php } ?>
					<!-- AddThis Button END -->
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="row-fluid">
				<div class="ho_title_box">
					<h1><?php echo $page_title; ?></h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End Header -->
	
	<!-- Start Content -->
	<div id="ho_content">
		<div class="container">
			<div class="row-fluid">
				<div class="ho_contentin">
					<div class="span8">
						<div class="ho_box">
							<div class="ho_vedio"  style="text-align:center; margin:0 auto;">
								<?php echo apply_filters('the_content', $video); ?>
								
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="ho_right">
							<h3><?php echo $sidebar_title; ?></h3>							
							<ul>
								<li><i class="icon-folder-open"></i> Title: <?php echo $title; ?></li>
								<li><i class="icon-anchor"></i> Url: <a href="<?php echo $URL; ?>"><?php echo $URL; ?></a></li>
								<li><i class="icon-calendar"></i> Date: <?php if(isset($_GET['schedule'])){ $new_date=explode('_a_b_',$_GET['schedule']) ; 
								echo implode("/",explode("-",$new_date[0]));
								}else{ echo $date; } ?></li>
								<li><i class="icon-time"></i> Time: <?php if(isset($_GET['schedule'])){ $new_time=explode('_a_b_',$_GET['schedule']) ; 
								echo $new_time[1];
								}else{ echo $time; } ?></li>
							</ul>
							<?php
						 $hangout_time = get_post_meta($post->ID,"hangout_timezone",true); 
						 if(get_post_meta($post->ID,"hangout_type",true)=='Record_hangout'){
							$email_id=explode('_a_b_',$_GET['schedule']) ;
							$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 						 
					 
						 $totalres = $wpdb->get_var('SELECT hangout_time  FROM '. $subscriber_table .' where g_event_id="'.$post->ID.'" and email="'.$email_id[2].'"');
						 $hangout_time= $totalres;
						 $timedata = explode(" ", $hangout_time);
						$daymonth=explode('/',$timedata[0]);
						$timezone = $daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2]." ".$timedata[1]." ".$timedata[2]." GMT ".$timedata[3];
						 }
						 
						$enddatearr = explode(" ",$hangout_time);
						$endate = explode("/",$enddatearr[0]);
						
						
						
						$hanogut_timezone = 	get_post_meta($post->ID,'hangout_timezone',true);
						 if(get_post_meta($post->ID,"hangout_type",true)=='Record_hangout'){
							$email_id=explode('_a_b_',$_GET['schedule']) ;
							
							$city=$email_id[3];
							$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 						 
					 
						 $totalres = $wpdb->get_var('SELECT hangout_time  FROM '. $subscriber_table .' where g_event_id="'.$post->ID.'" and email="'.$email_id[2].'"');
						 $hanogut_timezone= $totalres;
						 }
						$h_event_time	=	explode('+',$hanogut_timezone);
						if(count($h_event_time) > 1)
						{
							$hanogut_event_timezone	=	$h_event_time[0];
						}
						else
						{
							$h_event_time	=	explode('-',$hanogut_timezone);
							$hanogut_event_timezone	=	$h_event_time[0];
						}

						$hangout_event_date	=	date('Ymd',strtotime($hanogut_event_timezone));
						$hangout_event_time	=	date('Hi',strtotime($hanogut_event_timezone));
						$tym_zon	=	get_post_meta($post->ID,"hangout_time_zone",true);
						 if(get_post_meta($post->ID,"hangout_type",true)=='Record_hangout'){
						 $tym_zon=$city;
						 }
						 $tz = get_city_id($tym_zon);


						$link = "http://www.timeanddate.com/scripts/ics.php?type=utc&p1=".$tz."&iso=".$hangout_event_date."T".$hangout_event_time."&msg=".$hangout_title.": URL=".get_permalink() ;
						
						$enddatearr = explode(" ",$hangout_time);
						$endate = explode("/",$enddatearr[0]);
						
						$enmin = explode(":",$enddatearr[1]);
						//print_r($endate);
						if($enddatearr[2]=="am"){
							if($enmin[0]==12){
							$hour = 0;
							} else {
							$hour = $enmin[0];
							}
							$min = $enmin[1];
						} else { 
							if($enmin[0]==12){
								$hour = 12;
							} else{
							$hour = $enmin[0]+12;
							}
							$min = $enmin[1];
						}

						
						if(substr($enddatearr[3],0,1)=='-'){
							$timez = explode(":",substr($enddatearr[3],1));
							$addtime = $timez[0];
							$addmin = $timez[1];
							$time = strtotime($endate[2].'-'.$endate[0].'-'.$endate[1].' '.$hour.':'.$min);
							$minustr ='';
							
							$exacttime = strtotime("+".$addtime." hours", $time);
							$mnt = date("m",$exacttime);
							$date = date("d",$exacttime);
							$year = date("Y",$exacttime);
							$hour = date("h",$exacttime);
							$min = date("i",$exacttime);
						} else if(substr($enddatearr[3],0,1)=='+'){
								$timez = explode(":",substr($enddatearr[3],1));
								$addtime = $timez[0];
								$addmin = $timez[1];
								$time = strtotime($endate[2].'-'.$endate[0].'-'.$endate[1].' '.$hour.':'.$min);
								$minustr ='';
								$exacttime = strtotime("-".$addtime." hours", $time);
								if($addmin>0){
									$exacttime = strtotime("-".$addmin." minutes", $exacttime);
								}
								$mnt = date("m",$exacttime);
								$date = date("d",$exacttime);
								$year = date("Y",$exacttime);
								$hour = date("H",$exacttime);
								$min = date("i",$exacttime);
							} else {
								$mnt = $endate[0];
								$date = $endate[1];
								$year = $endate[2];
							}


							if(strlen($hour)==1){$hour='0'.$hour;}
							if(strlen($min)==1){$min='0'.$min;}
						
						//if($enddatearr[3])

						

						    $startDateTime = $year.$mnt.$date."T".$hour."".$min."00Z";
							$endDateTime = $year.$mnt.$date."T".$hour."".$min."00Z";

						?>
						<div class="ho_pre_lonch">
								<h4><?php echo $timezone; ?></h4>
								<ul class="pre">
									<li><a href="<?php echo $link; ?>"><img src="<?php echo plugin_dir_url(__FILE__);?>images/calender_icon.png"><span>Add To your<br /> iCal Calendar</span></a></li>
									<li><a target="_blank" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo $hangout_title; ?>&dates=<?php echo $startDateTime; ?>/<?php echo $endDateTime; ?>&details=<?php echo $hangout_title; ?>&location=<?php echo $post->guid; ?>&trp=true&sprop=<?php echo bloginfo('site_url');?>&sprop=name:<?php echo get_permalink(); ?>"><img src="<?php echo plugin_dir_url(__FILE__);?>images/go_cal.png"><span>Add To your<br /> Google Calender</span></a></li>
									<li><a href="<?php echo $link; ?>"><img src="<?php echo plugin_dir_url(__FILE__);?>images/quick_cal.png"><span>Add To your<br /> Outlook Calendar</span></a></li>
								</ul>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<?php

			if(get_post_meta($post->ID,"show_thanks_page_video",true)=='1') { echo do_shortcode('[ghangout_timer]'); }?>
		</div>
	</div>
	<!-- End Content -->
	</div>
	<!-- Start Footer -->
	<div id="ho_footer">
		<div class="container">
			<div class="row-fluid">
				<div class="ho_copy">
						<?php 
						$attribution_link = get_option('attribution_link');
						if($attribution_link=='1'){
							
							if(get_option('hangout_affiliate_text')==''){
								$hangout_affiliate_text = 'Powered By RunClick';
							}else{
								$hangout_affiliate_text=get_option('hangout_affiliate_text');
							}
							$link = get_option('hangout_youtube_affiliate_link');
							if(get_option('hangout_youtube_affiliate_link')==''){
								$link = 'http://runclick.com';
							}
							echo '<a href="'.$link.'" target="_blank">'.$hangout_affiliate_text.'</a>';
						}
						?> 
				</div>		
			</div>
		</div>
	</div>
	<!-- End Footer -->
	
	<?php 
	$chat_reg_off_thakyou = get_post_meta($post->ID,"thanks_page_chat",true);
	if($chat_reg_off_thakyou	== '1'){ ?>
	<?php wp_google_hangout();?>
	<?php } ?>
</body>
</html>
