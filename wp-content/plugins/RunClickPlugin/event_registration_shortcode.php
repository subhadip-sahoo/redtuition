<?php

$post = get_post($id);

//var_dump($post);
$ip_addr = $_SERVER['REMOTE_ADDR'];
//$ip_addr =   '122.176.115.21';
$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_addr) );
$lat = $geoplugin['geoplugin_latitude'];
$long = $geoplugin['geoplugin_longitude'];
$geozone =  file_get_contents('http://www.earthtools.org/timezone/'.$lat.'/'.$long) ;
$xml = simplexml_load_string($geozone);


$nowarr = explode(" ",$xml->isotime);
$symbolz =  substr($nowarr[2],0,1);
$hourz = substr($nowarr[2],1,2);
$timez = substr($nowarr[2],3,5);
$nowdate = explode("-",$nowarr[0]);
$nowmin = explode(":",$nowarr[1]);
if($symbolz=="+"){
	$now =  mktime($nowmin[0]-$hourz, $nowmin[1]-$timez, $nowmin[2], $nowdate[1], $nowdate[2], $nowdate[0]);
} else {
	$now =  mktime($nowmin[0]+$hourz, $nowmin[1]+$timez, $nowmin[2], $nowdate[1], $nowdate[2], $nowdate[0]);
}


$hanogut_timezone = 	get_post_meta($post->ID,'hangout_timezone',true);
$enddatearr = explode(" ",$hanogut_timezone);
$endate = explode("/",$enddatearr[0]);
$enmin = explode(":",$enddatearr[1]);
if($enddatearr[2]=="am"){ 
	$hour = $enmin[0];
	$min = $enmin[1];
} else { 
	$hour = $enmin[0]+12;
	$min = $enmin[1];
}

$symbolz =  substr($enddatearr[3],0,1);

$hourz = substr($enddatearr[3],1,2);

$timez = substr($enddatearr[3],3,5);

if($symbolz=='+'){
	$end =  mktime($hour-$hourz, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
} else {
	 $end =  mktime($hour+$hourz, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
}





$startdatearr = explode(" ",$post->post_date);
$stdate = explode("-",$startdatearr[0]);
$stmin = explode(":",$startdatearr[1]);



$start =  mktime($stmin[0], $stmin[1], $stmin[2], $stdate[1], $stdate[2], $stdate[0]);


$start = $start - 200000;
$timer_type=get_post_meta($post->ID,'timer_type',true);$timer_type=get_post_meta($post->ID,'timer_type',true);
if($end>$now){
	$content .= '<div id="google_hangout_video_url" style="display:none;">'.$post->post_content.'</div>';
	if($timer_type==2 || $timer_type==3){
	$form ='	<script language="Javascript" type="text/javascript" src="'.plugin_dir_url( __FILE__ ).'js/jquery.lwtCountdown-1.0.js"></script>';
	if($timer_type==2){
	$form .= '<link rel="Stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ).'css/dark.css"></link>';
	} else {
	$form .= '<link rel="Stylesheet" type="text/css" href="'.plugin_dir_url( __FILE__ ).'css/main.css"></link>';
	}
		$form .= '<div id="ghanout_event_timer" ><h4>Your Webinar will begin in:</h4><br><div id="countdown_dashboard">
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
			$(document).ready(function() {
				$("#countdown_dashboard").countDown({
					targetDate: {
						"current_time": '.$now.',
						"end_time": '.$end.'
					}
				});
				
				
			});
		</script>';

	} else {
	$form =  '<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ).'js/countdown.js"></script><script>
				$(document).ready(function(){
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
         });</script><div id="ghanout_event_timer" ><h4>Your Webinar will begin in:</h4>

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
                <!-- Days -->
                <!-- Hours -->
                <div class="clock_hours">
                    <div class="bgLayer">
                        <canvas id="canvas_hours" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>

                        <p class="val">0</p>
                        <p class="type_hours">Hours</p>
                    </div>
                </div>
                <!-- Hours -->
                <!-- Minutes -->
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
                <!-- Minutes -->
                <!-- Seconds -->
                <div class="clock_seconds">
                    <div class="bgLayer">
                        <canvas id="canvas_seconds" width="100" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <p class="val">0</p>
                        <p class="type_seconds">Seconds</p>
                    </div>
                </div>
                <!-- Seconds -->
            </div></div>';
	}
} else {
	$content .= '<div id="google_hangout_video_url" style="">'.$post->post_content.'</div>';
}

$hangout_registration = 	get_post_meta($post->ID,'hangout_registration',true);
$hangout_send_notifications = 	get_post_meta($post->ID,'hangout_send_notifications',true);
$reminder_time = 	explode(",",get_post_meta($post->ID,'reminder_time',true));

	
$hangout_registration_system = get_post_meta($post->ID,'hangout_registration_system',true);
	


	$form .= '<div id="g_hangout_event_button"> Register now to attend.';
	if($hangout_registration_system==1){
	
	
	
	$form .= '<div id="ghangout_event_form"><form id="g_hangout_reg_form" method="post" name="hangout_reg_form"><p><label> Name </label><span><input type="text" name="event_reg_name" id="event_reg_name" /></span></p>
	<p><label> Email </label><span><input type="text" name="event_reg_email" id="event_reg_email"/></span></p>
	<p>';
	$form .= '<p><label> Time </label><span><input type="text" name="event_reg_time" id="event_reg_time" /></span></p>
	<p><label> Date </label><span><input type="text" name="event_reg_date" id="event_reg_date"/></span></p>
	<p>';
	$form .= '<p> <input type="button" name="additonal_email"  id="additional_email"  value="Add additional email" /><?p>
	<p id="additional_email_p" style="display:none;"> <label> Additional Email id </label><span> <input type="text" name="event_reg_email_add" id="event_reg_email_add" /></span></p>
	<p>
	<input type="hidden" name="g_hangout_id" value="'.$post->ID.'" >
	<input type="submit" id="g_hangout_submit_form" value="Register Now"></p>
	
	</form>
	';
	} elseif($hangout_registration_system==2){
		 $aweber_name =get_post_meta($post->ID,'hangout_amber_name_field',true);
		 $aweber_email =get_post_meta($post->ID,'hangout_amber_name_email',true);
	
		$form .= '<div id="Aweber_hangout_form">';
		$form .= get_post_meta($post->ID,'hangout_amber_from',true);
		$form .='<input type="hidden" id="g_hangout_id" value="'.$post->ID.'" ><input type="hidden" id="hangout_name_field" value="'.$aweber_name.'"><input type="hidden" id="hangout_email_field" value="'.$aweber_email.'">';
		$form .= '</div>';

	} elseif($hangout_registration_system==3){
		
		$getresponse_name =get_post_meta($post->ID,'hangout_getresponse_name_field',true);
		$getresponse_email =get_post_meta($post->ID,'hangout_getresponse_name_email',true);

		$form .= '<div id="Aweber_hangout_form">';
		$form .= get_post_meta($post->ID,'hangout_getresponse_from',true);
		$form .='<input type="hidden" id="g_hangout_id" value="'.$post->ID.'" ><input type="hidden" id="hangout_name_field" value="'.$getresponse_name.'"><input type="hidden" id="hangout_email_field" value="'.$getresponse_email.'">';
		$form .= '</div>';

	}
	$form .= '</div>';


$attribution_link = get_option('attribution_link');
if($attribution_link=='1'){
$link = get_option('hangout_youtube_affiliate_link');
if(get_option('hangout_youtube_affiliate_link')==''){
$link = 'http://runclick.com';
}
} else {
$link ='';
}
	$content .=  $form.'<div style="float:right;"><small><a href="'.$link.'" target="_blank">Powered By runclick.com </a></small></div>';
	return $content;
	//global $post;
	//var_dump($post);



?>