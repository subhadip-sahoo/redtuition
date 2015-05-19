<?php
require_once('../../../wp-config.php');
require_once('google_hangout_plugin_connector.php');
global $wpdb;
$timezone = $_POST['g_timezone'];
$timeapidata = timeapi_servicecall('timeservice', array('placeid'=>$timezone));

$timeapidate = $timeapidata->datetime;
echo $timeapizone = $timeapidata->timezone->offset;
echo "<br>";

$now =  mktime($timeapidate->hour, $timeapidate->minute, $timeapidate->second, $timeapidate->month, $timeapidate->day, $timeapidate->year);

 $hanogut_timezone = $_POST["timeval"];


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


$end =  mktime($hour, $min, 0, $endate[0], $endate[1], $endate[2]);


$nowd = date('Y-m-d H:i:s',$now);
$endd = date('Y-m-d H:i:s',$end);

$diff = abs(strtotime($endd) - strtotime($nowd)); 

$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 



$return_str ='';
if($years>0)$return_str .= $years.' Year ';
if($months>0)$return_str .= $months.' months ';
if($days>0)$return_str .= $days.' days ';
if($hours>0)$return_str .= $hours.' hours ';
$return_str .= $minuts.' minutes ';
echo $return_str;
exit;
/*
$arr = explode("]",$_POST['g_timezone']);
	$arr1 = explode("[UTC",$arr[0]);
	if($arr1[1]==''){
		$timezo = '+0000'; 
	} else {
		$timearr = explode(" ", $arr1[1]);
		if(sizeof($timearr)==3){
			$timearr1 = explode(":",$timearr[2]);
			if(strlen($timearr1[0])<2){
				$hourma = '0'.$timearr1[0];
			} else { $hourma = $timearr1[0]; }
			if(sizeof($timearr1)==2){
				if($timearr[1]==''){ $sym ='+'; } else { $sym = $timearr[1];} 
				$timezo = $sym.$hourma.$timearr1[1];	
			} else {
				if($timearr[1]==''){ $sym ='+'; } else { $sym = $timearr[1];} 
				$timezo = $sym.$hourma.'00';	
			}
		} else {
			$timearr1 = explode(":",$timearr[3]);
			if(strlen($timearr1[0])<2){
				$hourma = '0'.$timearr1[0];
			} else { $hourma = $timearr1[0]; }
			if(sizeof($timearr1)==2){
				if($timearr[1]==''){ $sym ='+'; } else { $sym = $timearr[1];} 
				$timezo = $sym.$hourma.$timearr1[1];	
			} else {
				if($timearr[1]==''){ $sym ='+'; } else { $sym = $timearr[1];} 
				$timezo = $sym.$hourma.'00';	
			}
		}
	}
 $hanogut_timezone = $_POST["timeval"] .' ' .$timezo;


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



 $ip_addr =   '122.176.115.21';
//$ip		=	'122.176.115.21';//$_POST['address'];
//$ip_addr = $_SERVER['REMOTE_ADDR'];
$key	 =	"9dcde915a1a065fbaf14165f00fcc0461b8d0a6b43889614e8acdb8343e2cf15";
$url 	 = 	"http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip_addr&format=json";
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

$nowarr = explode(" ",$xml->utctime);
$nowdate = explode("-",$nowarr[0]);
$nowmin = explode(":",$nowarr[1]);
$now =  mktime($nowmin[0], $nowmin[1], $nowmin[2], $nowdate[1], $nowdate[2], $nowdate[0]);
$nowd = date('Y-m-d H:i:s',$now);
$endd = date('Y-m-d H:i:s',$end);

$diff = abs(strtotime($endd) - strtotime($nowd)); 

$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 



$return_str ='';
if($years>0)$return_str .= $years.' Year ';
if($months>0)$return_str .= $months.' months ';
if($days>0)$return_str .= $days.' days ';
if($hours>0)$return_str .= $hours.' hours ';
$return_str .= $minuts.' minutes ';
echo $return_str;*/
?>