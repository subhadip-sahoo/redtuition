<?php
ini_set('display_errors',0);
//var_dump($post);
$ip_addr = $_SERVER['REMOTE_ADDR'];
//$ip_addr =   '122.176.115.21';
$key	=	"9dcde915a1a065fbaf14165f00fcc0461b8d0a6b43889614e8acdb8343e2cf15";
//$ip		=	'122.176.115.21';//$_POST['address'];
$url 	= 	"http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip_addr&format=json";
//$url	=	'http://www.geoplugin.net/php.gp?ip='.$ip_addr;
//$geoplugin = unserialize( file_get_contents($url) );
$geoplugin =   	json_decode(file_get_contents($url) , true); 
if($geoplugin == "")
{
	$ch = curl_init();
	$timeout = 10;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$geoplugin = unserialize(curl_exec($ch));
	curl_close($ch);
}
//$lat = $geoplugin['geoplugin_latitude'];
//$long = $geoplugin['geoplugin_longitude'];
$lat = $geoplugin['latitude'];
$long = $geoplugin['longitude'];

$geozone =  file_get_contents('http://www.earthtools.org/timezone/'.$lat.'/'.$long) ;
if($geozone == "")
{
	$ch = curl_init();
	$timeout = 10;
	curl_setopt($ch,CURLOPT_URL,'http://www.earthtools.org/timezone/'.$lat.'/'.$long);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$geozone = curl_exec($ch);
	curl_close($ch);
}
$xml = simplexml_load_string($geozone);

$form ='';
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
//echo $now;
//echo '<br>';


$hangout_timezone_end_date = 	get_post_meta($post->ID,'hangout_timezone_end_date',true);
$enddatearr = explode(" ",$hangout_timezone_end_date);
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


$hangout_timezone_start_date = 	get_post_meta($post->ID,'hangout_timezone_start_date',true);
$enddatearr = explode(" ",$hangout_timezone_start_date);
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
	$sstart =  mktime($hour-$hourz, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
} else {
	 $sstart =  mktime($hour+$hourz, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
}
//echo  $end;




$startdatearr = explode(" ",$post->post_date);
$stdate = explode("-",$startdatearr[0]);
$stmin = explode(":",$startdatearr[1]);



$start =  mktime($stmin[0], $stmin[1], $stmin[2], $stdate[1], $stdate[2], $stdate[0]);


$start = $start - 200000;
$timer_type=get_post_meta($post->ID,'replay_timer_type',true);
if($now>=$sstart && $now<=$end){
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
		</script>';

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
         });</script><div class="ho_timer"><div id="ghanout_event_timer" ><h2 class="hangout_btn">Your Webinar will begin in:</h2><div class="clear"></div>

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
                </div><div class="clock_hours">
                    <div class="bgLayer">
                        <canvas id="canvas_hours" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
						<p class="val">0</p>
                        <p class="type_hours">Hours</p>
                    </div>
                </div><div class="clock_minutes">
                    <div class="bgLayer">
                        <canvas id="canvas_minutes" width="90" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <div class="text">
                            <p class="val">0</p>
                            <p class="type_minutes">Minutes</p>
                        </div>
                    </div>
                </div><div class="clock_seconds">
                    <div class="bgLayer">
                        <canvas id="canvas_seconds" width="100" height="90">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <p class="val">0</p>
                        <p class="type_seconds">Seconds</p>
                    </div>
                </div></div></div>';
	}
	$form	.=	'<div class="clear"></div></div></div>';	
	$content1 .= $form;
}
return $content1;
