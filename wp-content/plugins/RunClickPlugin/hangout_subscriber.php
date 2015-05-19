<?php
$message ='';
if($_REQUEST['action']=='delete'){
	wp_delete_post( $_REQUEST['DEL'], true); 
	$message="</div class='updated'>G Hangout Deleted successfully.</div>";
	wp_redirect(admin_url()."admin.php?page=google_hangout");
}
if($_REQUEST['action']=='delete_subscriber'){
	$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 
	$query = "DELETE FROM $subscriber_table WHERE email = '".$_REQUEST['DEL_sub']."'";
	$webinar_id=$_GET['EID'];
	$wpdb->query($query);
	$message="</div class='updated'>Subscriber Deleted successfully.</div>";
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$webinar_id&sel=6");
}
?>

                    	<div class="gh_tabs_div_inner">

							<ul class="table_view table_heading">
                    			<li class="span1 center"><span>S.No </span></li>
                        		<li class="span2"><span>Name </span></li>
                        		<li class="span3"><span>Email </span></li>
                        		<li class="span2"><span>Organization </span></li>
                                <li class="span2"><span>Joining Date </span></li>
								<li class="span2"><span>Delete Subscriber </span></li>
                    		</ul>

		<?php 
			global $wpdb;
			$id = $_GET['EID'];
			$subscriber_table = $wpdb->prefix . "google_hangout_subscriber"; 
			$url = admin_url()."admin.php?page=manage_hangout&EID=".$_REQUEST['EID']."&sel=6";
			/*Max Number of results to show*/
			$max = 25;
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
			//echo 'SELECT * from '. $subscriber_table.' where g_event_id="'.$id.'" limit '.$limits.','.$max.'';
			$result	=	$wpdb->get_results('SELECT * from '. $subscriber_table.' where g_event_id="'.$id.'" limit '.$limits.','.$max.'');
			
			//Get total records from db
			$totalres = $wpdb->get_var('SELECT COUNT(id) AS tot FROM '. $subscriber_table .' where  g_event_id="'.$id.'"');
			//devide it with the max value & round it up
			$totalposts = ceil($totalres / $max);
			$lpm1 = $totalposts - 1;
			
				$i=1;
				if( count($result) ){	
					foreach($result as $output){	
	
				 ?>
								<ul class="table_view">
									<li class="span1 center"><span><?php echo $i++; ?></span></li>
									<li class="span2"><span><?php echo $output->name; ?></span></li>
									<li class="span3"><span><?php echo $output->email; ?></span></li>
									<li class="span2"><span><?php echo $output->organization; ?></span></li>
									<li class="span2"><span><?php echo $output->joining_date; ?></span></li>
									<li class="span2"><span><a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete_subscriber&DEL_sub=<?php echo $output->email;?>&EID=<?echo $id;?>" class="h_editing_link"><img src="<?php echo plugins_url();?>/RunClickPlugin/images/delete.png" title="Delete"></a></span></li>
								</ul>
						
		<?php  		} ?>
					
							<?php echo Ghangoutpagination($totalposts,$p,$lpm1,$prev,$next,$url);?>
						
		<?php   } ?>
		</div>
