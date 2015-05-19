<?php 
error_reporting(0);
if(isset($_POST['total_questions']))
{
	
	$hangout_id          = $_POST['hangout_id'];
	
	$total_questions       = (int)$_POST['total_questions'];
	
	$questions				=	array();
	$vote_correct_option	=	array();
	$vote_hidden_options	=	array();
	
	$vote_hidden_options_val 	= $_POST['vote_hidden_options'];
	$vote_hidden_optionsA		=	explode('@@',$vote_hidden_options_val	);
	
	$counter	=	0;
	for($i=110;$i<=$total_questions;$i++){
		if(isset($_POST['vote_question'.$i])){
			$questions[$i]	=	$_POST['vote_question'.$i];
			$vote_correct_option[$i]	=	$_POST['vote_option'.$i];
			$vote_hidden_options[$i] =$vote_hidden_optionsA[$counter];
			$counter++;
		}
		
	}
	
	update_post_meta($hangout_id,"total_questions",$total_questions);
	update_post_meta($hangout_id,"vote_question", json_encode($questions));
	update_post_meta($hangout_id,"vote_correct_option", json_encode($vote_correct_option));
	update_post_meta($hangout_id,"vote_options", json_encode($vote_hidden_options));
	update_post_meta($hangout_id,"vote_show_on_live", $_POST["vote_show_on_live"]);
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$post_id&sel=8");
}
if(isset($_REQUEST['add_pop_up_submit'])){

/* video code updation starts here */
$post_id=$_POST['hangout_id'];

	$optin_hrs=$_POST["hangout_aweber_display_hr"];
	$optin_mins=$_POST["hangout_aweber_display_min"];
	$optin_secs=$_POST["hangout_aweber_display_sec"];
	$i=0;
	foreach($optin_hrs as $optin_hr){
	$ad[] = $optin_hr.'_'.$optin_mins[$i].'_'.$optin_secs[$i];
	$i++;
	}
	$optinh_hrs=$_POST["hangout_aweber_hide_hr"];
	$optinh_mins=$_POST["hangout_aweber_hide_min"];
	$optinh_secs=$_POST["hangout_aweber_hide_sec"];
	$hideoptin=0;
	foreach($optin_hrs as $optinh_hr){
	$ah[] = $optinh_hr.'_'.$optinh_mins[$hideoptin].'_'.$optinh_secs[$hideoptin];
	$hideoptin++;
	}
	
	
	$buy_hrs=$_POST["hangout_buybutton_display_hr"];
	$buy_mins=$_POST["hangout_buybutton_display_min"];
	$buy_secs=$_POST["hangout_buybutton_display_sec"];
	$i=0;
	foreach($buy_hrs as $buy_hr){
	$bd[] = $buy_hr.'_'.$buy_mins[$i].'_'.$buy_secs[$i];
	$i++;
	}
	$buyh_hrs=$_POST["hangout_buybutton_hide_hr"];
	$buyh_mins=$_POST["hangout_buybutton_hide_min"];
	$buyh_secs=$_POST["hangout_buybutton_hide_sec"];
	$hide=0;
	foreach($buy_hrs as $buyh_hr){
	$bh[] = $buyh_hr.'_'.$buyh_mins[$hide].'_'.$buyh_secs[$hide];
	$hide++;
	}
	
	
	$vote_hrs=$_POST["hangout_vote_display_hr"];
	$vote_mins=$_POST["hangout_vote_display_min"];
	$vote_secs=$_POST["hangout_vote_display_sec"];
	$i=0;
	foreach($vote_hrs as $vote_hr){
	$vd[] = $vote_hr.'_'.$vote_mins[$i].'_'.$vote_secs[$i];
	$i++;
	}
	$voteh_hrs=$_POST["hangout_vote_hide_hr"];
	$voteh_mins=$_POST["hangout_vote_hide_min"];
	$voteh_secs=$_POST["hangout_vote_hide_sec"];
	$hidevote=0;
	foreach($voteh_hrs as $voteh_hr){
	$vh[] = $voteh_hr.'_'.$voteh_mins[$hidevote].'_'.$voteh_secs[$hidevote];
	$hidevote++;
	}

	
	update_post_meta($post_id,"hangout_aweber_display", serialize($ad));
	update_post_meta($post_id,"hangout_aweber_hide", serialize($ah));
	update_post_meta($post_id,"hangout_buybutton_display", serialize($bd));
	update_post_meta($post_id,"hangout_buybutton_hide", serialize($bh));
	update_post_meta($post_id,"hangout_vote_display", serialize($vd));
	update_post_meta($post_id,"hangout_vote_hide", serialize($vh));
	$buy_button=$_POST["buybuttonhtml"];
	update_post_meta($post_id,"buybuttonhtml", serialize($buy_button));
	
	
	update_post_meta($post_id,"show_by_button", $_POST["show_by_button"]);
	update_post_meta($post_id,"show_vote_form", $_POST["show_vote_form"]);
	update_post_meta($post_id,"show_optin_form", $_POST["show_optin_form"]);
	
	update_post_meta($post_id,"buybuttonshow_on_live", $_POST["buybuttonshow_on_live"]);
	/* video code updation ends here */

}

if(isset($_GET['sel']) && $_GET['sel'] == 8)
{
?>
<div id="message" class="updated below-h2"><p>Vote Setting Successfully. </p></div>
<?php
}
?>
<?php
$total_questions       = get_post_meta($_REQUEST['EID'],"total_questions", true);
if($total_questions=='')
	$total_questions	=	110;


$vote_question       = json_decode(get_post_meta($_REQUEST['EID'],"vote_question", true));


if(empty($vote_question))
	$vote_question->$total_questions	=	'';
$vote_options        = json_decode(get_post_meta($_REQUEST['EID'],"vote_options", true));
if(empty($vote_options))
	$vote_options->$total_questions	=	'';
$vote_correct_option = json_decode(get_post_meta($_REQUEST['EID'],"vote_correct_option", true));
if(empty($vote_correct_option))
	$vote_correct_option->$total_questions	=	'';
/* video player setting starts here */
 $post_id=$_REQUEST['EID'];

	$optin_display_time    = get_post_meta($post_id,'hangout_aweber_display',true);
	$optin_hide_time       = get_post_meta($post_id,'hangout_aweber_hide',true);
	$buybutton_display_time = get_post_meta($post_id,'hangout_buybutton_display',true);
	$buybutton_hide_time    = get_post_meta($post_id,'hangout_buybutton_hide',true);
	$vote_display_time      = get_post_meta($post_id,'hangout_vote_display',true);
	$vote_hide_time         = get_post_meta($post_id,'hangout_vote_hide',true);
	
	$buybuttonhtml          = unserialize(get_post_meta($post_id,'buybuttonhtml',true));
	 $show_by_button          = get_post_meta($post_id,'show_by_button',true);
	 $show_vote_form          = get_post_meta($post_id,'show_vote_form',true);
	 $show_optin_form          = get_post_meta($post_id,'show_optin_form',true);
	 if(get_post_meta($post_id,'vote_show_on_live',true)==""){
		$vote_show_on_live=0;
	 }else{
	 $vote_show_on_live          = get_post_meta($post_id,'vote_show_on_live',true);
	 }
	  $buybuttonshow_on_live = get_post_meta($post_id,'buybuttonshow_on_live',true);
	 if($buybuttonshow_on_live==""){
		$buybuttonshow_on_live=0;
	 }
	
	/* video player setting ends here */
?>
<form method="post" id="hangout_vote" name="add_hangout" action="">
	<input type="hidden" name="hangout_id" value="<?php echo $_REQUEST['EID'];?>" />
	<div class="gh_tabs_div_inner">
		<div id="myMenu110" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Add Vote Question </div>
		<div id="myDiv110" class="gh_accordian_div">
			<div class="myDiv110">
		<?php 	
		$show_live=0;
		for($i=110;$i<=$total_questions;$i++){ 
						if(!isset($vote_question->{$i}))
							continue;
		?>
			<div class="row-fluid-outer remove_<?php echo $i; ?>">
				<div class="row-fluid">
					<div class="span4">
						<strong>Vote Question </strong>
					</div>
					<div class="span8">
						<input type="text" name="vote_question<?php echo $i; ?>" id="vote_question<?php echo $i; ?>" option_number="<?php echo $i; ?>" class="vote_question" value="<?php echo $vote_question->{$i};?>"/>
					</div>
				</div>
			</div>
			<div class="row-fluid-outer remove_<?php echo $i; ?>">
				<div class="row-fluid">
					<div class="span4">
						<strong>Vote Options </strong>
					</div>
					<div class="span8" id="vote_option_output<?php echo $i; ?>">
					<?php
					$options = explode('__', $vote_options->{$i});
					foreach($options as $option)
					{
						if($option == $vote_correct_option->{$i})
						{
							$selected = ' checked';
						}
						else
						{
							$selected = '';
						}
						if($option!=""){
					?>
						<div class="span8 optioncontainer">
							<input type="radio" name="vote_option<?php echo $i; ?>" class="vote_options<?php echo $i; ?>" <?php echo $selected;?> value="<?php echo $option;?>"> &nbsp;<?php echo $option;?> &nbsp;&nbsp;
							<a href="javascript:void(0);" style="float:right;" class="deletetoption" rel="<?php echo $option;?>">Delete</a>
						</div>
						<?php
						}
					}
					?>
					</div>
					<div class="span8 parent_option" style="float:right;">
						<input type="text" placeholder="Set Option" name="vote_title_dummy" option_number="<?php echo $i; ?>" class="vote_title_dummy"/> <br />
						<input type="button" name="vote_add_more" class="vote_add_more hangout_btn" value="Add"/>
						<input type="button" name="vote_remove_vote" option_number="<?php  echo $i; ?>" class="vote_remove_vote hangout_btn" value="Remove"/>
					</div>
				</div>
			</div>
			<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Vote Question show on live video</strong>
		                        </div>
		                      
								<div class="span8">
									<input type="radio" name="vote_show_on_live" value=<?php  echo $show_live; ?>
									<?php if($vote_show_on_live==$show_live){echo "checked=checked"; }?>  >Yes
												                        	
								</div>
		                    </div>
		                </div>
			<?php 
			$show_live++;
			} ?>
			<input type="hidden" name="total_questions" id="total_questions" value="<?php echo $total_questions; ?>" />
			<?php 
			$vote_hidden_options_edit	=	'';
			foreach($vote_options as $key=>$val){
				if($vote_hidden_options_edit=='')
					$vote_hidden_options_edit	=	$val;
				else	
					$vote_hidden_options_edit.='@@'.$val;
			}
			?>
		</div>	
			<input type="hidden" name="vote_hidden_options" id="vote_hidden_options" value="<?php echo $vote_hidden_options_edit;?>"/>
			<button type="button" class="hangout_btn" id="add_more_vote_question">Add More</button>
			<input type="button" name="add_vote_submit" class="hangout_btn" id="add_vote_submit" value="Submit"/>
			
		
		</div>
		
		
		</form>
		<form method="post" id="hangout_pop_up" name="add_hangout_pop_up" action="">
		<input type="hidden" name="hangout_id" value="<?php echo $_REQUEST['EID'];?>" />
		<div id="myMenu210" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Pop Up Setting </div>
		<div id="myDiv210" class="gh_accordian_div">
		<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Optin Form</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_optin_form" id="show_optin_form_yes" value="1" <?php if($show_optin_form==1 || $show_optin_form==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="show_optin_form" id="show_optin_form_no" value="0" <?php if($show_optin_form==0){ echo 'checked="checked"'; } ?>/> No
                                </div>
                            </div>
                        </div>
						<div id="optin_form"<?php if($show_optin_form==0 || $show_optin_form==''){ echo 'style="display:none"'; } ?>>
							<?php 
						$optin_display_times= unserialize($optin_display_time);
						if(empty($optin_display_times)){
						?>
						<div class="optin_area" id="optin_area" >
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Optin Form Display</strong>
		                        </div>
		                        <div class="span8">

		                        	<select name="hangout_aweber_display_hr[]" id="hangout_aweber_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_aweber_display_min[]" id="hangout_aweber_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_aweber_display_sec[]" id="hangout_aweber_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Optin Form Hide</strong>
		                        </div>
		                        <div class="span8">
		                        	
		                        	<select name="hangout_aweber_hide_hr[]" id="hangout_aweber_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_aweber_hide_min[]" id="hangout_aweber_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_aweber_hide_sec[]" id="hangout_aweber_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<input type="button" value="Remove" id="removeoptin" class="hangout_btn">
						</div>
						
						<?php 
						}else{ 
						$optin_display_times= unserialize($optin_display_time);
						$optin_hide_times=unserialize($optin_hide_time);
						
						$j=0;
						foreach($optin_display_times as $optn_display){
						?>
						<div class="optin_area" id="optin_area" >
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Optin Form Display</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_aweber_display_time = explode('_', $optn_display);
		                        	
		                        	$aweber_display_time_hr   = $temp_aweber_display_time[0];
		                        	$aweber_display_time_min  = $temp_aweber_display_time[1];
		                        	$aweber_display_time_sec  = $temp_aweber_display_time[2];
		                        	?>
		                        	<select name="hangout_aweber_display_hr[]" id="hangout_aweber_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_display_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_aweber_display_min[]" id="hangout_aweber_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_display_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_aweber_display_sec[]" id="hangout_aweber_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_display_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Optin Form Hide</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_aweber_hide_time = explode('_', $optin_hide_times[$j]);
		                        	
		                        	$aweber_hide_time_hr   = $temp_aweber_hide_time[0];
		                        	$aweber_hide_time_min  = $temp_aweber_hide_time[1];
		                        	$aweber_hide_time_sec  = $temp_aweber_hide_time[2];
		                        	?>
		                        	<select name="hangout_aweber_hide_hr[]" id="hangout_aweber_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_hide_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_aweber_hide_min[]" id="hangout_aweber_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_hide_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_aweber_hide_sec[]" id="hangout_aweber_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $aweber_hide_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<input type="button" value="Remove" id="removeoptin">
						</div>
						
						<?php
							$j++;
						} 
						}
						?>
						<div class ="optin_time_clone" id="optin_time_clone"></div>
						<input class="hangout_btn" value="Add More Optin Time" type="button" id="add_optin_time" />
						
						</div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Buy Button</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_by_button" id="show_by_button_yes" value="1" <?php if($show_by_button==1 || $show_by_button==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="show_by_button" id="show_by_button_no" value="0" <?php if($show_by_button==0){ echo 'checked="checked"'; } ?>/> No
                                </div>
                            </div>
                        </div>
						<div id="by_button"<?php if($show_by_button==0 || $show_by_button==''){ echo 'style="display:none"'; } ?>>
						
						<?php 
						$buybutton_display_times= unserialize($buybutton_display_time);
						if(empty($buybutton_display_times)){
						?>
						<div class="buy_button_area" id="buy_button_area">
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Display</strong>
		                        </div>
		                        <div class="span8">
		                        
		                        	<select name="hangout_buybutton_display_hr[]" id="hangout_buybutton_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_buybutton_display_min[]" id="hangout_buybutton_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_buybutton_display_sec[]" id="hangout_buybutton_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Hide</strong>
		                        </div>
		                        <div class="span8">
		                        
		                        	<select name="hangout_buybutton_hide_hr[]" id="hangout_buybutton_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_buybutton_hide_min[]" id="hangout_buybutton_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_buybutton_hide_sec[]" id="hangout_buybutton_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Html</strong>
		                        </div>
		                        <div class="span8">
								<?php
									$args=array("textarea_name" => "buybuttonhtml[]");
									$content = '';
									$editor_id = 'buybuttonhtml';

									wp_editor( $content, $editor_id,$args );

									?>		                        	
		                        </div>
		                    </div>
		                </div>
<input type="button" value="Remove" class="hangout_btn" id="removeadd">
						</div>
						
						<?php 
						}else{ 
						$buybutton_display_times= unserialize($buybutton_display_time);
						$buybutton_hide_times=unserialize($buybutton_hide_time);
						
						$j=0;
						foreach($buybutton_display_times as $buybutton_display){
						?>
						<div class="buy_button_area" id="buy_button_area">
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Display</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_buybutton_display_time = explode('_', $buybutton_display);
		                        	
		                        	$buybutton_display_time_hr   = $temp_buybutton_display_time[0];
		                        	$buybutton_display_time_min  = $temp_buybutton_display_time[1];
		                        	$buybutton_display_time_sec  = $temp_buybutton_display_time[2];
		                        	?>
		                        	<select name="hangout_buybutton_display_hr[]" id="hangout_buybutton_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_display_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_buybutton_display_min[]" id="hangout_buybutton_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_display_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_buybutton_display_sec[]" id="hangout_buybutton_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_display_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Hide</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_buybutton_hide_time = explode('_', $buybutton_hide_times[$j]);
		                        	
		                        	$buybutton_hide_time_hr   = $temp_buybutton_hide_time[0];
		                        	$buybutton_hide_time_min  = $temp_buybutton_hide_time[1];
		                        	$buybutton_hide_time_sec  = $temp_buybutton_hide_time[2];
		                        	?>
		                        	<select name="hangout_buybutton_hide_hr[]" id="hangout_buybutton_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_hide_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_buybutton_hide_min[]" id="hangout_buybutton_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_hide_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_buybutton_hide_sec[]" id="hangout_buybutton_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $buybutton_hide_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button Html</strong>
		                        </div>
		                        <div class="span8">
								<?php
									$args=array("textarea_name" => "buybuttonhtml[]");
									$content = $buybuttonhtml[$j];
									$editor_id = 'buybuttonhtml'.$j;

									wp_editor( $content, $editor_id,$args );

									?>		                        	
		                        </div>
		                    </div>
		                </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Buy Button show on live video</strong>
		                        </div>
		                      
								<div class="span8">
									<input type="radio" name="buybuttonshow_on_live" value=<?php  echo $j; ?>
									<?php if($buybuttonshow_on_live==$j){echo "checked=checked"; }?>  >Yes
												                        	
								</div>

		                    </div>

		                </div>
						<input type="button" value="Remove" class="hangout_btn" id="removeadd">
						</div>
						<?php 
						$j++;
						}
							}	?>
														
						<div class ="buy_time_clone" id="buy_time_clone"></div>
						<input value="Add More Button Time" class="hangout_btn" type="button" id="add_button_time" />
						
						</div>
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Show Vote Form</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="show_vote_form" id="show_vote_form_yes" value="1" <?php if($show_vote_form==1 || $show_vote_form==''){ echo 'checked="checked"'; } ?>/> Yes &nbsp;&nbsp; <input type="radio" name="show_vote_form" id="show_vote_form_no" value="0" <?php if($show_vote_form==0){ echo 'checked="checked"'; } ?>/> No
                                </div>
                            </div>
                        </div>
						<div id="vote_form" <?php if($show_vote_form==0 || $show_vote_form==''){ echo 'style="display:none"'; } ?>>
						<?php 
						$vote_display_times= unserialize($vote_display_time);
						if(empty($vote_display_times)){
						?>
						<div class="vote_area" id="vote_area" >
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Vote Form Display</strong>
		                        </div>
		                        <div class="span8">
		                        	
		                        	<select name="hangout_vote_display_hr[]" id="hangout_vote_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_vote_display_min[]" id="hangout_vote_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_vote_display_sec[]" id="hangout_vote_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Vote Form Hide</strong>
		                        </div>
		                        <div class="span8">
		                        	
		                        	<select name="hangout_vote_hide_hr[]" id="hangout_vote_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_vote_hide_min[]" id="hangout_vote_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_vote_hide_sec[]" id="hangout_vote_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" ><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<input type="button" value="Remove" id="removevote" class="hangout_btn">
						</div>
						
						<?php }else{
						$vote_display_times= unserialize($vote_display_time);
						$vote_hide_times=unserialize($vote_hide_time);
						
						$j=0;
						
						foreach($vote_display_times as $vote_display){
						?>
						<div class="vote_area" id="vote_area" >
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Vote Form Display</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_vote_display_time = explode('_', $vote_display);
		                        	
		                        	$vote_display_time_hr   = $temp_vote_display_time[0];
		                        	$vote_display_time_min  = $temp_vote_display_time[1];
		                        	$vote_display_time_sec  = $temp_vote_display_time[2];
		                        	?>
		                        	<select name="hangout_vote_display_hr[]" id="hangout_vote_display_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_display_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_vote_display_min[]" id="hangout_vote_display_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_display_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_vote_display_sec[]" id="hangout_vote_display_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_display_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<div class="row-fluid-outer">
		                    <div class="row-fluid">
								<div class="span4">
									<strong>Vote Form Hide</strong>
		                        </div>
		                        <div class="span8">
		                        	<?php
		                        	$temp_vote_hide_time = explode('_', $vote_hide_times[$j]);
		                        	
		                        	$vote_hide_time_hr   = $temp_vote_hide_time[0];
		                        	$vote_hide_time_min  = $temp_vote_hide_time[1];
		                        	$vote_hide_time_sec  = $temp_vote_hide_time[2];
		                        	?>
		                        	<select name="hangout_vote_hide_hr[]" id="hangout_vote_hide_hr">
		                        	<?php
		                        	for($i=0;$i<=12;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_hide_time_hr == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Hour(s)
		                        	
		                        	<select name="hangout_vote_hide_min[]" id="hangout_vote_hide_min">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_hide_time_min == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Minute(s)
		                        	
		                        	<select name="hangout_vote_hide_sec[]" id="hangout_vote_hide_sec">
		                        	<?php
		                        	for($i=0;$i<=60;$i++)
		                        	{
		                        	?>
		                        	<option value="<?php echo $i;?>" <?php echo $vote_hide_time_sec == $i ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
		                        	<?php
		                        	}
		                        	?>
		                        	</select>&nbsp;Second(s)
		                        </div>
		                    </div>
                        </div>
						<input type="button" value="Remove" id="removevote" class="hangout_btn">
						</div>
						
						<?php 
						$j++;
						}
							}	?>
						
						<div class ="vote_time_clone" id="vote_time_clone"></div>
						<input value="Add More Vote Time"  type="button" id="add_vote_time" class="hangout_btn" />
						</div>
						<input type="submit" name="add_pop_up_submit" class="hangout_btn" id="add_pop_up_submit" value="Save Settings"/>
		
		</div>
	
</form>


	<div id="myMenu0" class="gh_accordian_tab"><i class="icon-plus-sign"></i> View Vote Stats </div>
	
	<div id="myDiv0" class="gh_accordian_div">
		
	<?php 
		for($i=110;$i<=$total_questions;$i++){
			if(!isset($vote_question->{$i}))
				continue;
				
			$sql     = 'SELECT * FROM hangout_vote WHERE hangout_id = "'.$hangout.'" and option_number="'.$i.'"';
			$results = $wpdb->get_results($sql);
		

		?>
		<?php echo "Question : <strong>".$vote_question->{$i}."</strong>";?><br />
		<?php
			$options = explode('__', $vote_options->{$i});
			$count = 1;
			foreach($options as $option)
			{
				$sql     = 'SELECT count(*) FROM hangout_vote WHERE hangout_id = "'.$_REQUEST['EID'].'" AND answer = "'.$option.'" and option_number= "'.$i.'" ';
				$results = $wpdb->get_var($sql);
				if($option!=""){
				?>
				<?php echo $count.") <strong>".$option."</strong>";?> -- <?php echo $results;?> Vote(s)<br />
				<?php
				$count++;
				}
			}
		}	
		?>
	</div>
</div>

<script type="text/javascript">
function storeHiddenOptions()
{
	
	var opt	=	'';
	jQuery('.vote_question').each(function(){
		var option_number	=	jQuery(this).attr('option_number');
		
		var opt1 = '';
		
		jQuery('.vote_options'+option_number).each(function(){
				var optval = jQuery(this).attr('value');
				if(opt1=='')
					opt1 = optval;
				else
					opt1 +='__'+optval;
		});
		
		if(opt=='')
			opt 	= opt1;
		else	
			opt	+='@@'+opt1;	
	});
	
	jQuery('#vote_hidden_options').val(opt);
}

jQuery(document).ready(function(){

	/* 
		* bhuvnesh 
		* 8 nov
	*/

	jQuery('#add_more_vote_question').click(function(){
		var total_questions	=	parseInt(jQuery('#total_questions').val());
		total_questions	=	total_questions+1;
		jQuery('#total_questions').val(total_questions);
		
			 var html ='<div class="row-fluid-outer remove_'+total_questions+'">';
				html+='<div class="row-fluid">';
					html+='<div class="span4">';
						html+='<strong>Vote Question </strong>';
					html+='</div>';
					html+='<div class="span8">';
						html+='<input type="text" value="" id="vote_question'+total_questions+'" option_number="'+total_questions+'" class="vote_question" name="vote_question'+total_questions+'">';
					html+='</div>';
				html+='</div>';
			html+='</div>';
			html+='<div class="row-fluid-outer remove_'+total_questions+'">';
				html+='<div class="row-fluid">';
					html+='<div class="span4">';
						html+='<strong>Vote Options </strong>';
					html+='</div>';
					html+='<div id="vote_option_output'+total_questions+'" class="span8">';
										html+='</div>';
					html+='<div style="float:right;" class="span8 parent_option">';
						html+='<input type="text" class="vote_title_dummy" name="vote_title_dummy" option_number="'+total_questions+'" placeholder="Set Option"> <br>';
						html+='<input type="button" value="Add" class="vote_add_more hangout_btn" name="vote_add_more">';
						html+='<input type="button" name="vote_remove_vote" option_number="'+total_questions+'" class="vote_remove_vote hangout_btn" value="Remove"/>';
					html+='</div>';
				html+='</div>';
			html+='</div>';
		
		jQuery('.myDiv110').append(html);
		
	});
	
	jQuery('.vote_remove_vote').live('click',function(){
		var vote_qlength = jQuery('.vote_question').length;
		if(vote_qlength>1){
			var option_number	=	jQuery(this).attr('option_number');
			jQuery('.remove_'+option_number).remove();
			storeHiddenOptions();
		}
	});
	
	jQuery(".vote_add_more").live('click',function(){		
		
		var optiontitle   = jQuery(this).parents('.parent_option').find('.vote_title_dummy').val();
		var option_number   = jQuery(this).parents('.parent_option').find('.vote_title_dummy').attr('option_number');
		
		if(optiontitle == '')
		{
			alert('Fill Option Title.');
			return false;
		}
		
		// add option
		var generateradio = '<div class="span8 optioncontainer"><input type="radio" name="vote_option'+option_number+'" class="vote_options'+option_number+'" value="'+optiontitle+'"> &nbsp;'+optiontitle+' &nbsp;&nbsp;<a href="javascript:void(0);" style="float:right;" class="deletetoption" rel="'+optiontitle+'">Delete</a></div>';		
		jQuery('#vote_option_output'+option_number).append(generateradio);
		
		jQuery('.vote_title_dummy').val('');
		jQuery('.vote_option_value_dummy').val('');
		
		storeHiddenOptions();
	});
	
	jQuery('.deletetoption').live('click', function(){
		var currentclick = jQuery(this);
		var rel = jQuery(this).attr('rel');
		
		jQuery(currentclick).parent('.optioncontainer').remove();
		
		storeHiddenOptions();
	});
	
	jQuery('#add_vote_submit').live('click', function(){
		
		/* bhuvnesh */
		var flag=1;
		jQuery('.vote_question').each(function(){
		
			var option_number	=	jQuery(this).attr('option_number');
			if(jQuery(this).val()=='')
			{
				alert('Please Add Question');
				flag	=	0;
				return false;
			}
			
			var vote_options = jQuery('.vote_options'+option_number).length;
			if(vote_options == 0)
			{
				alert('Please Add Options');
				flag	=	0;
				return false;
			}
			
			var selec = 0;
			 jQuery('.vote_options'+option_number).each(function(){
				if(jQuery(this).attr('checked'))
				{
					selec = 1;
				}
			});
			
			if(selec == 0)
			{
				alert('Please Select Any Of The Option for Questions');
				flag	=	0;	
				return false;
			}
			
		});
		
		if(flag==0)
			return false;
		else	
			jQuery('#hangout_vote').submit();
	});
jQuery("input#add_button_time").click(function (e) {
jQuery("#buy_button_area").clone().appendTo("#buy_time_clone"); 
}); 
jQuery('body').on('click','#removeadd',function()
{ 
	var div_length = jQuery('.buy_button_area').length;
	if(div_length>1)
		jQuery(this).parent('div').remove(); 
}); 

jQuery("input#add_optin_time").click(function (e) {
jQuery("#optin_area").clone().appendTo("#optin_time_clone"); 
}); 
jQuery('body').on('click','#removeoptin',function()
{ 
var div_length = jQuery('.optin_area').length;
if(div_length>1)
	jQuery(this).parent('div').remove(); 
}); 	
jQuery("input#add_vote_time").click(function (e) {
	/* 
		* bhuvnesh 
		* check whether vote questions are equal or not
	*/
	var vote_qlength = jQuery('.vote_question').length;
	var vote_tlength = jQuery('.vote_area').length;
	if(vote_tlength<vote_qlength)
		jQuery("#vote_area").clone().appendTo("#vote_time_clone"); 
	else	
		alert('Add Vote Question First.');
}); 
jQuery('body').on('click','#removevote',function()
{ 
	var div_length = jQuery('.vote_area').length;
	if(div_length>1){
		var vote_qlength = jQuery('.vote_question').length;
		var vote_tlength = jQuery('.vote_area').length;
		if(vote_tlength>vote_qlength)
			jQuery(this).parent('div').remove(); 
		else	
			alert('Remove Vote Question First.');
	}	
}); 	
	
	
});
</script>
