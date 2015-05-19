<?php
global $post, $wpdb;
$upload_dir = wp_upload_dir(); 
$baseurl = $upload_dir['baseurl']; 

$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
if($_REQUEST['action']=='delete_webinar_logo'){
	$webinar_id=$_GET['EID'];
	 $logoname=$_GET['logo_name'];
	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['basedir'];
	@chmod($uploads_dir,0755);

	//unlink($uploads_dir.'/'.$logoname);
	update_post_meta($webinar_id,"ghanghout_logo","");
	$message="</div class='updated'>Logo Deleted successfully.</div>";
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$webinar_id&sel=2");
}
if(isset($_POST['edit_event_hangout'])){


	// Update the post into the database
	

		  $banner_name = $_FILES["ghanghout_full_banner_image"]["name"];
		  $ghanghout_logo = $_FILES["ghanghout_logo"]["name"];
		  $uploads = wp_upload_dir();
	      $uploads_dir = $uploads['basedir'];
			@chmod($uploads_dir,0755);


	
		if($banner_name !=''){
			move_uploaded_file( $_FILES["ghanghout_full_banner_image"]["tmp_name"], "$uploads_dir/$banner_name");
		} 
		if($ghanghout_logo !=''){
			move_uploaded_file($_FILES["ghanghout_logo"]["tmp_name"], "$uploads_dir/$ghanghout_logo");
		}

	
	$post_id = $_REQUEST['hangout_id'];
	$my_post = array();
	  $my_post['ID'] = $post_id;
	  $my_post['post_title'] = addslashes($_POST["hangout_title"]);
	   $youtubedata = $_POST['hangout_record_embed_code_url'];
	  if($youtubedata!=''){
	 
	$my_post['post_content'] = $youtubedata;
	}
// Update the post into the database

  wp_update_post( $my_post );
$timeapidata = timeapi_servicecall('timeservice', array('placeid'=>$_POST['hangout_time_zone']));

$timeapizone = $timeapidata->timezone->offset;
//print_r($_POST["hangout_timezone"]);
if($_POST["hangout_timezone"]!=""){
$newdate=explode(" ",$_POST["hangout_timezone"]);

$day_month=explode('/' ,$newdate[0]);
//print_r($day_month);
$new_date_for_database=$day_month[1].'/'.$day_month[0].'/'.$day_month[2].' '.$newdate[1].' '.$newdate[2];


		$newtimezone = $new_date_for_database .' ' .$timeapizone;
		}
		
		/* check if time is changing unset all mails variables */
		
		$old_hangout_time = get_post_meta($post_id,"hangout_timezone",true);
		if($old_hangout_time!=$newtimezone){
			update_post_meta($post_id,"minute_cron_mail_send",'0');
			update_post_meta($post_id,"hourly_cron_mail_send",'0');
			update_post_meta($post_id,"daily_cron_mail_send",'0');
			update_post_meta($post_id,"follow_minute_cron_mail_send",'0');
			update_post_meta($post_id,"reminder_minute_cron_mail_send",'0');
		}
		
		update_post_meta($post_id,"hangout_timezone",$newtimezone);
		//$reminder_time = 	implode(",", $_POST['reminder_time']);
		if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) { 

}else{
update_post_meta($post_id,"hangout_title",$_POST["hangout_record_embed_code_url"]);
update_post_meta($post_id,"hangout_timezone","");
}
		
		update_post_meta($post_id,"hangout_registration",$_POST["hangout_registration"]);		
		update_post_meta($post_id,"hangout_webinar_auto_play_event",$_POST["hangout_webinar_auto_play_event"]);		
		update_post_meta($post_id,"hangout_webinar_auto_play_replay",$_POST["hangout_webinar_auto_play_replay"]);		
		update_post_meta($post_id,"first_name_active",$_POST["first_name_active"]);		
		update_post_meta($post_id,"last_name_active",$_POST["last_name_active"]);		
		update_post_meta($post_id,"organisation_name_active",$_POST["organisation_name_active"]);		
		update_post_meta($post_id,"hangout_make_now",$_POST["hangout_make_now"]);
		update_post_meta($post_id,"replay_youtube_video_size",$_POST["replay_youtube_video_size"]);
		update_post_meta($post_id,"show_popup_on_video",$_POST["show_popup_on_video"]);
		update_post_meta($post_id,"registrations_date_system",$_POST["registrations_date_system"]);
		update_post_meta($post_id,"hangout_registration_system",$_POST["hangout_registration_system"]);
		
		update_post_meta($post_id,"hangout_amber_from",$_POST["hangout_amber_from"]);
		update_post_meta($post_id,"hangout_Mailchimp_list_id",$_POST["hangout_Mailchimp_list_id"]);
		update_post_meta($post_id,"hangout_ImnicaMail_list_id",$_POST["hangout_ImnicaMail_list_id"]);
		update_post_meta($post_id,"hangout_Icontact_list_id",$_POST["hangout_Icontact_list_id"]);
		update_post_meta($post_id,"hangout_Sendreach_api_key",$_POST["hangout_Sendreach_api_key"]);
		update_post_meta($post_id,"hangout_Sendreach_secret_key",$_POST["hangout_Sendreach_secret_key"]);
		update_post_meta($post_id,"hangout_Sendreach_user_id",$_POST["hangout_Sendreach_user_id"]);
		
		update_post_meta($post_id,"hangout_Icontact_user_password",$_POST["hangout_Icontact_user_password"]);
		update_post_meta($post_id,"hangout_Icontact_user_name",$_POST["hangout_Icontact_user_name"]);
		update_post_meta($post_id,"hangout_Icontact_app_id",$_POST["hangout_Icontact_app_id"]);
		update_post_meta($post_id,"hangout_GetResponce_api_key",$_POST["hangout_GetResponce_api_key"]);
		update_post_meta($post_id,"hangout_Sendreach_list_id",$_POST["hangout_Sendreach_list_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_list_id",$_POST["hangout_InfusionSoft_list_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_tag_id",$_POST["hangout_InfusionSoft_tag_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_app",$_POST["hangout_InfusionSoft_app"]);
		update_post_meta($post_id,"hangout_GetResponce_campaign_name",$_POST["hangout_GetResponce_campaign_name"]);
		update_post_meta($post_id,"hangout_Aweber_api_key",$_POST["hangout_Aweber_api_key"]);
		update_post_meta($post_id,"hangout_Aweber_consumer_Key",$_POST["hangout_Aweber_consumer_Key"]);
		update_post_meta($post_id,"hangout_Aweber_consumer_Secret",$_POST["hangout_Aweber_consumer_Secret"]);
		update_post_meta($post_id,"hangout_Aweber_access_Secret",$_POST["hangout_Aweber_access_Secret"]);
		update_post_meta($post_id,"hangout_Aweber_account_id",$_POST["hangout_Aweber_account_id"]);
		$aweber_list=$_POST["hangout_Aweber_list_id"];
		$aweber_list_name_id=explode('%',$aweber_list);
		
		update_post_meta($post_id,"hangout_Aweber_list_id",$aweber_list_name_id[0]);
		update_post_meta($post_id,"hangout_Aweber_list_name",$aweber_list_name_id[1]);
		update_post_meta($post_id,"hangout_Aweber_app_id",$_POST["hangout_Aweber_app_id"]);
		update_post_meta($post_id,"hangout_Mailchimp_api_key",$_POST["hangout_Mailchimp_api_key"]);
		update_post_meta($post_id,"hangout_amber_from",$_POST["hangout_amber_from"]);
		update_post_meta($post_id,"hangout_amber_name_email",$_POST["hangout_amber_name_email"]);
		update_post_meta($post_id,"hangout_amber_name_field",$_POST["hangout_amber_name_field"]);
		
		update_post_meta($post_id,"hangout_send_notifications",$_POST["hangout_send_notifications"]);
		update_post_meta($post_id,"hangout_day_light",$_POST["hangout_day_light"]);
		update_post_meta($post_id,"hangout_right_timer",$_POST["hangout_right_timer"]);
		update_post_meta($post_id,"ppc_theme_select_replay_time",serialize($_POST['ppc_theme_select_replay_time']));		update_post_meta($post_id,"hangout_select_replay_day",serialize($_POST['hangout_select_replay_day']));
	  

	  
		update_post_meta($post_id,"reminder_time",$reminder_time);
		update_post_meta($post_id,"hangout_show_replay",$hangout_show_replay);
	  
	
		
		
		$hanogut_timezone = $new_date_for_database .' ' .$timeapizone;
		$enddatearr = explode(" ",$hanogut_timezone);
		$endate = explode("/",$enddatearr[0]);
		$enmin = explode(":",$enddatearr[1]);
		
		$symbolz =  substr($enddatearr[3],0,1);

		$hourz = substr($enddatearr[3],1,2);

		$timez = substr($enddatearr[3],4,5);

if($enddatearr[2]=="am"){ 
			if($enmin[0]==12){
			$hour = 0;
			} else {
			$hour = $enmin[0];
			}
			$min = $enmin[1];
		} else { 
			if($enmin[0]==12){
				$hour = 12;
			} else {
				$hour = $enmin[0]+12;
			}
			$min = $enmin[1];
		}


		if($symbolz=='+'){
			if($enddatearr[1]=="am"){
				$cur = mktime((date('H')+12),date('i'),date('s'),date('m'),(date('d')-1),date('Y'));

			} else {
				$cur = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
			}

			$now = mktime($timeapidata->datetime->hour+$hourz,($timeapidata->datetime->minute+$timez),$timeapidata->datetime->second,$timeapidata->datetime->month,$timeapidata->datetime->day,$timeapidata->datetime->year);
			$end =  mktime(($hour+$hourz), ($min+$timez), 0, $endate[0], $endate[1], $endate[2]);
		} else {
			$cur = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
			
			$now = mktime(($timeapidata->datetime->hour-$hourz),($timeapidata->datetime->minute-$timez),$timeapidata->datetime->second,$timeapidata->datetime->month,$timeapidata->datetime->day,$timeapidata->datetime->year);
			 $end =  mktime(($hour-$hourz), ($min-$timez), 0, $endate[0], $endate[1], $endate[2]);
		}
		$dife = $end - $now;
		$cur_end = $cur + $dife;
		update_post_meta($post_id,"hangout_mktim_timezone",$end);
		update_post_meta($post_id,"hangout_mktim_timezone_now",$now);
		update_post_meta($post_id,"hangout_current_time",$cur);
		update_post_meta($post_id,"hangout_server_end_time",$cur_end);


		
		update_post_meta($post_id,"timer_type",$_POST['timer_type']);
	

		
		
		/* Option 1 values */
		update_post_meta($post_id,"ghanghout_enable_header",$_POST["ghanghout_enable_header"]);
		update_post_meta($post_id,"ghanghout_enable_sharing",$_POST["ghanghout_enable_sharing"]);
		if($ghanghout_logo !=''){
			update_post_meta($post_id,"ghanghout_logo",$ghanghout_logo);
		}
		update_post_meta($post_id,"ghanghout_logo_text",$_POST["ghanghout_logo_text"]);
		update_post_meta($post_id,"ghanghout_logo_family",$_POST["ghanghout_logo_family"]);
		update_post_meta($post_id,"ghanghout_logo_size",$_POST["ghanghout_logo_size"]);
		update_post_meta($post_id,"ghanghout_logo_style",$_POST["ghanghout_logo_style"]);
		update_post_meta($post_id,"ghanghout_logo_shadow",$_POST["ghanghout_logo_shadow"]);
		update_post_meta($post_id,"ghanghout_logo_height",$_POST["ghanghout_logo_height"]);
		update_post_meta($post_id,"ghanghout_logo_spacing",$_POST["ghanghout_logo_spacing"]);
		update_post_meta($post_id,"ghanghout_logo_color",$_POST["ghanghout_logo_color"]);
		
		
		if(isset($_POST['g_hangout_layout_type'])){
			update_post_meta($post_id,"g_hangout_layout_type",$_POST["g_hangout_layout_type"]);
			update_post_meta($post_id,"ghanghout_headline",$_POST["ghanghout_headline"]);
			update_post_meta($post_id,"ghanghout_headline_family",$_POST["ghanghout_headline_family"]);
			update_post_meta($post_id,"ghanghout_headline_size",$_POST["ghanghout_headline_size"]);
			update_post_meta($post_id,"ghanghout_headline_style",$_POST["ghanghout_headline_style"]);
			update_post_meta($post_id,"ghanghout_headline_shadow",$_POST["ghanghout_headline_shadow"]);
			update_post_meta($post_id,"ghanghout_headline_height",$_POST["ghanghout_headline_height"]);
			update_post_meta($post_id,"ghanghout_headline_spacing",$_POST["ghanghout_headline_spacing"]);
			update_post_meta($post_id,"ghanghout_headline_color",$_POST["ghanghout_headline_color"]);
			update_post_meta($post_id,"ghanghout_subhead",$_POST["ghanghout_subhead"]);
			update_post_meta($post_id,"ghanghout_subhead_family",$_POST["ghanghout_subhead_family"]);
			update_post_meta($post_id,"ghanghout_subhead_size",$_POST["ghanghout_subhead_size"]);
			update_post_meta($post_id,"ghanghout_subhead_style",$_POST["ghanghout_subhead_style"]);
			update_post_meta($post_id,"ghanghout_subhead_shadow",$_POST["ghanghout_subhead_shadow"]);
			update_post_meta($post_id,"ghanghout_subhead_height",$_POST["ghanghout_subhead_height"]);
			update_post_meta($post_id,"ghanghout_subhead_spacing",$_POST["ghanghout_subhead_spacing"]);
			update_post_meta($post_id,"ghanghout_subhead_color",$_POST["ghanghout_subhead_color"]);
			update_post_meta($post_id,"ghanghout_option1editor",$_POST["ghanghout_option1editor"]);
			/* Option 1 end values*/
			update_post_meta($post_id,"ghanghout_timer_position",$_POST["ghanghout_timer_position"]);
			if($banner_name !=''){
				update_post_meta($post_id,"ghanghout_full_banner_image",$banner_name);
			}  
		}
		
		if(isset($_POST['ghanghout_editor_undervideo']))
			update_post_meta($post_id,"ghanghout_editor_undervideo",$_POST["ghanghout_editor_undervideo"]);
			
		update_post_meta($post_id,"chat_reg_off_replay",$_POST["chat_reg_off_replay"]);
		update_post_meta($post_id,"add_meta_tag",stripcslashes($_POST["add_meta_tag"]));
		update_post_meta($post_id,"runclick_social_networks",$_POST["runclick_social_networks"]);
		update_post_meta($post_id,"runclick_google_plus_wall",$_POST["runclick_google_plus_wall"]);
		
		update_post_meta($post_id,"hangout_time_zone",$_POST['hangout_time_zone']);
		update_post_meta($post_id,"hangout_public_private",$_POST['hangout_public_private']);

		update_post_meta($post_id,"ghanghout_enabled_membership",$_POST['ghanghout_enabled_membership']);
		update_post_meta($post_id,"ghangout_membership_Type",$_POST['ghangout_membership_Type']);
		update_post_meta($post_id,"ghangout_live_page_member_access",implode(',',$_POST['ghangout_live_page_member_access']));
		update_post_meta($post_id,"ghangout_replay_page_member_access",implode(',',$_POST['ghangout_replay_page_member_access']));
		update_post_meta($post_id,"ghangout_event_page_member_access",implode(',',$_POST['ghangout_event_page_member_access']));

		update_post_meta($post_id,"ghangout_member_login_url",$_POST['ghangout_member_login_url']);
		update_post_meta($post_id,"ghangout_member_msg",$_POST['ghangout_member_msg']);
		
			

		
		/* Bhuvnesh Code for theme settings */
		
		$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
		
		if($google_hangout_theme == "Default" || $google_hangout_theme	==	""){}
		else{
			include_once 'themes/'.$google_hangout_theme.'/event_back.php';
		}
		
		/* Bhuvnesh Code for theme settings End */
		
	  wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=".$post_id."&sel=2");

}
if(isset($_POST['new_hangout_submit'])){
	
	$timeapidata = timeapi_servicecall('timeservice', array('placeid'=>$_POST['hangout_time_zone']));
	$new_date_for_database="";
	$timeapizone = $timeapidata->timezone->offset;


	$userid = get_current_user_id( ); 
	$youtubedata = $_POST['hangout_record_embed_code_url'];
	

	$my_post = array(
	  'post_title'    => addslashes($_POST["hangout_title"]),
	  'post_status'   => 'publish',
	  'post_author'   => $userid,
	  'post_content'   => $youtubedata,
	  'post_type'      => 'ghangout'
	);
	//$reminder_time = 	implode(",", $_POST['reminder_time']);

// Insert the post into the database
	$post_id = wp_insert_post( $my_post );
	if($_POST["hangout_timezone"]!=""){
	$newdate=explode(" ",$_POST["hangout_timezone"]);

$day_month=explode('/' ,$newdate[0]);
//print_r($day_month);
$new_date_for_database=$day_month[1].'/'.$day_month[0].'/'.$day_month[2].' '.$newdate[1].' '.$newdate[2];

  $newtimezone = $new_date_for_database .' ' .$timeapizone;
	
}



	update_post_meta($post_id,"hangout_title",$_POST["hangout_record_embed_code_url"]);
	 if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) { 

}else{

update_post_meta($post_id,"hangout_title",$_POST["hangout_record_embed_code_url"]);
update_post_meta($post_id,"hangout_timezone","");
}
 
		
		

	foreach($_POST as $val=>$key)
	{
		if($key != 'hangout_id' || $key != 'hangout_title' || $key != 'new_hangout_submit' || $key != 'hangout_timezone')
		{
			update_post_meta($post_id,$val,$key);
		}	
	}
	update_post_meta($post_id,"hangout_timezone",$newtimezone);
	
	 foreach($_FILES as $key=>$val)
       {
              
               $ghanghout_logo = $_FILES[$key]["name"];
       
                 $uploads = wp_upload_dir();
             $uploads_dir = $uploads['basedir'];
                 chmod($uploads_dir,0755);
               if($banner_name !=''){
                       move_uploaded_file( $_FILES[$key]["tmp_name"], "$uploads_dir/$banner_name");
               }
               if($ghanghout_logo !=''){
                       move_uploaded_file($_FILES[$key]["tmp_name"], "$uploads_dir/$ghanghout_logo");
               }
				if(isset($_REQUEST['type'])){
       update_post_meta($post_id,$key,$_POST[$key]);
       }else{
               update_post_meta($post_id,$key,$ghanghout_logo);
			   }
       }
	  
	if(isset($_REQUEST['type'])){
	
	update_post_meta($post_id,"google_hangout_theme",$_POST["selected_theme"]);
	
	update_post_meta($post_id,"hangout_type",$_POST["selected_type"]);
	
	}else{
	
	update_post_meta($post_id,"google_hangout_theme",$_GET["selected_theme"]);
	
	update_post_meta($post_id,"hangout_type",$_GET["selected_type"]);
	}
	update_post_meta($post_id,"hangout_registration",$_POST["hangout_registration"]);	
	update_post_meta($post_id,"hangout_webinar_auto_play_event",$_POST["hangout_webinar_auto_play_event"]);	
	update_post_meta($post_id,"hangout_webinar_auto_play_replay",$_POST["hangout_webinar_auto_play_replay"]);	
	update_post_meta($post_id,"first_name_active",$_POST["first_name_active"]);	
	update_post_meta($post_id,"last_name_active",$_POST["last_name_active"]);	
	update_post_meta($post_id,"organisation_name_active",$_POST["organisation_name_active"]);	
	update_post_meta($post_id,"hangout_make_now",$_POST["hangout_make_now"]);
	update_post_meta($post_id,"replay_youtube_video_size",$_POST["replay_youtube_video_size"]);
	update_post_meta($post_id,"show_popup_on_video",$_POST["show_popup_on_video"]);
	update_post_meta($post_id,"registrations_date_system",$_POST["registrations_date_system"]);
	
 $banner_name = $_FILES["ghanghout_full_banner_image"]["name"];
		$ghanghout_logo = $_FILES["ghanghout_logo"]["name"];
		  $uploads = wp_upload_dir();
	      $uploads_dir = $uploads['basedir'];
		  chmod($uploads_dir,0755);
		if($banner_name !=''){
			move_uploaded_file( $_FILES["ghanghout_full_banner_image"]["tmp_name"], "$uploads_dir/$banner_name");
		} 
		if($ghanghout_logo !=''){
			move_uploaded_file($_FILES["ghanghout_logo"]["tmp_name"], "$uploads_dir/$ghanghout_logo");
		}
		
update_post_meta($post_id,"hangout_registration_system",$_POST["hangout_registration_system"]);
		
		update_post_meta($post_id,"hangout_amber_from",$_POST["hangout_amber_from"]);
		
		update_post_meta($post_id,"hangout_Mailchimp_list_id",$_POST["hangout_Mailchimp_list_id"]);
		update_post_meta($post_id,"hangout_ImnicaMail_list_id",$_POST["hangout_ImnicaMail_list_id"]);
		update_post_meta($post_id,"hangout_Icontact_list_id",$_POST["hangout_Icontact_list_id"]);
		update_post_meta($post_id,"hangout_Sendreach_api_key",$_POST["hangout_Sendreach_api_key"]);
		update_post_meta($post_id,"hangout_Sendreach_secret_key",$_POST["hangout_Sendreach_secret_key"]);
		update_post_meta($post_id,"hangout_Sendreach_user_id",$_POST["hangout_Sendreach_user_id"]);
		
		update_post_meta($post_id,"hangout_Icontact_user_password",$_POST["hangout_Icontact_user_password"]);
		update_post_meta($post_id,"hangout_Icontact_user_name",$_POST["hangout_Icontact_user_name"]);
		update_post_meta($post_id,"hangout_Icontact_app_id",$_POST["hangout_Icontact_app_id"]);
		update_post_meta($post_id,"hangout_GetResponce_api_key",$_POST["hangout_GetResponce_api_key"]);
		update_post_meta($post_id,"hangout_Sendreach_list_id",$_POST["hangout_Sendreach_list_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_list_id",$_POST["hangout_InfusionSoft_list_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_tag_id",$_POST["hangout_InfusionSoft_tag_id"]);
		update_post_meta($post_id,"hangout_InfusionSoft_app",$_POST["hangout_InfusionSoft_app"]);
		update_post_meta($post_id,"hangout_GetResponce_campaign_name",$_POST["hangout_GetResponce_campaign_name"]);
		update_post_meta($post_id,"hangout_Aweber_api_key",$_POST["hangout_Aweber_api_key"]);
		update_post_meta($post_id,"hangout_Aweber_consumer_Key",$_POST["hangout_Aweber_consumer_Key"]);
		update_post_meta($post_id,"hangout_Aweber_consumer_Secret",$_POST["hangout_Aweber_consumer_Secret"]);
		update_post_meta($post_id,"hangout_Aweber_access_Secret",$_POST["hangout_Aweber_access_Secret"]);
		update_post_meta($post_id,"hangout_Aweber_account_id",$_POST["hangout_Aweber_account_id"]);
		$aweber_list=$_POST["hangout_Aweber_list_id"];
		$aweber_list_name_id=explode('%',$aweber_list);
		
		update_post_meta($post_id,"hangout_Aweber_list_id",$aweber_list_name_id[0]);
		update_post_meta($post_id,"hangout_Aweber_list_name",$aweber_list_name_id[1]);
		
		
		update_post_meta($post_id,"hangout_Aweber_app_id",$_POST["hangout_Aweber_app_id"]);
		update_post_meta($post_id,"hangout_Mailchimp_api_key",$_POST["hangout_Mailchimp_api_key"]);
		
		update_post_meta($post_id,"hangout_amber_from",$_POST["hangout_amber_from"]);
		update_post_meta($post_id,"hangout_amber_name_email",$_POST["hangout_amber_name_email"]);
		update_post_meta($post_id,"hangout_amber_name_field",$_POST["hangout_amber_name_field"]);
		update_post_meta($post_id,"ppc_theme_select_replay_time",serialize($_POST['ppc_theme_select_replay_time']));		
		update_post_meta($post_id,"hangout_select_replay_day",serialize($_POST['hangout_select_replay_day']));
		
		
	
		
	

		update_post_meta($post_id,"hangout_send_notifications",$_POST["hangout_send_notifications"]);
	  
		update_post_meta($post_id,"hangout_show_replay",$hangout_show_replay);
	  
		update_post_meta($post_id,"reminder_time",$reminder_time);
		update_post_meta($post_id,"timer_type",$_POST['timer_type']);
	  
	
		
		
		$hanogut_timezone = $new_date_for_database .' ' .$timeapizone;
		$enddatearr = explode(" ",$hanogut_timezone);
		$endate = explode("/",$enddatearr[0]);
		$enmin = explode(":",$enddatearr[1]);
		if($enddatearr[2]=="am"){ 
			if($enmin[0]==12){
			$hour = 0;
			} else {
			$hour = $enmin[0];
			}
			$min = $enmin[1];
		} else { 
			if($enmin[0]==12){
				$hour = 12;
			} else {
				$hour = $enmin[0]+12;
			}
			$min = $enmin[1];
		}

		$symbolz =  substr($enddatearr[3],0,1);

		$hourz = substr($enddatearr[3],1,2);

		$timez = substr($enddatearr[3],4,5);
		if($enddatearr[2]=="am"){ 
					if($enmin[0]==12){
					$hour = 0;
					} else {
					$hour = $enmin[0];
					}
					$min = $enmin[1];
				} else { 
					if($enmin[0]==12){
						$hour = 12;
					} else {
						$hour = $enmin[0]+12;
					}
					$min = $enmin[1];
				}


		if($symbolz=='+'){
			if($enddatearr[1]=="am"){
				$cur = mktime((date('H')+12),date('i'),date('s'),date('m'),(date('d')-1),date('Y'));

			} else {
				$cur = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
			}

			$now = mktime($timeapidata->datetime->hour+$hourz,($timeapidata->datetime->minute+$timez),$timeapidata->datetime->second,$timeapidata->datetime->month,$timeapidata->datetime->day,$timeapidata->datetime->year);
			$end =  mktime(($hour+$hourz), ($min+$timez), 0, $endate[0], $endate[1], $endate[2]);
		} else {
			$cur = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
			
			$now = mktime(($timeapidata->datetime->hour-$hourz),($timeapidata->datetime->minute-$timez),$timeapidata->datetime->second,$timeapidata->datetime->month,$timeapidata->datetime->day,$timeapidata->datetime->year);
			 $end =  mktime(($hour-$hourz), ($min-$timez), 0, $endate[0], $endate[1], $endate[2]);
		}

		$dife = $end - $now;
		$cur_end = $cur + $dife;
		update_post_meta($post_id,"hangout_mktim_timezone",$end);
		update_post_meta($post_id,"hangout_mktim_timezone_now",$now);
		update_post_meta($post_id,"hangout_current_time",$cur);
		update_post_meta($post_id,"hangout_server_end_time",$cur_end);
		
		

		update_post_meta($post_id,"hangout_day_light",$_POST["hangout_day_light"]);
	
		update_post_meta($post_id,"hangout_title",$_POST["hangout_record_embed_code_url"]);
				update_post_meta($post_id,"g_hangout_layout_type",$_POST["g_hangout_layout_type"]);
		/* Option 1 values */
		update_post_meta($post_id,"ghanghout_enable_header",$_POST["ghanghout_enable_header"]);
		update_post_meta($post_id,"ghanghout_enable_sharing",$_POST["ghanghout_enable_sharing"]);
		update_post_meta($post_id,"ghanghout_logo",$ghanghout_logo);
		update_post_meta($post_id,"ghanghout_logo_text",$_POST["ghanghout_logo_text"]);
		update_post_meta($post_id,"ghanghout_logo_family",$_POST["ghanghout_logo_family"]);
		update_post_meta($post_id,"ghanghout_logo_size",$_POST["ghanghout_logo_size"]);
		update_post_meta($post_id,"ghanghout_logo_style",$_POST["ghanghout_logo_style"]);
		update_post_meta($post_id,"ghanghout_logo_shadow",$_POST["ghanghout_logo_shadow"]);
		update_post_meta($post_id,"ghanghout_logo_height",$_POST["ghanghout_logo_height"]);
		update_post_meta($post_id,"ghanghout_logo_spacing",$_POST["ghanghout_logo_spacing"]);
		update_post_meta($post_id,"ghanghout_logo_color",$_POST["ghanghout_logo_color"]);
		update_post_meta($post_id,"ghanghout_headline",$_POST["ghanghout_headline"]);
		update_post_meta($post_id,"ghanghout_headline_family",$_POST["ghanghout_headline_family"]);
		update_post_meta($post_id,"ghanghout_headline_size",$_POST["ghanghout_headline_size"]);
		update_post_meta($post_id,"ghanghout_headline_style",$_POST["ghanghout_headline_style"]);
		update_post_meta($post_id,"ghanghout_headline_shadow",$_POST["ghanghout_headline_shadow"]);
		update_post_meta($post_id,"ghanghout_headline_height",$_POST["ghanghout_headline_height"]);
		update_post_meta($post_id,"ghanghout_headline_spacing",$_POST["ghanghout_headline_spacing"]);
		update_post_meta($post_id,"ghanghout_headline_color",$_POST["ghanghout_headline_color"]);
		update_post_meta($post_id,"ghanghout_subhead",$_POST["ghanghout_subhead"]);
		update_post_meta($post_id,"ghanghout_subhead_family",$_POST["ghanghout_subhead_family"]);
		update_post_meta($post_id,"ghanghout_subhead_size",$_POST["ghanghout_subhead_size"]);
		update_post_meta($post_id,"ghanghout_subhead_style",$_POST["ghanghout_subhead_style"]);
		update_post_meta($post_id,"ghanghout_subhead_shadow",$_POST["ghanghout_subhead_shadow"]);
		update_post_meta($post_id,"ghanghout_subhead_height",$_POST["ghanghout_subhead_height"]);
		update_post_meta($post_id,"ghanghout_subhead_spacing",$_POST["ghanghout_subhead_spacing"]);
		update_post_meta($post_id,"ghanghout_subhead_color",$_POST["ghanghout_subhead_color"]);
		update_post_meta($post_id,"ghanghout_option1editor",$_POST["ghanghout_option1editor"]);
		update_post_meta($post_id,"ghanghout_editor_undervideo",$_POST["ghanghout_editor_undervideo"]);
		update_post_meta($post_id,"chat_reg_off_replay",$_POST["chat_reg_off_replay"]);
		update_post_meta($post_id,"add_meta_tag",stripcslashes($_POST["add_meta_tag"]));
		update_post_meta($post_id,"runclick_social_networks",$_POST["runclick_social_networks"]);
		update_post_meta($post_id,"runclick_google_plus_wall",$_POST["runclick_google_plus_wall"]);
		/* Option 1 end values*/
		update_post_meta($post_id,"ghanghout_timer_position",$_POST["ghanghout_timer_position"]);
		update_post_meta($post_id,"ghanghout_full_banner_image",$banner_name);
		update_post_meta($post_id,"hangout_time_zone",$_POST['hangout_time_zone']);
		update_post_meta($post_id,"hangout_public_private",$_POST['hangout_public_private']);

		update_post_meta($post_id,"ghanghout_enabled_membership",$_POST['ghanghout_enabled_membership']);
		update_post_meta($post_id,"ghangout_membership_Type",$_POST['ghangout_membership_Type']);
		update_post_meta($post_id,"ghangout_live_page_member_access",implode(',',$_POST['ghangout_live_page_member_access']));
		
		update_post_meta($post_id,"ghangout_event_page_member_access",implode(',',$_POST['ghangout_event_page_member_access']));

		update_post_meta($post_id,"ghangout_replay_page_member_access",implode(',',$_POST['ghangout_replay_page_member_access']));
		update_post_meta($post_id,"ghangout_member_login_url",$_POST['ghangout_member_login_url']);
		update_post_meta($post_id,"ghangout_member_msg",$_POST['ghangout_member_msg']);
		 $google_hangout_theme1 = $_GET["selected_theme"];
		$google_hangout_theme=str_replace('_',' ',$google_hangout_theme1);
		if($google_hangout_theme1 == "Default" || $google_hangout_theme1	==	""){}
		else{
			
			include_once ('themes/'.$google_hangout_theme.'/event_back.php');
		}
		

	    wp_redirect(admin_url()."admin.php?page=google_hangout");
	
	//default values for event live page 
	$ghanghout_make_live_option1editor	= '<p style="text-align: center;">[live_hangout]</p><p style="text-align: center;">[ghangout_reg_form]</p>';
	update_post_meta($post_id,"ghanghout_make_live_option1editor",$ghanghout_make_live_option1editor);
	//default value for replay page
	update_post_meta($post_id,"hangout_replay_option","0");
	$ghanghout_replay_option1editor = '<p style="text-align: center;">[ghangout_replan_reg_form]</p>'; 	
	update_post_meta($post_id,"ghanghout_replay_option1editor",$ghanghout_replay_option1editor);
	update_post_meta($post_id,"hangout_lock_replay",'0');
	update_post_meta($post_id,"hangout_timezone_start_date",$newtimezone);
	$cur_event_date	=	explode(" ",$timezone);
	
	$parts = explode('/', $cur_event_date[0]);
	
	$datePlusFive = date(
		'm/d/Y', 
		mktime(0, 0, 0, $parts[0], $parts[1] + 10, $parts[2])
		//              ^ Month    ^ Day + 5      ^ Year
	);
	$curr_replay_start_date	=	date('m/d/Y')." ".$cur_event_date[1]." ".$cur_event_date[2]." ".$cur_event_date[3];
	$curr_replay_end_date = $datePlusFive." ".$cur_event_date[1]." ".$cur_event_date[2]." ".$cur_event_date[3]; 
	update_post_meta($post_id,"hangout_timezone_start_date",$curr_replay_start_date);
	update_post_meta($post_id,"hangout_timezone_end_date",$curr_replay_end_date);
	//default value for the thankyou page
	update_post_meta($post_id,"thanks_page_title","Thankyou for registering. Please check your email for details");
	
}
if(isset($_REQUEST['refresh_list'])){
$post_id = $_REQUEST['hangout_id'];
update_post_meta($post_id,"hangout_Aweber_api_key",'');

wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=".$post_id."&sel=2");
}
if($_REQUEST['msg_id']=='4'){
?>
<div id="message" class="updated below-h2"><p>Webinar Event published. </p></div>
<?php } 
/*if(get_option('g_project_id')==''){ ?>
	<div id="message" class="error"><p>Project Number is Missing </p></div>
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
$hangout_make_now='1';
$yousrc_size='1';
$show_popup_on_video='1';
$event_notification='1';
$reminder_time =array(24);
$hangout_registration_system = 'Default';
$aweber ='';
$getresponse ='';
$last_name_active ='1';
$first_name_active ='1';
$organisation_name_active ='1';
$aweber=""; 
$aweber_name=""; 
$aweber_email=""; 
$hangout_Mailchimp_api_key ='';
$hangout_Mailchimp_list_id ='';
$hangout_ImnicaMail_list_id ='';
$hangout_Icontact_list_id ='';
$hangout_Sendreach_api_key ='';
$hangout_Sendreach_secret_key ='';
$hangout_Sendreach_user_id ='';

$hangout_Icontact_user_password ='';
$hangout_Icontact_user_name ='';
$hangout_Icontact_app_id ='';
$hangout_GetResponce_api_key ='';
$hangout_Sendreach_list_id ='';
$hangout_InfusionSoft_list_id ='';
$hangout_InfusionSoft_tag_id ='';
$hangout_InfusionSoft_app ='';
$hangout_GetResponce_campaign_name ='';
$hangout_Aweber_api_key ='';
$hangout_Aweber_consumer_Key ='';
$hangout_Aweber_consumer_Secret ='';
$hangout_Aweber_access_Secret ='';
$hangout_Aweber_account_id ='';
$hangout_Aweber_list_id ='';
$hangout_Aweber_list_name ='';
$hangout_Aweber_app_id ='';
$getresponse_name ='';
$getresponse_email ='';
$timer_type='';

$g_hangout_layout_type = '';
	$ghanghout_enable_header = '';
	$ghanghout_enable_sharing = '';
	$ghanghout_logo = '';
	$ghanghout_logo_text = '';
	$ghanghout_logo_family = '';
	$ghanghout_logo_size = '';
	$ghanghout_logo_style = '';
	$ghanghout_logo_shadow = '';
	$ghanghout_logo_height = '';
	$ghanghout_logo_spacing = '';
	$ghanghout_logo_color = '';
	$ghanghout_headline = '';
	$ghanghout_headline_family = '';
	$ghanghout_headline_size = '';
	$ghanghout_headline_style = '';
	$ghanghout_headline_shadow = '';
	$ghanghout_headline_height = '';
	$ghanghout_headline_spacing = '';
	$ghanghout_headline_color = '';
	$ghanghout_subhead = '';
	$ghanghout_subhead_family = '';
	$ghanghout_subhead_size = '';
	$ghanghout_subhead_style = '';
	$ghanghout_subhead_shadow = '';
	$ghanghout_subhead_height = '';
	$ghanghout_subhead_spacing = '';
	$ghanghout_subhead_color = '';
	$ghanghout_option1editor = '';
	$ghanghout_editor_undervideo = '';
	$hangout_show_replay =1;
	$ghanghout_enabled_membership='';
$ghangout_membership_Type ='';
$ghangout_replay_page_member_access = array();
$ghangout_live_page_member_access = array();
$ghangout_event_page_member_access = array();
	
$google_hangout_theme	=	"";

	
		/* Option 1 end values*/
	$ghanghout_timer_position = get_post_meta($post_id,"ghanghout_timer_position",true);
	$ghanghout_full_banner_image =	get_post_meta($post_id,"ghanghout_full_banner_image",true);


if(isset($_REQUEST['EID'])){
	$postdata = get_post($post_id);

	$title=get_post_meta($post_id,'hangout_title',true);
	$event_reg = get_post_meta($post_id,'hangout_registration',true);	
	$event_auto_play = get_post_meta($post_id,'hangout_webinar_auto_play_event',true);	
	$replay_auto_play = get_post_meta($post_id,'hangout_webinar_auto_play_replay',true);	
	$first_name_active = get_post_meta($post_id,'first_name_active',true);	
	$last_name_active = get_post_meta($post_id,'last_name_active',true);	
	$organisation_name_active = get_post_meta($post_id,'organisation_name_active',true);	
	$hangout_make_now = get_post_meta($post_id,'hangout_make_now',true);
	$yousrc_size = get_post_meta($post_id,'replay_youtube_video_size',true);
	$show_popup_on_video = get_post_meta($post_id,'show_popup_on_video',true);
	$registrations_date_system = get_post_meta($post_id,'registrations_date_system',true);
	$event_notification = get_post_meta($post_id,'hangout_send_notifications',true);
	$reminder = get_post_meta($post_id,'reminder_time',true);
	$reminder_time = explode(",",$reminder);
	if(get_post_meta($post_id,'hangout_timezone',true)!=""){
	$timezone = get_post_meta($post_id,'hangout_timezone',true);
	
	$timedata = explode(" ", $timezone);
	$daymonth=explode('/',$timedata[0]);
	$timezone = $daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2]." ".$timedata[1]." ".$timedata[2];
	}
	$youcode=stripslashes($postdata->post_title);
	$youembed=stripslashes($postdata->post_content);
	$hangout_registration_system = get_post_meta($post_id,'hangout_registration_system',true);
	if($hangout_registration_system=='' || $hangout_registration_system=='1'){
		$hangout_registration_system ='Default';
	}

	$aweber =get_post_meta($post_id,'hangout_amber_from',true);
	

	$hangout_Mailchimp_api_key =get_post_meta($post_id,'hangout_Mailchimp_api_key',true);
	
	$hangout_Mailchimp_list_id =get_post_meta($post_id,'hangout_Mailchimp_list_id',true);
	
	

	$aweber_name =get_post_meta($post_id,'hangout_amber_name_field',true);
	$aweber_email =get_post_meta($post_id,'hangout_amber_name_email',true);
	$hangout_ImnicaMail_list_id =get_post_meta($post_id,'hangout_ImnicaMail_list_id',true);
	$hangout_Icontact_list_id =get_post_meta($post_id,'hangout_Icontact_list_id',true);
	$hangout_Sendreach_api_key =get_post_meta($post_id,'hangout_Sendreach_api_key',true);
	$hangout_Sendreach_secret_key =get_post_meta($post_id,'hangout_Sendreach_secret_key',true);
	$hangout_Sendreach_user_id =get_post_meta($post_id,'hangout_Sendreach_user_id',true);
	
	$hangout_Icontact_user_password =get_post_meta($post_id,'hangout_Icontact_user_password',true);
	$hangout_Icontact_user_name =get_post_meta($post_id,'hangout_Icontact_user_name',true);
	$hangout_Icontact_app_id =get_post_meta($post_id,'hangout_Icontact_app_id',true);
	$hangout_GetResponce_api_key =get_post_meta($post_id,'hangout_GetResponce_api_key',true);
	$hangout_Sendreach_list_id =get_post_meta($post_id,'hangout_Sendreach_list_id',true);
	$hangout_InfusionSoft_list_id =get_post_meta($post_id,'hangout_InfusionSoft_list_id',true);
	$hangout_InfusionSoft_tag_id =get_post_meta($post_id,'hangout_InfusionSoft_tag_id',true);
	$hangout_InfusionSoft_app =get_post_meta($post_id,'hangout_InfusionSoft_app',true);
	$hangout_GetResponce_campaign_name =get_post_meta($post_id,'hangout_GetResponce_campaign_name',true);
	$hangout_Aweber_api_key =get_post_meta($post_id,'hangout_Aweber_api_key',true);
	$hangout_Aweber_consumer_Key =get_post_meta($post_id,'hangout_Aweber_consumer_Key',true);
	$hangout_Aweber_consumer_Secret =get_post_meta($post_id,'hangout_Aweber_consumer_Secret',true);
	$hangout_Aweber_access_Secret =get_post_meta($post_id,'hangout_Aweber_access_Secret',true);
	$hangout_Aweber_account_id =get_post_meta($post_id,'hangout_Aweber_account_id',true);
	$hangout_Aweber_list_id =get_post_meta($post_id,'hangout_Aweber_list_id',true);
	$hangout_Aweber_list_name =get_post_meta($post_id,'hangout_Aweber_list_name',true);
	$hangout_Aweber_app_id =get_post_meta($post_id,'hangout_Aweber_app_id',true);
	
	
	$timer_type=get_post_meta($post_id,'timer_type',true);

	$g_hangout_layout_type = get_post_meta($post_id,"g_hangout_layout_type",true);
	$ghanghout_enable_header = get_post_meta($post_id,"ghanghout_enable_header",true);
	$ghanghout_enable_sharing = get_post_meta($post_id,"ghanghout_enable_sharing",true);
	$ghanghout_logo = get_post_meta($post_id,"ghanghout_logo",true);
	$ghanghout_logo_text = get_post_meta($post_id,"ghanghout_logo_text",true);
	$ghanghout_logo_family = get_post_meta($post_id,"ghanghout_logo_family",true);
	$ghanghout_logo_size = get_post_meta($post_id,"ghanghout_logo_size",true);
	$ghanghout_logo_style =	get_post_meta($post_id,"ghanghout_logo_style",true);
	$ghanghout_logo_shadow = get_post_meta($post_id,"ghanghout_logo_shadow",true);
	$ghanghout_logo_height = get_post_meta($post_id,"ghanghout_logo_height",true);
	$ghanghout_logo_spacing =	get_post_meta($post_id,"ghanghout_logo_spacing",true);
	$ghanghout_logo_color =	get_post_meta($post_id,"ghanghout_logo_color",true);
	$ghanghout_headline =	get_post_meta($post_id,"ghanghout_headline",true);
	$ghanghout_headline_family = get_post_meta($post_id,"ghanghout_headline_family",true);
	$ghanghout_headline_size = get_post_meta($post_id,"ghanghout_headline_size",true);
	
	$ghanghout_headline_style =	get_post_meta($post_id,"ghanghout_headline_style",true);
	$ghanghout_headline_shadow = get_post_meta($post_id,"ghanghout_headline_shadow",true);
	$ghanghout_headline_height = get_post_meta($post_id,"ghanghout_headline_height",true);
	$ghanghout_headline_spacing = get_post_meta($post_id,"ghanghout_headline_spacing",true);
	$ghanghout_headline_color =	get_post_meta($post_id,"ghanghout_headline_color",true);
	$ghanghout_subhead = get_post_meta($post_id,"ghanghout_subhead",true);
	$ghanghout_subhead_family =	get_post_meta($post_id,"ghanghout_subhead_family",true);
	$ghanghout_subhead_size =	get_post_meta($post_id,"ghanghout_subhead_size",true);
		
	$ghanghout_subhead_style = get_post_meta($post_id,"ghanghout_subhead_style",true);
	$ghanghout_subhead_shadow =	get_post_meta($post_id,"ghanghout_subhead_shadow",true);
	$ghanghout_subhead_height =	get_post_meta($post_id,"ghanghout_subhead_height",true);
	$ghanghout_subhead_spacing = get_post_meta($post_id,"ghanghout_subhead_spacing",true);
	$ghanghout_subhead_color =	get_post_meta($post_id,"ghanghout_subhead_color",true);
	$ghanghout_option1editor =	get_post_meta($post_id,"ghanghout_option1editor",true);
	$ghanghout_editor_undervideo =	get_post_meta($post_id,"ghanghout_editor_undervideo",true);
	
		/* Option 1 end values*/
	$ghanghout_timer_position = get_post_meta($post_id,"ghanghout_timer_position",true);
	$ghanghout_full_banner_image =	get_post_meta($post_id,"ghanghout_full_banner_image",true);
	$hangout_show_replay =	get_post_meta($post_id,"hangout_show_replay",true);
	$chat_reg_off_replay	=	get_post_meta($post_id,"chat_reg_off_replay",true);
	$add_meta_tag	=	get_post_meta($post_id,"add_meta_tag",true);
	$runclick_social_networks	=	get_post_meta($post_id,"runclick_social_networks",true);
	$runclick_google_plus_wall	=	get_post_meta($post_id,"runclick_google_plus_wall",true);
	$hangout_time_zone	=	get_post_meta($post_id,"hangout_time_zone",true);
	$hangout_public_private	=	get_post_meta($post_id,"hangout_public_private",true);

	$ghanghout_enabled_membership = get_post_meta($post_id,"ghanghout_enabled_membership",true);
	$ghangout_membership_Type = get_post_meta($post_id,"ghangout_membership_Type",true);
	$ghangout_live_page_member_access = explode(',',get_post_meta($post_id,"ghangout_live_page_member_access",true));
	$ghangout_replay_page_member_access = 	explode(',',get_post_meta($post_id,"ghangout_replay_page_member_access",true));

	$ghangout_event_page_member_access = explode(',',get_post_meta($post_id,"ghangout_event_page_member_access",true));
	$ghangout_member_login_url = get_post_meta($post_id,"ghangout_member_login_url",true);
	$ghangout_member_msg = get_post_meta($post_id,"ghangout_member_msg",true);
	$ghangout_type = get_post_meta($post_id,"hangout_type",true);
	
	$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
	$recorded_youembed=stripslashes($postdata->post_content);
}



?>



<div class="gh_tabs_div_inner">
<form method="post" id="hangout_manage" name="add_hangout" action="" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $post_id; ?>" name="hangout_id"/>
<div id="myMenu1" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Event Details  </div>
						<div id="myDiv1" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Google Webinar Event Title </strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" id="hangout_title" name="hangout_title" value="<?php echo $youcode; ?>">
								<input type="hidden" name="selected_theme" value="<?php echo $_REQUEST['selected_theme']; ?>">
							</div>
                        </div>
                        </div>
						<?php if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) { ?>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Date & Time</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" name="hangout_timezone" id="ghangout_timezone" value="<?php if(isset($_REQUEST['type'])){ echo $timezone=''; } else{ echo $timezone; } ?>" />
								<input type="hidden" value="<?php echo $ghangout_type;?>" name="selected_type">
								<input type="hidden" value="<?php echo $google_hangout_theme;?>" name="selected_theme">
							</div>
                        </div>
                        </div>
						
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Time Zone (start typing City name) </strong>
                            </div>
                            <div class="span8">
							<select id="locationsearch" class="locationsearch" name="hangout_time_zone" style="width:100%">
							
							<?php 
							
							$locatation = $wpdb->get_results('select * from '. $wpdb->prefix.'location order by time_code asc '); 
							foreach($locatation as $locdata){ ?>
								
										<option value="<?php echo $locdata->name; ?>" <?php if($hangout_time_zone == $locdata->name){ echo "selected='selected'";} ?>><?php echo $locdata->time_code;?> (<?php echo $locdata->title;?>)</option>

							<?php }
							?>

								
										
								</select>
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Webinar Auto Play</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_webinar_auto_play_event" value="1" <?php if($event_auto_play==1 || $event_auto_play==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="hangout_webinar_auto_play_event" value="0" <?php if($event_auto_play==0){ echo 'checked="checked"'; } ?>/> No</span>

								
                            </div>
                        </div>
                        </div>
						<?php } else { ?>
						
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Event Video Url</strong>
                            </div>
                            <div class="span8">
								<textarea name="hangout_record_embed_code_url"><?php echo $recorded_youembed; ?></textarea>
								<input type="hidden" value="<?php echo $ghangout_type;?>" name="selected_type">
								<input type="hidden" value="<?php echo $google_hangout_theme;?>" name="selected_theme">
                            </div>
                        </div>
                        </div>
						<?php 
						$selected_theme=$_REQUEST['selected_theme'];
						if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					}else{?>
						<div class="row-fluid-outer" <?php //if($youembed==''){ echo 'style="display:none;"'; } ?> id="youtube_video_size_cont">
						
                        <div class="row-fluid">
							<div class="span4">
								<strong>Event Video Size(Select any width) </strong>
                            </div>
                            <div class="span8">
									<select name="replay_youtube_video_size" id="youtube_video_size">
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
						<strong>Enable Watch Now</strong>                  
						</div>                            
						<div class="span8">							
						<input type="radio" name="hangout_make_now" id="make_now_ye" value="1" <?php if($hangout_make_now==1 || $hangout_make_now==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="hangout_make_now" value="0" id="make_now_n" <?php if($hangout_make_now==0){ echo 'checked="checked"'; } ?>/> No</span>	 </div>                       
						</div>                       
						</div>
						<?php 
				$selected_theme=$_REQUEST['selected_theme'];
				 if($selected_theme!='' or $google_hangout_theme !=''  ){
				
				$google_hangout_selected_theme=str_replace('_',' ',$selected_theme);
				if($google_hangout_selected_theme==''){
				$google_hangout_selected_theme=$google_hangout_theme;
				$google_hangout_selected_theme=str_replace('_',' ',$google_hangout_selected_theme);
				}				$days=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				?>
				<div id="date_system_area"  >
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Date System  on Registrations Page</strong>
                            </div>
                            <div class="span8">
								
								<input type="radio" id="select_date_sys" name="registrations_date_system" value="1" <?php if($registrations_date_system==1 || $registrations_date_system==''){ echo 'checked="checked"'; } ?>/> 3 Day System <input type="radio" id="select_cal"  name="registrations_date_system" value="0" <?php if($registrations_date_system==0){ echo 'checked="checked"'; } ?>/> Calendar <input type="radio"  name="registrations_date_system" value="2" id="selectday" <?php if($registrations_date_system==2){ echo 'checked="checked"'; } ?>/> Days 
                            </div>
                        </div>						<?php $replay_day= get_post_meta($post_id,"hangout_select_replay_day",true);														$replay_day_array=unserialize($replay_day);																		?>
						<div class="row-fluid">						
						<div style=" width: 200px;height: 200px; overflow-y:scroll;border:1px solid;  margin: 0 0 17px 249px; display:none" id="showdayarea" >						<input type="checkbox" id="checkAllday" <?php if(count($replay_day_array)==7){ ?> checked="checked"<?php } ?>   value="" > &nbsp;&nbsp;&nbsp; Select all<br>						<?php foreach($days as $day) { ?>												<input type="checkbox" class="select_day" name="hangout_select_replay_day[]"  <?php if(!empty($replay_day_array)){ if(in_array($day,$replay_day_array)){ ?>checked="checked"<?php } }?> value=<?php echo $day; ?> > &nbsp;&nbsp;&nbsp;<?php echo $day; ?><br>						<?php } ?>						</div>						</div>
						<div class="row-fluid">
							<div class="span4">
								<strong>Select Webinar Replay Time</strong>
                            </div>
                            <div class="span8">
								<?php $replay_time= get_post_meta($post_id,"ppc_theme_select_replay_time",true);
								
						$replay_time_array=unserialize($replay_time);
						
						
						?>
								<div style=" width: 200px;height: 300px; overflow-y:scroll;border:1px solid;" >
								<input type="checkbox" id="checkAll" <?php if(count($replay_time_array)==24){ ?> checked="checked"<?php } ?>   value="" > &nbsp;&nbsp;&nbsp; Select all<br>
					<?php
											
				for($i = 1; $i <= 24; $i++){
						
						
						?>
					<input type="checkbox" class="select_time" name="ppc_theme_select_replay_time[]"  <?php if(!empty($replay_time_array)){if(in_array(date("h.iA", strtotime("$i:00")),$replay_time_array)){ ?>checked="checked"<?php } }?> value=<?php echo date("h.iA", strtotime("$i:00")); ?> > &nbsp;&nbsp;&nbsp;<?php echo date("h.iA", strtotime("$i:00")); ?><br>
					<?php }
					
					?>
					</div>
                            </div>
                        </div>
                        </div>
						</div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Pop-Up On Video</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_popup_on_video" value="1" <?php if($show_popup_on_video==1 || $show_popup_on_video==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="show_popup_on_video" value="0" <?php if($show_popup_on_video==0){ echo 'checked="checked"'; } ?>/> No</span>

								
                            </div>
                        </div>
                        </div>
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
						<?php } ?>
						
						<?php } ?>
						  

                        
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Take Registrations</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_registration" value="1" <?php if($event_reg==1 || $event_reg==''){ echo 'checked="checked"'; } ?>/> Yes <input type="radio" name="hangout_registration" value="0" <?php if($event_reg==0){ echo 'checked="checked"'; } ?>/> No</span>

								
                            </div>
                        </div>
                        </div>
						<div  id="hangout_registration_system" <?php if($event_reg==0){  echo 'style="display:none;"'; } ?> >
                        <div class="row-fluid-outer" >
                        <div class="row-fluid">
							<div class="span4">
								<strong>Registration System </strong>
                            </div>
							<div class="span8">
								<select id="hangout_registration_system_option" name="hangout_registration_system">
									<option value="Default" <?php if($hangout_registration_system=="Default" || $hangout_registration_system =="1" || $hangout_registration_system ==""){echo 'selected';}?>>Default</option>
									<option value="Aweber" <?php if($hangout_registration_system=="Aweber"){echo 'selected';}?>>Aweber</option>
									
									<option value="InfusionSoft" <?php if($hangout_registration_system=="InfusionSoft"){echo 'selected';}?>>InfusionSoft</option>
									<option value="Sendreach" <?php if($hangout_registration_system=="Sendreach"){echo 'selected';}?>>Sendreach</option> 
									<option value="ImnicaMail" <?php if($hangout_registration_system=="ImnicaMail"){echo 'selected';}?>>ImnicaMail</option>
									<option value="Mailchimp" <?php if($hangout_registration_system=="Mailchimp"){echo 'selected';}?>>Mailchimp</option>
									<!--<option value="ArpReach" <?php //if($hangout_registration_system=="ArpReach"){echo 'selected';}?>>ArpReach</option>-->
									<option value="Icontact" <?php if($hangout_registration_system=="Icontact"){echo 'selected';}?>>Icontact</option>
									<option value="GetResponce" <?php if($hangout_registration_system=="GetResponce"){echo 'selected';}?>>GetResponse</option>
									<!--<option value="Sendpeppe" <?php //if($hangout_registration_system=="Sendpeppe"){echo 'selected';}?>>Sendpeppe</option>
									<option value="Parabots" <?php //if($hangout_registration_system=="Parabots"){echo 'selected';}?>>Parabots</option> -->
									<?php  $selected_theme=$_REQUEST['selected_theme'];
						
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					}
					else{ ?>
									<option value="Other" <?php if($hangout_registration_system=="Other"){echo 'selected';}?>>Other</option>
									<?php } ?>
							</select>
                            </div>
                        </div >
						 
						
						<div <?php if($hangout_registration_system=='default' || $hangout_registration_system==''){  echo 'style="display:none;"'; } ?> id="hangout_autoresponder">
								
								
								<div id="Mailchimp" <?php if($hangout_registration_system!='Mailchimp'){  echo 'style="display:none;"'; } ?>>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder API Key </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Mailchimp_api_key" id="hangout_Mailchimp_api_key" value="<?php echo $hangout_Mailchimp_api_key; ?>" /></span>
											</div>

										</div>
									</div>
									
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder List ID </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Mailchimp_list_id" id="hangout_Mailchimp_list_id" value="<?php echo $hangout_Mailchimp_list_id; ?>" /></span>
											</div>

										</div>
									</div>
									</div>
									<div id="ImnicaMail"  <?php if($hangout_registration_system!='ImnicaMail'){  echo 'style="display:none;"'; } ?>>
									
									
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder List ID </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_ImnicaMail_list_id" id="hangout_ImnicaMail_list_id" value="<?php echo $hangout_ImnicaMail_list_id; ?>" /></span>
											</div>

										</div>
									</div>
									</div>
									<div id="Icontact" <?php if($hangout_registration_system!='Icontact'){  echo 'style="display:none;"'; } ?>>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder APP ID </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Icontact_app_id" id="hangout_Icontact_app_id" value="<?php echo $hangout_Icontact_app_id; ?>" /></span>
											</div>

										</div>
									</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder User Name </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Icontact_user_name" id="hangout_Icontact_user_name" value="<?php echo $hangout_Icontact_user_name; ?>" /></span>
											</div>

										</div>
									</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Password </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Icontact_user_password" id="hangout_Icontact_user_password" value="<?php echo $hangout_Icontact_user_password; ?>" /></span>
											</div>

										</div>
									</div>
									
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder List ID </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Icontact_list_id" id="hangout_Icontact_list_id" value="<?php echo $hangout_Icontact_list_id; ?>" /></span>
											</div>

										</div>
									</div>
									</div>
									<div id="GetResponce" <?php if($hangout_registration_system!='GetResponce'){  echo 'style="display:none;"'; } ?>>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder API Key </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_GetResponce_api_key" id="hangout_GetResponce_api_key" value="<?php echo $hangout_GetResponce_api_key; ?>" /></span>
											</div>

										</div>
										</div>
										<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Campaign Name </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_GetResponce_campaign_name" id="hangout_GetResponce_campaign_name" value="<?php echo $hangout_GetResponce_campaign_name; ?>" /></span>
											</div>

										</div>
									</div>
									
									
									</div>
									<div id="Sendreach" <?php if($hangout_registration_system!='Sendreach'){  echo 'style="display:none;"'; } ?>>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder List Id </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Sendreach_list_id" id="hangout_Sendreach_list_id" value="<?php echo $hangout_Sendreach_list_id; ?>" /></span>
											</div>

										</div>
										</div>
									
									
									
									</div>
									<div id="InfusionSoft" <?php if($hangout_registration_system!='InfusionSoft'){  echo 'style="display:none;"'; } ?>>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Api Key </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_InfusionSoft_list_id" id="hangout_InfusionSoft_list_id" value="<?php echo $hangout_InfusionSoft_list_id; ?>" /></span>
											</div>

										</div>
										</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder App  </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_InfusionSoft_app" id="hangout_InfusionSoft_app" value="<?php echo $hangout_InfusionSoft_app; ?>" /></span>
											</div>

										</div>
										</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Tag Id </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_InfusionSoft_tag_id" id="hangout_InfusionSoft_tag_id" value="<?php echo $hangout_InfusionSoft_tag_id; ?>" /></span>
											</div>

										</div>
										</div>
									
									</div>
									<div id="Aweber" <?php if($hangout_registration_system!='Aweber'){  echo 'style="display:none;"'; } ?>>
									<div id="set_up_data" >
									<?php if($hangout_Aweber_api_key==''){?>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Set Up </strong>
											</div>
											<div class="span8">
												
												<input id="allow_access_event" type="button" value="setup" name="setup_aweber" class="hangout_btn" onclick="window.open('https://auth.aweber.com/1.0/oauth/authorize_app/abc9dca2 ');" >
											</div>
												
										</div>
									</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Auth Code </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_Aweber_auth_code" id="hangout_Aweber_auth_code" value="<?php echo $hangout_Aweber_auth_code; ?>" />
												
												<input id="set_connection" type="button" value="Create Connection" class="hangout_btn">
												
											</div>
												
										</div>
									</div>
									<?php }else { ?>
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
												<input type="text" class="longinput" name="hangout_Aweber_consumer_Secret" value="<?php echo $hangout_Aweber_consumer_Secret; ?>" ></span>
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
												<strong>Autoresponder List  </strong>
											</div>
											<div class="span8">
											<select name="hangout_Aweber_list_id" id="hangout_Aweber_list_id">
												<option  class="longinput"  value="<?php echo $hangout_Aweber_list_id.'%'.$hangout_Aweber_list_name; ?>" ><?php echo $hangout_Aweber_list_name; ?></option>
												</select>
												<input  type="submit" value="Refresh List" name="refresh_list" class="hangout_btn" onclick="window.open('https://auth.aweber.com/1.0/oauth/authorize_app/abc9dca2 ');" >
											</div>

										</div>
									</div> 
									<?php } ?>
									
									
									</div>
									</div>
									<div  <?php if($hangout_registration_system!='Other'){  echo 'style="display:none;"'; } ?> id="hangout_othersresponder" >
										<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Name Field Name </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_amber_name_field" id="hangout_amber_name_field" value="<?php echo $aweber_name; ?>" /></span>
											</div>

										</div>
									</div>
									
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder Email Field Name </strong>
											</div>
											<div class="span8">
												<input type="text" class="longinput" name="hangout_amber_name_email" id="hangout_amber_name_email" value="<?php echo $aweber_email; ?>" /></span>
											</div>

										</div>
									</div>
									<div class="row-fluid-outer">
										<div class="row-fluid">
										
											<div class="span4">
												<strong>Autoresponder HTML code </strong>
											</div>
											<div class="span8">
												<textarea name="hangout_amber_from" cols="80" rows="10"><?php echo $aweber; ?></textarea></span>
											</div>

										</div>
									</div>
									</div>
								</div>
                        </div>
						<?php 
						$selected_theme=$_REQUEST['selected_theme'];
						if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){?>
						<div class="row-fluid-outer" >
						
						 <div class="row-fluid">
							<div class="span4">
								<strong>Form Field Active</strong>
                            </div>
                            <div class="span8">
								First name</br>
								<input type="radio" name="first_name_active" value="1" <?php if($first_name_active==1 || $first_name_active==""){ echo 'checked="checked"'; } ?>/> Yes 
								<input type="radio" name="first_name_active" value="0" <?php if($first_name_active==0 || $first_name_active==""){ echo 'checked="checked"'; } ?>/> No</span></br></br>
								Last name</br>
								<input type="radio" name="last_name_active" value="1" <?php if($last_name_active==1 || $first_name_active==""){ echo 'checked="checked"'; } ?>/> Yes 
								<input type="radio" name="last_name_active" value="0" <?php if($last_name_active==0 || $first_name_active==""){ echo 'checked="checked"'; } ?>/> No</span></br></br>
								Organisation name</br>
								<input type="radio" name="organisation_name_active" value="1" <?php if($organisation_name_active==1){ echo 'checked="checked"'; } ?>/> Yes 
								<input type="radio" name="organisation_name_active" value="0" <?php if($organisation_name_active==0){ echo 'checked="checked"'; } ?>/> No</span>
								
                            </div>
                        </div>
						
						</div>
						<?php } ?>
						</div>
                        <div class="row-fluid-outer" <?php if($hangout_registration_system!="Default"){  echo 'style="display:none;"'; } ?> id="send_notification">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Send Notifications  </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="hangout_send_notifications" value="1" <?php if($event_notification==1){ echo 'checked="checked"'; } ?>/> Yes
								<input <?php if($event_notification==0){ echo 'checked="checked"'; }?> type="radio" name="hangout_send_notifications" value="0" /> No</span>

								
                               
                            </div>
                        </div>
						</div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong> Turn On Chat On Registration Page? </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="chat_reg_off_replay" value="1" <?php if($chat_reg_off_replay==1 || $chat_reg_off_replay==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="chat_reg_off_replay" value="0" <?php if($chat_reg_off_replay==0){ echo 'checked="checked"'; } ?>/> No
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong> Add Meta Tag </strong>
                            </div>
                            <div class="span8">
								<textarea name="add_meta_tag"  col="10" rows="5"><?php echo   stripcslashes(get_post_meta($_REQUEST['EID'],'add_meta_tag',true)); ?></textarea>
                            </div>
                        </div>
                        </div>
                        <?php

						if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {
						
						
								?>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Make Webinar Public Or Private</strong>
                            </div>
                            <span class="span_block_phone">
		                		<input type="radio" value="public" <?php if($hangout_public_private == "public" || $hangout_public_private == "" ){ echo "checked"; } ?> name="hangout_public_private"> Public
		                	</span>
		                	<span class="span_block_phone">
		                		<input type="radio" value="private" <?php if($hangout_public_private == "private"){ echo "checked"; } ?> name="hangout_public_private">  Private
		                	</span>
                        </div>
                        </div>
						<?php } ?>
						<?php if(is_plugin_active( 'RunclickPlus/runclickplus.php' ) ) { ?>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong> Publish on Runclick Google+ wall </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="runclick_google_plus_wall" value="1" <?php if($runclick_google_plus_wall==1 || $runclick_google_plus_wall==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="runclick_google_plus_wall" value="0" <?php if($runclick_google_plus_wall==0){ echo 'checked="checked"'; } ?>/> No
                            </div>
                        </div>
                        </div>
						
						
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong> Publish on Social Networks </strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="runclick_social_networks" value="1" <?php if($runclick_social_networks==1 || $runclick_social_networks==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="runclick_social_networks" value="0" <?php if($runclick_social_networks==0){ echo 'checked="checked"'; } ?>/> No
                            </div>
                        </div>
                        </div>
						<?php } ?>
						
						
						
						
                        </div>
					<?php 
					if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {
					?>
					<div id="myMenu2" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Clock Design </div>
						<div id="myDiv2" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Clock Design </strong>
                            </div>
                            <div class="span8">
								<div class="row-fluid">
									<div class="span4">
                                    <div class="gh_img_full">
                                    <input type="radio" name="timer_type" <?php if($timer_type=='1' || $timer_type == ''){ echo 'checked="checked"'; }?> value="1">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/timer1.JPG" alt=""/>
                                    </div>
                                    </div>
                                    <div class="span4">
                                    <div class="gh_img_full">
                                    <input type="radio" name="timer_type" <?php if($timer_type=='2'){ echo 'checked="checked"'; }?> value="2">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/timer2.JPG" alt=""/>
                                    </div>
                                    </div>
                                    <div class="span4">
                                    <div class="gh_img_full">
                                    <input type="radio" name="timer_type" <?php if($timer_type=='3'){ echo 'checked="checked"'; }?> value="3">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/timer3.JPG" alt=""/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
						<?php } ?>
						<?php
						$selected_theme=$_REQUEST['selected_theme'];
						
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					?>
						<div id="myMenu31" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Add Html below Webinar video </div>
							<div id="myDiv31" class="gh_accordian_div">
								<div class="ghanghoutDiv" >
						
								<?php if(isset($_REQUEST['EID'])){ ?>
									<a href="javascript:void(0);" class="preview_hangout_event">Save and preview</a>
								<?php } ?>
							<br/>
							<?php echo wp_editor( $ghanghout_editor_undervideo, 'ghanghout_editor_undervideo' ); ?>


							</div>
							</div>
					<?php
					}
					else{
						?>
						<div id="myMenu3" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Page Design </div>
						<div id="myDiv3" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Registration Page Design </strong>
                            </div>
                            <div class="span8">
								<div class="row-fluid">
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_layout_type ==1 || $g_hangout_layout_type==''){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_layout_type" value="1">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/option1.png" alt=""/>
                                    </div>
                                    </div>
                                    <div class="span6">
                                    <div class="gh_img_full">
                                    <input <?php if($g_hangout_layout_type ==2 ){ echo 'checked="checked"'; } ?> type="radio" name="g_hangout_layout_type" value="2">
                                    <img src="<?php echo plugin_dir_url(__FILE__);?>images/option2.png" alt=""/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
						<div id="option2layout" <?php if($g_hangout_layout_type==1 || $g_hangout_layout_type==''){ echo 'style="display:none;"'; } ?>>

							 <div class="row-fluid-outer">
	                        <div class="row-fluid">
							        <div class="span6">
							<b>Full Banner Image</b>  
									</div><div class="span6">
							<input type="file" name="ghanghout_full_banner_image" id="ghanghout_full_banner_image" value="" class="ghanghoutUpload upload2">
							<?php if($ghanghout_full_banner_image!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_full_banner_image;?>">
								<?php } ?>
							</div>
							</div>
							</div>
							<!--<div class="row-fluid-outer">
	                        <div class="row-fluid">
							<div class="span6">
							<b>Timer Position</b>  </div>
							<div class="span6">
							<input type="radio" name="ghanghout_timer_position"  value="top" <?php if($ghanghout_timer_position=='' || $ghanghout_timer_position == "top")echo 'checked="checked"';?>> Top &nbsp;&nbsp;
							<input type="radio" name="ghanghout_timer_position"  value="bottom" <?php if($ghanghout_timer_position == "bottom")echo 'checked="checked"';?>> Bottom
							</div>
							</div>
							</div>-->
							
						</div>
						<div id="option1layout" <?php if($g_hangout_layout_type==2){ echo 'style="display:block;"'; } ?>>
						 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="notfullscreen" style="">

							<div class="ghanghoutDiv" id="headline">
							<p class="ghanghoutHeading">Headline Settings</p>

							<b>Headline Text</b><br>
							<span class="howto">Enter text for your headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_headline" rows="2" cols="60" class="ghanghoutText"><?php echo $ghanghout_headline; ?></textarea>

							<p><b>Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_headline_family" id="ghanghout_headline_family">
							<option <?php if($ghanghout_headline_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_headline_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_headline_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_headline_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_headline_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_headline_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_headline_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_headline_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_headline_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_headline_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_headline_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_headline_size" id="ghanghout_headline_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_headline_size=='' && $x==48){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_headline_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_headline_style" id="ghanghout_headline_style">
								<option <?php if($ghanghout_headline_style=="Normal" || $ghanghout_headline_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_headline_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_headline_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_headline_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_headline_shadow" id="ghanghout_headline_shadow">
								<option <?php if($ghanghout_headline_shadow=="None" || $ghanghout_headline_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_headline_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_headline_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_headline_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_headline_height" id="ghanghout_headline_height">
								<option <?php if($ghanghout_headline_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_headline_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_headline_height=="75%" || $ghanghout_headline_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_headline_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_headline_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_headline_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_headline_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_headline_spacing" id="ghanghout_headline_spacing">
								<option <?php if($ghanghout_headline_spacing=="-3" || $ghanghout_headline_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_headline_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_headline_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_headline_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_headline_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_headline_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_headline_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_headline_color" id="ghanghout_headline_color" type="text" value="<?php echo $ghanghout_headline_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>
							</p>

							<b>Sub-Headline Text</b><br>
							<span class="howto">Enter text for your sub-headline. Click "Enter" to add a new line.</span>
							<textarea name="ghanghout_subhead" rows="2" cols="60" class="ghanghoutText"><?php echo $ghanghout_subhead; ?></textarea>

							<p><b>Sub-Headline Style</b><br>
							<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
							<select name="ghanghout_subhead_family" id="ghanghout_subhead_family">
								<option <?php if($ghanghout_subhead_family=="Arial")echo "selected=''"; ?>>Arial</option>
								<option <?php if($ghanghout_subhead_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
								<option <?php if($ghanghout_subhead_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

								<option <?php if($ghanghout_subhead_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
								<option <?php if($ghanghout_subhead_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
								<option <?php if($ghanghout_subhead_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
								<option <?php if($ghanghout_subhead_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
								<option <?php if($ghanghout_subhead_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
								<option <?php if($ghanghout_subhead_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
								<option <?php if($ghanghout_subhead_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
								<option <?php if($ghanghout_subhead_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
							</select>
							<select name="ghanghout_subhead_size" id="ghanghout_subhead_size">
								<?php $x=10; 
							while($x<=100){
								$chk='';
								if($ghanghout_subhead_size=='' && $x==28){
									$chk = 'selected=""';
								} else {
									$comparstr = $ghanghout_subhead_size.'px';
									if($comparstr==$x){
										$chk = 'selected=""';
									}
								}
							echo '<option '.$chk.'>'.$x.'px</option>';
							$x++;
							}
							?>
							</select>
							<select name="ghanghout_subhead_style" id="ghanghout_subhead_style">
								<option <?php if($ghanghout_subhead_style=="Normal" || $ghanghout_subhead_style=='')echo "selected=''"; ?> >Normal</option>
								<option <?php if($ghanghout_subhead_style=="Italic")echo "selected=''"; ?>>Italic</option>
								<option <?php if($ghanghout_subhead_style=="Bold")echo "selected=''"; ?>>Bold</option>
								<option <?php if($ghanghout_subhead_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
							</select>

							<select name="ghanghout_subhead_shadow" id="ghanghout_subhead_shadow">
								<option <?php if($ghanghout_subhead_shadow=="None" || $ghanghout_subhead_shadow=='')echo "selected=''"; ?> >None</option>
								<option <?php if($ghanghout_subhead_shadow=="Small")echo "selected=''"; ?>>Small</option>
								<option <?php if($ghanghout_subhead_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
								<option <?php if($ghanghout_subhead_shadow=="Large")echo "selected=''"; ?>>Large</option>
							</select>

							<select name="ghanghout_subhead_height" id="ghanghout_subhead_height">
								<option <?php if($ghanghout_subhead_height=="70%")echo "selected=''"; ?> >70%</option>
								<option <?php if($ghanghout_subhead_height=="75%")echo "selected=''"; ?>>75%</option>
								<option <?php if($ghanghout_subhead_height=="75%" || $ghanghout_subhead_height=='')echo "selected=''"; ?>>80%</option>
								<option <?php if($ghanghout_subhead_height=="85%")echo "selected=''"; ?> >85%</option>
								<option <?php if($ghanghout_subhead_height=="90%")echo "selected=''"; ?> >90%</option>
								<option <?php if($ghanghout_subhead_height=="95%")echo "selected=''"; ?> >95%</option>
								<option <?php if($ghanghout_subhead_height=="100%")echo "selected=''"; ?> >100%</option>
							</select>

							<select name="ghanghout_subhead_spacing" id="ghanghout_subhead_spacing">
								<option <?php if($ghanghout_subhead_spacing=="-3" || $ghanghout_subhead_spacing=='')echo "selected=''"; ?> >-3</option>
								<option <?php if($ghanghout_subhead_spacing=="-2" )echo "selected=''"; ?>>-2</option>
								<option <?php if($ghanghout_subhead_spacing=="-1" )echo "selected=''"; ?>>-1</option>
								<option <?php if($ghanghout_subhead_spacing=="0" )echo "selected=''"; ?>>0</option>
								<option <?php if($ghanghout_subhead_spacing=="1" )echo "selected=''"; ?>>1</option>
								<option <?php if($ghanghout_subhead_spacing=="2" )echo "selected=''"; ?>>2</option>
								<option <?php if($ghanghout_subhead_spacing=="3" )echo "selected=''"; ?>>3</option>
							</select>

							 <input name="ghanghout_subhead_color" id="ghanghout_subhead_color" type="text" value="<?php echo $ghanghout_subhead_color;?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

							</p>
							</div>
							</div>

							<div class="ghanghoutDiv" >
							<?php if($ghanghout_option1editor == "")
							{
								$ghanghout_option1editor	=	'<p style="text-align: center;">[ghangout_timer]</p><p style="text-align: center;">[ghangout_reg_form]</p>';
							}?>	
							
								<?php if(isset($_REQUEST['EID'])){ ?>
									<a href="javascript:void(0);" class="preview_hangout_event">Save and preview</a>
								<?php } ?>
							<br/>
							<?php echo wp_editor( $ghanghout_option1editor, 'ghanghout_option1editor' ); ?>


							</div>
							</div>
							</div>
							</div>
							
					</div>
						
					<?php }	?>

					<div id="myMenu4" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Header settings </div>
						<div id="myDiv4" class="gh_accordian_div">
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo / Social Sharing </strong>
                            </div>
                            <div class="span8">
								<input id="ghanghout_enable_header" name="ghanghout_enable_header" size="30" value="checked" type="checkbox" <?php if($ghanghout_enable_header=="checked"){ echo 'checked="checked"'; } ?> > Enable Logo &nbsp;&nbsp;<input id="ghanghout_enable_sharing" name="ghanghout_enable_sharing" size="30" value="checked" type="checkbox" <?php if($ghanghout_enable_sharing=="checked"){ echo 'checked="checked"'; } ?>> Enable Social Sharing 
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
								<input type="file" class="ghanghoutUpload upload2" name="ghanghout_logo" id="ghanghout_logo" value="" class="ghanghoutUpload upload2">
								<?php if($ghanghout_logo!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_logo;?>"><br>
									<a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete_webinar_logo&logo_name=<?php echo $ghanghout_logo;?>&EID=<?echo $post_id;?>" class="h_editing_link">
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
								<input class="longinput"  type="text" name="ghanghout_logo_text" id="ghanghout_logo_text" value="<?php echo $ghanghout_logo_text; ?>" class="ghanghoutText">
                            </div>
                        </div>
                        </div>


					 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span12">
								<b>Logo Style</b><br>
								<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
								<select name="ghanghout_logo_family" id="ghanghout_logo_family">

									<option <?php if($ghanghout_logo_family=="Arial")echo "selected=''"; ?>>Arial</option>
									<option <?php if($ghanghout_logo_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
									<option <?php if($ghanghout_logo_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

									<option <?php if($ghanghout_logo_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
									<option <?php if($ghanghout_logo_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
									<option <?php if($ghanghout_logo_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
									<option <?php if($ghanghout_logo_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
									<option <?php if($ghanghout_logo_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
									<option <?php if($ghanghout_logo_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
									<option <?php if($ghanghout_logo_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
									<option <?php if($ghanghout_logo_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
								</select>

								<select name="ghanghout_logo_size" id="ghanghout_logo_size">
								<?php $x=10; 
								while($x<=100){
									$chk='';
									if($ghanghout_logo_size=='' && $x==48){
										$chk = 'selected="selected"';
									} else {
										echo $comparstr = $ghanghout_logo_size.'px';
										if($comparstr==$x){
											$chk = 'selected="selected"';
										}
									}
								echo '<option '.$chk.'>'.$x.'px</option>';
								$x++;
								}
								?>
								</select>
								<select name="ghanghout_logo_style" id="ghanghout_logo_style">
									<option <?php if($ghanghout_logo_style=="Normal" || $ghanghout_logo_style=='')echo "selected=''"; ?> >Normal</option>
									<option <?php if($ghanghout_logo_style=="Italic")echo "selected=''"; ?>>Italic</option>
									<option <?php if($ghanghout_logo_style=="Bold")echo "selected=''"; ?>>Bold</option>
									<option <?php if($ghanghout_logo_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
								</select>

								<select name="ghanghout_logo_shadow" id="ghanghout_logo_shadow">
									<option <?php if($ghanghout_logo_shadow=="None" || $ghanghout_logo_shadow=='')echo "selected=''"; ?> >None</option>
									<option <?php if($ghanghout_logo_shadow=="Small")echo "selected=''"; ?>>Small</option>
									<option <?php if($ghanghout_logo_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
									<option <?php if($ghanghout_logo_shadow=="Large")echo "selected=''"; ?>>Large</option>
								</select>

								<select name="ghanghout_logo_height" id="ghanghout_logo_height">
									<option <?php if($ghanghout_logo_height=="70%")echo "selected=''"; ?> >70%</option>
									<option <?php if($ghanghout_logo_height=="75%")echo "selected=''"; ?>>75%</option>
									<option <?php if($ghanghout_logo_height=="75%" || $ghanghout_logo_height=='')echo "selected=''"; ?>>80%</option>
									<option <?php if($ghanghout_logo_height=="85%")echo "selected=''"; ?> >85%</option>
									<option <?php if($ghanghout_logo_height=="90%")echo "selected=''"; ?> >90%</option>
									<option <?php if($ghanghout_logo_height=="95%")echo "selected=''"; ?> >95%</option>
									<option <?php if($ghanghout_logo_height=="100%")echo "selected=''"; ?> >100%</option>
								</select>

								<select name="ghanghout_logo_spacing" id="ghanghout_logo_spacing">
									<option <?php if($ghanghout_logo_spacing=="-3" || $ghanghout_logo_spacing=='')echo "selected=''"; ?> >-3</option>
									<option <?php if($ghanghout_logo_spacing=="-2" )echo "selected=''"; ?>>-2</option>
									<option <?php if($ghanghout_logo_spacing=="-1" )echo "selected=''"; ?>>-1</option>
									<option <?php if($ghanghout_logo_spacing=="0" )echo "selected=''"; ?>>0</option>
									<option <?php if($ghanghout_logo_spacing=="1" )echo "selected=''"; ?>>1</option>
									<option <?php if($ghanghout_logo_spacing=="2" )echo "selected=''"; ?>>2</option>
									<option <?php if($ghanghout_logo_spacing=="3" )echo "selected=''"; ?>>3</option>
								</select>

								 <input name="ghanghout_logo_color" id="ghanghout_logo_color" type="text" value="<?php echo $ghanghout_logo_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

			</div>
			</div>
			</div>
			</div>
			<?php 
				
				if($google_hangout_theme == "Default" or $selected_theme ==  "Default" ){
				}
				else if($selected_theme!='' or $google_hangout_theme !=''  ){
				
				$google_hangout_selected_theme=str_replace('_',' ',$selected_theme);
				if($google_hangout_selected_theme==''){
				$google_hangout_selected_theme=$google_hangout_theme;
				$google_hangout_selected_theme=str_replace('_',' ',$google_hangout_selected_theme);
				}
				?>
				<!-- Theme Settings Start -->
					<div id="myMenuB1" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Theme settings </div>
					<div id="myDivB1" class="gh_accordian_div">
				<?php
					include_once 'themes/'.$google_hangout_selected_theme.'/event_back.php';
				?>
					</div>
					<!-- Theme Settings End -->
				<?php
				}
			?>
				
			</div>
			<div class="actionBar">
<?php /* if(get_option('g_project_id')=='' || get_option('hangout_youtube_user_id')==''){?>
<button class="hangout_btn" type="button" name="submit"><i class="icon-plus-sign"></i> Add Webinar Event</button>


<?php } else{ */
if($_REQUEST['type']){
?>
<button class="hangout_btn" name="new_hangout_submit"  id="add_new_hangout_event" type="submit"><i class="icon-plus-sign"></i> Add Webinar Event</button>
<?php
} else{ 
if(isset($_REQUEST['EID'])){ ?>
<a class="hangout_btn preview_hangout_button" href="javascript:void(0);"><i class="icon-plus-sign"></i> Save & Preview Webinar Event</a>
<button class="hangout_btn update_hangout_event" name="edit_event_hangout" type="submit"><i class="icon-plus-sign"></i> Update Event</button>
<?php } else { 
?>
<button class="hangout_btn" name="new_hangout_submit"  id="add_new_hangout_event" type="submit"><i class="icon-plus-sign"></i> Add Webinar Event</button>

<?php } }  ?></div>
</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#ghangout_timezone').datetimepicker({
				timeFormat: 'hh:mm tt',
				dateFormat: 'dd/mm/yy'
				});

		
			
	jQuery(".locationsearch").searchable({
				maxListSize: 100,
				maxMultiMatch: 50,
				latency: 200,
				exactMatch: false,
				wildcards: true,
				ignoreCase: true,
				warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch
		        warnNoMatch: 'no matches ...',  
				zIndex: 'auto'
	});



		//jQuery("#value").html($("#locationsearch :selected").text() + " (VALUE: " + $("#locationsearch").val() + ")");
		jQuery(".locationsearch").change(function(){
			jQuery("#value").html(this.options[this.selectedIndex].text + " (VALUE: " + this.value + ")");
		});
		
		jQuery(".preview_hangout_event").live('click',function(){
			jQuery("#hangout_manage").submit();
			setTimeout(function(){
				window.open("<?php echo get_permalink($_REQUEST['EID']);?>","_blank");
			});
		});
	});
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".preview_hangout_button").live('click',function(){
			jQuery(".update_hangout_event").trigger('click');
			setTimeout(function(){
				window.open('<?php echo get_permalink($_REQUEST['EID']); ?>','_blank');
			},800);
			
		});
		jQuery('.ghangout_membership_type').change(function(){
			clasnm = jQuery(this).val();
			jQuery('.2xmembership').hide();
			jQuery('.memberchk').prop('checked', false);
			jQuery('.'+clasnm).show();

		});
		jQuery('.ghanghout_enabled_membership').click(function(){
			if(jQuery(this).val()=='no'){
				jQuery('.is_mebership_active').hide();	
			} else {
				jQuery('.is_mebership_active').show();
			}
		});
		jQuery("#delete_webinar_logo").click(function(){
		 confirm("Want to delete Logo");
		 
		});
	});
</script>