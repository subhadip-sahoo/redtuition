<?php
$message ='';
if($_REQUEST['action']=='delete'){
	wp_delete_post( $_REQUEST['DEL'], true); 
	$message="</div class='updated'>G Webinar Deleted successfully.</div>";
	wp_redirect(admin_url()."admin.php?page=google_hangout");
}
?>
<div class="gh_container_header">
                    	<div class="row-fluid">
                        <div class="span6">
                           <strong>Webinars</strong>
                        	List of existing Webinars. Click to modify Or Make Live
                        </div>
                        <div class="span6">
                            	<div class="block_right">
                        		<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout" class="hangout_btn"><i class="icon-plus-sign"></i> Create New Webinar</a>
                                </div>
                        </div>
                        </div>
                    </div>
                    <div class="gh_tabs_div_inner">
                        	<ul class="table_view table_heading">
                    			<li class="span3"><span>Name </span></li>
                        		<li class="span3"><span>Time </span></li>
                        		<li class="span3"><span>Webinar Type </span></li>
                        		<li class="span3"><span class="center">Action </span></li>
                    		</ul>

							<?php 
			global $wpdb;

		   $post_table = $wpdb->prefix . "posts"; 
			$url = admin_url()."admin.php?page=google_hangout";
			/*Max Number of results to show*/
			$max = 10;
			/*Get the current page eg index.php?pg=4*/
			if(isset($_GET['pg'])){
			$p = $_GET['pg'];
			}else{
			$p = 1;
			}
			$limit = ($p - 1) * $max;
			$prev = $p - 1;
			$next = $p + 1;
			$limits = (int)($p - 1) * $max;

			//This is the query to get the current dataset
			$result=$wpdb->get_results('SELECT * from '. $post_table.' where post_type="ghangout" order by id desc limit '.$limits.','.$max.'');
			//Get total records from db
			$totalres = $wpdb->get_var('SELECT COUNT(id) AS tot FROM '. $post_table .' where post_type="ghangout"');
			//devide it with the max value & round it up
			$totalposts = ceil($totalres / $max);
			$lpm1 = $totalposts - 1;
			
				$i=1;
				if( count($result) ){	
					foreach($result as $output){	
	
				 ?>

							<ul class="table_view">
                    			<li class="span3"><span><?php echo $output->	post_title; ?> </span></li>
                        		<li class="span3"><span><?php 
								
								
								if(get_post_meta($output->ID, 'hangout_timezone', true)==""){
								
								}else{
								  $timezone=get_post_meta($output->ID, 'hangout_timezone', true);
								$timedata = explode(" ", $timezone);
	$daymonth=explode('/',$timedata[0]);
	echo $timezone = $daymonth[1].'/'.$daymonth[0].'/'.$daymonth[2]." ".$timedata[1]." ".$timedata[2];
	}
								 ?> </span></li>
                        		<li class="span3"><span><?php if(get_post_meta($output->ID, 'hangout_type', true)=="Record_hangout"){ echo "Recorded Webinar";}else{ echo "New Webinar";} ?> </span></li>
								
                        		<li class="span3">
                                <span class="center">
                                	<a href="<?php echo get_permalink($output->ID);?>" class="h_editing_link" target="_blank"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/view.png" title="View"></a>
                                	<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&EID=<?php echo $output->ID;?>" class="h_editing_link"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/edit.png" title="Edit"></a>
                                    <a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete&DEL=<?php echo $output->ID;?>" class="h_editing_link"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/delete.png" title="Delete"></a>
									<?php  if(get_post_meta($output->ID, 'hangout_type', true)!='Record_hangout'){?>
                                	<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&EID=<?php echo $output->ID;?>&sel=3" class="h_editing_link"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/live.png" title="Live"></a>
									<?php } ?>
                                	<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&EID=<?php echo $output->ID;?>&sel=6" class="h_editing_link" target="_blank"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/subscriber.png" title="Subscriber"></a>
									<a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&EID=<?php echo $output->ID;?>&type=clone&sel=2" class="h_editing_link"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/clone.png" title="Clone"></a>									
                                </span>
                                </li>
                    		</ul>

						
		<?php  		} ?>
					
							<?php echo Ghangoutpagination($totalposts,$p,$lpm1,$prev,$next,$url);?>
						
		<?php   } ?>

                        	</div>
