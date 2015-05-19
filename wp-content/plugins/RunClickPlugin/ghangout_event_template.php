<?php 
global $wpdb;

if($_REQUEST['action']=='btn_email_update'){
	extract($_POST);
	$g_hangout_additional_reminder_time  = $follow_auto_resp_days .'-'.$follow_auto_resp_hour.'-'.$follow_auto_resp_minutes;
//	echo "update ".$wpdb->prefix."reminder set name='".$auto_resp_name."', subject='".$auto_resp_subject."', body='".$auto_resp_body."', reminder_time='".$g_hangout_additional_reminder_time."' where id='".$EID."'";

	$wpdb->query("update ".$wpdb->prefix."reminder set name='".$auto_resp_name."', subject='".$auto_resp_subject."', body='".$auto_resp_body."', reminder_time='".$g_hangout_additional_reminder_time."' where id='".$EMAIL_EID."'");
	wp_redirect(admin_url()."admin.php?page=google_hangout&msg=1&sel=2");

}
if($_REQUEST['action']=='email_delete'){
	$delid = $_REQUEST['EMAIL_DEL'];
	$wpdb->query("delete from ".$wpdb->prefix."reminder where id='".$delid."'");
	wp_redirect(admin_url()."admin.php?page=google_hangout&msg=1&sel=2");
}
if(isset($_POST['update_email'])){
	
	extract($_POST);
	foreach($auto_resp_days as $id => $data){
		$name = $auto_resp_name[$id];
		$subject = $auto_resp_subject[$id];
		$body = $auto_resp_body[$id];
		$g_hangout_additional_reminder_time  = $data .'-'.$auto_resp_hour[$id].'-'.$auto_resp_minutes[$id] ;
		if($subject !='' && $body != ''){
			$wpdb->query("insert into ".$wpdb->prefix."reminder (name,subject,body,reminder_time,reminder_type) values('".$name."', '".$subject."','".$body."','".$g_hangout_additional_reminder_time."','reminder')");
		}
	}

	$g_hangout_followup_reminder_time= '';
	
	foreach($follow_auto_resp_days as $id => $data){
		$name = $follow_auto_resp_name[$id];
		$subject = $follow_auto_resp_subject[$id];
		$body = $follow_auto_resp_body[$id];
		$g_hangout_followup_reminder_time  = $data .'-'.$follow_auto_resp_hour[$id].'-'.$follow_auto_resp_minutes[$id];
		$wpdb->query("insert into ".$wpdb->prefix."reminder (name,subject,body,reminder_time,reminder_type) values('".$name."', '".$subject."','".$body."','".$g_hangout_followup_reminder_time."','follow')");
	}
	
	update_option('g_hangout_followup_reminder_time', $g_hangout_followup_reminder_time);
	update_option('g_hangout_additional_reminder_time', $g_hangout_additional_reminder_time);
	update_option('g_hangout_reminder_subject', $g_hangout_reminder_subject);
	update_option('g_hangout_reminder_from', $g_hangout_reminder_from);
	update_option('g_hangout_reminder_msg', $g_hangout_reminder_msg);
	update_option('g_hangout_subscriber_subject', $g_hangout_subscriber_subject);
	update_option('g_hangout_subscriber_from', $g_hangout_subscriber_from);
	update_option('g_hangout_subscriber_msg', $g_hangout_subscriber_msg);
	update_option('g_hangout_follow_up_subject', $g_hangout_follow_up_subject);
	update_option('g_hangout_follow_up_from', $g_hangout_follow_up_from);
	update_option('g_hangout_follow_up_msg', $g_hangout_follow_up_msg);
	wp_redirect('admin.php?page=google_hangout&msg=1&sel=2');
}
if($_REQUEST['action']=='email_edit'){ ?>
	<form name="g_hangout_event" action="" method="post"/>

	<?php	
$id = $_REQUEST['EMAIL_EID'];
$editdata = $wpdb->get_results("select * from ".$wpdb->prefix."reminder where id='".$id."'");	

$g_hangout_followup_reminder_time = $editdata[0]->reminder_time; 
?>
<input type="hidden" name="EMAIL_EID" value="<?php echo $id; ?>">

<div class="gh_container_header">
                    	<div class="row-fluid">
                        <div class="span6">
                           <strong>EDIT EMAIL SETTINGS</strong>
                        	<br>
                        </div>
                        <div class="span6">
                            	<div class="block_right">
                        		<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout" class="hangout_btn"><i class="icon-reply-all"></i> Back</a>
                                </div>
                        </div>
                        </div>
</div>
<form name="g_hangout_event" action="" method="post"/>
<div class="gh_tabs_div_inner">
					<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Name</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput"  name="auto_resp_name" value="<?php echo $editdata[0]->name; ?>">
                            </div>
                        </div>
                    </div>
					<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Subject</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput"  name="auto_resp_subject" value="<?php echo $editdata[0]->subject; ?>">
                            </div>
                        </div>
                    </div>
					<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Body</strong>
                            </div>
							<div class="span8">
								<textarea rows="5" name="auto_resp_body"><?php echo $editdata[0]->body; ?></textarea>
                                <strong>Available variable</strong> {sitename},{date},{time}, {name}, {eventlinkURL},{eventName},{creatorEmail} 
                            </div>
                        </div>
                    </div>
					<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Body</strong>
                            
					
<?php if($editdata[0]->reminder_type=="reminder"){ ?>
<strong>How long before</strong>
<?php } else { ?>
<strong>How long after</strong>
<?php
}
?>
</div>
							<div class="span8">
<?php
$add_data_arr = explode("-",$g_hangout_followup_reminder_time);
	$add_data_str .= 'Days : <select name="follow_auto_resp_days">';
	$x=30;
	while($x>=0){
		$sel ='';
		if($x==$add_data_arr[0]){ $sel ="selected";}
		$add_data_str .= '<option value="'.$x.'" '. $sel.'>'.$x.'</option>';
		$x--;
	}

	$add_data_str .='</select> Hour  : <select name="follow_auto_resp_hour">';
	$x=24;
	while($x>=0){
		$sel ='';
		if($x==$add_data_arr[1]){ $sel ="selected";}
		$add_data_str .= '<option value="'.$x.'" '. $sel.'>'.$x.'</option>';
		$x--;
	}
	$add_data_str .='</select> Minutes : <select name="follow_auto_resp_minutes">';
	$x=55;
	while($x>=0){
		$sel ='';
		if($x==$add_data_arr[2]){ $sel ="selected";}
		$add_data_str .= '<option value="'.$x.'" '. $sel.'>'.$x.'</option>';
		$x = $x-5;
	}
	$add_data_str .='</select>';

echo $add_data_str; ?></div>
<input type="hidden" name="EID" value="<?php echo $_REQUEST['EID']; ?>"/>
<input type="hidden" name="action" value="btn_email_update"/>
<button name="btn_email_update" type="submit" class="hangout_btn"><i class="icon-save"></i> Update</button>

	</form>
	</div></div></div>
<?php } else {
?>

<form name="g_hangout_event" action="" method="post"/>




			<div class="gh_container_header">
            	<strong>Email Settings</strong>
            </div>

                    <div class="gh_tabs_div_inner">
					<?php if($_REQUEST['msg']=='1'){
							?>

							<div class="gh-announcement"> 
							<a class="gh-close alertbox">x</a>
							<strong>Successfully Updated!</strong>
							Webinar Email Template Setting is Successfully Updated.
							</div>
							<?php } ?>
                        <div id="myMenu1" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Subscriber Emails </div>
						<div id="myDiv1" class="gh_accordian_div">
                        <div class="hangout_text_padbtm">Customise this email as the 'subscriber' email , people will receive email when they register. </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>From</strong>
                            </div>
                            <div class="span8">
								<input type="text" value="<?php if(get_option('g_hangout_subscriber_from')=="") { echo get_bloginfo('admin_email');}else{ echo get_option('g_hangout_subscriber_from'); }?>" name="g_hangout_subscriber_from" class="longinput">
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Subject</strong>
                            </div>
                            <div class="span8">
								<input type="text" value="<?php echo get_option('g_hangout_subscriber_subject'); ?>" name="g_hangout_subscriber_subject" class="longinput">
                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Message</strong>
                            </div>
                            <div class="span8">
								<textarea rows="5" name="g_hangout_subscriber_msg"><?php echo get_option('g_hangout_subscriber_msg'); ?></textarea>
                                <strong>Available variable</strong> {sitename}, {date},{time}, {name}, {eventlinkURL},{eventName},{creatorEmail} 
                            </div>
                        </div>
                        </div>
						</div>

                        <div id="myMenu2" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Reminder Emails </div>
                        <div id="myDiv2" class="gh_accordian_div">
                        <div class="hangout_text_padbtm">Customise this email as the 'reminder' email, people will receive reminder emails. </div>
                         <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>From</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" value="<?php if(get_option('g_hangout_reminder_from')==""){ echo get_bloginfo('admin_email');}else{ echo get_option('g_hangout_reminder_from'); }?>" name="g_hangout_reminder_from">
                            </div>
                            </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Subject</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" value="<?php echo get_option('g_hangout_reminder_subject'); ?>" name="g_hangout_reminder_subject">
                            </div>
                            </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Message</strong>
                            </div>
                            <div class="span8">
								<textarea rows="5" name="g_hangout_reminder_msg"><?php echo get_option('g_hangout_reminder_msg'); ?></textarea>
                                <strong>Available variable</strong> {sitename},{date},{time}, {name}, {eventlinkURL},{eventName},{creatorEmail} 
                                <div class="gh_block_btn">
                                <button type="button" class="hangout_btn" id="add_additional_reminder"><i class="icon-plus-sign"></i> Add Reminder Emails</button>
                                </div>
                            </div>
                        </div>
                 		</div>
						<div id="reminder_data">
<?php
	$reminder_data = $wpdb->get_results("select * from ".$wpdb->prefix."reminder where reminder_type='reminder'");
	if( count($reminder_data) ){ ?>	

	<div class="gh_tabs_div_inner">
                        	<ul class="table_view table_heading">
                    			<li class="span3"><span>Name </span></li>
                        		<li class="span3"><span>Subject </span></li>
								<li class="span3"><span>Time(Day-Hour-Min)</span></li>
                        		<li class="span3"><span class="center">Action </span></li>
                    		</ul>
                        	
	
			<?php foreach($reminder_data as $output){ ?>
				
						<ul class="table_view">
                    			<li class="span3"><span><?php echo $output->name; ?> </span></li>
                        		<li class="span3"><span><?php echo $output->subject; ?></span></li>
								<li class="span3"><span><?php echo $output->reminder_time; ?></span></li>
                        		<li class="span3">
                                <span class="center">
                                	<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout&action=email_edit&EMAIL_EID=<?php echo $output->id;?>&sel=2" class="h_editing_link"><i class="icon-edit"></i> Edit</a> /
                                    <a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout&action=email_delete&EMAIL_DEL=<?php echo $output->id;?>" class="h_editing_link"><i class="icon-trash"></i> Delete</a>
                                </span>
                                </li>
                    		</ul>
			<?php } ?>
		</div>
	<?php }
?>

</div>
                        </div>
                        <div id="myMenu3" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Follow up Emails </div>
                        <div id="myDiv3" class="gh_accordian_div">
                        <div class="hangout_text_padbtm">Customise this email as the 'follow up' email , people will receive follow up emails. </div>
                                                <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>From</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" value="<?php if(get_option('g_hangout_follow_up_from')==""){ echo get_bloginfo('admin_email'); }echo get_option('g_hangout_follow_up_from'); ?>" name="g_hangout_follow_up_from">
                            </div>
                        </div>
                        </div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Subject</strong>
                            </div>
                            <div class="span8">
								<input type="text" class="longinput" value="<?php echo get_option('g_hangout_follow_up_subject'); ?>" name="g_hangout_follow_up_subject">
                            </div>
                        </div>
                        </div>
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Message</strong>
                            </div>
                            <div class="span8">
								<textarea rows="5" name="g_hangout_follow_up_msg"><?php echo get_option('g_hangout_follow_up_msg'); ?></textarea>
                                <strong>Available variable</strong> {sitename}, {date},{time}, {name}, {eventlinkURL},{eventName},{creatorEmail} 
                                <div class="gh_block_btn">
                                <button type="button" class="hangout_btn" id="add_follow_up_reminder"><i class="icon-plus-sign"></i> Add Follow Up Email</button>
                                </div>
                            </div>
                        </div>
                        </div>
                        	<div id="follow_reminder_data">
						<?php
							$reminder_data = $wpdb->get_results("select * from ".$wpdb->prefix."reminder where reminder_type='follow'");
							if( count($reminder_data) ){ ?>	

							<div class="gh_tabs_div_inner">
													<ul class="table_view table_heading">
														<li class="span3"><span>Name </span></li>
														<li class="span3"><span>Subject </span></li>
														<li class="span3"><span>Time(Day-Hour-Min)</span></li>
														<li class="span3"><span class="center">Action </span></li>
													</ul>
													
							
									<?php foreach($reminder_data as $output){ ?>
										
												<ul class="table_view">
														<li class="span3"><span><?php echo $output->name; ?> </span></li>
														<li class="span3"><span><?php echo $output->subject; ?></span></li>
														<li class="span3"><span><?php echo $output->reminder_time; ?></span></li>
														<li class="span3">
														<span class="center">
															<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout&action=email_edit&EMAIL_EID=<?php echo $output->id;?>&sel=2" class="h_editing_link"><i class="icon-edit"></i> Edit</a> /
															<a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout&action=email_delete&EMAIL_DEL=<?php echo $output->id;?>" class="h_editing_link"><i class="icon-trash"></i> Delete</a>
														</span>
														</li>
													</ul>
									<?php } ?>
								</div>
							<?php }
						?>

						</div>
						</div>

                        </div>
                        
                        <div class="actionBar">
                        	<button type="submit" name="update_email" class="hangout_btn"><i class="icon-save"></i> Update</button>
                        </div>

</form>



<?php } ?>
