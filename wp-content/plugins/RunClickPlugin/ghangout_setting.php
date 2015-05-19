<?php
global $post, $wpdb; 

if(isset($_POST['hangout_setting'])){
		update_option('g_project_id', $_POST['g_project_id']);
		
	
		update_option('hangout_youtube_user_id', $_POST['hangout_youtube_user_id']);
		update_option('hangout_youtube_affiliate_link', $_POST['hangout_youtube_affiliate_link']);
		update_option('attribution_link', $_POST['attribution_link']);
		update_option('hangout_cron_settings', $_POST['hangout_cron_settings']);
		update_option('hangout_chat_settings', $_POST['hangout_chat_settings']);
		update_option('hangout_facbook_app_id', $_POST['hangout_facbook_app_id']);
		update_option('hangout_affiliate_text', $_POST['hangout_affiliate_text']);
		
		/* Upload layout code */
		$uploaded_layout	=	$_FILES['upload_theme'];
		if($uploaded_layout[name]!=''){
		$uploaded_theme=substr($uploaded_layout['name'], 0, -4);
		$template_name=array('Template 1','Template 2','Template 3','Template 4','Template 5','Template 6','Template 7','Template 8','Template 9','Template 10');
		$uploads = wp_upload_dir();
		$uploads_dir = plugin_dir_path(__FILE__);
		@chmod($uploads_dir,0755);
		if($uploaded_theme=='Templates'){
		
		
		
			
					
				
				$zip = new ZipArchive;
				if ($zip->open($uploaded_layout['tmp_name']) === TRUE) 
				{
					$zip->extractTo($uploads_dir.'/themes/');
					$zip->close();
					
					
					
					$xdoc = new DomDocument();
					$xdoc->formatOutput = true;
					$xdoc->preserveWhiteSpace = false;
					$xdoc->Load($uploads_dir."/layout.xml");
					  $xmlstr = file_get_contents($uploads_dir."/layout.xml");
						 $xmlcont = new SimpleXMLElement($xmlstr);
						
						 foreach($xmlcont as $url) 
						 {
							$saved_elements[]	=	$url;
						 }
						//echo "<pre>"; print_r($saved_elements); echo "</pre>"; exit;
						
					 foreach($template_name as $uploaded_theme ){
						if(!in_array($uploaded_theme, $saved_elements))
						{
						   $layouts = $xdoc->getElementsByTagName('layouts')->item(0);
						   
						   $newItemElement = $xdoc ->createElement('item');
						   $layouts-> appendChild($newItemElement);
						  
						   $itemNode = $xdoc ->createTextNode ($uploaded_theme);
						   $newItemElement-> appendChild($itemNode);
						   $xdoc->save($uploads_dir."/layout.xml");
						} 
					}
				}
			
		} else if(in_array($uploaded_theme, $template_name)){
		
		 $dir = $uploads_dir.'themes/'.$uploaded_theme;
		
			if(is_dir($dir) == false){
					
				
				$zip = new ZipArchive;
				if ($zip->open($uploaded_layout['tmp_name']) === TRUE) 
				{
					$zip->extractTo($uploads_dir.'/themes/');
					$zip->close();
					
					
					
					$xdoc = new DomDocument();
					$xdoc->formatOutput = true;
					$xdoc->preserveWhiteSpace = false;
					$xdoc->Load($uploads_dir."/layout.xml");
					
				   $layouts = $xdoc->getElementsByTagName('layouts')->item(0);
				   $newItemElement = $xdoc ->createElement('item');
				   $layouts-> appendChild($newItemElement);
				  
				   $itemNode = $xdoc ->createTextNode ($uploaded_theme);
				   $newItemElement-> appendChild($itemNode);
				   $xdoc->save($uploads_dir."/layout.xml");
					
					}
			}else{
			 $error_msg="exist";
			}
		} else {
		 $error_msg="invalid";
			
		}
		}
		
		if($_POST['hangout_cron_settings'] == "1")
		{
			$reoccurence		=	'12perhour';
			$reminderoccurence	=	'12perhour';
			$followoccurence	=	'12perhour';
			
			wp_clear_scheduled_hook('hangout_cron_event');			
			wp_clear_scheduled_hook('hangout_reminder_cron_event');			
			wp_clear_scheduled_hook('hangout_follow_cron_event');		
			wp_schedule_event( time(), $reoccurence, 'hangout_cron_event');
			wp_schedule_event( time(), $reminderoccurence, 'hangout_reminder_cron_event');
			wp_schedule_event( time(), $followoccurence, 'hangout_follow_cron_event');
		}
		else
		{
			//De-activate all cron schedule
			wp_clear_scheduled_hook('hangout_cron_event');			
			wp_clear_scheduled_hook('hangout_reminder_cron_event');			
			wp_clear_scheduled_hook('hangout_follow_cron_event');		
		}
	if(isset($error_msg)){
	wp_redirect('admin.php?page=google_hangout&errormsg='.$error_msg.'&sel=4');
	}else{
	wp_redirect('admin.php?page=google_hangout&smsg=1&sel=4');
	}
}
$hangout_cron_settings	=	get_option("hangout_cron_settings",true);
$hangout_chat_settings = get_option("hangout_chat_settings",true);
$hangout_apps_settings =  get_option('hangout_apps_settings',true);
//$ghangout_layout = get_option('ghangout_layout',true);
?>

			<form class="hangouts_form" enctype="multipart/form-data" action="" method="post">
                    	<div class="gh_tabs_div_inner">
                        <?php if($_REQUEST['smsg']!=''){
							?>

							<div class="gh-announcement"> 
							<a class="gh-close alertbox">x</a>
							<strong>Successfully Updated!</strong>
							Webinar Setting is Successfully Updated.
							</div>
							<?php } ?>
							 <?php if($_REQUEST['errormsg']=='invalid'){
							?>

							<div class="gh-announcement"> 
							<a class="gh-close alertbox">x</a>
							<strong>Your Theme is invalid!</strong>
							Select valid Theme.
							</div>
							<?php } ?>
							<?php if($_REQUEST['errormsg']=='exist'){
							?>

							<div class="gh-announcement"> 
							<a class="gh-close alertbox">x</a>
							<strong>This Theme is Exist!</strong>
							Select another Theme.
							</div>
							<?php }
								 ?>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Project Number</strong> <a target="_blank" href="https://code.google.com/apis/console/">(To get your Project Number, Click here)</a>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" value="<?php echo get_option('g_project_id'); ?>" name="g_project_id">
                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Youtube User Id</strong> <a target="_blank" href="https://www.youtube.com/account_advanced">(To Know your youtube Id, Click here )</a>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" name="hangout_youtube_user_id" value="<?php echo get_option('hangout_youtube_user_id'); ?>">
                            </div>
                        </div>
                        </div>
						<?php  ?>
						<div class="row-fluid-outer">
								<div class="row-fluid">	
									<div class="span4">	
										<strong>Facbook AppID For Sharing</strong> <a target="_blank" href="https://developers.facebook.com/docs/apps">(To Know your Facebook App Id, Click here )</a> 
									</div> 
									<div class="span8">	
										<input type="text" class="longinput" name="hangout_facbook_app_id" value="<?php echo get_option('hangout_facbook_app_id'); ?>">
									</div> 
							</div> 
						</div>

						
						
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Upload Theme</strong> 
                            </div>
                            <div class="span4">
								<input type="file" name="upload_theme" style="width: 237px;" /></br></br>
								How to Upload Theme Via FTP <a id="upload_via_ftp">click here</a></br>
								<div style="display:none;width: 517px;" id="show_theme_div">
								Step 1:  Connect your website using FTP client and open the plugin directory located at root/wpcontent/plugin</br></br>

								 Step 2:  Now go to the Runclick directory in the plugins folder</br>

								 Step 3:  Go to the themes folder in the above Runclick folder and upload the folder of the purchased template here</br></br>

								 Step 4:  Once the template is uploaded, open the layout.xml file located in the Runclick directory.</br></br>

								 Step 5:  Edit this layout.xml file and add a new node for the template. The format will be <item>Template 1</item> and then save the file.</br></br>

								 Step 6:  After the layout.xml file is saved, you will find the newly added template in the “Themes” section of the webinar. You can select this template and start new webinar.    </div>
                            </div>
							<div class="span4">
							<a href="http://runclick.com/template" target="_blank">(Click Here To Purchase Theme Packages)</a>
							</div>
                        </div>
                        </div>
						
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
							<?php 
								$attribution_link = get_option('attribution_link'); 
							?>

								<strong>Include Attribution Link</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="attribution_link" value="1" <?php if($attribution_link==1 || $attribution_link==''){ echo 'checked';}?>> Yes &nbsp;&nbsp; <input type="radio" name="attribution_link" value="2" <?php if($attribution_link==2){ echo 'checked';}?>> No 
                            </div>
                        </div>
                        </div>
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Affiliate Text </strong>
								
                            </div>
							
                            <div class="span8">
								<input type="text" class="longinput" name="hangout_affiliate_text" value="<?php echo get_option('hangout_affiliate_text'); ?>">
                              
                            </div>
							 <div class="span8 wpcron">
								Fill Affiliate Text to show on footer.
							</div>
                        </div>
                    	</div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Affiliate Link</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" name="hangout_youtube_affiliate_link" value="<?php echo get_option('hangout_youtube_affiliate_link'); ?>">
                                <a href="https://www.jvzoo.com/affiliates/info/44321" target="_blank"><i class="icon-location-arrow"></i> Receive Your Affiliate Link Here</a>
                            </div>
                        </div>
                    	</div>
						 
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Set Cron</strong>
                            </div>
                            <div class="span8">
								<input class="cron-setup" type="radio" value="1" name="hangout_cron_settings" <?php if($hangout_cron_settings == "1" || $hangout_cron_settings == ""){ echo "checked='checked'";} ?>> Wp-cron 
								<input class="cron-setup" type="radio" value="0" name="hangout_cron_settings" <?php if($hangout_cron_settings == "0"){ echo "checked='checked'";} ?>> External Cron
                            </div>
							<div class="span8 wpcron">
								No settings Required. Click Update to activate Cron.
							</div>
							<div class="extcron">
								You need to set the External Cron from cpanel.
								<br /><br />
								- copy&paste next command to "Command" field:
								<br /><br />
								- You need to Set THREE commands.
								<br /><br />
								1. wget -O /dev/null <?php echo plugins_url();?>/RunClickPlugin/cron.php 2>/dev/null	<br /> (enter "*/5" to minute field)<br /><br />
								2. wget -O /dev/null <?php echo plugins_url();?>/RunClickPlugin/reminder_cron.php 2>/dev/null <br />(enter "*/15" to minute field)<br /><br />
								3. wget -O /dev/null <?php echo plugins_url();?>/RunClickPlugin/reminder_cron_record.php 2>/dev/null <br />(enter "*/15" to minute field)<br /><br />
								4. wget -O /dev/null <?php echo plugins_url();?>/RunClickPlugin/follow_cron.php 2>/dev/null	<br /> (enter "*/15" to minute field)
							</div>
                        </div>
                    	</div>


						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar Chat</strong>
                            </div>
                            <div class="span8">
								<input class="chat-setup" type="radio" value="1" name="hangout_chat_settings" <?php if($hangout_chat_settings == "1"){ echo "checked='checked'";} ?>> Yes
								<input class="chat-setup" type="radio" value="0" name="hangout_chat_settings" <?php if($hangout_chat_settings == "0" || $hangout_chat_settings == ""){ echo "checked='checked'";} ?>> No 
								
                            </div>
						</div>
					 </div>
						 <div class="row-fluid-outer" id="use_hangout_apps" <?php if($hangout_chat_settings == "0" || $hangout_chat_settings == ""){ echo "style='display:none;'";} ?>>
                        <div class="row-fluid">
							<div class="span4">
								<strong>To use Webinar Apps</strong>
                            </div>
                            <div class="span8">

							<?php
							
							$siteurl = explode("/",site_url());
								if(count($siteurl)>3){
									 $len = sizeof($siteurl);
									$x=3;
									$subdomain='';
									while($x<=$len){
											if($siteurl[$x]!=''){
											$subdomain.= '/'.$siteurl[$x];
											}
										
										$x++;
									}
									
								}
							?>
							<strong style="font-size: 17px;">Webinar APPs Link:</strong> <a href="https://hangoutsapi.talkgadget.google.com/hangouts/_?gid=728076588717" target="_blank" /><strong>https://hangoutsapi.talkgadget.google.com/hangouts/_?gid=728076588717</strong></a>
							
							</div>
                        </div>
                    	</div>
						
                        </div>
                        <div class="actionBar">
                        	<button type="submit" name="hangout_setting" class="hangout_btn"><i class="icon-save"></i> Save Settings</button>
                        </div>
                    	</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var selected_cron	=	jQuery(".cron-setup:checked").val();
		if(selected_cron	==	"1")
		{
			jQuery(".wpcron").show();
			jQuery(".extcron").hide();
		}
		else
		{
			jQuery(".extcron").show();
			jQuery(".wpcron").hide();
		}
		
		jQuery("#upload_via_ftp").live('click',function(){
			jQuery("#show_theme_div").show();
		
		})
		
	});
	jQuery(".cron-setup").live('click',function(){
		var cron_val	=	jQuery(this).val();
		if(cron_val	==	"1")
		{
			jQuery(".wpcron").show();
			jQuery(".extcron").hide();
		}
		else
		{
			jQuery(".extcron").show();
			jQuery(".wpcron").hide();
		}
	});
	jQuery(".chat-setup").live('click',function(){
		var cron_val	=	jQuery(this).val();
		if(cron_val	==	"1")
		{
			jQuery("#use_hangout_apps").show();
		}
		else
		{
			jQuery("#use_hangout_apps").hide();
		}
	});
</script>
