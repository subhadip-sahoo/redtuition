<div id="hangout_main">
<?php $plugins_url = plugin_dir_url(__FILE__);
									
									
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
												die();
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
					Chat<?php if(get_option("hangout_chat_settings",true) == "1"){ ?> <img src="<?php echo plugin_dir_url(__FILE__);?>images/activated.png" alt="" align="top" />
					<?php }else {?>
					<img src="<?php echo plugin_dir_url(__FILE__);?>images/deactivated.png" alt="" align="top" />
					<?php } ?>
                </div>
    		</div>
    	</div>
    </div>
    <!-- End Header -->
	<div class="hangout_activated">
    	<!-- Start Tabs -->
    	<div class="gh_tabs">
		<div class="row-fluid">
			<div class="span12">
     		<ul class="gh_tabs_list">
            <li class="span3" id="hangouts_dashboard_1"><a href="#hangouts_panel"><span><i class="icon-time"></i></span>Webinars </a></li>
            <li class="span3" id="hangouts_dashboard_2"><a href="#email_settings_panel"><span><i class="icon-envelope"></i></span>Email Settings </a></li>
            <li class="span3" id="hangouts_dashboard_3"><a href="#export_subscribers_panel"><span><i class="icon-share"></i></span>Export Subscribers </a></li>
            <li class="span3" id="hangouts_dashboard_4" ><a href="#hangouts_settings_panel"><span><i class="icon-cogs"></i></span>Webinars Settings </a></li>
            </ul>
    		</div>
    	</div>
    	</div>
    	<!-- End Tabs -->
    <!-- Start Container -->
    <div class="gh_container">
		<div class="row-fluid">
			<div class="span12">
                
                <!-- Start Hangouts Panel -->
                <div id="hangouts_panel" class="gh_tabs_div">
                
                	
                    <?php require_once('hangout.php');?>    	
                    
                    
                </div>
                <!-- End Hangouts Panel -->
                
                <!-- Start Email Settings Panel -->
                <div id="email_settings_panel" class="gh_tabs_div">
                	  <?php require_once('ghangout_event_template.php');?>    	
                    
                </div>
                <!-- End Email Settings Panel -->
                
                <!-- Start Export Subscribers Panel -->
                <div id="export_subscribers_panel" class="gh_tabs_div">
                    <div class="gh_container_header">
                    	<div class="row-fluid">
							<div class="span6">
                    			<strong>Export Subscribers </strong>
                        			
                        	</div>
                        	<div class="span6">
                            	<div class="block_right">
                        		<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=google_hangout_export" class="hangout_btn"><i class="icon-share"></i> Click to Export All Subscribers</a>
                                </div>
                        	</div>
                        </div>
                    </div>
                </div>
                <!-- End Export Subscribers Panel -->
                
                <!-- Start Hangouts Settings Panel -->
     			<div id="hangouts_settings_panel" class="gh_tabs_div">
                	<div class="gh_container_header">
                    	<strong>Webinar Settings</strong>
                        
                    </div>
                    	<?php require_once('ghangout_setting.php'); ?>
                    </div>
                <!-- End Hangouts Settings Panel -->
                
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
		$("#hangout_main .gh_container .gh_tabs_div").hide(); //Hide all content
		$("#hangout_main .gh_tabs .gh_tabs_list li:first").addClass("selected_tab").show(); //Activate first tab
		$("#hangout_main .gh_container .gh_tabs_div:first").show(); //Show first tab content
		//On Click Event
		$("#hangout_main .gh_tabs .gh_tabs_list li").click(function() {
			$("#hangout_main .gh_tabs .gh_tabs_list li").removeClass("selected_tab"); //Remove any "active" class
			$(this).addClass("selected_tab"); //Add "active" class to selected tab
			$("#hangout_main .gh_container .gh_tabs_div").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active content
			return false;
		});
	});
});
</script>
<?php if($_REQUEST['sel']!=''){?>
<script>
jQuery(function($){
	$(document).ready(function(){

			$("#hangout_main .gh_tabs .gh_tabs_list li").removeClass("selected_tab"); //Remove any "active" class
			$('#hangouts_dashboard_<?php echo $_REQUEST["sel"];?>').addClass("selected_tab"); //Add "active" class to selected tab
			$("#hangout_main .gh_container .gh_tabs_div").hide(); //Hide all tab content
			var activeTab = $('#hangouts_dashboard_<?php echo $_REQUEST["sel"];?>').find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			
			$(activeTab).show(); //Fade in the active content
			return false;
		});
	});

</script>
<?php } ?>
