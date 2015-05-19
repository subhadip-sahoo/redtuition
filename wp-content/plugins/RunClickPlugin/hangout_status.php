<?php

if(isset($_POST))
{
$status	=	$_POST['status'];
$ID	=	$_POST['ID'];
update_post_meta($ID,'current_hangout_status',$status);
echo "ok";
}
else
{
	echo "not ok";
}
?>
