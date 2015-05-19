<?php
global $post, $wpdb;

if(isset($_POST['submit'])){
	$userid = get_current_user_id( ); 
	$youtubedata = $_POST['g_embeded_code'];
	$youtubedata = addslashes($youtubedata);
	$post_id = $_REQUEST['EID'];

	$my_post = array(
	  'post_title'    => addslashes($_POST["hangout_youtube"]),
	  'post_content'  => $youtubedata,
	  'post_status'   => 'publish',
	  'post_author'   => $userid,
	  'post_type'      => 'ghangout'
	);

// Insert the post into the database
	//$post_id = wp_insert_post( $my_post );

	if($_POST["hangout_timezone"])
	  {
		update_post_meta($post_id,"hangout_timezone",addslashes($_POST["hangout_timezone"]));
	  }

	if($_POST["hangout_title"])
	  {
		update_post_meta($post_id,"hangout_title",addslashes($_POST["hangout_title"]));
	  }
          if($_POST["hangout_youtube"])
          {
		update_post_meta($post_id,"hangout_youtube",$_POST["hangout_youtube"]);
	  }


		

	/* $my_post = array(
	  'post_title'    => $_POST["hangout_youtube"],
	  'post_content'  => $youtubedata,
	  'post_status'   => 'publish',
	  'post_author'   => $userid,
	  'post_type'      => 'gevent'
	);
	$new_post_id = wp_insert_post( $my_post );
	update_post_meta($post_id,"gevent_id",$new_post_id);*/
	  

	wp_redirect(admin_url()."admin.php?page=google_hangout");
}

if($_REQUEST['msg_id']=='4'){
?>
<div id="message" class="updated below-h2"><p>Webinar Event published. </p></div>
<?php } 
/*
if(get_option('g_project_id')==''){ ?>
	<div id="message" class="error"><p>Project Id is Missing </p></div>
<?php }
if(get_option('hangout_youtube_user_id')==''){ ?>
	<div id="message" class="error"><p>Youtube User ID is Missing </p></div>
<?php } 
*/
?>



<div class="hangoutfrm">
<h2> Add New Webinar</h2>
<form method="post" name="add_hangout" action="">
<p> <label> Google Webinar Title </label><span><input type="text" name="hangout_title"></span></p>
<p> <label> Date </label><span>

<input type="text" name="hangout_timezone" id="timezone" value="" /></span>
</p>
<p><lable>Start Webinar</lable><span>&nbsp;&nbsp;&nbsp;&nbsp;
<a class="ghangout" href="https://plus.google.com/hangouts/_?gid=<?php //echo get_option('g_project_id'); ?>" style="text-decoration:none;"> <img src="https://ssl.gstatic.com/s2/oz/images/stars/hangout/1/gplus-hangout-15x79-normal.png" alt="Start a Webinar" style="border:0;width:79px;height:15px;"/> </a>
</span></p>
<p><br></p>
<p><br></p>
<p> <a href="#" id="get_youtube_details"> Click here To get Youtube Webinar details </a></p>
<p> <label> Youtube URL </label><span>

<input type="text" name="hangout_youtube" id="hangout_youtube" value="" /></span>
</p>
<p> <label> Youtube Embeded Code </label><span>

<textarea name="g_embeded_code" cols="50" rows="5" id="hangout_emb_code"></textarea></span>
</p>

<p><input type="submit" value="Add Google Webinar" name="submit"/>

</form>

</div>
