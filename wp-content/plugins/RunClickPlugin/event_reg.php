<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: 0});
	});
	
	
	
</script>
<?php  
global $wpdb;
$url	=	get_permalink(get_the_ID());
$url_parts	=	explode("?",$url);

if(count($url_parts) > 1)
{
?>

	<script type="text/javascript">
		var thankyou_url	=	'<?php echo get_permalink(get_the_ID());?>&thankyou=true';
		var replay_url	=	'<?php echo get_permalink(get_the_ID());?>&replay_preview=true';
	</script>
<?php
}
else{
?>
	<script type="text/javascript">
		var thankyou_url	=	'<?php echo get_permalink(get_the_ID());?>?thankyou=true';
		var replay_url	=	'<?php echo get_permalink(get_the_ID());?>?replay_preview=true';
	</script>
<?php
}
if(get_post_meta($post->ID,'hangout_live_timer',true)){
	//return '';
}

$hangout_registration = 	get_post_meta($post->ID,'hangout_registration',true);
$hangout_send_notifications = 	get_post_meta($post->ID,'hangout_send_notifications',true);
$reminder_time = 	explode(",",get_post_meta($post->ID,'reminder_time',true));

$hangout_status	=	get_post_meta(get_the_ID(),'current_hangout_status',true);
	
$hangout_registration_system = get_post_meta($post->ID,'hangout_registration_system',true);
$hangot_type=get_post_meta($post->ID,"hangout_type",true);	
$hangout_make_now = get_post_meta($post->ID,'hangout_make_now',true);
$form ='';

if($hangout_status==2){
	echo $keep_registration_form =get_post_meta($post->ID,'keep_registration_form',true);
} 
else{
	$keep_registration_form = get_post_meta($post->ID,'hangout_registration',true);
}
$keep_registration_form=1;
	
if($keep_registration_form==1){

	if($hangout_registration_system!='Other'){
		$post_id=get_the_ID();
		$current_date=date('d-m-Y');
		$time1 = date('h.i A');
		if($hangot_type=='Record_hangout'  ){
			$time_show='<select name="select_time" id="select_time" class="span12" style="color: #9F9F9F;">
							<option value="">Select Time*</option>';
			$replay_time= get_post_meta($post_id,"ppc_theme_select_replay_time",true);
			$replay_time_array=unserialize($replay_time);
			if(!empty($replay_time_array)){
				foreach($replay_time_array as $time){
					$time_show.='<option value="'.$time.'">'.$time.'</option>';
				}
			}
			$time_show.='</select>';
		}	 
	
	 
		$time=time();
		$next_date=date("d-m-Y", mktime(0,0,0,date("n", $time),date("j",$time)+ 1 ,date("Y", $time)));
		$next_to_next_date=date("d-m-Y", mktime(0,0,0,date("n", $time),date("j",$time)+ 2 ,date("Y", $time)));
	
		if($hangot_type=='Record_hangout' ){	
			 $registrations_date_system=get_post_meta($post_id,'registrations_date_system',true);
			 if($registrations_date_system==1 || $registrations_date_system==''){
				$date_system='<select  name="select_date" id="select_date" class="span12 select_date" style="color: #9F9F9F;" />
								<option value="">Select Date*</option>
								<option value="Today">Today('.$current_date.')</option>
								<option value="'.$next_date.'">'.$next_date.'</option>
								<option value="'.$next_to_next_date.'">'.$next_to_next_date.'</option>
							 </select>';
			}elseif($registrations_date_system==0 || $registrations_date_system==''){
				$date_system='<input type="text" id="datepicker" name="select_date" class="span12 select_date" placeholder="Select Date*" />';
			}else{	 
				$replay_day= get_post_meta($post->ID,"hangout_select_replay_day",true);															 $replay_day_array=unserialize($replay_day);	  
					foreach($replay_day_array as $day){
						$date_array[]=(date('d-m-Y', strtotime($day)));
				 
					}
			
				sort($date_array);

				foreach($date_array as $passdate){
					$replay_day_sort[]= date('l', strtotime($passdate));
				}
				
				$date_system.='<select  name="select_date" id="select_date" class="span12 select_date" style="color: #9F9F9F;" />';	 foreach($replay_day_sort as $day){	 $date_system.='<option    value="'.(date('d-m-Y', strtotime($day))).'" />'.$day .' ('.(date('d-m-Y', strtotime($day))).')</option>';	 }	 $date_system.= '</select>';	 	
		 
			}
		}
		

		$locatation = $wpdb->get_results('select * from '. $wpdb->prefix.'location'); 

		 if($hangot_type=='Record_hangout'){  
			$timezone=  '<select id="locationsearch" class="locationsearch" name="locationsearch" style="width:100%;color: #9F9F9F;">
							<option value="">Select Time Zone*</option>';
		
								
			foreach($locatation as $locdata){ 
				if($hangout_time_zone == $locdata->name){ $selected= "selected='selected'"; }
					$timezone.='<option value="'.$locdata->name.'" '.$selected.' >'. $locdata->time_code.' ('.$locdata->title.')</option>';
			}
					$timezone.='</select>';
		
		 }
		
		if($hangout_make_now==1) {
			$checkbox=' <div style="display:block; clear:both; min-height:30px;">
							<input type="checkbox" style="display:inline; padding:0px; margin:0px 10px 15px 0px; height:auto;" name="makenow" id="watch_now" value="1" class="user-success"><span>I prefer to watch now</span> 
						</div> ';
			$blankdiv =' <div style="display:block; clear:both; min-height:30px;"></div>'; 
		}
		if($hangot_type=='Record_hangout' && $hangout_make_now==1 ){
			$divstyle='style="margin-top:77px;"';
		}
		 
		$div_clear="<div class=clear></div>";
		
		$form	.=	'<div class="row-fluid ff-hh">
				<div class="ho_contentin">
					<div class="ho_registation">
						<form id="g_hangout_reg_form" method="post" name="hangout_reg_form">
							<div class="ho_block"><h2>Register Now</h2></div>
							
							<div class="span4">
								<div class="ho_block">
									<input class="span12" id="event_reg_name" name="event_reg_name" type="text" placeholder="Enter Your Full Name" />
									
									'.$checkbox.'
									'.$date_system.'
									'.$div_clear.'
									'.$timezone.'
								</div>
							</div>
							<div class="span4">
								<div class="ho_block">
									<input class="span12" id="event_reg_email" name="event_reg_email" type="text" placeholder="Enter Your Email" />
									'.$blankdiv.'	
									'.$time_show.'
									

									
								</div>
							</div>
							
							<div class="span4">
								<div class="ho_block">
									<input type="hidden" name="g_hangout_id" value="'.$post->ID.'" >
									<button type="submit" name="submit" id="g_hangout_submit_form" class="hangout_btn span12" '.$divstyle.' ><i class="icon-share-alt" ></i> Register Now</button>
								</div>
							</div>
							<div class="clear"></div>
						</form>	
					</div>
				</div>
			</div>
			<div class="clear"></div>';
			
			$buybuttonhtml       = get_post_meta($post->ID,'buybuttonhtml',true);

			$vote_question       = get_post_meta($post->ID, "vote_question", true);
			$vote_options        = get_post_meta($post->ID, "vote_options", true);
			$vote_correct_option = get_post_meta($post->ID, "vote_correct_option", true);

			
		$form .= '<a href="javascript:void(0);" data-reveal-id="myModal" id="clicktoopenpopup">&nbsp;</a>
					<div id="myModal" class="reveal-modal" rel="0">
						<h1>Please Fill Optin Form</h1>';
						$form	.=	'<div class="row-fluid ff-hh">
					<div class="ho_contentin">
						<div class="ho_registation">
							<form id="g_hangout_reg_form" method="post" name="hangout_reg_form">
								<div class="ho_block"><h2>Register Now</h2></div>
								<div class="span4">
									<div class="ho_block">
										<input class="span12" id="event_reg_name" name="event_reg_name" type="text" placeholder="Enter Your Full Name" />
										
									</div>
								</div>
								<div class="span4">
									<div class="ho_block">
										<input class="span12" id="event_reg_email" name="event_reg_email" type="text" placeholder="Enter Your Email" />
										
										
									</div>
								</div>
								<div class="span4">
									<div class="ho_block">
										<input type="hidden" name="g_hangout_id" value="'.$post->ID.'" >
										<button type="submit" name="submit" id="g_hangout_submit_form" class="hangout_btn span12"><i class="icon-share-alt"></i> Register Now</button>
									</div>
								</div>
								<div class="clear"></div>
							</form>	
						</div>
					</div>
				</div>
				<div class="clear"></div>
					</div>
				
				
					<a href="javascript:void(0);" data-reveal-id="myModal2" id="clicktoopenpopup2">&nbsp;</a>
					<div id="myModal2" class="reveal-modal" rel="0">
						<h1>Buy Button</h1>
						'.$buybuttonhtml.'
						<a class="close-reveal-modal" style="display:none;">&nbsp;</a>
					</div>
					
					<a href="javascript:void(0);" data-reveal-id="myModal3" id="clicktoopenpopup3">&nbsp;</a>
					<div id="myModal3" class="reveal-modal" rel="0">
						<h1>Please Vote</h1>';
						$form   .= '<div id="vote_hangout_form"><div id="voteoutput"></div>';
						$form   .= '<span>'.$vote_question.'</span>'."<br />";
						$options = explode('__', $vote_options);
						foreach($options as $option)
						{
							$form   .= '<input type="radio" name="vote_answer" class="vote_options" value="'.$option.'">&nbsp;'.$option."<br />";
						}
						$form   .= '<input type="button" class="hangout_btn" value="Vote" id="addvotefrompop">';
						$form   .= '</div>
					</div>';

	}else{
		$aweber_name	=	get_post_meta($post->ID,'hangout_amber_name_field',true);
		$aweber_email	=	get_post_meta($post->ID,'hangout_amber_name_email',true);
	
		$form .= '<div id="Aweber_hangout_form">';
		$form .= get_post_meta($post->ID,'hangout_amber_from',true);
		$form .='<input type="hidden" id="g_hangout_id" value="'.$post->ID.'" ><input type="hidden" id="hangout_name_field" value="'.$aweber_name.'"><input type="hidden" id="hangout_email_field" value="'.$aweber_email.'">';
		$form .= '</div>';
	}

}

$content1 .= '<div id="ajax_loader" style="position: fixed; width:300px; z-index: 1070; top: 334px; right: 220px; display: none; background: none; border: 0px solid #259BB8;"><img src="'.plugin_dir_url(__FILE__).'images/ajax-loader.gif"></div>';


	$content1 .=  $form;
	
	//global $post;
	//var_dump($post);
	return $content1;


?>
