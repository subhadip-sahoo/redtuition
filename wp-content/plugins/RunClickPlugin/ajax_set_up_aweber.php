<?php
require_once('aweber_api/aweber_api.php'); 
 $auth_code=$_REQUEST['auth_code'];

$consumerKey    = ''; 
$consumerSecret = ''; 
$accessKey      = ''; 
$accessSecret   = ''; 
$account_id     = ''; 
$credentials = AWeberAPI::getDataFromAweberID($auth_code);
list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $credentials;

$aweber = new AWeberAPI($consumerKey, $consumerSecret);

try {
    $account = $aweber->getAccount($accessKey, $accessSecret);
	
	
	display_available_lists($account,$consumerKey, $consumerSecret, $accessKey, $accessSecret);

}catch(AWeberAPIException $exc) {
    print "<h3>AWeberAPIException:</h3>";
    print " <li> Type: $exc->type              <br>";
    print " <li> Msg : $exc->message           <br>";
    print " <li> Docs: $exc->documentation_url <br>";
    print "<hr>";
    exit(1);
}

function display_available_lists($account,$consumerKey, $consumerSecret, $accessKey, $accessSecret){
   
    $listURL ="/accounts/{$account->id}/lists/"; 
    $lists = $account->loadFromUrl($listURL);
	$hangout_Aweber_access_Secret=$accessSecret;
$hangout_Aweber_consumer_Secret=$consumerSecret;
$hangout_Aweber_consumer_Key=$consumerKey;
$hangout_Aweber_api_key=$accessKey;
	$hangout_Aweber_account_id = $account->id;
	?>
	<div class="row-fluid-outer">
	<div class="row-fluid">
										
		<div class="span4">
			<strong>Autoresponder Access Key </strong>
		</div>
		<div class="span8">
			<input type="text" class="longinput" name="hangout_Aweber_api_key" id="hangout_Aweber_api_key" value="<?php echo $hangout_Aweber_api_key; ?>" /></span>
		</div>

	</div>
	</div>
	<div class="row-fluid-outer">
	<div class="row-fluid">
	
		<div class="span4">
			<strong>Autoresponder Consumer Key </strong>
		</div>
		<div class="span8">
			<input type="text" class="longinput" name="hangout_Aweber_consumer_Key" id="hangout_Aweber_consumer_Key" value="<?php echo $hangout_Aweber_consumer_Key; ?>" /></span>
		</div>


	</div>
	</div>
	<div class="row-fluid-outer">
	<div class="row-fluid">
	
		<div class="span4">
			<strong>Autoresponder Consumer Secret </strong>
		</div>
		<div class="span8">
			<input type="text" class="longinput" name="hangout_Aweber_consumer_Secret" value="<?php echo $hangout_Aweber_consumer_Secret; ?>" > </span>
		</div>

	</div>
	</div>
	<div class="row-fluid-outer">
	<div class="row-fluid">
	
		<div class="span4">
			<strong>Autoresponder Access Secret Key </strong>
		</div>
		<div class="span8">
			<input type="text" class="longinput" name="hangout_Aweber_access_Secret" id="hangout_Aweber_access_Secret" value="<?php echo $hangout_Aweber_access_Secret; ?>" /></span>
		</div>

	</div>
	</div>
	<div class="row-fluid-outer">
	<div class="row-fluid">
	
		<div class="span4">
			<strong>Autoresponder Account Id </strong>
		</div>
		<div class="span8">
			<input type="text" class="longinput" name="hangout_Aweber_account_id" id="hangout_Aweber_account_id" value="<?php echo $hangout_Aweber_account_id; ?>" /></span>
		</div>

	</div>
	</div>
	<div class="row-fluid-outer">
	<div class="row-fluid">
	
		<div class="span4">
			<strong>Autoresponder List </strong>
		</div>
		<div class="span8" >
		<select name="hangout_Aweber_list_id" id="hangout_Aweber_list_id">
	<?php 
    foreach($lists->data['entries'] as $list ){
	?>
	
			<option  type="text" class="longinput"  value="<?php echo $list['id'].'%'.$list['name']; ?>" ><?php echo $list['name'];?> </option>
		
	<?php 
        
    }
	?>
	</div>

	</div>
	</div>
	
	<?php 
}
?>