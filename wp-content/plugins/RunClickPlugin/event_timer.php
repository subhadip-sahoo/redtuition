<?php
ini_set('display_errors',0);
global $wpdb;
if(get_post_meta($post->ID, "hangout_public_private", true) == "private"){
return '';
}
$webinar_type=get_post_meta($post->ID,"hangout_type",true);
if($webinar_type=="Record_hangout"){
return '';

}
$youtube_video_size = get_post_meta($post->ID,'youtube_video_size',true);
	$width ='430px';
if($youtube_video_size!=''){
	$widtharr = explode(' x ', $youtube_video_size);
	$width = $widtharr[0].'px';
	$hight = $widtharr[1].'px';
}

$google_hangout_theme = get_post_meta($post->ID,"google_hangout_theme",true);
if($google_hangout_theme!="Default"){
$width="";
$hight="";
}


?>
<style type="text/css">
.player {
	margin: auto;
	padding: 10px;
	width: <?php echo $width;?>;
	hight: <?echo $hight;?>;
	max-width: 900px;
	min-width: 320px;
}
.mediaplayer {
	position: relative;
	height: 0;
	width: 100%;
	padding-bottom: 56.25%;
	/* 16/9 */
}
.mediaplayer video, .mediaplayer .polyfill-video {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
}
</style>
<?php

$hangout_status	=	get_post_meta(get_the_ID(),'current_hangout_status',true);
if(($hangout_status == '2') || ($_GET['live_preview'] == 'true')){

if(get_post_meta(get_the_ID(), "hangout_webinar_auto_play_live", true)==1){
	$auto_play="autoplay";
}else{
	$auto_paly="";
}



$live_hits	=	get_post_meta(get_the_ID(), "ghanghout_live_hits", true);
	$curr_live_hits	=	$live_hits+1;
	update_post_meta(get_the_ID(),'ghanghout_live_hits',$curr_live_hits);	
	

  $hangoutvideourl = get_post_meta($post->ID,'hangout_title', true);
$get_url=fatch_youtube_key($hangoutvideourl);


  $hangoutvideokey = $get_url;

$content1 .= '<div class="row-fluid ss_sh">
				<div class="ho_contentin">
				<div class="ho_vedio">				
				<div id="google_hangout_video_url" style="text-align:center; margin:0 auto;">
					<div class="player">
						<div class="mediaplayer">
							<video poster="http://i1.ytimg.com/vi/'.$hangoutvideokey.'/0.jpg" controls preload="none"  '.$auto_play.'>
								<source src="https://www.youtube.com/watch?v='.$hangoutvideokey.'" />
							</video>
						</div>
					</div>
					</div>
				</div></div></div>
				<!--input type="hidden" id="AWeberFormIn" value="'.$AWeberFormIn.'">
				<input type="hidden" id="AWeberFormOut" value="'.$AWeberFormOut.'">
				
				<input type="hidden" id="BuyButtonIn" value="'.$BuyButtonIn.'">
				<input type="hidden" id="BuyButtonOut" value="'.$BuyButtonOut.'">
				
				<input type="hidden" id="VoteFormIn" value="'.$VoteFormIn.'">
				<input type="hidden" id="VoteFormOut" value="'.$VoteFormOut.'"-->';

 $show_social_button =get_post_meta($post->ID,'show_social_button',true);
if($show_social_button =='1'):
	  $content1 .= '<div class="sharing"><a href="https://twitter.com/share" class="twitter-share-button" data-counturl="'.get_permalink().'">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		
		<iframe src="//www.facebook.com/plugins/like.php?href='.get_permalink().'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
		<g:plusone annotation="none" size="medium" href="'.get_permalink().'"></g:plusone></div><div>&nbsp;<br><br><br></div></div>';
	endif;


} else {


	if(get_post_meta(get_the_ID(), "hangout_webinar_auto_play_event", true)==1){
		$auto_play="autoplay";
	}else{
		$auto_paly="";
	}


$hanogut_timezone = 	get_post_meta($post->ID,'hangout_timezone',true);
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
$enddatearr = explode(" ",$hanogut_timezone);

$endate = explode("/",$enddatearr[0]);
$enmin = explode(":",$enddatearr[1]);

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
	} else {
	$hour = $enmin[0]+12;
	}
	
	$min = $enmin[1];
}

$symbolz =  substr($enddatearr[3],0,1);

$hourz = substr($enddatearr[3],1,2);

$timez = substr($enddatearr[3],4,5);


if($symbolz=='+'){
	
		$end =  mktime($hour-$hourz, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
	
} else {
			$end =  mktime($hour+$hourz, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
}





$startdatearr = explode(" ",$post->post_date);
$stdate = explode("-",$startdatearr[0]);
$stmin = explode(":",$startdatearr[1]);



$end = 	get_post_meta($post->ID,'hangout_mktim_timezone',true);
$now = 	get_post_meta($post->ID,'hangout_mktim_timezone_now',true);
$server_t = 	get_post_meta($post->ID,'hangout_current_time',true);
$cur = mktime();
$diff = $cur - $server_t;
$now = $now + $diff;

$hanogut_timezone = 	get_post_meta($post->ID,'hangout_timezone',true);


$start =  mktime($stmin[0], $stmin[1], $stmin[2], $stdate[1], $stdate[2], $stdate[0]);


$start = $start - 200000;
$timer_type=get_post_meta($post->ID,'timer_type',true);
$tym_zon	=	get_post_meta($post->ID,"hangout_time_zone",true);
$tz = get_city_id($tym_zon);


$hangout_status	=	get_post_meta(get_the_ID(),'current_hangout_status',true);

if($end>$now){
	if('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == get_permalink(get_the_ID()))
	{	
		$event_hits	=	get_post_meta(get_the_ID(), "ghanghout_event_hits", true);
		$curr_event_hit	=	$event_hits+1;
		update_post_meta(get_the_ID(),'ghanghout_event_hits',$curr_event_hit);
		
		// code for Stats
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$stat_result	=	$wpdb->get_results("select * from ".$wpdb->prefix."ghangout_stats where IP='".$ip_addr."' and event='1' and post_id='".get_the_ID()."'");
		if(count($stat_result) <= 0 )
		{
			$wpdb->query("INSERT INTO ".$wpdb->prefix."ghangout_stats Values('','".get_the_ID()."','".$ip_addr."','1','0','0','0')");	
		}
		// code for Stats

	}
	//	$content1 .= '<div id="google_hangout_video_url" style="display:none;">'.$post->post_content.'</div>';
	$timezone=get_post_meta($post->ID, 'hangout_timezone', true);
		
								$timedata = explode(" ", $timezone);
	$daymonth=explode('/',$timedata[0]);
	 $timezone = $daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2]." ".$timedata[1]." ".$timedata[2];
	if($timer_type==2 || $timer_type==3){
	$form ='	<script language="Javascript" type="text/javascript" src="'.plugin_dir_url( __FILE__ ).'js/jquery.lwtCountdown-1.0.js"></script>';
	if($timer_type==2){
	$form .= '<link rel="Stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ).'css/dark.css"></link><div id="ghanout_event_timer">';
	} else {
	$form .= '<link rel="Stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ).'css/main.css"></link><div id="ghanout_event_timer"  >';
	}
		$form	.= '<div class="ho_timer">';
		$form .= '<h2 class="hangout_btn">Your Webinar will begin in:</h2><div class="clear"></div><div id="countdown_dashboard">
			<div class="dash weeks_dash">
				<span class="dash_title">weeks</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash days_dash">
				<span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

		</div>
		

		
		<script language="javascript" type="text/javascript">
			jQuery(document).ready(function($) {
				$("#countdown_dashboard").countDown({
					targetDate: {
						"current_time": '.$now.',
						"end_time": '.$end.'
					}
				});});
		</script>
		';
		
		$form	.=	"<div class='clear'></div><br/ ><p>".$timezone." ".get_post_meta($post->ID,"hangout_time_zone",true)." <a href='http://www.timeanddate.com/worldclock/fixedtime.html?msg=".str_replace(" ","+",get_the_title())."&iso=".$hangout_event_date."T".$hangout_event_time."&p1=".$tz."' target='_blank'>Check Time Zone Here</a></p>";	
		$form	.=	'<div class="clear"></div></div></div>';
		

	} else {
	$form =  '<link rel="Stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ).'css/countdown.css"><script type="text/javascript" src="'. plugin_dir_url( __FILE__ ).'js/countdown.js"></script><script>				
				jQuery(document).ready(function($) {
					HangoutCountDown({
                    secondsColor : "#ff4200",
                    secondsGlow  : "#ab3005",                    
                    minutesColor : "#b51818",
                    minutesGlow  : "#d00707",                    
                    hoursColor   : "#378cff",
                    hoursGlow    : "#0c55a9",                    
                    daysColor    : "#919524",
                    daysGlow     : "#f6ff00",                    
                    startDate   : "'.$start.'",
                    endDate     : "'.$end.'",
                    now         : "'.$now.'",
                    seconds     : "'.date("s").'"
                });
         });</script><div id="ghanout_event_timer"  ><div class="ho_timer"><h2 class="hangout_btn">Your Webinar will begin in:</h2><div class="clear"></div><div id="countdown_dashboard">

            <div class="clock">
                <!-- Days -->
                <div class="clock_days">
                    <div class="bgLayer">
                        <canvas id="canvas_days" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <p class="val">0</p>
                        <p class="type_days">Days</p>
                    </div>
                </div>
				<div class="clock_hours">
                    <div class="bgLayer">
                        <canvas id="canvas_hours" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
						<p class="val">0</p>
                        <p class="type_hours">Hours</p>
                    </div>
                </div>
				<div class="clock_minutes">
                    <div class="bgLayer">
                        <canvas id="canvas_minutes" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <div class="text">
                            <p class="val">0</p>
                            <p class="type_minutes">Minutes</p>
                        </div>
                    </div>
                </div>
				<div class="clock_seconds">
					<div class="bgLayer">
						<canvas id="canvas_seconds" width="100" height="90">
							Your browser does not support the HTML5 canvas tag.
						</canvas>
						<p class="val">0</p>
						<p class="type_seconds">Seconds</p>
					</div>
                </div>
			</div>
		</div>';
	
		$form	.=	"<div class='clear'></div><br/ ><p>".$timezone." ".get_post_meta($post->ID,"hangout_time_zone",true)." <a href='http://www.timeanddate.com/worldclock/fixedtime.html?msg=".str_replace(" ","+",get_the_title())."&iso=".$hangout_event_date."T".$hangout_event_time."&p1=".$tz."' target='_blank'>Check Time Zone Here</a></p>";	
		$form	.=	'<div class="clear"></div></div></div>';
	}
	$content1 .= $form;
} else {
		 
	$live_hits	=	get_post_meta(get_the_ID(), "ghanghout_live_hits", true);
	$curr_live_hits	=	$live_hits+1;
	update_post_meta(get_the_ID(),'ghanghout_live_hits',$curr_live_hits);	
	$youtube_video_size = get_post_meta($post->ID,'youtube_video_size',true);
	$width ='430px';
if($youtube_video_size!=''){
	$widtharr = explode(' x ', $youtube_video_size);
	$width = $widtharr[0].'px';
}
/*$content1 .= '<div class="row-fluid ss_sh">
				<div class="ho_contentin">
				<div class="ho_vedio">				
				<div id="google_hangout_video_url" style="text-align:center; margin:0 auto;">'.$post->post_content;
$content1 .= '</div></div></div>';*/
?>

<?php
if(get_post_meta($post->ID,'show_optin_form',true)==0){
$AWeberFormIn="";
$AWeberFormOut="";
}else{
$AWeberFormIn  = get_post_meta($post->ID,'hangout_aweber_display', true);
$AWeberFormOut = get_post_meta($post->ID,'hangout_aweber_hide', true);
}
if(get_post_meta($post->ID,'show_by_button',true)==0){
$BuyButtonIn="";
$BuyButtonOut="";
}else{
$BuyButtonIn   = get_post_meta($post->ID,'hangout_buybutton_display', true);
$BuyButtonOut  = get_post_meta($post->ID,'hangout_buybutton_hide', true);
}
if(get_post_meta($post->ID,'show_vote_form',true)==0){
$VoteFormIn="";
$VoteFormOut="";
}else{
$VoteFormIn    = get_post_meta($post->ID,'hangout_vote_display', true);
$VoteFormOut   = get_post_meta($post->ID,'hangout_vote_hide', true);
}
$hangoutvideourl = get_post_meta($post->ID,'hangout_title', true);
$get_url=fatch_youtube_key($hangoutvideourl);
// parse_str( parse_url( $hangoutvideourl, PHP_URL_QUERY ), $my_array_of_vars );
// $hangoutvideokey = $my_array_of_vars['v'];
$hangoutvideokey = $get_url;
$content1 .= '<div class="row-fluid ss_sh">
				<div class="ho_contentin">
				<div class="ho_vedio">				
				<div id="google_hangout_video_url" style="text-align:center; margin:0 auto;">
					<div class="player">
						<div class="mediaplayer">
							<video poster="http://i1.ytimg.com/vi/'.$hangoutvideokey.'/0.jpg" controls preload="none" '.$auto_play.' >
								<source src="https://www.youtube.com/watch?v='.$hangoutvideokey.'"/>
							</video>
						</div>
					</div>
					</div>
				</div></div></div>
				<input type="hidden" id="AWeberFormIn" value="'.$AWeberFormIn.'">
				<input type="hidden" id="AWeberFormOut" value="'.$AWeberFormOut.'">
				
				<input type="hidden" id="BuyButtonIn" value="'.$BuyButtonIn.'">
				<input type="hidden" id="BuyButtonOut" value="'.$BuyButtonOut.'">
				
				<input type="hidden" id="VoteFormIn" value="'.$VoteFormIn.'">
				<input type="hidden" id="VoteFormOut" value="'.$VoteFormOut.'">';

$show_social_button =get_post_meta($post->ID,'show_social_button',true);
if($show_social_button =='1'):
	  $content1 .= '<div class="sharing"><a href="https://twitter.com/share" class="twitter-share-button" data-counturl="'.get_permalink().'">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		
		<iframe src="//www.facebook.com/plugins/like.php?href='.get_permalink().'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
		<g:plusone annotation="none" size="medium" href="'.get_permalink().'"></g:plusone></div><div>&nbsp;<br><br><br></div></div>';
	endif;
}

}
return $content1;
