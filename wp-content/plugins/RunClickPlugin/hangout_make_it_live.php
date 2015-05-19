<?php
global $post, $wpdb;
$base_path			=	plugin_dir_url(__FILE__);
$upload_dir = wp_upload_dir(); 
$baseurl = $upload_dir['baseurl']; 
$selected_theme=$_REQUEST['selected_theme'];

if($_REQUEST['action']=='delete_webinar_live_logo'){
	$webinar_id=$_GET['EID'];
	 $live_logoname=$_GET['live_logo_name'];
	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['basedir'];
	@chmod($uploads_dir,0755);

	//unlink($uploads_dir.'/'.$live_logoname);
	update_post_meta($webinar_id,"ghanghout_make_live_logo","");
	$message="</div class='updated'>Logo Deleted successfully.</div>";
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$webinar_id&sel=3");
}



if(isset($_POST['edit_live_hangout'])){
	$banner_name = $_FILES["ghanghout_make_live_full_banner_image"]["name"];
	$ghanghout_logo = $_FILES["ghanghout_make_live_logo"]["name"];
	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['basedir'];
	@chmod($uploads_dir,0755);
	if($banner_name !=''){
		move_uploaded_file( $_FILES["ghanghout_make_live_full_banner_image"]["tmp_name"], "$uploads_dir/$banner_name");
	} 
	if($ghanghout_logo !=''){
		move_uploaded_file($_FILES["ghanghout_make_live_logo"]["tmp_name"], "$uploads_dir/$ghanghout_logo");
	}
	$post_id = $_REQUEST['hangout_id'];
	$youtubedata = $_POST['hangout_youtube'];
	//$youtubedata = addslashes($youtubedata);
	$my_post = array();
	$my_post['ID'] = $post_id;
	$my_post['post_content'] = $youtubedata;
	// Update the post into the database
	wp_update_post( $my_post );
	update_post_meta($post_id,"hangout_title",$_POST["hangout_youtube"]);
	update_post_meta($post_id,"hangout_youtube_src",$_POST["hangout_youtube_src"]);
	
	if(isset($_POST['g_hangout_make_live_layout_type'])){
		update_post_meta($post_id,"youtube_video_size",$_POST["youtube_video_size"]);
		update_post_meta($post_id,"g_hangout_make_live_layout_type",$_POST["g_hangout_make_live_layout_type"]);
		update_post_meta($post_id,"ghanghout_make_live_headline",$_POST["ghanghout_make_live_headline"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_family",$_POST["ghanghout_make_live_headline_family"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_size",$_POST["ghanghout_make_live_headline_size"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_style",$_POST["ghanghout_make_live_headline_style"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_shadow",$_POST["ghanghout_make_live_headline_shadow"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_height",$_POST["ghanghout_make_live_headline_height"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_spacing",$_POST["ghanghout_make_live_headline_spacing"]);
		update_post_meta($post_id,"ghanghout_make_live_headline_color",$_POST["ghanghout_make_live_headline_color"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead",$_POST["ghanghout_make_live_subhead"]);
		update_post_meta($post_id,"ghanghout_subhead_family",$_POST["ghanghout_subhead_family"]);
		update_post_meta($post_id,"ghanghout_subhead_size",$_POST["ghanghout_subhead_size"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead_style",$_POST["ghanghout_make_live_subhead_style"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead_shadow",$_POST["ghanghout_make_live_subhead_shadow"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead_height",$_POST["ghanghout_make_live_subhead_height"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead_spacing",$_POST["ghanghout_make_live_subhead_spacing"]);
		update_post_meta($post_id,"ghanghout_make_live_subhead_color",$_POST["ghanghout_make_live_subhead_color"]);
		update_post_meta($post_id,"ghanghout_make_live_option1editor",$_POST["ghanghout_make_live_option1editor"]);
		if($banner_name !=''){
			update_post_meta($post_id,"ghanghout_make_live_full_banner_image",$banner_name);
		} 
	}
	update_post_meta($post_id,"keep_registration_form",$_POST["keep_registration_form"]);
	update_post_meta($post_id,"show_social_button",$_POST["show_social_button"]);
	
	if(isset($_POST['ghanghout_editor_undervideo_live']))
		update_post_meta($post_id,"ghanghout_editor_undervideo_live",$_POST["ghanghout_editor_undervideo_live"]);
	 


	/* Option 1 end values*/
	update_post_meta($post_id,"ghanghout_make_live_timer_position",$_POST["ghanghout_make_live_timer_position"]);

	update_post_meta($post_id,"ghanghout_make_live_enable_header",$_POST["ghanghout_make_live_enable_header"]);
	update_post_meta($post_id,"ghanghout_make_live_enable_sharing",$_POST["ghanghout_make_live_enable_sharing"]);

	if($ghanghout_logo !=''){
		update_post_meta($post_id,"ghanghout_make_live_logo",$ghanghout_logo);
	}
	update_post_meta($post_id,"ghanghout_make_live_logo_text",$_POST["ghanghout_make_live_logo_text"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_family",$_POST["ghanghout_make_live_logo_family"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_size",$_POST["ghanghout_make_live_logo_size"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_style",$_POST["ghanghout_make_live_logo_style"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_shadow",$_POST["ghanghout_make_live_logo_shadow"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_height",$_POST["ghanghout_make_live_logo_height"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_spacing",$_POST["ghanghout_make_live_logo_spacing"]);
	update_post_meta($post_id,"ghanghout_make_live_logo_color",$_POST["ghanghout_make_live_logo_color"]);
	update_post_meta($post_id,"chat_make_off_replay",$_POST["chat_make_off_replay"]);
	update_post_meta($post_id,"hangout_webinar_auto_play_live",$_POST["hangout_webinar_auto_play_live"]);
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	
	$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_addr) );
	$lat = $geoplugin['geoplugin_latitude'];
	$long = $geoplugin['geoplugin_longitude'];
	$geozone =  file_get_contents('http://www.earthtools.org/timezone/'.$lat.'/'.$long) ;
	$xml = simplexml_load_string($geozone);
	$stdata = json_encode($xml->isotime);
	update_post_meta($post_id,"hangout_live_timer",$stdata);
	/* Bhuvnesh Code for theme settings */
	$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);

	if($google_hangout_theme == "Default" || $google_hangout_theme	==	""){}
	else{
	include_once 'themes/'.$google_hangout_theme.'/live_back.php';
	}

	/* Bhuvnesh Code for theme settings End */

	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$post_id&sel=3");

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
$yousrc ='';
$event_reg='';
$event_notification='1';
$reminder_time =array(24);
$hangout_registration_system = 1;
$aweber ='';
$getresponse ='';
$aweber_name ='';
$aweber_email ='';
$getresponse_name ='';
$getresponse_email ='';
if(isset($_REQUEST['EID'])){
	$postdata = get_post($post_id);

	$title=get_post_meta($post_id,'hangout_title',true);
	$event_reg = get_post_meta($post_id,'hangout_registration',true);
	$event_notification = get_post_meta($post_id,'hangout_send_notifications',true);
	$reminder = get_post_meta($post_id,'reminder_time',true);
	$reminder_time = explode(",",$reminder);
	$timezone = get_post_meta($post_id,'hangout_timezone',true);
	$youcode=stripslashes($postdata->post_title);
	$youembed=stripslashes($postdata->post_content);
	$yousrc =get_post_meta($post_id,'hangout_youtube_src',true);
	$yousrc_size =get_post_meta($post_id,'youtube_video_size',true);
	$hangout_registration_system = get_post_meta($post_id,'hangout_registration_system',true);
	$aweber =get_post_meta($post_id,'hangout_amber_from',true);
	$getresponse =get_post_meta($post_id,'hangout_getresponse_from',true);

	$aweber_name =get_post_meta($post_id,'hangout_amber_name_field',true);
	$aweber_email =get_post_meta($post_id,'hangout_amber_name_email',true);
	$getresponse_name =get_post_meta($post_id,'hangout_getresponse_name_field',true);
	$getresponse_email =get_post_meta($post_id,'hangout_getresponse_name_email',true);
	
	$g_hangout_make_live_layout_type = get_post_meta($post_id,"g_hangout_make_live_layout_type",true);
	$ghanghout_make_live_headline =	get_post_meta($post_id,"ghanghout_make_live_headline",true);
	$ghanghout_make_live_headline_family = get_post_meta($post_id,"ghanghout_make_live_headline_family",true);
	$ghanghout_make_live_headline_size = get_post_meta($post_id,"ghanghout_make_live_headline_size",true);
	
	$ghanghout_make_live_headline_style =	get_post_meta($post_id,"ghanghout_make_live_headline_style",true);
	$ghanghout_make_live_headline_shadow = get_post_meta($post_id,"ghanghout_make_live_headline_shadow",true);
	$ghanghout_make_live_headline_height = get_post_meta($post_id,"ghanghout_make_live_headline_height",true);
	$ghanghout_make_live_headline_spacing = get_post_meta($post_id,"ghanghout_make_live_headline_spacing",true);
	$ghanghout_make_live_headline_color =	get_post_meta($post_id,"ghanghout_make_live_headline_color",true);
	$ghanghout_make_live_subhead = get_post_meta($post_id,"ghanghout_make_live_subhead",true);
	$ghanghout_make_live_subhead_family =	get_post_meta($post_id,"ghanghout_subhead_family",true);
	$ghanghout_make_live_subhead_size =	get_post_meta($post_id,"ghanghout_subhead_size",true);
		
	$ghanghout_make_live_subhead_style = get_post_meta($post_id,"ghanghout_make_live_subhead_style",true);
	$ghanghout_make_live_subhead_shadow =	get_post_meta($post_id,"ghanghout_make_live_subhead_shadow",true);
	$ghanghout_make_live_subhead_height =	get_post_meta($post_id,"ghanghout_make_live_subhead_height",true);
	$ghanghout_make_live_subhead_spacing = get_post_meta($post_id,"ghanghout_make_live_subhead_spacing",true);
	$ghanghout_make_live_subhead_color =	get_post_meta($post_id,"ghanghout_make_live_subhead_color",true);
	$ghanghout_make_live_option1editor =	get_post_meta($post_id,"ghanghout_make_live_option1editor",true);
	$ghanghout_editor_undervideo_live =	get_post_meta($post_id,"ghanghout_editor_undervideo_live",true);
	$ghanghout_make_live_full_banner_image =	get_post_meta($post_id,"ghanghout_make_live_full_banner_image",true);
		/* Option 1 end values*/
	$ghanghout_make_live_timer_position = get_post_meta($post_id,"ghanghout_make_live_timer_position",true);
	$ghanghout_make_live_enable_sharing = get_post_meta($post_id,"ghanghout_make_live_enable_sharing",true);

	$ghanghout_make_live_enable_header = get_post_meta($post_id,"ghanghout_make_live_enable_header",true);
	$ghanghout_make_live_logo = get_post_meta($post_id,"ghanghout_make_live_logo",true);
	$ghanghout_make_live_logo_text = get_post_meta($post_id,"ghanghout_make_live_logo_text",true);
	$ghanghout_make_live_logo_family = get_post_meta($post_id,"ghanghout_make_live_logo_family",true);
	$ghanghout_make_live_logo_size = get_post_meta($post_id,"ghanghout_make_live_logo_size",true);
	$ghanghout_make_live_logo_style =	get_post_meta($post_id,"ghanghout_make_live_logo_style",true);
	$ghanghout_make_live_logo_shadow = get_post_meta($post_id,"ghanghout_make_live_logo_shadow",true);
	$ghanghout_make_live_logo_height = get_post_meta($post_id,"ghanghout_make_live_logo_height",true);
	$ghanghout_make_live_logo_spacing =	get_post_meta($post_id,"ghanghout_make_live_logo_spacing",true);
	$ghanghout_make_live_logo_color =	get_post_meta($post_id,"ghanghout_make_live_logo_color",true);
	$chat_make_off_replay =	get_post_meta($post_id,"chat_make_off_replay",true);
	$live_auto_play =	get_post_meta($post_id,"hangout_webinar_auto_play_live",true);
}

?>





<?php 
$keep_registration_form =get_post_meta($post_id,'keep_registration_form',true);
$show_social_button =get_post_meta($post_id,'show_social_button',true);
?>
<form method="post" id="hangout_manage" name="add_hangout" action="" enctype="multipart/form-data">
<input type="hidden" name="hangout_id" value="<?php echo $_REQUEST['EID'];?>" />
<div class="gh_tabs_div_inner">

                        <div id="myMenu5" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Live Event Settings </div>
						<div id="myDiv5" class="gh_accordian_div">
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar ID </strong>
                            </div>
                            <div class="span8">
								<input type="text" name="" id="" value="<?php echo $post_id; ?>" readonly disabled="disabled"/>
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar Auto Play</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_webinar_auto_play_live" value="1" <?php if($live_auto_play==1 || $live_auto_play==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="hangout_webinar_auto_play_live" value="0" <?php if($live_auto_play==0){ echo 'checked="checked"'; } ?>/> No</span>

								
                            </div>
                        </div>
                        </div>
						<?php 
					if(($google_hangout_theme != "" or $selected_theme!='') and $selected_theme !='Default'){
					}
					else{
					?>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Keep registration form </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="keep_registration_form" value="1" <?php if($keep_registration_form=='1' || $keep_registration_form==''){ echo 'checked';} ?>/> Yes &nbsp;&nbsp; <input type="radio" name="keep_registration_form" value="0" <?php if($keep_registration_form=='0'){ echo 'checked';} ?>/> No
                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Social Buttons</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_social_button" value="1" <?php if($show_social_button=='1' || $show_social_button==''){ echo 'checked';} ?>/> Yes &nbsp;&nbsp; <input type="radio" name="show_social_button" value="0" <?php if($show_social_button=='0'){ echo 'checked';} ?>/> No
                            </div>
                        </div>
                        </div>
						<?php } ?>
						
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Start Webinar</strong>
                            </div>
                            <div class="span8">
                            	<?php if(get_post_meta($_REQUEST['EID'],'hangout_public_private',true) == "private"){ ?>
								<a id="start_ghangout" class="ghangout" href="https://plus.google.com/hangouts/_?gid=<?php //echo get_option('g_project_id'); ?>" style="text-decoration:none;"> <img src="https://ssl.gstatic.com/s2/oz/images/stars/hangout/1/gplus-hangout-15x79-normal.png" alt="Start a Hangout" /></a>
								<?php }else{ ?>
								<a id="start_ghangout" class="ghangout" href="https://plus.google.com/hangouts/_?hso=0&gid=<?php //echo get_option('g_project_id'); ?>" style="text-decoration:none;"> <img src="https://ssl.gstatic.com/s2/oz/images/stars/hangout/1/gplus-hangout-15x79-normal.png" alt="Start a Hangout" /></a>
                            	<?php }?>
                            </div>
                        </div>
                        </div>
						
                        <?php if(get_post_meta($_REQUEST['EID'],'hangout_public_private',true) != "private"){ ?>
                       
						<?php } ?>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Youtube URL </strong>                                
                            </div>
                            <div class="span8">
								<input type="text" name="hangout_youtube" id="hangout_youtube" value="<?php echo $title; ?>" />
                            </div>
                        </div>
                        </div>						
						
						<?php if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){}else {?>
                        <div class="row-fluid-outer"  id="youtube_video_size_cont">
						
                        <div class="row-fluid">
							<div class="span4">
								<strong>Youtube Video Size(Select any width) </strong>
                            </div>
                            <div class="span8">
									<select name="youtube_video_size" id="youtube_video_size">
										<option value="420 x 315" <?php if($yousrc_size=="420 x 315"){ echo "selected=selected"; }?> > 420</option>
										<option value="480 x 360" <?php if($yousrc_size=="480 x 360"){ echo "selected=selected"; }?>>480</option>
										<option value="640 x 480" <?php if($yousrc_size=="640 x 480"){ echo "selected=selected"; }?>>640</option>
										<option value="915 x 600" <?php if($yousrc_size=="915 x 600" || $yousrc_size==""){ echo "selected=selected"; } ?> > 915</option>

									</select>
                            </div>
                        </div>
						
                        </div>
						<?php } ?>
                       <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Turn On Chat At Make Live?  </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="chat_make_off_replay" value="1" <?php if($chat_make_off_replay==1 || $chat_make_off_replay==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="chat_make_off_replay" value="0" <?php if($chat_make_off_replay==0){ echo 'checked="checked"'; } ?>/> No
                                </div>
                            </div>
                        </div>
                        </div>
                       <?php 
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
						?>
						<div id="myMenu61" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Add Html below Webinar video </div>
							<div id="myDiv61" class="gh_accordian_div">
								<div class="ghanghoutDiv" >
						
								<?php if(isset($_REQUEST['EID'])){ ?>
									<a href="javascript:void(0);" class="preview_hangout_event">Save and preview</a>
								<?php } ?>
							<br/>
							<?php echo wp_editor( $ghanghout_editor_undervideo_live, 'ghanghout_editor_undervideo_live' ); ?>


							</div>
							</div>
					<?php
					}						
					else{
					?>					
                        <div id="myMenu6" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Page Design </div>
						<div id="myDiv6" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Live Page Design </strong>
                            </div>
                            <div class="span8">
								<div class="row-fluid">
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_make_live_layout_type ==1 || $g_hangout_make_live_layout_type==''){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_make_live_layout_type" value="1">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/option1.png" alt=""/>
                                    </div>
                                    </div>
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_make_live_layout_type ==2){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_make_live_layout_type" value="2">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/option2.png" alt=""/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
							<div id="liveoption2layout" <?php if($g_hangout_make_live_layout_type==1 || $g_hangout_make_live_layout_type==''){ echo 'style="display:none;"'; } ?>>

							 <div class="row-fluid-outer">
	                        <div class="row-fluid">
							        <div class="span6">
							<b>Full Banner Image</b>  
									</div><div class="span6">
							<input type="file" name="ghanghout_make_live_full_banner_image" id="ghanghout_make_live_full_banner_image" value="" class="ghanghoutUpload upload2">
							<?php if($ghanghout_make_live_full_banner_image!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_make_live_full_banner_image;?>">
								<?php } ?>
							</div>
							</div>
							</div>
							<!--<div class="row-fluid-outer">
	                        <div class="row-fluid">
							<div class="span6">
							<b>Registration Form Position</b>  </div>
							<div class="span6">
							<input type="radio" name="ghanghout_make_live_timer_position"  value="top" <?php if($ghanghout_make_live_timer_position=='' || $ghanghout_make_live_timer_position == "top")echo 'checked="checked"';?>> Top &nbsp;&nbsp;
							<input type="radio" name="ghanghout_make_live_timer_position"  value="bottom" <?php if($ghanghout_make_live_timer_position == "bottom")echo 'checked="checked"';?>> Bottom
							</div>
							</div>
							</div>-->
							
					</div>
						<div id="liveoption1layout" <?php if($g_hangout_make_live_layout_type==2){ echo 'style="display:block;"'; } ?>>
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="notfullscreen" style="">

							<div class="ghanghoutDiv" id="headline">
							<p class="ghanghoutHeading">Headline Settings</p>

							<b>Headline Text</b><br>
							<span class="howto">Enter text for your headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_make_live_headline" rows="2" cols="60" class="ghanghoutText"><?php echo $ghanghout_make_live_headline; ?></textarea>

							<p><b>Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_make_live_headline_family" id="ghanghout_make_live_headline_family">
							<option <?php if($ghanghout_make_live_headline_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_make_live_headline_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_make_live_headline_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_make_live_headline_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_make_live_headline_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_make_live_headline_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_make_live_headline_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_make_live_headline_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_make_live_headline_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_make_live_headline_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_make_live_headline_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_make_live_headline_size" id="ghanghout_make_live_headline_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_make_live_headline_size=='' && $x==48){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_make_live_headline_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_make_live_headline_style" id="ghanghout_make_live_headline_style">
								<option <?php if($ghanghout_make_live_headline_style=="Normal" || $ghanghout_make_live_headline_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_make_live_headline_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_make_live_headline_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_make_live_headline_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_make_live_headline_shadow" id="ghanghout_make_live_headline_shadow">
								<option <?php if($ghanghout_make_live_headline_shadow=="None" || $ghanghout_make_live_headline_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_make_live_headline_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_make_live_headline_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_make_live_headline_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_make_live_headline_height" id="ghanghout_make_live_headline_height">
								<option <?php if($ghanghout_make_live_headline_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_make_live_headline_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_make_live_headline_height=="75%" || $ghanghout_make_live_headline_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_make_live_headline_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_make_live_headline_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_make_live_headline_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_make_live_headline_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_make_live_headline_spacing" id="ghanghout_make_live_headline_spacing">
								<option <?php if($ghanghout_make_live_headline_spacing=="-3" || $ghanghout_make_live_headline_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_make_live_headline_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_make_live_headline_color" id="ghanghout_make_live_headline_color" type="text" value="<?php echo $ghanghout_make_live_headline_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>
							</p>

							<b>Sub-Headline Text</b><br>
							<span class="howto">Enter text for your sub-headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_make_live_subhead" rows="2" cols="60" class="ghanghout_make_liveText"><?php echo $ghanghout_make_live_subhead; ?></textarea>

							<p><b>Sub-Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_subhead_family" id="ghanghout_make_live_subhead_family">
								<option <?php if($ghanghout_make_live_subhead_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_make_live_subhead_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_make_live_subhead_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_subhead_size" id="ghanghout_make_live_subhead_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_make_live_subhead_size=='' && $x==28){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_make_live_subhead_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_make_live_subhead_style" id="ghanghout_make_live_subhead_style">
								<option <?php if($ghanghout_make_live_subhead_style=="Normal" || $ghanghout_make_live_subhead_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_make_live_subhead_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_make_live_subhead_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_make_live_subhead_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_make_live_subhead_shadow" id="ghanghout_make_live_subhead_shadow">
								<option <?php if($ghanghout_make_live_subhead_shadow=="None" || $ghanghout_make_live_subhead_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_make_live_subhead_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_make_live_subhead_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_make_live_subhead_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_make_live_subhead_height" id="ghanghout_make_live_subhead_height">
								<option <?php if($ghanghout_make_live_subhead_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="75%" || $ghanghout_make_live_subhead_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_make_live_subhead_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_make_live_subhead_spacing" id="ghanghout_make_live_subhead_spacing">
								<option <?php if($ghanghout_make_live_subhead_spacing=="-3" || $ghanghout_make_live_subhead_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_make_live_subhead_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_make_live_subhead_color" id="ghanghout_make_live_subhead_color" type="text" value="<?php echo $ghanghout_make_live_subhead_color;?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

							</p>
							</div>
							</div>
							<?php if($ghanghout_make_live_option1editor == "")
							{
								$ghanghout_make_live_option1editor	= '<p style="text-align: center;">[live_hangout]</p><p style="text-align: center;">[ghangout_reg_form]</p>';
							}
							?>
							<div class="ghanghoutDiv" >
								
							<b>Shortcode Available </b><br>
							Event Live Video = [live_hangout]<br>
							Registration From= [ghangout_reg_form] 
							<br>
							<?php echo wp_editor( $ghanghout_make_live_option1editor, 'ghanghout_make_live_option1editor' ); ?>


							</div>
							</div>
							</div>
							</div>
						
					</div>
					<?php } ?>
					<div id="myMenu7" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Live Webinar Header Settings </div>
						<div id="myDiv7" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo / Social Sharing </strong>
                            </div>
                            <div class="span8">
								<input id="ghanghout_make_live_enable_header" name="ghanghout_make_live_enable_header" size="30" value="checked" type="checkbox" <?php if($ghanghout_make_live_enable_header=="checked"){ echo 'checked="checked"'; } ?> > Enable Logo &nbsp;&nbsp;<input id="ghanghout_make_live_enable_sharing" name="ghanghout_make_live_enable_sharing" size="30" value="checked" type="checkbox" <?php if($ghanghout_make_live_enable_sharing=="checked"){ echo 'checked="checked"'; } ?>> Enable Social Sharing 
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
								<input type="file" class="ghanghout_make_liveUpload upload2" name="ghanghout_make_live_logo" id="ghanghout_make_live_logo" value="" class="ghanghoutUpload upload2">
								<?php if($ghanghout_make_live_logo!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_make_live_logo;?>">
									<a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete_webinar_live_logo&live_logo_name=<?php echo $ghanghout_make_live_logo;?>&EID=<?echo $post_id;?>" class="h_editing_link">
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
								<input class="longinput"  type="text" name="ghanghout_make_live_logo_text" id="ghanghout_make_live_logo_text" value="<?php echo $ghanghout_make_live_logo_text; ?>" class="ghanghoutText">
                            </div>
                        </div>
                        </div>


					 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span12">
								<b>Logo Style</b><br>
								<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
								<select name="ghanghout_make_live_logo_family" id="ghanghout_make_live_logo_family">

									<option <?php if($ghanghout_make_live_logo_family=="Arial")echo "selected=''"; ?>>Arial</option>
									<option <?php if($ghanghout_make_live_logo_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
									<option <?php if($ghanghout_make_live_logo_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

									<option <?php if($ghanghout_make_live_logo_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
									<option <?php if($ghanghout_make_live_logo_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
									<option <?php if($ghanghout_make_live_logo_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
									<option <?php if($ghanghout_make_live_logo_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
									<option <?php if($ghanghout_make_live_logo_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
									<option <?php if($ghanghout_make_live_logo_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
									<option <?php if($ghanghout_make_live_logo_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
									<option <?php if($ghanghout_make_live_logo_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
								</select>

								<select name="ghanghout_make_live_logo_size" id="ghanghout_make_live_logo_size">
								<?php $x=10; 
								while($x<=100){
									$chk='';
									if($ghanghout_make_live_logo_size=='' && $x==48){
										$chk = 'selected="selected"';
									} else {
										echo $comparstr = $ghanghout_make_live_logo_size.'px';
										if($comparstr==$x){
											$chk = 'selected="selected"';
										}
									}
								echo '<option '.$chk.'>'.$x.'px</option>';
								$x++;
								}
								?>
								</select>
								<select name="ghanghout_make_live_logo_style" id="ghanghout_make_live_logo_style">
									<option <?php if($ghanghout_make_live_logo_style=="Normal" || $ghanghout_make_live_logo_style=='')echo "selected=''"; ?> >Normal</option>
									<option <?php if($ghanghout_make_live_logo_style=="Italic")echo "selected=''"; ?>>Italic</option>
									<option <?php if($ghanghout_make_live_logo_style=="Bold")echo "selected=''"; ?>>Bold</option>
									<option <?php if($ghanghout_make_live_logo_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
								</select>

								<select name="ghanghout_make_live_logo_shadow" id="ghanghout_make_live_logo_shadow">
									<option <?php if($ghanghout_make_live_logo_shadow=="None" || $ghanghout_make_live_logo_shadow=='')echo "selected=''"; ?> >None</option>
									<option <?php if($ghanghout_make_live_logo_shadow=="Small")echo "selected=''"; ?>>Small</option>
									<option <?php if($ghanghout_make_live_logo_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
									<option <?php if($ghanghout_make_live_logo_shadow=="Large")echo "selected=''"; ?>>Large</option>
								</select>

								<select name="ghanghout_make_live_logo_height" id="ghanghout_make_live_logo_height">
									<option <?php if($ghanghout_make_live_logo_height=="70%")echo "selected=''"; ?> >70%</option>
									<option <?php if($ghanghout_make_live_logo_height=="75%")echo "selected=''"; ?>>75%</option>
									<option <?php if($ghanghout_make_live_logo_height=="75%" || $ghanghout_make_live_logo_height=='')echo "selected=''"; ?>>80%</option>
									<option <?php if($ghanghout_make_live_logo_height=="85%")echo "selected=''"; ?> >85%</option>
									<option <?php if($ghanghout_make_live_logo_height=="90%")echo "selected=''"; ?> >90%</option>
									<option <?php if($ghanghout_make_live_logo_height=="95%")echo "selected=''"; ?> >95%</option>
									<option <?php if($ghanghout_make_live_logo_height=="100%")echo "selected=''"; ?> >100%</option>
								</select>

								<select name="ghanghout_make_live_logo_spacing" id="ghanghout_make_live_logo_spacing">
									<option <?php if($ghanghout_make_live_logo_spacing=="-3" || $ghanghout_make_live_logo_spacing=='')echo "selected=''"; ?> >-3</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="-2" )echo "selected=''"; ?>>-2</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="-1" )echo "selected=''"; ?>>-1</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="0" )echo "selected=''"; ?>>0</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="1" )echo "selected=''"; ?>>1</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="2" )echo "selected=''"; ?>>2</option>
									<option <?php if($ghanghout_make_live_logo_spacing=="3" )echo "selected=''"; ?>>3</option>
								</select>

								 <input name="ghanghout_make_live_logo_color" id="ghanghout_make_live_logo_color" type="text" value="<?php echo $ghanghout_make_live_logo_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

			</div>
			</div>
			</div>
			</div>
							<?php 
								$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
								if($google_hangout_theme == "Default" or $selected_theme ==  "Default" ){
								}
								elseif($selected_theme!=''  or $google_hangout_theme !=''){
								$google_hangout_selected_theme=str_replace('_',' ',$selected_theme);
								if($google_hangout_selected_theme==''){
									$google_hangout_selected_theme=$google_hangout_theme;
									$google_hangout_selected_theme=str_replace('_',' ',$google_hangout_selected_theme);
									}
								?>
								<!-- Theme Settings Start -->
									<div id="myMenuB3" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Theme settings </div>
									<div id="myDivB3" class="gh_accordian_div">
								<?php
									include_once 'themes/'.$google_hangout_selected_theme.'/live_back.php';
								?>
									</div>
									<!-- Theme Settings End -->
								<?php
								}
							?>
			</div>
			<?php
			$live_exp_url	=	explode("?",get_permalink($_REQUEST['EID']));
			if(count($live_exp_url) >1)
			{
				$live_prev_url	=	get_permalink($_REQUEST['EID'])."&live_preview=true";
			}
			else
			{
				$live_prev_url	=	get_permalink($_REQUEST['EID'])."?live_preview=true";
			}
			?>
			<div class="actionBar">
				<a class="hangout_btn preview_live_button" href='javascript:void(0);'><i class="icon-plus-sign"></i> Save & Preview Live Webinar </a>
				<button class="hangout_btn update_live_event" type="submit" name="edit_live_hangout"><i class="icon-plus-sign"></i> Update Live Webinar </button>
			</div>
</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".preview_live_button").live('click',function(){
			jQuery(".update_live_event").trigger('click');
			setTimeout(function(){
				window.open('<?php echo $live_prev_url; ?>','_blank');
			},800);
		});
		
		
		
	});
</script>