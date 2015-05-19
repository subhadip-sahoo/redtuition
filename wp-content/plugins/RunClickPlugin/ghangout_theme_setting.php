<?php
global $post, $wpdb; 

if(isset($_POST['hangout_setting'])){
		//update_option('g_project_id', $_POST['g_project_id']);
		
	
		//update_option('hangout_youtube_user_id', $_POST['hangout_youtube_user_id']);
		update_option('hangout_youtube_affiliate_link', $_POST['hangout_youtube_affiliate_link']);
		update_option('attribution_link', $_POST['attribution_link']);
		update_option('hangout_cron_settings', $_POST['hangout_cron_settings']);
		update_option('hangout_chat_settings', $_POST['hangout_chat_settings']);
		update_option('ghangout_layout', $_POST['ghangout_layout']);
		
		if($_POST['hangout_cron_settings'] == "1")
		{
			$reoccurence		=	'60perhour';
			$reminderoccurence	=	'4perhour';
			$followoccurence	=	'4perhour';
			
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
	
	wp_redirect('admin.php?page=google_hangout&smsg=1&sel=4');
}
$hangout_cron_settings	=	get_option("hangout_cron_settings",true);
$hangout_chat_settings = get_option("hangout_chat_settings",true);
$hangout_apps_settings =  get_option('hangout_apps_settings',true);
$ghangout_layout = get_option('ghangout_layout',true);
?>

			<form class="hangouts_form" action="" method="post">
                    	<div class="gh_tabs_div_inner">
                        <?php if($_REQUEST['smsg']!=''){
							?>

							<div class="gh-announcement"> 
							<a class="gh-close alertbox">x</a>
							<strong>Successfully Updated!</strong>
							Webinar Setting is Successfully Updated.
							</div>
							<?php } 
							/*
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
						<?php */ ?>


						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Layout</strong> 
                            </div>
                            <div class="span8">
								<select name="ghangout_layout" id="ghangout_layout">
									<?php $layoutlist = get_layout_list();
										foreach($layoutlist as $layoutname){ ?>
											<option value="<?php echo $layoutname; ?>" <?php if($ghangout_layout==$layoutname){ echo 'selected';}?>><?php echo $layoutname; ?></option>
										<?php }
									?>
								</select>
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
								3. wget -O /dev/null <?php echo plugins_url();?>/RunClickPlugin/follow_cron.php 2>/dev/null	<br /> (enter "*/15" to minute field)
							</div>
                        </div>
                    	</div>


						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar Chat</strong>
                            </div>
                            <div class="span8">
								<input class="chat-setup" type="radio" value="1" name="hangout_chat_settings" <?php if($hangout_chat_settings == "1" || $hangout_chat_settings == ""){ echo "checked='checked'";} ?>> Internal Chat 
								<input class="chat-setup" type="radio" value="0" name="hangout_chat_settings" <?php if($hangout_chat_settings == "0"){ echo "checked='checked'";} ?>> Webinar APPs
                            </div>
						</div>
					 </div>
						 <div class="row-fluid-outer" id="use_hangout_apps" <?php if($hangout_chat_settings == "1" || $hangout_chat_settings == ""){ echo "style='display:none;'";} ?>>
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
							Please Add the code mention below into : <?php echo $subdomain;?>/wp-content/plugins/RunClickPlugin/.htaccess<br>
							<IfModule mod_rewrite.c><br>
								RewriteEngine On<br>
								RewriteBase <?php echo $subdomain;?>/wp-content/plugins/RunClickPlugin/<br>
								RewriteCond %{REQUEST_FILENAME} !-d<br>
								RewriteCond %{REQUEST_FILENAME} !-s<br>
								RewriteRule ^(.*)$ hangoutapi.php?rquest=$1 [QSA,NC,L]<br>
<br>
							</IfModule>
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
		if(cron_val	==	"0")
		{
			jQuery("#use_hangout_apps").show();
		}
		else
		{
			jQuery("#use_hangout_apps").hide();
		}
	});
</script>