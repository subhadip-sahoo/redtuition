<?php
$key	=	"9dcde915a1a065fbaf14165f00fcc0461b8d0a6b43889614e8acdb8343e2cf15";
$ip		=	'122.176.115.21';//$_POST['address'];
$url 	= 	"http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip&format=json";
$cont 	= 	file_get_contents($url);
$data 	= 	json_decode($cont , true);
if(strlen($data['latitude']))
{
    $result = array(
        'ip' => $data['ipAddress'] ,
        'country_code' => $data['countryCode'] ,
        'country_name' => $data['countryName'] ,
        'region_name' => $data['regionName'] ,
        'city' => $data['cityName'] ,
        'zip_code' => $data['zipCode'] ,
        'latitude' => $data['latitude'] ,
        'longitude' => $data['longitude'] ,
        'time_zone' => $data['timeZone'] ,
    );
}
echo "<pre>"; print_r($result); 
$lat = $data['latitude'];
$long = $data['longitude'];

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
print_r($xml);
?>

<!-- 
http://ws.geonames.org/timezone?lat=28.6667&lng=77.433296
-->