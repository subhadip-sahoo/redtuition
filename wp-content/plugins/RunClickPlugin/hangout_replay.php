<?php
global $post, $wpdb;
$upload_dir = wp_upload_dir(); 
$baseurl = $upload_dir['baseurl']; 
$selected_theme=$_REQUEST['selected_theme'];

if($_REQUEST['action']=='delete_webinar_replay_logo'){
	$webinar_id=$_GET['EID'];
	 $replay_logoname=$_GET['replay_logo_name'];
	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['basedir'];
	@chmod($uploads_dir,0755);

	//unlink($uploads_dir.'/'.$thk_logoname);
	update_post_meta($webinar_id,"ghanghout_replay_logo","");
	$message="</div class='updated'>Logo Deleted successfully.</div>";
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$webinar_id&sel=5");
}

if(isset($_POST['edit_replay_hangout'])){

		  $banner_name = $_FILES["ghanghout_replay_full_banner_image"]["name"];
		  $ghanghout_replay_logo = $_FILES["ghanghout_replay_logo"]["name"];
		  $uploads = wp_upload_dir();
	      $uploads_dir = $uploads['basedir'];
			@chmod($uploads_dir,0755);


	
		if($banner_name !=''){
			move_uploaded_file( $_FILES["ghanghout_replay_full_banner_image"]["tmp_name"], "$uploads_dir/$banner_name");
		} 
		if($ghanghout_replay_logo !=''){
			move_uploaded_file($_FILES["ghanghout_replay_logo"]["tmp_name"], "$uploads_dir/$ghanghout_replay_logo");
		}

	
	$post_id = $_REQUEST['hangout_id'];
	
 
		$reminder_time = 	implode(",", $_POST['reminder_time']);
  	
		
		update_post_meta($post_id,"hangout_lock_replay",$_POST["hangout_lock_replay"]);
		update_post_meta($post_id,"hangout_replan_registration_system",$_POST["hangout_replan_registration_system"]);
		
		update_post_meta($post_id,"hangout_replay_embed_code",$_POST["hangout_replay_embed_code"]);
		update_post_meta($post_id,"hangout_replay_embed_code_time",$_POST["hangout_replay_embed_code_time"]);
		update_post_meta($post_id,"show_repay_pop_up_form",$_POST["show_repay_pop_up_form"]);
		update_post_meta($post_id,"hangout_webinar_auto_play_replay",$_POST["hangout_webinar_auto_play_replay"]);

		update_post_meta($post_id,"hangout_replan_amber_name_field",$_POST["hangout_replan_amber_name_field"]);
		update_post_meta($post_id,"hangout_replan_amber_name_email",$_POST["hangout_replan_amber_name_email"]);
		update_post_meta($post_id,"hangout_replan_amber_from",$_POST["hangout_replan_amber_from"]);
		update_post_meta($post_id,"replay_timer_type",$_POST["replay_timer_type"]);

	
	  	
		/* Option 1 values */
		update_post_meta($post_id,"ghanghout_replay_enable_header",$_POST["ghanghout_replay_enable_header"]);
		update_post_meta($post_id,"ghanghout_replay_enable_sharing",$_POST["ghanghout_replay_enable_sharing"]);
		if($ghanghout_replay_logo !=''){
			update_post_meta($post_id,"ghanghout_replay_logo",$ghanghout_replay_logo);
		}
		update_post_meta($post_id,"ghanghout_replay_logo_text",$_POST["ghanghout_replay_logo_text"]);
		update_post_meta($post_id,"ghanghout_replay_logo_family",$_POST["ghanghout_replay_logo_family"]);
		update_post_meta($post_id,"ghanghout_replay_logo_size",$_POST["ghanghout_replay_logo_size"]);
		update_post_meta($post_id,"ghanghout_replay_logo_style",$_POST["ghanghout_replay_logo_style"]);
		update_post_meta($post_id,"ghanghout_replay_logo_shadow",$_POST["ghanghout_replay_logo_shadow"]);
		update_post_meta($post_id,"ghanghout_replay_logo_height",$_POST["ghanghout_replay_logo_height"]);
		update_post_meta($post_id,"ghanghout_replay_logo_spacing",$_POST["ghanghout_replay_logo_spacing"]);
		update_post_meta($post_id,"ghanghout_replay_logo_color",$_POST["ghanghout_replay_logo_color"]);
		
		if(isset($_POST['g_hangout_replan_layout_type'])){
			update_post_meta($post_id,"g_hangout_replan_layout_type",$_POST["g_hangout_replan_layout_type"]);
			if($banner_name !=''){
				update_post_meta($post_id,"ghanghout_replay_full_banner_image",$banner_name);
			}
			update_post_meta($post_id,"ghanghout_replay_headline",$_POST["ghanghout_replay_headline"]);
			update_post_meta($post_id,"ghanghout_replay_headline_family",$_POST["ghanghout_replay_headline_family"]);
			update_post_meta($post_id,"ghanghout_replay_headline_size",$_POST["ghanghout_replay_headline_size"]);
			update_post_meta($post_id,"ghanghout_replay_headline_style",$_POST["ghanghout_replay_headline_style"]);
			update_post_meta($post_id,"ghanghout_replay_headline_shadow",$_POST["ghanghout_replay_headline_shadow"]);
			update_post_meta($post_id,"ghanghout_replay_headline_height",$_POST["ghanghout_replay_headline_height"]);
			update_post_meta($post_id,"ghanghout_replay_headline_spacing",$_POST["ghanghout_replay_headline_spacing"]);
			update_post_meta($post_id,"ghanghout_replay_headline_color",$_POST["ghanghout_replay_headline_color"]);
			update_post_meta($post_id,"ghanghout_replay_subhead",$_POST["ghanghout_replay_subhead"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_family",$_POST["ghanghout_replay_subhead_family"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_size",$_POST["ghanghout_replay_subhead_size"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_style",$_POST["ghanghout_replay_subhead_style"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_shadow",$_POST["ghanghout_replay_subhead_shadow"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_height",$_POST["ghanghout_replay_subhead_height"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_spacing",$_POST["ghanghout_replay_subhead_spacing"]);
			update_post_meta($post_id,"ghanghout_replay_subhead_color",$_POST["ghanghout_replay_subhead_color"]);
			update_post_meta($post_id,"ghanghout_replay_option1editor",$_POST["ghanghout_replay_option1editor"]);
		}
		
		if(isset($_POST['ghanghout_editor_undervideo_replay']))
			update_post_meta($post_id,"ghanghout_editor_undervideo_replay",$_POST["ghanghout_editor_undervideo_replay"]);
		
		update_post_meta($post_id,"hangout_replay_option",$_POST["hangout_replay_option"]);
		
		  
		
		/* Bhuvnesh Code for theme settings */
		$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
		if($google_hangout_theme == "Default" || $google_hangout_theme == ""){
		}
		else{
			include_once 'themes/'.$google_hangout_theme.'/replay_back.php';
		}
	/* Bhuvnesh Code for theme settings End */		
	
	
	  wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=".$post_id."&sel=5");

}
if($_REQUEST['msg_id']=='4'){
?>
<div id="message" class="updated below-h2"><p>Webinar Event published. </p></div>
<?php } 
/*
if(get_option('g_project_id')==''){ ?>
	<div id="message" class="error"><p>Project Id is Missing </p></div>
<?php }
if(get_option('hangout_youtube_user_id')==''){ ?>
	<div id="message" class="error"><p>Youtube User ID is Missing </p></div>
<?php }
*/
$post_id = $_REQUEST['EID'];
$title='';
$timezone = '';
$youcode='';
$youembed='';
$event_reg='1';
$event_notification='1';
$reminder_time =array(24);
$hangout_registration_system = 1;
$aweber ='';
$getresponse ='';

$aweber_name ='';
$aweber_email ='';
$getresponse_name ='';
$getresponse_email ='';
$timer_type='';

$g_hangout_layout_type = '';
	$ghanghout_replay_enable_header = '';
	$ghanghout_replay_enable_sharing = '';
	$ghanghout_replay_logo = '';
	$ghanghout_replay_logo_text = '';
	$ghanghout_replay_logo_family = '';
	$ghanghout_replay_logo_size = '';
	$ghanghout_replay_logo_style = '';
	$ghanghout_replay_logo_shadow = '';
	$ghanghout_replay_logo_height = '';
	$ghanghout_replay_logo_spacing = '';
	$ghanghout_replay_logo_color = '';
	$ghanghout_replay_headline = '';
	$ghanghout_replay_headline_family = '';
	$ghanghout_replay_headline_size = '';
	$ghanghout_replay_headline_style = '';
	$ghanghout_replay_headline_shadow = '';
	$ghanghout_replay_headline_height = '';
	$ghanghout_replay_headline_spacing = '';
	$ghanghout_replay_headline_color = '';
	$ghanghout_replay_subhead = '';
	$ghanghout_replay_subhead_family = '';
	$ghanghout_replay_subhead_size = '';
	$ghanghout_replay_subhead_style = '';
	$ghanghout_replay_subhead_shadow = '';
	$ghanghout_replay_subhead_height = '';
	$ghanghout_replay_subhead_spacing = '';
	$ghanghout_replay_subhead_color = '';

	
	
		/* Option 1 end values*/
	
	$ghanghout_replay_full_banner_image =	get_post_meta($post_id,"ghanghout_replay_full_banner_image",true);


if(isset($_REQUEST['EID'])){
	$post_id = $_REQUEST['EID'];
	$postdata = get_post($post_id);

	$title=get_post_meta($post_id,'hangout_title',true);
	 $hangout_lock_replay = get_post_meta($post_id,'hangout_lock_replay',true);

	$hangout_replan_registration_system = get_post_meta($post_id,'hangout_replan_registration_system',true);
	
	$hangout_replay_embed_code	=	get_post_meta($post_id,'hangout_replay_embed_code',true);
	$hangout_replay_embed_code_time	=	get_post_meta($post_id,'hangout_replay_embed_code_time',true);
	$show_repay_pop_up_form	=	get_post_meta($post_id,'show_repay_pop_up_form',true);

	$autorespondre_name =get_post_meta($post_id,'hangout_replan_amber_name_field',true);
	$autorespondre_email =get_post_meta($post_id,'hangout_replan_amber_name_email',true);
	$autorespondre_form =get_post_meta($post_id,'hangout_replan_amber_from',true);

	$replay_timer_type=get_post_meta($post_id,'replay_timer_type',true);

	$g_hangout_replan_layout_type = get_post_meta($post_id,"g_hangout_replan_layout_type",true);
	$ghanghout_replay_enable_header = get_post_meta($post_id,"ghanghout_replay_enable_header",true);
	$ghanghout_replay_enable_sharing = get_post_meta($post_id,"ghanghout_replay_enable_sharing",true);
	$ghanghout_replay_logo = get_post_meta($post_id,"ghanghout_replay_logo",true);
	$ghanghout_replay_logo_text = get_post_meta($post_id,"ghanghout_replay_logo_text",true);
	$ghanghout_replay_logo_family = get_post_meta($post_id,"ghanghout_replay_logo_family",true);
	$ghanghout_replay_logo_size = get_post_meta($post_id,"ghanghout_replay_logo_size",true);
	$ghanghout_replay_logo_style =	get_post_meta($post_id,"ghanghout_replay_logo_style",true);
	$ghanghout_replay_logo_shadow = get_post_meta($post_id,"ghanghout_replay_logo_shadow",true);
	$ghanghout_replay_logo_height = get_post_meta($post_id,"ghanghout_replay_logo_height",true);
	$ghanghout_replay_logo_spacing =	get_post_meta($post_id,"ghanghout_replay_logo_spacing",true);
	$ghanghout_replay_logo_color =	get_post_meta($post_id,"ghanghout_replay_logo_color",true);
	$ghanghout_replay_headline =	get_post_meta($post_id,"ghanghout_replay_headline",true);
	$ghanghout_replay_headline_family = get_post_meta($post_id,"ghanghout_replay_headline_family",true);
	$ghanghout_replay_headline_size = get_post_meta($post_id,"ghanghout_replay_headline_size",true);
	
	$ghanghout_replay_headline_style =	get_post_meta($post_id,"ghanghout_replay_headline_style",true);
	$ghanghout_replay_headline_shadow = get_post_meta($post_id,"ghanghout_replay_headline_shadow",true);
	$ghanghout_replay_headline_height = get_post_meta($post_id,"ghanghout_replay_headline_height",true);
	$ghanghout_replay_headline_spacing = get_post_meta($post_id,"ghanghout_replay_headline_spacing",true);
	$ghanghout_replay_headline_color =	get_post_meta($post_id,"ghanghout_replay_headline_color",true);
	$ghanghout_replay_subhead = get_post_meta($post_id,"ghanghout_replay_subhead",true);
	$ghanghout_replay_subhead_family =	get_post_meta($post_id,"ghanghout_replay_subhead_family",true);
	$ghanghout_replay_subhead_size =	get_post_meta($post_id,"ghanghout_replay_subhead_size",true);
		
	$ghanghout_replay_subhead_style = get_post_meta($post_id,"ghanghout_replay_subhead_style",true);
	$ghanghout_replay_subhead_shadow =	get_post_meta($post_id,"ghanghout_replay_subhead_shadow",true);
	$ghanghout_replay_subhead_height =	get_post_meta($post_id,"ghanghout_replay_subhead_height",true);
	$ghanghout_replay_subhead_spacing = get_post_meta($post_id,"ghanghout_replay_subhead_spacing",true);
	$ghanghout_replay_subhead_color =	get_post_meta($post_id,"ghanghout_replay_subhead_color",true);
	
	$ghanghout_replay_option1editor = get_post_meta($post_id,"ghanghout_replay_option1editor",true);
	$ghanghout_editor_undervideo_replay = get_post_meta($post_id,"ghanghout_editor_undervideo_replay",true);
	$hangout_replay_option = get_post_meta($post_id,"hangout_replay_option",true);
	
	
	
		/* Option 1 end values*/
	
	$ghanghout_replay_full_banner_image =	get_post_meta($post_id,"ghanghout_replay_full_banner_image",true);
	$hangout_show_replay =	get_post_meta($post_id,"hangout_show_replay",true);
	$replay_auto_play =	get_post_meta($post_id,"hangout_webinar_auto_play_replay",true);
	

}

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		if(jQuery('.choose_replay_option:checked').val() == '0')
		{
			jQuery('.replay_option').hide();
			jQuery('.limit_replay_option').hide();
		}
		else
		{
			jQuery('.replay_option').show();
			jQuery('.limit_replay_option').show();
		}
		jQuery('.choose_replay_option').live('click',function(){
			var replay_opt_val	=	jQuery(this).val();
			if(replay_opt_val == "1")
			{
				jQuery('.replay_option').show();
				jQuery('.limit_replay_option').show();
			}
			else
			{
				jQuery('.replay_option').hide();
				jQuery('.limit_replay_option').hide();
			}
		});
	});
</script>
<div class="gh_tabs_div_inner">

                        <div id="myMenu13" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Replay Settings</div>
						<form method="post" id="hangout_manage" name="add_hangout" action="" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $post_id; ?>" name="hangout_id"/>
						<div id="myDiv13" class="gh_accordian_div">
						
						
						<?php 
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					?>
					 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Replay </strong>
                            </div>
                            <div class="span8">
								<input type="radio" class="choose_replay_option" name="hangout_replay_option" value="1" <?php if($hangout_replay_option == '1'){ echo "checked='checked'";}?> />&nbsp;Yes &nbsp;&nbsp;
								<input type="radio" class="choose_replay_option" name="hangout_replay_option" value="0" <?php if($hangout_replay_option == '0' || $hangout_replay_option == ""){ echo "checked='checked'";}?> />&nbsp;No
                            </div>
                        </div>
                        </div>
						<?php 
					}
					else{
					?>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Lock Replay</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_lock_replay" value="1" <?php if($hangout_lock_replay==1 ){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; 
								<input type="radio" name="hangout_lock_replay" value="0" <?php if($hangout_lock_replay==0 || $hangout_lock_replay=='' ){ echo 'checked="checked"'; } ?>/> No
                            </div>
                        </div>
                        </div>
					<?php }  ?>
							<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar Auto Play</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_webinar_auto_play_replay" value="1" <?php if($replay_auto_play==1 || $replay_auto_play==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="hangout_webinar_auto_play_replay" value="0" <?php if($replay_auto_play==0){ echo 'checked="checked"'; } ?>/> No</span>

								
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer" style="display:none;" <?php if($hangout_lock_replay==0){  echo 'style="display:none;"'; } ?> id="hangout_replay_registration_system1">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Registration System  </strong>
                            </div>
                            <div class="span8">
								<select id="hangout_replan_registration_system" name="hangout_replan_registration_system">
									<option <?php if($hangout_replan_registration_system=="Default"){echo 'selected';}?>>Default</option>
									<option <?php if($hangout_replan_registration_system=="Aweber"){echo 'selected';}?>>Aweber</option>
									<option <?php if($hangout_replan_registration_system=="GetResponse"){echo 'selected';}?>>GetResponse</option>
									<option <?php if($hangout_replan_registration_system=="InfusionSoft"){echo 'selected';}?>>InfusionSoft</option>
									<option <?php if($hangout_replan_registration_system=="Sendreach"){echo 'selected';}?>>Sendreach</option>
									<option <?php if($hangout_replan_registration_system=="ImnicaMail"){echo 'selected';}?>>ImnicaMail</option>
									<option <?php if($hangout_replan_registration_system=="Mailchimp"){echo 'selected';}?>>Mailchimp</option>
									<option <?php if($hangout_replan_registration_system=="ArpReach"){echo 'selected';}?>>ArpReach</option>
									<option <?php if($hangout_replan_registration_system=="Icontact"){echo 'selected';}?>>Icontact</option>
									<option <?php if($hangout_replan_registration_system=="1ShopingCart"){echo 'selected';}?>>1ShopingCart</option>
									<option <?php if($hangout_replan_registration_system=="Sendpeppe"){echo 'selected';}?>>Sendpeppe</option>
									<option <?php if($hangout_replan_registration_system=="Other"){echo 'selected';}?>>Other</option>
							</select>
                                </div>
                            </div>
                        
						<div <?php if($hangout_replan_registration_system=='Default' || $hangout_replan_registration_system==''){  echo 'style="display:none;"'; } ?> id="hangout_replay_autoresponder">
                        <div class="row-fluid-outer">
							<div class="row-fluid">
							
								<div class="span4">
									<strong>Autoresponder Name Field Name </strong>
								</div>
								<div class="span8">
									<input type="text" class="longinput" name="hangout_replan_amber_name_field" id="hangout_replan_amber_name_field" value="<?php echo $autorespondre_name; ?>" /></span>
								</div>

	                        </div>
                        </div>
						
						<div class="row-fluid-outer">
							<div class="row-fluid">
							
								<div class="span4">
									<strong>Autoresponder Email Field Name </strong>
								</div>
								<div class="span8">
									<input type="text" class="longinput" name="hangout_replan_amber_name_email" id="hangout_replan_amber_name_email" value="<?php echo $autorespondre_email; ?>" /></span>
								</div>

	                        </div>
                        </div>
						<div class="row-fluid-outer">
							<div class="row-fluid">
							
								<div class="span4">
									<strong>Autoresponder HTML code </strong>
								</div>
								<div class="span8">
									<textarea name="hangout_replan_amber_from" cols="80" rows="10"><?php echo $autorespondre_form; ?></textarea></span>
								</div>

	                        </div>
                        </div>
                        </div>
                        </div>
						<?php if(0){ ?>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Embed Code</strong>
                            </div>
                            <div class="span8">
								<textarea name="hangout_replay_embed_code"><?php echo $hangout_replay_embed_code; ?></textarea>
                            </div>
                        </div>
                        </div>
                    	<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Embed Code Time</strong>
                            </div>
                            <div class="span8">
								<input type="text" id="hangout_replay_embed_code_time" name="hangout_replay_embed_code_time" value="<?php echo $hangout_replay_embed_code_time; ?>"/>
                            </div>
                        </div>
                        </div>
						<?php } ?>
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Pop-Up Form On Replay Page </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_repay_pop_up_form" value="1" <?php if($show_repay_pop_up_form==1 || $show_repay_pop_up_form==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="show_repay_pop_up_form" value="0" <?php if($show_repay_pop_up_form==0){ echo 'checked="checked"'; } ?>/> No
                                </div>
                            </div>
                        </div>
						
						</div>

					
                        <?php $base_path			=	plugin_dir_url(__FILE__);
						
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					?>
						<div id="myMenu131" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Add Html below Webinar video </div>
							<div id="myDiv131" class="gh_accordian_div">
								<div class="ghanghoutDiv" >
						
								<?php if(isset($_REQUEST['EID'])){ ?>
									<a href="javascript:void(0);" class="preview_hangout_event">Save and preview</a>
								<?php } ?>
							<br/>
							<?php echo wp_editor( $ghanghout_editor_undervideo_replay, 'ghanghout_editor_undervideo_replay' ); ?>


							</div>
							</div>
					<?php
					}
					else{
					?>
                        <div id="myMenu15" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Page Design </div>
						<div id="myDiv15" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Re Play Page Design </strong>
                            </div>
                            <div class="span8">
								<div class="row-fluid">
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_replan_layout_type ==1 || $g_hangout_replan_layout_type==''){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_replan_layout_type" value="1">
                                    <img src="<?php echo $base_path; ?>images/option1.png" alt=""/>
                                    </div>
                                    </div>
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_replan_layout_type ==2){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_replan_layout_type" value="2">
                                    <img src="<?php echo $base_path; ?>images/option2.png" alt=""/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
						<div id="replayoption2layout" <?php if($g_hangout_replan_layout_type==1 or$g_hangout_replan_layout_type==''){ echo 'style="display:none;"'; } ?> >

							 <div class="row-fluid-outer">
	                        <div class="row-fluid">
							        <div class="span6">
							<b>Full Banner Image</b>  
									</div><div class="span6">
							<input type="file" name="ghanghout_replay_full_banner_image" id="ghanghout_replay_full_banner_image" value="" class="ghanghout_replay_replayUpload upload2">
							<?php if($ghanghout_replay_full_banner_image!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_replay_full_banner_image;?>">
								<?php } ?>
							</div>
							</div>
							</div>
							
                        </div>
                        <div id="replayoption1layout" <?php if($g_hangout_replan_layout_type==2){ echo 'style="display:block;"'; } ?>>
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="notfullscreen" style="">

							<div class="ghanghout_replay_replayDiv" id="headline">
							<p class="ghanghout_replay_replayHeading">Headline Settings</p>

							<b>Headline Text</b><br>
							<span class="howto">Enter text for your headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_replay_headline" rows="2" cols="60" class="ghanghout_replayText"><?php echo $ghanghout_replay_headline; ?></textarea>

							<p><b>Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_replay_headline_family" id="ghanghout_replay_headline_family">
							<option <?php if($ghanghout_replay_headline_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_replay_headline_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_replay_headline_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_replay_headline_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_replay_headline_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_replay_headline_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_replay_headline_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_replay_headline_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_replay_headline_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_replay_headline_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_replay_headline_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_replay_headline_size" id="ghanghout_replay_headline_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_replay_headline_size=='' && $x==48){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_replay_headline_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_replay_headline_style" id="ghanghout_replay_headline_style">
								<option <?php if($ghanghout_replay_headline_style=="Normal" || $ghanghout_replay_headline_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_replay_headline_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_replay_headline_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_replay_headline_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_replay_headline_shadow" id="ghanghout_replay_headline_shadow">
								<option <?php if($ghanghout_replay_headline_shadow=="None" || $ghanghout_replay_headline_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_replay_headline_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_replay_headline_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_replay_headline_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_replay_headline_height" id="ghanghout_replay_headline_height">
								<option <?php if($ghanghout_replay_headline_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_replay_headline_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_replay_headline_height=="75%" || $ghanghout_replay_headline_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_replay_headline_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_replay_headline_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_replay_headline_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_replay_headline_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_replay_headline_spacing" id="ghanghout_replay_headline_spacing">
								<option <?php if($ghanghout_replay_headline_spacing=="-3" || $ghanghout_replay_headline_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_replay_headline_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_replay_headline_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_replay_headline_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_replay_headline_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_replay_headline_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_replay_headline_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_replay_headline_color" id="ghanghout_replay_headline_color" type="text" value="<?php echo $ghanghout_replay_headline_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>
							</p>

							<b>Sub-Headline Text</b><br>
							<span class="howto">Enter text for your sub-headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_replay_subhead" rows="2" cols="60" class="ghanghout_replayText"><?php echo $ghanghout_replay_subhead; ?></textarea>

							<p><b>Sub-Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_replay_subhead_family" id="ghanghout_replay_subhead_family">
								<option <?php if($ghanghout_replay_subhead_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_replay_subhead_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_replay_subhead_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_replay_subhead_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_replay_subhead_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_replay_subhead_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_replay_subhead_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_replay_subhead_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_replay_subhead_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_replay_subhead_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_replay_subhead_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_replay_subhead_size" id="ghanghout_replay_subhead_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_replay_subhead_size=='' && $x==28){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_replay_subhead_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_replay_subhead_style" id="ghanghout_replay_subhead_style">
								<option <?php if($ghanghout_replay_subhead_style=="Normal" || $ghanghout_replay_subhead_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_replay_subhead_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_replay_subhead_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_replay_subhead_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_replay_subhead_shadow" id="ghanghout_replay_subhead_shadow">
								<option <?php if($ghanghout_replay_subhead_shadow=="None" || $ghanghout_replay_subhead_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_replay_subhead_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_replay_subhead_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_replay_subhead_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_replay_subhead_height" id="ghanghout_replay_subhead_height">
								<option <?php if($ghanghout_replay_subhead_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_replay_subhead_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_replay_subhead_height=="75%" || $ghanghout_replay_subhead_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_replay_subhead_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_replay_subhead_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_replay_subhead_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_replay_subhead_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_replay_subhead_spacing" id="ghanghout_replay_subhead_spacing">
								<option <?php if($ghanghout_replay_subhead_spacing=="-3" || $ghanghout_replay_subhead_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_replay_subhead_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_replay_subhead_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_replay_subhead_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_replay_subhead_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_replay_subhead_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_replay_replay_subhead_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_replay_subhead_color" id="ghanghout_replay_subhead_color" type="text" value="<?php echo $ghanghout_replay_subhead_color;?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

							</p>
							</div>
							</div>
							<?php if($ghanghout_replay_option1editor == "")
							{
								$ghanghout_replay_option1editor = '<p style="text-align: center;">[ghangout_replan_reg_form]</p>'; 	
							}
							?>
							<div class="ghanghout_replay_replayDiv" >
								
							<b>Shortcode Available </b><br>
							<!-- Event Timer = [ghangout_replan_timer]<br> -->
							Registration From= [ghangout_replan_reg_form] 
							<br>
							<?php echo wp_editor( $ghanghout_replay_option1editor, 'ghanghout_replay_option1editor' ); ?>


							</div>
							</div>
							</div>
							</div>
							
                        </div>
                        <?php } ?>
                        <div id="myMenu16" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Replay Header Settings </div>
						<div id="myDiv16" class="gh_accordian_div">
                         <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo / Social Sharing </strong>
                            </div>
                            <div class="span8">
								<input id="ghanghout_replay_enable_header" name="ghanghout_replay_enable_header" size="30" value="checked" type="checkbox" <?php if($ghanghout_replay_enable_header=="checked"){ echo 'checked="checked"'; } ?> > Enable Logo &nbsp;&nbsp;<input id="ghanghout_replay_enable_sharing" name="ghanghout_replay_enable_sharing" size="30" value="checked" type="checkbox" <?php if($ghanghout_replay_enable_sharing=="checked"){ echo 'checked="checked"'; } ?>> Enable Social Sharing 
							</div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo Image  </strong>(optional)
                                <div class="small_font">suggested image size 468x60 </div>
                            </div>
                            <div class="span8">
								<input type="file" class="ghanghout_replayUpload upload2" name="ghanghout_replay_logo" id="ghanghout_replay_logo" value="" class="ghanghout_replayUpload upload2">
								<?php if($ghanghout_replay_logo!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_replay_logo;?>">
									<a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete_webinar_replay_logo&replay_logo_name=<?php echo $ghanghout_replay_logo;?>&EID=<?echo $post_id;?>" class="h_editing_link">
									<img src="<?php echo plugin_dir_url(__FILE__);?>images/delete_sign.png" title="Delete" alt="Delete"  style="cursor:pointer"  /></a>
								<?php } ?>

                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo Text </strong>(optional)
                                <div class="small_font">If you don't have a logo image, we can create one for you. Just enter the text below.</div>
                            </div>
                            <div class="span8">
								<input class="longinput"  type="text" name="ghanghout_replay_logo_text" id="ghanghout_replay_logo_text" value="<?php echo $ghanghout_replay_logo_text; ?>" class="ghanghout_replayText">
                            </div>
                        </div>
                        </div>


					 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span12">
								<b>Logo Style</b><br>
								<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
								<select name="ghanghout_replay_logo_family" id="ghanghout_replay_logo_family">

									<option <?php if($ghanghout_replay_logo_family=="Arial")echo "selected=''"; ?>>Arial</option>
									<option <?php if($ghanghout_replay_logo_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
									<option <?php if($ghanghout_replay_logo_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

									<option <?php if($ghanghout_replay_logo_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
									<option <?php if($ghanghout_replay_logo_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
									<option <?php if($ghanghout_replay_logo_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
									<option <?php if($ghanghout_replay_logo_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
									<option <?php if($ghanghout_replay_logo_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
									<option <?php if($ghanghout_replay_logo_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
									<option <?php if($ghanghout_replay_logo_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
									<option <?php if($ghanghout_replay_logo_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
								</select>

								<select name="ghanghout_replay_logo_size" id="ghanghout_replay_logo_size">
								<?php $x=10; 
								while($x<=100){
									$chk='';
									if($ghanghout_replay_logo_size=='' && $x==48){
										$chk = 'selected="selected"';
									} else {
										echo $comparstr = $ghanghout_replay_logo_size.'px';
										if($comparstr==$x){
											$chk = 'selected="selected"';
										}
									}
								echo '<option '.$chk.'>'.$x.'px</option>';
								$x++;
								}
								?>
								</select>
								<select name="ghanghout_replay_logo_style" id="ghanghout_replay_logo_style">
									<option <?php if($ghanghout_replay_logo_style=="Normal" || $ghanghout_replay_logo_style=='')echo "selected=''"; ?> >Normal</option>
									<option <?php if($ghanghout_replay_logo_style=="Italic")echo "selected=''"; ?>>Italic</option>
									<option <?php if($ghanghout_replay_logo_style=="Bold")echo "selected=''"; ?>>Bold</option>
									<option <?php if($ghanghout_replay_logo_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
								</select>

								<select name="ghanghout_replay_logo_shadow" id="ghanghout_replay_logo_shadow">
									<option <?php if($ghanghout_replay_logo_shadow=="None" || $ghanghout_replay_logo_shadow=='')echo "selected=''"; ?> >None</option>
									<option <?php if($ghanghout_replay_logo_shadow=="Small")echo "selected=''"; ?>>Small</option>
									<option <?php if($ghanghout_replay_logo_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
									<option <?php if($ghanghout_replay_logo_shadow=="Large")echo "selected=''"; ?>>Large</option>
								</select>

								<select name="ghanghout_replay_logo_height" id="ghanghout_replay_logo_height">
									<option <?php if($ghanghout_replay_logo_height=="70%")echo "selected=''"; ?> >70%</option>
									<option <?php if($ghanghout_replay_logo_height=="75%")echo "selected=''"; ?>>75%</option>
									<option <?php if($ghanghout_replay_logo_height=="75%" || $ghanghout_replay_logo_height=='')echo "selected=''"; ?>>80%</option>
									<option <?php if($ghanghout_replay_logo_height=="85%")echo "selected=''"; ?> >85%</option>
									<option <?php if($ghanghout_replay_logo_height=="90%")echo "selected=''"; ?> >90%</option>
									<option <?php if($ghanghout_replay_logo_height=="95%")echo "selected=''"; ?> >95%</option>
									<option <?php if($ghanghout_replay_logo_height=="100%")echo "selected=''"; ?> >100%</option>
								</select>

								<select name="ghanghout_replay_logo_spacing" id="ghanghout_replay_logo_spacing">
									<option <?php if($ghanghout_replay_logo_spacing=="-3" || $ghanghout_replay_logo_spacing=='')echo "selected=''"; ?> >-3</option>
									<option <?php if($ghanghout_replay_logo_spacing=="-2" )echo "selected=''"; ?>>-2</option>
									<option <?php if($ghanghout_replay_logo_spacing=="-1" )echo "selected=''"; ?>>-1</option>
									<option <?php if($ghanghout_replay_logo_spacing=="0" )echo "selected=''"; ?>>0</option>
									<option <?php if($ghanghout_replay_logo_spacing=="1" )echo "selected=''"; ?>>1</option>
									<option <?php if($ghanghout_replay_logo_spacing=="2" )echo "selected=''"; ?>>2</option>
									<option <?php if($ghanghout_replay_logo_spacing=="3" )echo "selected=''"; ?>>3</option>
								</select>

								 <input name="ghanghout_replay_logo_color" id="ghanghout_replay_logo_color" type="text" value="<?php echo $ghanghout_replay_logo_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

			</div>
			</div>
			</div>
							
			</div>
								<?php 
									$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
									if($google_hangout_theme == "Default" or $selected_theme ==  "Default" or $selected_theme == "Template_7" or $selected_theme == "Template_10" or $google_hangout_theme == "Template_7" or $google_hangout_theme == "Template_10"  ){
									}
									elseif($selected_theme!='' or $google_hangout_theme !=''){
									$google_hangout_selected_theme=str_replace('_',' ',$selected_theme);
									if($google_hangout_selected_theme==''){
											$google_hangout_selected_theme=$google_hangout_theme;
											$google_hangout_selected_theme=str_replace('_',' ',$google_hangout_selected_theme);
											}
									?>
									<!-- Theme Settings Start -->
										<div id="myMenuB4" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Theme settings </div>
										<div id="myDivB4" class="gh_accordian_div">
									<?php
										include_once 'themes/'.$google_hangout_selected_theme.'/replay_back.php';
									?>
										</div>
										<!-- Theme Settings End -->
									<?php
									}
								?>		
                        
 </div>						<?php									 $exp_url1	=	explode("?",get_permalink($_REQUEST['EID']));			$count=count($exp_url1);			if($count >1)			{								 $replay_prev_url	=	get_permalink($_REQUEST['EID'])."&replay_preview=true";			}else{								 $replay_prev_url	=	get_permalink($_REQUEST['EID'])."?replay_preview=true";			}			//echo $thank_prev_url; die;			?>
				<div class="actionBar">
							<a class="hangout_btn preview_replay_button" name="preview_replay_hangout" href="javascript:void(0);"><i class="icon-plus-sign"></i> Save & Preview Re Play Webinar</a>
                        	<button class="hangout_btn update_replay_event" name="edit_replay_hangout" type="submit"><i class="icon-plus-sign"></i> Update Re Play Webinar</button>
                </div>
				</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".preview_replay_button").live('click',function(){
			jQuery(".update_replay_event").trigger('click');
			setTimeout(function(){
				window.open('<?php echo $replay_prev_url;?>','_blank');
			},800);
			
		});
		
		jQuery('#hangout_replay_embed_code_time').timepicker({
					timeFormat: 'mm:ss',
				});
		
	});
	
		
</script>