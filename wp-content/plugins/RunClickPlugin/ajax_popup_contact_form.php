<?php 
if(file_exists('../../../wp-config.php'))
include('../../../wp-config.php');
global $wpdb;

$g_event_id = $_POST['g_hangout_id'];
$first_name=$_REQUEST['event_reg_name'];
$email_address=$_REQUEST['event_reg_email'];
$last_name="";
$siteurl = get_permalink($g_event_id);
 $hangout_registration_system = get_post_meta($g_event_id,'hangout_registration_system',true); $hangout_make_now = get_post_meta($g_event_id,'hangout_make_now',true);
 $list_id=get_post_meta($g_event_id,'hangout_list_id',true);

$table = $wpdb->prefix."google_hangout_subscriber";
$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$table ." where email='".$email_address."' and g_event_id ='".$g_event_id."'");

if($user_count<1){

$sql = "INSERT INTO $table(`g_event_id`, `name`, `email`, `auto_reminder`, `24_hour`, `1_hour`, `5_min`,`joining_date`,`organization`,`hangout_date`,`hangout_time`,`reminder_time`) VALUES ('$g_event_id', '$first_name', '$email_address', '', '$hour_24', '$hour_1', '$min_5', CURRENT_TIMESTAMP,'','','','')";

$wpdb->query($sql);

$post_data = get_post($g_event_id); 








$sitename = get_bloginfo('name');



}else{
echo 'You are already subscribed';
}
if($hangout_registration_system=='ImnicaMail'){
$ch		=	curl_init('http://www.imnicamail.com/v4/api.php');
$list_id=get_post_meta($g_event_id,'hangout_ImnicaMail_list_id',true);		
curl_setopt($ch,CURLOPT_POST,true);
$var='Command=Subscriber.Subscribe&ResponseFormat=JSON&JSONPCallBack=true&ListID='.$list_id.'&EmailAddress='.$email_address.'&IPAddress='.$_SERVER["REMOTE_ADDR"].'';
curl_setopt($ch,CURLOPT_POSTFIELDS,$var);



curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

$output	=	curl_exec($ch);


}
if($hangout_registration_system=='Mailchimp'){
require_once('MCAPI.class.php');  // same directory as store-address.php
 $list_id=get_post_meta($g_event_id,'hangout_Mailchimp_list_id',true);	
 $api_key=get_post_meta($g_event_id,'hangout_Mailchimp_api_key',true);	
    // grab an API Key from http://admin.mailchimp.com/account/api/
    $api = new MCAPI($api_key);

    $merge_vars = Array( 
        'EMAIL' => $email_address,
        'FNAME' => $first_name, 
        'LNAME' => $last_name
        
    );

    // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
    // Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
   

    $api->listSubscribe($list_id, $email_address, $merge_vars ); 

}
if($hangout_registration_system=='Icontact'){
require_once('iContactApi.php');
$appid=get_post_meta($g_event_id,'hangout_Icontact_app_id',true);
$user_name=get_post_meta($g_event_id,'hangout_Icontact_user_name',true);
$user_pass=get_post_meta($g_event_id,'hangout_Icontact_user_password',true);
$Icontact_list_id=get_post_meta($g_event_id,'hangout_Icontact_list_id',true);
iContactApi::getInstance()->setConfig(array(
        'appId' => $appid,
        'apiPassword' => $user_pass,
        'apiUsername' => $user_name
));
$oiContact = iContactApi::getInstance();
 $add_contact	=	$oiContact->addContact($email_address, null, null, $first_name, $last_name, null, null, null, null, null, null,null, null, null);
 
 $user_id	=	$add_contact->contactId;
        $oiContact->subscribeContactToList($user_id, $Icontact_list_id, 'normal');
		
}
if($hangout_registration_system=='Sendreach'){
require_once('sendreachclasses.php');
$api_vars['key'] =get_post_meta($g_event_id,'hangout_Sendreach_api_key',true);
$api_vars['secret'] = get_post_meta($g_event_id,'hangout_Sendreach_secret_key',true);
$api_vars['userid'] =get_post_meta($g_event_id,'hangout_Sendreach_user_id',true);
$list_id=get_post_meta($g_event_id,'hangout_Sendreach_list_id',true);
$client_ip=$_SERVER["REMOTE_ADDR"];
$sendreach = new api();
$sendreach->subscriber_add($list_id,$first_name,$last_name,$email_address,$client_ip);


}
if($hangout_registration_system=='GetResponce'){
require_once('jsonRPCClient.php');
  $api_key = get_post_meta($g_event_id,'hangout_GetResponce_api_key',true);
  $campaign_name=get_post_meta($g_event_id,'hangout_GetResponce_campaign_name',true);
$api_url = 'http://api2.getresponse.com';
$client = new jsonRPCClient($api_url);
$campaigns = $client->get_campaigns(
        $api_key,
    array (
            # find by name literally
        'name' => array ( 'EQUALS' => $campaign_name )
        )
);

$CAMPAIGN_ID = array_pop(array_keys($campaigns));
$result = $client->add_contact(
        $api_key,
        array (
            # identifier of 'test' campaign
                'campaign' => $CAMPAIGN_ID,
            
                # basic info
                'name' => $first_name.' '.$last_name,
            'email' => $email_address,

                # custom fields
                'customs' => array(
         array(
         'name' => 'Organization'  ,
         'content' => $organization
         )
         )
        )
);


}


if($hangout_registration_system=='Aweber'){
require_once('aweber_api/aweber_api.php');

$consumerKey    = get_post_meta($g_event_id,'hangout_Aweber_consumer_Key',true); 
$consumerSecret = get_post_meta($g_event_id,'hangout_Aweber_consumer_Secret',true); 
$accessKey      = get_post_meta($g_event_id,'hangout_Aweber_api_key',true);
$accessSecret   = get_post_meta($g_event_id,'hangout_Aweber_access_Secret',true);
$account_id     = get_post_meta($g_event_id,'hangout_Aweber_account_id',true);
$list_id        = get_post_meta($g_event_id,'hangout_Aweber_list_id',true); 
$client_ip=$_SERVER["REMOTE_ADDR"];
$aweber = new AWeberAPI($consumerKey, $consumerSecret);


    $account = $aweber->getAccount($accessKey, $accessSecret);
    $listURL = "/accounts/{$account_id}/lists/{$list_id}";
    $list = $account->loadFromUrl($listURL);
	
    # create a subscriber
    $params = array(
        'email' => $email_address,
        'ip_address' => $client_ip,
        'ad_tracking' => 'client_lib_example',
        'misc_notes' => 'my cool app',
        'name' =>  $first_name.' '.$last_name
       
       
    );
    $subscribers = $list->subscribers;
    $new_subscriber = $subscribers->create($params);
	
	 

}
if($hangout_registration_system=='Sendreach'){

$post_data = array(
        'name' => $first_name.' '.$last_name,
        'email' => $email_address
		);
$list_id        = get_post_meta($g_event_id,'hangout_Sendreach_list_id',true);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://register.sendreach.com/forms/?listid=$list_id");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec ($ch);

curl_close ($ch);

}
if($hangout_registration_system=='InfusionSoft'){
$app_name = get_post_meta($g_event_id,'hangout_InfusionSoft_app',true);
$api_key = get_post_meta($g_event_id,'hangout_InfusionSoft_list_id',true);

require_once("infusionsoft_src/isdk.php");

$app = new iSDK;


$app->cfgCon($app_name, $api_key);
$conDat = array('FirstName' => $first_name,
                'lastName'  => $last_name,
                'Email'     => $email_address);
				

 $conID = $app->addCon($conDat);


}
?>