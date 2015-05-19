<?php 
function fatch_youtube_key($url)
{
$url_part=explode('?',$url);
if(count($url_part)>1){
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
return $my_array_of_vars['v'];
}else{
$url_part=explode('/',$url);
 $part_count=count($url_part);
$url_key= $url_part[$part_count-1];
return $url_key;
}

}

?>