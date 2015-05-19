<div id="hangout_main">
<?php $plugins_url = plugin_dir_url(__FILE__);
									//$xml=simplexml_load_file($plugins_url ."/layout.xml");
									
										$ch = curl_init();
										$timeout = 10;
										curl_setopt($ch,CURLOPT_URL,$plugins_url ."/layout.xml");
										curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
										curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
										$d = curl_exec($ch);
										if(empty($d)){
											 if(ini_get('allow_url_fopen')){
												$d = file_get_contents($plugins_url ."/layout.xml");
												}else{
												$fopen_error_msg= "Please contact your web hoster and ask them to enable allow_url_fopen";
												if(isset($fopen_error_msg)){ ?>
													<div class="updated" style="min-height: 44px !important; padding-top: 5px !important;"><p><?php echo $fopen_error_msg;?></p></div>
													<?php }
												}
										}
										curl_close($ch);
										$xml = new SimpleXMLElement($d);
										$element_count = count($xml);
								
								
								?>
<div id='updatemsg'></div>

    <!-- Start Header -->
    <div class="gh_header">
		<div class="row-fluid">
			<div class="span6">
     			<div class="block_left">
                	RunClick <span>Webinar and Video-conferencing Software</span><br>
                    <span class="hangout_version">
                    	{ Version <?php echo get_option('umo_hangout_version',true);?> }
                    </span>
                </div>
    		</div>
			
    		<div class="span6">
            	<div class="block_right">
				<?php if($element_count!=1){ ?>
					<!--<button class="template_check_update hangout_btn" type="button">Check Template Update</button>-->
					<?php } ?>
					<button class="hangout_check_update hangout_btn" type="button">Check Plugin Update</button>
					<br>
					<br>
     				<img src="<?php echo plugin_dir_url(__FILE__);?>images/activated.png" alt="" align="top" /> Activated <br><br>
					 <a style="width:200px;" target="blank" href="http://runclick.com/tutorials.html">
					<img width="197" height="61" src="<?php echo plugin_dir_url(__FILE__);?>img/training.jpg" alt="training">
					</a><br><br>
					Chat <?php if(get_option("hangout_chat_settings",true) == "1"){ ?> <img src="<?php echo plugin_dir_url(__FILE__);?>images/activated.png" alt="" align="top" />
					<?php }else{?>
					<img src="<?php echo plugin_dir_url(__FILE__);?>images/deactivated.png" alt="" align="top" />
					<?php } ?>
                </div>
    		</div>
    	</div>
    </div>
    <!-- End Header -->

    <div class="hangout_activated">

    <!-- Start Container -->
    <div class="gh_container">
		<div class="row-fluid">
			<div class="span12">
                
                <!-- Start Hangouts Panel -->
                <div id="hangouts_panel" class="gh_tabs_div">
                
                	<div class="gh_container_header include_tabs">
                    	<div class="row-fluid">
                        <div class="span6">
                           <strong>Webinars</strong>
                        	
                        </div>
                        <div class="span6">
                            	<div class="block_right">
                        		<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout" class="hangout_btn"><i class="icon-reply-all"></i> Dashboard</a>
                                </div>
                        </div>
                        </div>
                        
                    </div>
					<script src="<?php echo plugin_dir_url(__FILE__);?>/js/modernizr.custom.js"></script>

	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Karla:400,700">
	<!--<link rel="stylesheet" href="<?php //echo plugin_dir_url(__FILE__);?>/css/screen.css" media="screen"/>-->
	<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__);?>/css/lightbox.css" media="screen"/>
	
	<script src="<?php echo plugin_dir_url(__FILE__);?>/js/lightbox-2.6.min.js"></script>
                     <script type="text/javascript">
						                     
								jQuery('.hangout_status').live('click',function(){
									var curr_status	=	jQuery(this).val();
								
									var g_hangout = {"ajaxurl": "<?php echo site_url(); ?>\/wp-admin\/admin-ajax.php","plugin_url":"<?php echo site_url(); ?>\/wp-content\/plugins\/RunClickPlugin","tr_no_one_online":"No one is online","tr_logout":"Logout","tr_sending":"Sending","tr_in_chat_header":"Now Chatting","tr_offline_header":"Contact us","use_css_anim":"1","delay":"2","is_admin":"","is_op":"1"};
								

										data= {
											action: 'ghangout_webinar_status',
											status: curr_status,
											ID:	'<?php echo $_REQUEST["EID"] ?>'
										};
										jQuery.post(g_hangout.ajaxurl, data, function(response) {
											response	=	jQuery.trim(response);
											if(response == "ok")
											{
												alert('Status Updated Successfully!');
												return false;
											}
											else
											{
												alert('Status Not Updated,Please try again.');
												return false;
											}

										});
								});
							
							/*jQuery(document).ready(function(){
							jQuery( ".full_image" ).hover(function() {
											var path=jQuery( this ).attr('src');
											alert(path);
											});

										
										
									});*/
							
						</script>
                        <?php
                        		if(isset($_REQUEST['EID']))
                        		{
                        		?>
                        			<script type="text/javascript">
		                    		jQuery(document).ready(function(){
									
										var child	=	"<?php echo get_post_meta($_REQUEST['EID'],'current_hangout_status',true);?>";
										if(child == "")
										{
											child	= '1';
										}
										jQuery(".gh_btns_box label:nth-child("+child+")").addClass("r_on");
									});
									</script>
								<?php	
                        		}
                        ?>
                        <div class="row-fluid-outer1">
							 <div class="row-fluid">
							 	<!-- <div class="span4">
									<strong>Lorem ipsum dolor sit amet</strong>
		                            <div class="small_font">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
								</div> -->
								<div class="span8">
									<div class="gh_btns_box">
<?php if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {
								?>									
										<label class="label_radio hangout_btn "<?php if(get_post_meta($_REQUEST['EID'],'current_hangout_status',true) == '1' || get_post_meta($_REQUEST['EID'],'current_hangout_status',true) == ""){ echo "class='r_on'";}?> for="radio-01"><input name="sample-radio" id="radio-01" value="1" type="radio" class="hangout_status"><span>Countdown</span></label>
										
								        <label class="label_radio hangout_btn "<?php if(get_post_meta($_REQUEST['EID'],'current_hangout_status',true) == '2'){ echo "class='r_on'";}?> for="radio-02"><input name="sample-radio" id="radio-02" value="2" type="radio" class="hangout_status"><span>Live</span></label>
									
								        <label class="label_radio hangout_btn "<?php if(get_post_meta($_REQUEST['EID'],'current_hangout_status',true) == '3'){ echo "class='r_on'";}?> for="radio-03"><input name="sample-radio" id="radio-03" value="3" type="radio" class="hangout_status"><span>Replay</span></label>
								        <label class="label_radio hangout_btn "<?php if(get_post_meta($_REQUEST['EID'],'current_hangout_status',true) == '4'){ echo "class='r_on'";}?> for="radio-04"><input name="sample-radio" id="radio-04" value="4" type="radio" class="hangout_status"><span>Closed</span></label>
											<?php } ?>
									</div>
								</div>
							</div>
						
						</div>
						<?php if($_REQUEST['EID']!=''){ ?>
						<div class="row-fluid-outer3">
							<strong>Webinar Live URL  </strong><a href="<?php echo get_permalink($_REQUEST['EID']); ?>" target="_blank"><?php echo get_permalink($_REQUEST['EID']); ?> </a>
                            <div class="small_font"></div>

						</div>
						<?php } ?>
                    <ul class="hornav">
					
								
								<?php if($_GET['type']=='') { ?>
									<li id="hangouts_dashboard_7"><a href="#theme" >Theme</a></li>
								<?php } ?>

								
                				<li id="hangouts_dashboard_2"><a href="#events" >Event </a></li>
                				<li id="hangouts_dashboard_4"><a href="#thank_you">Thank You</a></li>
								<?php if(isset($_REQUEST['selected_type'])){
							$hangout_selected_type	=	$_REQUEST['selected_type'];
						}	
						else{
								$hangout_type	=  get_post_meta($_REQUEST['EID'],'hangout_type',true);
								
						}
						if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout')  && ($hangout_type=='New_hangout' || $hangout_type=='' )) {
								?>
                				<li id="hangouts_dashboard_3"><a href="#live" >Live </a></li>
								
                				<li id="hangouts_dashboard_5"><a href="#replay">Replay</a></li>
								<?php } ?>
                				<li id="hangouts_dashboard_1"><a href="#stats">Stats </a></li>
                				<li id="hangouts_dashboard_6"><a href="#subscriber" >Subscribers</a></li>
								<li id="hangouts_dashboard_8"><a href="#vote" >Vote And Pop up</a></li>
								<!--<li id="hangouts_dashboard_9"><a href="#user_level" >User Level</a></li>-->
								
            			</ul>
					
					<!-- Start Events Tab -->
                    <div id="events" class="gh_inner_tabs">
							<?php require_once('add_hangout.php'); ?>
                    </div>
                    <!-- End Events Tab -->
                    
                    <!-- End Thank You Tab -->
                    <div id="thank_you" class="gh_inner_tabs">
                    	<?php require_once('hangout_thankyou.php'); ?>
                    </div>
                    <!-- End Thank You Tab -->
                    
                    <!-- Start Live Tab -->
                    <div id="live" class="gh_inner_tabs">
                    		<?php require_once('hangout_make_it_live.php'); ?>
                    </div>
                    <!-- Start Live Tab -->
                    
                     <!-- Start Replay Tab -->
                    <div id="replay" class="gh_inner_tabs">
                    	
							<?php require_once('hangout_replay.php'); ?>
						
                    </div>
					<!-- End Replay Tab -->
					<!-- Start vote Tab -->
                    <div id="vote" class="gh_inner_tabs">                    	
						<?php require_once('hangout_vote.php'); ?>
                    </div>
					<!-- End vote Tab -->
					
					<!-- Start User Level Tab -->
                    <div id="user_level" class="gh_inner_tabs">                    	
						<?php //require_once('user_level.php'); ?>
                    </div>
					<!-- End vote Tab -->
					
                    <!-- Start Stats Tab -->
                    <div id="stats" class="gh_inner_tabs">
                    	<div class="gh_tabs_div_inner">
                        <?php global $wpdb; ?>
                        
                        <div class="row-fluid-outer2">
                        <div class="row-fluid">
							<?php
								
							if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {?>
                            <div class="span3">
							<?php }else{ ?>
                            <div class="span4">
							<?php } ?>
                            	<div class="gh_stats">
                            		<?php $event_hits	=	$wpdb->get_var("SELECT count(event) from ".$wpdb->prefix."ghangout_stats where event='1' and post_id='".$_REQUEST['EID']."'"); ?>
                            		<span><?php if($event_hits != ""){ echo $event_hits; }else{ echo "0";  }?></span>
								landing page
                                </div>
                            </div>
							<?php if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) { ?>
                            <div class="span3">
							<?php }else{ ?>
                            <div class="span4">
							<?php } ?>
                            	<div class="gh_stats">
                            		<?php $thanks_hits	=	$wpdb->get_var("SELECT count(thankyou) from ".$wpdb->prefix."ghangout_stats where thankyou='1' and post_id='".$_REQUEST['EID']."'"); ?>
                                	<span><?php if($thanks_hits != ""){ echo $thanks_hits; }else{ echo "0";  }?></span>
								thank you page
                                </div>
                            </div>
							<?php
								
							if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {?>
                            <div class="span3">
                            	<div class="gh_stats">
                            	<?php $live_hits	=	$wpdb->get_var("SELECT count(live) from ".$wpdb->prefix."ghangout_stats where live='1' and post_id='".$_REQUEST['EID']."'"); ?>
                                	<span><?php if($live_hits != ""){ echo $live_hits; }else{ echo "0";  }?></span>
								live webinar
                                </div>
                            </div>
							<?php } ?>
                           <?php
								
							if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout') && ($hangout_type=='New_hangout' || $hangout_type=='' )) {?>
                            <div class="span3">
							<?php }else{ ?>
                            <div class="span4">
							<?php } ?>
                            	<div class="gh_stats">
                            	<?php $replay_hits	=	$wpdb->get_var("SELECT count(replay) from ".$wpdb->prefix."ghangout_stats where replay='1' and post_id='".$_REQUEST['EID']."'"); ?>
                                	<span><?php if($replay_hits != ""){ echo $replay_hits; }else{ echo "0";  }?></span>
								webinars replay
                                </div>
                            </div>
                        </div>
						</div>
                       
						
                        
                        
						
                    	</div>
                    	<div class="actionBar">
                    		
                        	<!-- <button class="hangout_btn" type="submit"><i class="icon-save"></i> Save Settings</button> -->
                    	</div>
                    </div>
					<!-- End Stats Tab -->
                    
                    <!-- Start Subscriber Tab -->
                    <div id="subscriber" class="gh_inner_tabs">
                    	<div class="export_subscribers_div">
                    		<a class="hangout_btn ghangout" href="<?php echo admin_url();?>admin.php?page=google_hangout_broadcast&g_event_id=<?php echo $_REQUEST['EID'];?>"><i class="icon-save"></i> Broadcast Email</a>
                        	<a class="hangout_btn" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout_export&g_event_id=<?php echo $_REQUEST['EID'];?>"><i class="icon-share"></i> Click to Export All Subscribers</a>
                       	</div>
                    	<?php require_once('hangout_subscriber.php');?>
                    </div>
					<!-- End Subscriber Tab -->
					
					 <!-- Start Theme Tab -->
					 <?php
					 $hangout_id		=	$_REQUEST['EID'];
					 
					 if(isset($_POST['theme_next'])){
						//$post_id = $hangout_id;
						
						//update_post_meta( $hangout_id, 'google_hangout_theme', $_POST['ghangout_layout'] );
						wp_redirect(admin_url()."admin.php?page=manage_hangout&sel=2&selected_theme=".$_POST['ghangout_layout']."&selected_type=".$_POST['ghangout_type']." ");
					 }
					 if(isset($_POST['theme_submit'])){
						$post_id = $hangout_id;
						update_post_meta( $hangout_id, 'google_hangout_theme', $_POST['ghangout_layout'] );
						wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=".$post_id."&sel=7 ");
					 }
					 $google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
					 ?>
					 
					 <form name="theme_form" method="post" action="">
                    <div id="theme" class="gh_inner_tabs">
                    	<div class="export_theme_div">
						<?php if($google_hangout_theme =='' ){ ?>
							<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Webinar Type</strong> 
								</div>
								<div class="span8">
									
									<input type="radio" class="choose_replay_option" name="ghangout_type" value="New_hangout"   checked="checked" />&nbsp;New Webinar&nbsp;&nbsp;
								<input type="radio" class="choose_replay_option" name="ghangout_type" value="Record_hangout"  />&nbsp;Recorded Webinar
										
								</div>
							</div>
							</div>
							<?php } ?>
						
                    		<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Layout</strong> 
								</div>
								<div class="span8">
									
										<?php $layoutlist = get_layout_list();
											foreach($layoutlist as $layoutname){
													$value=str_replace(' ','_',$layoutname);	
												if($google_hangout_theme==$value )
													$selected	=	'checked';
												else	
													$selected	=	'';
												if($google_hangout_theme=="" && $value=="Default"){
												$selected = "checked";
												}
											?>
													<div style="float:left; margin: 10px;">
													<a class="example-image-link" href="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>.png" data-lightbox="example<?php echo $a;?>" title="Event Page">
													
													<img class="image-row" src="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>.png" height="150px;" width="150px;"  align="top" />
													
													</a>
													<a class="example-image-link" href="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_thanku.png" data-lightbox="example<?php echo $a;?>" style="display:none;" title="Thank You Page">
													<img class="image-row" src="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_thanku.png" height="150px;" width="150px;"  align="top" />
													
													</a>
													<a class="example-image-link" href="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_live.png" data-lightbox="example<?php echo $a;?>" style="display:none;" title="Live Page">
													<img class="image-row" src="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_live.png" height="150px;" width="150px;"  align="top" />
													</a>
													<a class="example-image-link" href="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_replay.png" data-lightbox="example<?php echo $a;?>" style="display:none;" title="Replay Page">
													
													<img class="image-row" src="<?php echo plugin_dir_url(__FILE__);?>themes/<?php echo $layoutname; ?>/img/<?php echo $value; ?>_replay.png" height="150px;" width="150px;"  align="top" />
													
													</a>
													
													</a>
													<br><br>
												<input type="radio" name="ghangout_layout" id="ghangout_layout" <?php echo $selected;  ?> value="<?php echo $value; ?>" <?php if($ghangout_layout==$layoutname){ echo 'selected';}?>/><?php echo $layoutname; ?>
												</div>
												
											<?php $a++; }
										?>
									
								</div>
							</div>
							
							</div>
						
							
							<div class="actionBar">
							
							<?php
								
							if($google_hangout_theme !=''){ ?>
							<?php  
						
							if($element_count == 11){}else{ ?>
									<div style="float:left;">
											To Purchase more landing page templates Please <a href="http://runclick.com/template/" target="_blank" class="hangout_btn theme_update_button">Click Here</a>
									</div>		
								<?php 	} ?>
								<button class="hangout_btn theme_update_button" type="submit" name="theme_submit"><i class="icon-plus-sign"></i> Save & Update Theme page</button>
								<?php } else { ?>
								<?php  if($element_count==11){}else{ ?>
									<div style="float:left;">
											To Purchase more landing page templates Please <a href="http://runclick.com/template/" target="_blank" class="hangout_btn theme_update_button">Click Here</a>
									</div>		
								<?php 	} ?>
								<button class="hangout_btn theme_update_button" type="submit" name="theme_next"><i class="icon-plus-sign"></i> Next</button>
								
								<?php } ?>
							</div>
                       	</div>
                    </div>
					</form>
					<!-- End Theme Tab -->
                    
                </div>
                <!-- End Hangouts Panel -->
				<strong style="font-size: 17px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Webinar APPs Link : </strong> <a href="https://hangoutsapi.talkgadget.google.com/hangouts/_?gid=728076588717" target="_blank" /><strong>https://hangoutsapi.talkgadget.google.com/hangouts/_?gid=728076588717</strong></a>
                
                </div>
                </div>
    		</div>
    	</div>
    </div>
    <!-- End Container -->   
    
<script>
jQuery(function($){
	$(document).ready(function(){
	$(".gh_accordian_div").css("display","none");
	$('.gh_accordian_tab').click(function(){   
	$(this).toggleClass("MenuTopon");  
	var id = $(this).attr("id");
	var number = id.substring(6,id.length);
	$("#myDiv"+number).slideToggle("slow");});
	
	//Default Action
	$("#hangout_main .gh_container .gh_inner_tabs").hide(); //Hide all content
	$("#hangout_main .hornav li:first").addClass("current_tab").show(); //Activate first tab
	
	
	$("#hangout_main .gh_container #theme").show(); //Show first tab content
	
	//On Click Event
	$("#hangout_main .hornav li").click(function() {
		$("#hangout_main .hornav li").removeClass("current_tab"); //Remove any "active" class
		$(this).addClass("current_tab"); //Add "active" class to selected tab
		$("#hangout_main .gh_container .gh_inner_tabs").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
  
  
  
  });
});

</script>
<?php if(($hangout_selected_type=='' || $hangout_selected_type=='New_hangout')  && ($hangout_type=='New_hangout' || $hangout_type=='' ) && (($_GET['selected_theme']=='' && $_GET['EID']=='') || $_GET['type']!='')) { ?>
<script>
jQuery(function($){
$(document).ready(function(){
$("#hangout_main .hornav li").hide();
$("#hangout_main .hornav li:first").show();
});
});
</script>
<?php } ?>

<?php if($_REQUEST['sel']!=''){?>
<script>
jQuery(function($){
	$(document).ready(function(){

			$("#hangout_main .hornav li").removeClass("current_tab"); //Remove any "active" class
			$('#hangouts_dashboard_<?php echo $_REQUEST["sel"];?>').addClass("current_tab"); //Add "active" class to selected tab
			$("#hangout_main .gh_container .gh_inner_tabs").hide(); //Hide all tab content
			var activeTab = $('#hangouts_dashboard_<?php echo $_REQUEST["sel"];?>').find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).show(); //Fade in the active content
			return false;
		});
	});

</script>

<?php } ?>
