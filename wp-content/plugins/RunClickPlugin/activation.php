<?php
/*
Code by Varun Srivastava
on date: 21/2/12
Description: This file insert activation ID and Payment ID into option table.
*/
	if( get_option('umo_hangout_updated') )
	{
		$directory = plugin_dir_path(__FILE__);
		if( is_writable($directory.'google_hangout_plugin.php') )
		{
			$fh			=	file_get_contents($directory.'google_hangout_plugin.php');

			$lines		=	explode("\n",$fh);
			
			$lines[6]  	= 	'Version: '. get_option('umo_hangout_version');
			
			$data		=	implode("\n",$lines);

			if( file_put_contents($directory.'google_hangout_plugin.php',$data) )
			{
				update_option('umo_hangout_updated',0);
			}
		}
	}
	$message = '';
	if( isset($_GET['msg']) )
	{
		$message = '<div class="updated"><p>'.$_GET['msg'].'</p></div>';
	}
	
	if(isset($_POST['activate']) )
	{           
		$paymenyt_id 	= $_POST['wp_payment_id'];
		
		$activation_id 	= $_POST['wp_activation_id'];
		
			if($paymenyt_id == "")
			{
				$message ="<div class='error'>Error:Please Enter Payment ID.</div>";	//Display error message if payment ID is blank.
			}
			elseif($activation_id == "")
			{
				$message ="<div class='error'>Error:Please Enter Activation ID.</div>";	//Display error message if activation ID is blank.
			}
			else			//update Data if both fields are active.
			{
				update_option('umo_hangout_payment_id',$paymenyt_id);
				
				update_option('umo_hangout_activation_key',$activation_id);
				
//code to check new activation credentials
				$payment_id			=	get_option('umo_hangout_payment_id');
				
				$activation_key		=	get_option('umo_hangout_activation_key');

				$requesturl			=	get_option('umo_hangout_licenceurl');
				
				if( preg_match('/^(http:\/\/|www.|https:\/\/)+[a-z0-9\-]/',$requesturl,$matches) )
				{
					if($requesturl && $payment_id && $activation_key)
					{
						$datastring			=	"client_licence=$activation_key&client_url=".site_url()."&email=$payment_id";
						
						$requesturl			.=	'wp-content/plugins/ghangout_main/licenc_test.php';
						
						$result				=	umo_hangout_requestServer($requesturl,$datastring);
						
						$result['result'] = (array) $result['result'];
						
						if( $result['result']['error']==0 )
						{
							
							$message ='<script type="text/javascript"> window.location="'.get_admin_url().'admin.php?page=google_hangout&msg=Activated successfully.'.'"; </script>';
						}
						else
						{
							$message ='<div class="error"><p>Wrong activation credentials!</p></div>';
						}
					}
					else
					{
						$message ='<div class="error"><p>Wrong activation credentials!</p></div>';
					}
				}
				else
				{
					$message ='<div class="error"><p>Wrong activation credentials!</p></div>';
				}
//code to check new activation credentials ends here				
				
			}
	}		
?>		
<div id="hangout_main">

    <!-- Start Header -->
    <div class="gh_header">
		<div class="row-fluid">
			<div class="span6">
     			<div class="block_left">
                RunClick <span>Webinar and Video-conferencing Software</span><br>
                    <span class="hangout_version">
                    	{ Version 4.0.3 }
                    </span>
                </div>
    		</div>
    		<div class="span6">
            	<div class="block_right">
                	<?php if(get_option('umo_hangout_payment_id')=="" && get_option('umo_hangout_activation_key')==""){?>
                	<img src="<?php echo plugin_dir_url(__FILE__);?>images/deactivated.png" alt="" align="top" /> Deactivated
					<?php }else{ ?>
                    <!-- When User Activated --> 
     				<img src="<?php echo plugin_dir_url(__FILE__);?>images/activated.png" alt="" align="top" /> Activated
                   <?php } ?>
                </div>
    		</div>
    	</div>
    </div>
    <!-- End Header -->

	 <!-- Start Hangout Login Panel -->
    <div class="hangout_login">
    <div class="gh_container">
		<div class="row-fluid">
			<div class="span12">
                	<div class="gh_container_header">
					<?php echo $message; ?> 
				
                    	<strong>Webinar Activation</strong>
                        Please enter your email id and Activation Key to Activate Webinar
						<div style="float:right">Get A License Reminder.<a href="http://hangoutplugin.com/ipn/requestkey.php" target="blank"> CLICK HERE</a></div>
                    </div>
                    	 <form action="" method="POST" enctype="form-data" class="hangouts_form">
                    	<div class="gh_tabs_div_inner">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Email</strong>
                            </div>
                            <div class="span8">
								<input type="text" name="wp_payment_id" class="longinput" id="wp_payment_id" value="<?php echo get_option('umo_hangout_payment_id'); ?>"/>

                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Activation Key</strong>
                            </div>
                            <div class="span8">
								<input type="text" name="wp_activation_id" id="wp_activation_id" class="longinput"  value="<?php echo get_option('umo_hangout_activation_key'); ?>"/>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="actionBar">
                        	<button name="activate" type="submit" class="hangout_btn"><i class="icon-share-alt"></i> Submit</button>
                        </div>
                    	</form>
                    </div>
                </div>
    		</div>
    </div>
    <!-- End Hangout Login Panel -->
    

	
	</div>
