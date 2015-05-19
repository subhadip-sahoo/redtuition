<?php
include('../../../wp-config.php');
// call this function, and pass it the website URL
// It will return a string with the websites source
 
$root = $_SERVER['DOCUMENT_ROOT'];
// create a new curl resource

$url ="https://gdata.youtube.com/feeds/api/users/". get_option('hangout_youtube_user_id'). "/live/events?v=2&alt=json";


$ch = curl_init();
$browser = $_SERVER['HTTP_USER_AGENT'];
$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
$header[] = "Cache-Control: max-age=0";
$header[] = "Connection: keep-alive";
$header[] = "Keep-Alive: 300";
$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
$header[] = "Accept-Language: en-us,en;q=0.5";
$header[] = "Pragma: ";
curl_setopt($ch, CURLOPT_FAILONERROR,true);
curl_setopt($ch, CURLOPT_USERAGENT, $browser);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_AUTOREFERER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); //needed for SSL
curl_setopt($ch, CURLOPT_CAINFO,  plugin_dir_path(__FILE__)."cacert.pem"); //path to file
curl_setopt($ch, CURLOPT_URL, $url);
$content = curl_exec($ch);
$error_no = curl_error($ch);  //display errors under development

curl_close($ch);
$content = json_decode($content);

	if($error_no==''){
		$length = sizeof($content->feed->entry);
		$youturl = $content->feed->entry[$length-1]->content->src;

		$youtubearr = explode("/",$youturl);
		$len = sizeof($youtubearr);
		$youtubestr = explode("?",$youtubearr[$len-1]);
		echo $youtubestr[0];
		//var_dump($content->feed->entry[0]);
		foreach($content->feed->entry[$length-1]->title as $dtitle){
			echo '|--||--'.$dtitle;
		}
	} else {
		echo 'error';
	}

?>