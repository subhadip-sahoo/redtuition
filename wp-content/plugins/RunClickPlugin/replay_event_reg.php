<?php $url	=	get_permalink(get_the_ID());
	$url_parts	=	explode("?",$url);
	if(count($url_parts) > 1)
	{
?>
<script type="text/javascript">
var thankyou_url	=	'<?php echo get_permalink(get_the_ID());?>&thankyou=true';
</script>
<?php
	}
	else{
		?>
			<script type="text/javascript">
var thankyou_url	=	'<?php echo get_permalink(get_the_ID());?>?thankyou=true';
</script>
		<?php
	}
if(get_post_meta($post->ID,'hangout_live_timer',true)){
	
		//return '';
	//}
}



	
$hangout_registration_system = get_post_meta($post->ID,'hangout_replan_registration_system',true);
	
$form ='';
$hangout_lock_replay = get_post_meta($post->ID,'hangout_lock_replay',true);

if($hangout_lock_replay==1){
	if($hangout_registration_system=='Default'){
	
	$form	.=	'<div class="row-fluid ff-hh">
			<div class="ho_contentin">
				<div class="ho_registation">
					<form id="g_hangout_reg_form1" method="post" name="hangout_reg_form">
						<div class="ho_block"><h2>Register Now</h2></div>
						<div class="span4">
							<div class="ho_block">
								<input class="span12" id="event_reg_name" name="event_reg_name" type="text" placeholder="Enter Your Full Name" />
							</div>
						</div>
						<div class="span4">
							<div class="ho_block">
								<input class="span12" id="event_reg_email" name="event_reg_email" type="text" placeholder="Enter Your Email" />
								<div class="hide_show">
									<input class="span12" name="event_reg_email_add" id="event_reg_email_add" type="text" placeholder="Add Additional Email" />
								</div>								
								<a href="javascript:void(0);" class="btn_ss">Add Additional Email</a>
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
		<div class="clear"></div>';
	
	
	
	} else {
		
		
			$aweber_name	=	get_post_meta($post->ID,'hangout_replan_amber_name_field',true);
			$aweber_email	=	get_post_meta($post->ID,'hangout_replan_amber_name_email',true);
		
		$form .= '<div id="Aweber_hangout_form">';
		$form .= get_post_meta($post->ID,'hangout_replan_amber_from',true);
		$form .='<input type="hidden" id="g_hangout_id" value="'.$post->ID.'" ><input type="hidden" id="hangout_name_field" value="'.$aweber_name.'"><input type="hidden" id="hangout_email_field" value="'.$aweber_email.'">';
		$form .= '</div>';

	}

}



	$content1 .=  $form;
	
	
	return $content1;


?>
