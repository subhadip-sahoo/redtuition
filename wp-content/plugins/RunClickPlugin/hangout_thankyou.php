<?php
$hangout_id		=	$_REQUEST['EID'];
 $selected_theme=$_REQUEST['selected_theme'];
 if($_REQUEST['action']=='delete_webinar_thk_logo'){
	$webinar_id=$_GET['EID'];
	 $thk_logoname=$_GET['thk_logo_name'];
	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['basedir'];
	@chmod($uploads_dir,0755);

	//unlink($uploads_dir.'/'.$thk_logoname);
	update_post_meta($webinar_id,"ghanghout_thankyou_logo","");
	$message="</div class='updated'>Logo Deleted successfully.</div>";
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=$webinar_id&sel=4");
}
if(isset($_POST['thankyou_submit']))
{

	$post_id = $hangout_id;

	$thanks_page_title	=	$_POST['thanks_page_title'];
	$thanks_page_video	=	$_POST['thanks_page_video'];

	$thanks_sidebar_title	=	$_POST['thanks_sidebar_title'];
	$thanks_sidebar_sub_title	=	$_POST['thanks_sidebar_sub_title'];
	$thanks_sidebar_heading_color	=	$_POST['thanks_sidebar_heading_color'];
	$thanks_sidebar_heading_box_color	=	$_POST['thanks_sidebar_heading_box_color'];
	$chat_reg_off_thakyou	=	$_POST['chat_reg_off_thakyou'];
	$thanks_page_chat	=	$_POST['thanks_page_chat'];
	$show_thanks_page_video	=	$_POST['show_thanks_page_video'];
	$thanks_page_gift	=	$_POST['thanks_page_gift'];
	$gift_html	=	$_POST['gift_html'];
	$gift_url	=	$_POST['gift_url'];
	$gift_button_text	=	$_POST['gift_button_text'];

	
	//update the meta value of the hangout post 
	if(isset($_POST['thanks_page_title'])){
		update_post_meta( $hangout_id, 'thanks_page_title', $thanks_page_title );
		update_post_meta( $hangout_id, 'thanks_page_chat', $thanks_page_chat );
		update_post_meta( $hangout_id, 'thanks_page_video', $thanks_page_video );
		update_post_meta( $hangout_id, 'show_thanks_page_video', $show_thanks_page_video );
		update_post_meta( $hangout_id, 'thanks_sidebar_title', $thanks_sidebar_title );
		update_post_meta( $hangout_id, 'thanks_sidebar_sub_title', $thanks_sidebar_sub_title );
		update_post_meta( $hangout_id, 'thanks_sidebar_heading_color', $thanks_sidebar_heading_color );
		update_post_meta( $hangout_id, 'thanks_sidebar_heading_box_color', $thanks_sidebar_heading_box_color );
	}
	
	if(isset($_POST['thanks_page_gift'])){
		update_post_meta( $hangout_id, 'thanks_page_gift', $thanks_page_gift );
		update_post_meta( $hangout_id, 'gift_html', $gift_html );
		update_post_meta( $hangout_id, 'gift_url', $gift_url );
		update_post_meta( $hangout_id, 'gift_button_text', $gift_button_text );
	}
	
	update_post_meta( $hangout_id, 'chat_reg_off_thakyou', $chat_reg_off_thakyou );
	
		  $ghanghout_thankyou_logo = $_FILES["ghanghout_thankyou_logo"]["name"];
		  $uploads = wp_upload_dir();
	      $uploads_dir = $uploads['basedir'];
		  @chmod($uploads_dir,0755);
			if($ghanghout_thankyou_logo !=''){
				move_uploaded_file($_FILES["ghanghout_thankyou_logo"]["tmp_name"], "$uploads_dir/$ghanghout_thankyou_logo");
			}
			if($ghanghout_thankyou_logo !=''){
				update_post_meta($post_id,"ghanghout_thankyou_logo",$ghanghout_thankyou_logo);
			}
		update_post_meta($post_id,"ghanghout_thankyou_logo_text",$_POST["ghanghout_thankyou_logo_text"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_family",$_POST["ghanghout_thankyou_logo_family"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_size",$_POST["ghanghout_thankyou_logo_size"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_style",$_POST["ghanghout_thankyou_logo_style"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_shadow",$_POST["ghanghout_thankyou_logo_shadow"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_height",$_POST["ghanghout_thankyou_logo_height"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_spacing",$_POST["ghanghout_thankyou_logo_spacing"]);
		update_post_meta($post_id,"ghanghout_thankyou_logo_color",$_POST["ghanghout_thankyou_logo_color"]);

		update_post_meta($post_id,"ghanghout_thankyou_enable_header",$_POST["ghanghout_thankyou_enable_header"]);
		update_post_meta($post_id,"ghanghout_thankyou_enable_sharing",$_POST["ghanghout_thankyou_enable_sharing"]);

		update_post_meta($post_id,"thankyou_timer_type",$_POST['thankyou_timer_type']);
	/*C0de for update logo*/
	$thanks_sidebar_image	= $_FILES['thanks_sidebar_image']['name'];
    $target_file      		= wp_upload_dir();
    $target_path      		= $target_file['path']."/".basename( $_FILES['thanks_sidebar_image']['name']);
    if(move_uploaded_file($_FILES['thanks_sidebar_image']['tmp_name'],$target_path))
    {
        update_post_meta($hangout_id,'thanks_sidebar_image',$target_file['url']."/".$thanks_sidebar_image);               
    }
	
	/* Bhuvnesh Code for theme settings */
		$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
		if($google_hangout_theme == "Default" || $google_hangout_theme == ""){
		}
		else{
			include_once 'themes/'.$google_hangout_theme.'/thankyou_back.php';
		}
	/* Bhuvnesh Code for theme settings End */		
	
	wp_redirect(admin_url()."admin.php?page=manage_hangout&EID=".$post_id."&sel=4");
}
	$thankyou_timer_type = get_post_meta($post_id,"thankyou_timer_type",true);
	$ghanghout_thankyou_enable_header = get_post_meta($post_id,"ghanghout_thankyou_enable_header",true);
	$ghanghout_thankyou_enable_sharing = get_post_meta($post_id,"ghanghout_thankyou_enable_sharing",true);
	$ghanghout_thankyou_logo = get_post_meta($post_id,"ghanghout_thankyou_logo",true);
	$ghanghout_thankyou_logo_text = get_post_meta($post_id,"ghanghout_thankyou_logo_text",true);
	$ghanghout_thankyou_logo_family = get_post_meta($post_id,"ghanghout_thankyou_logo_family",true);
	$ghanghout_thankyou_logo_size = get_post_meta($post_id,"ghanghout_thankyou_logo_size",true);
	$ghanghout_thankyou_logo_style =	get_post_meta($post_id,"ghanghout_thankyou_logo_style",true);
	$ghanghout_thankyou_logo_shadow = get_post_meta($post_id,"ghanghout_thankyou_logo_shadow",true);
	$ghanghout_thankyou_logo_height = get_post_meta($post_id,"ghanghout_thankyou_logo_height",true);
	$ghanghout_thankyou_logo_spacing =	get_post_meta($post_id,"ghanghout_thankyou_logo_spacing",true);
	$ghanghout_thankyou_logo_color =	get_post_meta($post_id,"ghanghout_thankyou_logo_color",true);
	$chat_reg_off_thakyou =	get_post_meta($post_id,"chat_reg_off_thakyou",true);
	$thanks_page_chat =	get_post_meta($post_id,"thanks_page_chat",true);
	$show_thanks_page_video =	get_post_meta($post_id,"show_thanks_page_video",true);
	$thanks_page_gift =	get_post_meta($post_id,"thanks_page_gift",true);
	$gift_html =	get_post_meta($post_id,"gift_html",true);
	$gift_url =	get_post_meta($post_id,"gift_url",true);
	$gift_button_text =	get_post_meta($post_id,"gift_button_text",true);

?>

<form action="" method="POST" enctype="multipart/form-data">
<div class="gh_tabs_div_inner">
						<?php 
							if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
								
							
							}
							else{
							?>
                        <div id="myMenu9" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Thankyou Page Settings  </div>
						<div id="myDiv9" class="gh_accordian_div">
                        	
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Title </strong>
                            </div>
                            <div class="span8">
							<input type="text" name="thanks_page_title" value="<?php echo get_post_meta( $hangout_id, 'thanks_page_title',true ); ?>" class="longinput"/>
                            </div>
                        </div>
                        </div>
					
                        <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Thankyou Page Design</strong>
                            </div>
                            <div class="span8">
								
                            	<?php echo wp_editor( get_post_meta( $hangout_id, 'thanks_page_video', true), 'thanks_page_video' ); ?>
                            </div>
                        </div>
                        </div>
                      
					<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Turn On Chat On Thankyou Page?</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="thanks_page_chat" value="1" <?php if($thanks_page_chat=='1' ){ echo 'checked'; } ?>> Yes &nbsp;&nbsp; <input type="radio" name="thanks_page_chat" value="0" <?php if($thanks_page_chat=='0' || $thanks_page_chat==''){ echo 'checked'; }?>> No
                            </div>
                        </div>
					
                        </div>
						<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Show video On Thankyou Page?</strong>
								</div>
								<div class="span8">
									<input type="radio" name="show_thanks_page_video" value="1" <?php if($show_thanks_page_video=='1' ){ echo 'checked'; } ?>> Yes &nbsp;&nbsp; <input type="radio" name="show_thanks_page_video" value="0" <?php if($show_thanks_page_video=='0' || $show_thanks_page_video==''){ echo 'checked'; }?>> No
								</div>
							</div>					
                        </div>
						</div>	
						 <?php } ?> 
                       <?php 
						$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
						if($google_hangout_theme == "Default" or $selected_theme ==  "Default"  ){
						}
						elseif($selected_theme!='' or $google_hangout_theme !=''){
						
						?>
						<div id="myMenu10" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Gift Sharing Settings  </div>
						<div id="myDiv10" class="gh_accordian_div">
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Enable a Gift</strong>
                            </div>
                            <div class="span8">
								<input type="radio" name="thanks_page_gift"  id="thanks_gift_yes" value="1" <?php if($thanks_page_gift=='1' || $thanks_page_gift==''){ echo 'checked'; } ?>> Yes &nbsp;&nbsp; <input type="radio" name="thanks_page_gift" value="0" id="thanks_gift_no" <?php if($thanks_page_gift=='0'){ echo 'checked'; }?>> No
                            </div>
                        </div>
						
						
						
						
                        </div>
						<div style="<?php if($thanks_page_gift=='1' || $thanks_page_gift==''){ echo 'display:block;'; }else{ echo "display:none;";} ?>" id="gift_setting">
						<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Html for gift</strong>
								</div>
								<div class="span8">	
									<textarea placeholder="Html For gift setting..." name="gift_html" id="gift_html" ><?php echo $gift_html; ?></textarea>
								</div>	
							</div>
						</div>
						<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Gift Url</strong>
								</div>
								<div class="span8">	
									<input type="text" placeholder="Url For gift..." name="gift_url" id="gift_url" value="<?php echo $gift_url; ?>" />
								</div>	
							</div>
						</div>
						<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Gift Button Text</strong>
								</div>
								<div class="span8">	
									<input type="text" placeholder="Text For Gift..." name="gift_button_text" id="gift_button_text" value="<?php echo $gift_button_text; ?>" />
								</div>	
							</div>
						</div>
						
						</div>
						
						
						
						
</div>
<?php } ?>
                       
						<?php 
					if(($google_hangout_theme != "" or $selected_theme!='') and ($selected_theme !='Default' and $google_hangout_theme != "Default" )){
					}
					else{
					?>
                        <div id="myMenu11" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Sidebar Box Setting  </div>
						<div id="myDiv11" class="gh_accordian_div">
							<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Sidebar Box Title</strong>
								</div>
								<div class="span8">
									<input type="text" class="longinput" name="thanks_sidebar_title" size="50" Value="<?php echo get_post_meta( $hangout_id, 'thanks_sidebar_title', true); ?>" />
								</div>
							</div>
							</div>
							
							<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Sidebar Heading Color </strong>
								</div>
								<div class="span8">
									<input type="text" class="longinput" name="thanks_sidebar_heading_color" value="<?php echo get_post_meta( $hangout_id, 'thanks_sidebar_heading_color', true); ?>"/>
									<a href="http://hangoutplugin.com/colors.html" target="_blank">Click Here For A Color Chart</a>
								</div>
							</div>
							</div>
							
							<div class="row-fluid-outer">
							<div class="row-fluid">
								<div class="span4">
									<strong>Sidebar Heading Box Color </strong>
								</div>
								<div class="span8">
									<input type="text" class="longinput" name="thanks_sidebar_heading_box_color" value="<?php echo get_post_meta( $hangout_id, 'thanks_sidebar_heading_box_color', true); ?>"/>
									<a href="http://hangoutplugin.com/colors.html" target="_blank">Click Here For A Color Chart</a>
								</div>
							</div>
							</div>
							
							
                        </div>

						<?php } ?>
                        
                        <div id="myMenu12" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Header settings </div>
						<div id="myDiv12" class="gh_accordian_div">
						<div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span4">
								<strong>Logo <!--/ Social Sharing--> </strong>
                            </div>
                            <div class="span8">
								<input id="ghanghout_thankyou_enable_header" name="ghanghout_thankyou_enable_header" size="30" value="checked" type="checkbox" <?php if($ghanghout_thankyou_enable_header=="checked"){ echo 'checked="checked"'; } ?> > Enable Logo &nbsp;&nbsp;
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
								<input type="file" class="ghanghoutUpload upload2" name="ghanghout_thankyou_logo" id="ghanghout_thankyou_logo" value="" class="ghanghoutUpload upload2">
								<?php if($ghanghout_thankyou_logo!=''){ ?>
									<br><img width="100" src="<?php echo $baseurl.'/'.$ghanghout_thankyou_logo;?>">
									<a onclick="javascript: return confirm('Are you SURE you want to delete this?');" href="<?php echo get_site_url();?>/wp-admin/admin.php?page=manage_hangout&action=delete_webinar_thk_logo&thk_logo_name=<?php echo $ghanghout_thankyou_logo;?>&EID=<?echo $post_id;?>" class="h_editing_link">
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
								<input class="longinput"  type="text" name="ghanghout_thankyou_logo_text" id="ghanghout_thankyou_logo_text" value="<?php echo $ghanghout_thankyou_logo_text; ?>" class="ghanghoutText">
                            </div>
                        </div>
                        </div>


					 <div class="row-fluid-outer">
                        <div class="row-fluid">
							<div class="span12">
								<b>Logo Style</b><br>
								<span class="howto">Select font family, font size, font weight, text shadow, line height, letter spacing, and color.</span>
								<select name="ghanghout_thankyou_logo_family" id="ghanghout_thankyou_logo_family">

									<option <?php if($ghanghout_thankyou_logo_family=="Arial")echo "selected=''"; ?>>Arial</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Verdana")echo "selected=''"; ?>>Verdana</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Tahoma")echo "selected=''"; ?>>Tahoma</option>

									<option <?php if($ghanghout_thankyou_logo_family=="Kristi")echo "selected=''"; ?>>Kristi</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Crafty Girls")echo "selected=''"; ?>>Crafty Girls</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Yesteryear")echo "selected=''"; ?>>Yesteryear</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Finger Paint")echo "selected=''"; ?>>Finger Paint</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Press Start 2P")echo "selected=''"; ?>>Press Start 2P</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Spirax")echo "selected=''"; ?>>Spirax</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Bonbon")echo "selected=''"; ?>>Bonbon</option>
									<option <?php if($ghanghout_thankyou_logo_family=="Over the Rainbow")echo "selected=''"; ?>>Over the Rainbow</option>
								</select>

								<select name="ghanghout_thankyou_logo_size" id="ghanghout_thankyou_logo_size">
								<?php $x=10; 
								while($x<=100){
									$chk='';
									if($ghanghout_thankyou_logo_size=='' && $x==48){
										$chk = 'selected="selected"';
									} else {
										echo $comparstr = $ghanghout_thankyou_logo_size.'px';
										if($comparstr==$x){
											$chk = 'selected="selected"';
										}
									}
								echo '<option '.$chk.'>'.$x.'px</option>';
								$x++;
								}
								?>
								</select>
								<select name="ghanghout_thankyou_logo_style" id="ghanghout_thankyou_logo_style">
									<option <?php if($ghanghout_thankyou_logo_style=="Normal" || $ghanghout_thankyou_logo_style=='')echo "selected=''"; ?> >Normal</option>
									<option <?php if($ghanghout_thankyou_logo_style=="Italic")echo "selected=''"; ?>>Italic</option>
									<option <?php if($ghanghout_thankyou_logo_style=="Bold")echo "selected=''"; ?>>Bold</option>
									<option <?php if($ghanghout_thankyou_logo_style=="Bold/Italic")echo "selected=''"; ?>>Bold/Italic</option>
								</select>

								<select name="ghanghout_thankyou_logo_shadow" id="ghanghout_thankyou_logo_shadow">
									<option <?php if($ghanghout_thankyou_logo_shadow=="None" || $ghanghout_thankyou_logo_shadow=='')echo "selected=''"; ?> >None</option>
									<option <?php if($ghanghout_thankyou_logo_shadow=="Small")echo "selected=''"; ?>>Small</option>
									<option <?php if($ghanghout_thankyou_logo_shadow=="Medium")echo "selected=''"; ?>>Medium</option>
									<option <?php if($ghanghout_thankyou_logo_shadow=="Large")echo "selected=''"; ?>>Large</option>
								</select>

								<select name="ghanghout_thankyou_logo_height" id="ghanghout_thankyou_logo_height">
									<option <?php if($ghanghout_thankyou_logo_height=="70%")echo "selected=''"; ?> >70%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="75%")echo "selected=''"; ?>>75%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="75%" || $ghanghout_thankyou_logo_height=='')echo "selected=''"; ?>>80%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="85%")echo "selected=''"; ?> >85%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="90%")echo "selected=''"; ?> >90%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="95%")echo "selected=''"; ?> >95%</option>
									<option <?php if($ghanghout_thankyou_logo_height=="100%")echo "selected=''"; ?> >100%</option>
								</select>

								<select name="ghanghout_thankyou_logo_spacing" id="ghanghout_thankyou_logo_spacing">
									<option <?php if($ghanghout_thankyou_logo_spacing=="-3" || $ghanghout_thankyou_logo_spacing=='')echo "selected=''"; ?> >-3</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="-2" )echo "selected=''"; ?>>-2</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="-1" )echo "selected=''"; ?>>-1</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="0" )echo "selected=''"; ?>>0</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="1" )echo "selected=''"; ?>>1</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="2" )echo "selected=''"; ?>>2</option>
									<option <?php if($ghanghout_thankyou_logo_spacing=="3" )echo "selected=''"; ?>>3</option>
								</select>

								 <input name="ghanghout_thankyou_logo_color" id="ghanghout_thankyou_logo_color" type="text" value="<?php echo $ghanghout_thankyou_logo_color; ?>"> <a target="_blank" href="http://hangoutplugin.com/colors.html">Click Here For A Color Chart</a>

			</div>
			</div>
			</div>
			</div>
					<?php 
						$google_hangout_theme = get_post_meta($post_id,"google_hangout_theme",true);
						if($google_hangout_theme == "Default" or $selected_theme ==  "Default"  ){
						}
						elseif($selected_theme!='' or $google_hangout_theme !=''){
						$google_hangout_selected_theme=str_replace('_',' ',$selected_theme);
						if($google_hangout_selected_theme==''){
							$google_hangout_selected_theme=$google_hangout_theme;
							$google_hangout_selected_theme=str_replace('_',' ',$google_hangout_selected_theme);
							}
						?>
						<!-- Theme Settings Start -->
							<div id="myMenuB2" class="gh_accordian_tab"><i class="icon-plus-sign"></i> Theme settings </div>
							<div id="myDivB2" class="gh_accordian_div">
						<?php
							include_once 'themes/'.$google_hangout_selected_theme.'/thankyou_back.php';
						?>
							</div>
							<!-- Theme Settings End -->
						<?php
						}
					?>
			</div>
			<?php
			$exp_url	=	explode("?",get_permalink($_REQUEST['EID']));
			//print_r($exp_url);
			if(count($exp_url) >1)
			{
				$thank_prev_url	=	get_permalink($_REQUEST['EID'])."&thankyou=true";
			}
			else
			{
				$thank_prev_url	=	get_permalink($_REQUEST['EID'])."?thankyou=true";
			}
			//echo $thank_prev_url; die;
			?>
			<div class="actionBar">
				<button class="hangout_btn thankyou_update_button" type="submit" name="thankyou_submit"><i class="icon-plus-sign"></i> Save & Update Thankyou page</button>
				<a class="hangout_btn preview_thankyou_button" href="javascript:void(0);" name="preview_thankyou"><i class="icon-plus-sign"></i> Save & Preview Thankyou page</a>
			</div>
			</form>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".preview_thankyou_button").live('click',function(){
			jQuery(".thankyou_update_button").trigger('click');
			setTimeout(function(){
				window.open('<?php echo $thank_prev_url;?>','_blank');
			},800);
			
		});
	});
</script>
