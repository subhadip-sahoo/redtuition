<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" >

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<?php echo get_post_meta(get_the_ID(), "add_meta_tag", true); ?>
<title><?php the_title(); ?></title>
<!-- Fonts +++++++++++++ -->	
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Kristi|Crafty+Girls|Yesteryear|Finger+Paint|Press+Start+2P|Spirax|Bonbon|Over+the+Rainbow" />	
<!-- Style +++++++++++++ -->
   <link rel="stylesheet" href="<?php echo plugins_url('RunClickPlugin/css/font-awesome.css')?>">
    <!--[if IE 7]>
	<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
	<![endif]-->

<!-- Js +++++++++++++ -->

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url('RunClickPlugin/js/hangout_custom.js')?>"></script>
    
<link rel='stylesheet' id='prefix-style-countdown-css-css'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/countdown.css?ver=3.5.1' type='text/css' media='all' />
<link rel='stylesheet' id='hangout-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<link rel='stylesheet' id='g_hangout_skin-css'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/skins/basic/style.min.css?ver=3.5.1' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/bootstrap.css' type='text/css' media='all' />
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/comment-reply.min.js?ver=3.5.1'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/jquery/jquery.js?ver=1.8.3'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/jquery.easing.min.js?ver=3.5.1'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/jquery.autosize.min.js?ver=3.5.1'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/cookie.min.js?ver=3.5.1'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var g_hangout = {"ajaxurl": "<?php echo site_url(); ?>\/wp-admin\/admin-ajax.php","plugin_url":"<?php echo site_url(); ?>\/wp-content\/plugins\/RunClickPlugin","tr_no_one_online":"No one is online","tr_logout":"Logout","tr_sending":"Sending","tr_in_chat_header":"Now Chatting","tr_offline_header":"Contact us","use_css_anim":"1","delay":"2","is_admin":"","is_op":"1"};
var site_url	=	"<?php echo site_url(); ?>";
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/assets/js/App.min.js?ver=3.5.1'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo site_url();?>/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo site_url();?>/wp-includes/wlwmanifest.xml" /> 

<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<style type="text/css" media="print">#wpadminbar { display:none; }</style>

<!-- Developed By Ravi Prakash
25 May 2013 -->
<!-- new video code added by Arun Srivastava on 11/4/14 -->
<link rel="stylesheet" href="<?php echo plugins_url('RunClickPlugin/css/reveal.css');?>">
<script type="text/javascript">
var PLUGIN_URL = "<?php echo plugins_url('RunClickPlugin/');?>";
var eid        = "<?php echo $post->ID;?>";
</script>
<script src="<?php echo plugins_url('RunClickPlugin/js/jquery.reveal.js');?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('RunClickPlugin/js/modernizr.custom.js');?>" type="text/javascript" ></script>
<script src="http://afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script src="<?php echo plugins_url('RunClickPlugin/js/videoplayer_custom.js');?>" type="text/javascript"></script>


<link rel='stylesheet' id='g_hangout_inline_style'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/g_hangout_inline_style.css?ver=4.0.3' type='text/css' media='all' />

<!-- new video code added by Arun Srivastava on 11/4/14 -->
</head>


<?php 
error_reporting(0);
include('ghangout-style.php');
include_once('plugin_function.php');
$keep_reg_form	=	get_post_meta($post->ID,"keep_registration_form",true);	
$uploads = wp_upload_dir();
$uploads_dir = $uploads['baseurl'];
$enable_header=get_post_meta($post->ID, "ghanghout_make_live_enable_header", true);
$enable_sharing=get_post_meta($post->ID, "ghanghout_make_live_enable_sharing", true);

$logo_src=get_post_meta($post->ID, "ghanghout_make_live_logo", true);
if($logo_src!=''){
	$logo =  $uploads_dir.'/'.$logo_src;
}
$logo_text=get_post_meta($post->ID, "ghanghout_make_live_logo_text", true);
$logo_family=get_post_meta($post->ID, "ghanghout_make_live_logo_family", true);
$logo_size=get_post_meta($post->ID, "ghanghout_make_live_logo_size", true);
$logo_style=get_post_meta($post->ID, "ghanghout_make_live_logo_style", true);
$logo_color=get_post_meta($post->ID, "ghanghout_make_live_logo_color", true);
$logo_height=get_post_meta($post->ID, "ghanghout_make_live_logo_height", true);
$logo_spacing=get_post_meta($post->ID, "ghanghout_make_live_logo_spacing", true);
$logo_shadow=get_post_meta($post->ID, "ghanghout_make_live_logo_shadow", true);

if($logo_style=='Normal')$logo_style='normal';$logo_weight='normal';
if($logo_style=='Italic')$logo_style='italic';$logo_weight='normal';
if($logo_style=='Bold')$logo_style='normal';$logo_weight='bold';
if($logo_style=='Bold/Italic')$logo_style='italic';$logo_weight='bold';

if($logo_shadow=='Small'){$logo_shadow="1px 1px #777";}
elseif($logo_shadow=='Medium'){$logo_shadow="2px 2px #777";}
elseif($logo_shadow=='Large'){$logo_shadow="3px 3px #777";}
else{$logo_shadow = 'false';}
$layout	=	get_post_meta($post->ID,'g_hangout_make_live_layout_type',true);

// code for Stats
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$stat_result	=	$wpdb->get_results("select * from ".$wpdb->prefix."ghangout_stats where IP='".$ip_addr."' and live='1' and post_id='".get_the_ID()."'");
	if(count($stat_result) <= 0 )
	{
		$wpdb->query("INSERT INTO ".$wpdb->prefix."ghangout_stats Values('','".get_the_ID()."','".$ip_addr."','0','0','1','0')");	
	}
// code for Stats
	?>
	<style type="text/css">
	.logoText {
		font-family:<?php echo $logo_family; ?>; font-size:<?php echo $logo_size; ?>; font-weight:<?php echo $logo_weight; ?>; text-shadow:<?php echo $logo_shadow; ?>; line-height:<?php echo $logo_height; ?>; letter-spacing:<?php echo $logo_spacing; ?>px; color:<?php echo $logo_color; ?>;
	}
</style>
<?php
$post_id = $post->ID;


$headline=get_post_meta($post->ID, "ghanghout_make_live_headline", true);
$headline = str_replace("\n","<br>", $headline);
$membership_pass=1;
$headline_family=get_post_meta($post->ID, "ghanghout_make_live_headline_family", true);
$headline_size=get_post_meta($post->ID, "ghanghout_make_live_headline_size", true);
$headline_style=get_post_meta($post->ID, "ghanghout_make_live_headline_style", true);
$headline_color=get_post_meta($post->ID, "ghanghout_make_live_headline_color", true);
$headline_height=get_post_meta($post->ID, "ghanghout_make_live_headline_height", true);
$headline_spacing=get_post_meta($post->ID, "ghanghout_make_live_headline_spacing", true);
$headline_shadow=get_post_meta($post->ID, "ghanghout_make_live_headline_shadow", true);

if($headline_style=='Normal')$headline_style='normal';$headline_weight='normal';
if($headline_style=='Italic')$headline_style='italic';$headline_weight='normal';
if($headline_style=='Bold')$headline_style='normal';$headline_weight='bold';
if($headline_style=='Bold/Italic')$headline_style='italic';$headline_weight='bold';

if($headline_shadow=='Small'){$headline_shadow="1px 1px #777";}
elseif($headline_shadow=='Medium'){$headline_shadow="2px 2px #777";}
elseif($headline_shadow=='Large'){$headline_shadow="3px 3px #777";}
else{$headline_shadow = 'false';}

$subhead=get_post_meta($post->ID, "ghanghout_make_live_subhead", true);
$subhead = str_replace("\n","<br>", $subhead);
$subhead_family=get_post_meta($post->ID, "ghanghout_subhead_family", true);
$subhead_size=get_post_meta($post->ID, "ghanghout_subhead_size", true);
$subhead_style=get_post_meta($post->ID, "ghanghout_make_live_subhead_style", true);
$subhead_color=get_post_meta($post->ID, "ghanghout_make_live_subhead_color", true);
$subhead_height=get_post_meta($post->ID, "ghanghout_make_live_subhead_height", true);
$subhead_spacing=get_post_meta($post->ID, "ghanghout_make_live_subhead_spacing", true);
$subhead_shadow=get_post_meta($post->ID, "ghanghout_make_live_subhead_shadow", true);

if($subhead_style=='Normal')$subhead_style='normal';$subhead_weight='normal';
if($subhead_style=='Italic')$subhead_style='italic';$subhead_weight='normal';
if($subhead_style=='Bold')$subhead_style='normal';$subhead_weight='bold';
if($subhead_style=='Bold/Italic')$subhead_style='italic';$subhead_weight='bold';

if($subhead_shadow=='Small'){$subhead_shadow="1px 1px #777";}
elseif($subhead_shadow=='Medium'){$subhead_shadow="2px 2px #777";}
elseif($subhead_shadow=='Large'){$subhead_shadow="1px 3px #777";}
else{$subhead_shadow = 'false';}


$editorval =	get_post_meta($post_id,"ghanghout_make_live_option1editor",true);
 
if($layout==1){

?>
<?php include "ghangout-style.php"; ?>
<style type="text/css">
	.ho_title_box h1{
		font-family:<?php echo $headline_family; ?>; font-size:<?php echo $headline_size; ?>; font-weight:<?php echo $headline_weight; ?>; text-shadow:<?php echo $headline_shadow; ?>; line-height:<?php echo $headline_height; ?>; letter-spacing:<?php echo $headline_spacing; ?>px; color:<?php echo $headline_color; ?>;
	}
	.ho_title_box h2{
		font-family:<?php echo $subhead_family; ?>; font-size:<?php echo $subhead_size; ?>; font-weight:<?php echo $subhead_weight; ?>; text-shadow:<?php echo $subhead_shadow; ?>; line-height:<?php echo $subhead_height; ?>; letter-spacing:<?php echo $subhead_spacing; ?>px; color:<?php echo $subhead_color; ?>;
	}
</style>
<body>
	<div id="wrap">
		<!-- Start Header -->
		<div id="ho_header">
			<div class="container">
				<div class="row-fluid">
					<div class="span4">
						<a class="logo" href="#">
						<?php if($logo){ ?>
							<?php if($enable_header == "checked"){ ?>
						  		<img border="0" src="<?php echo $logo; ?>">
						  	<?php } ?>		
						<?php }
						if($enable_header == "checked" and $logo == '') { ?>
						  <div class="logoText"><?php echo $logo_text; ?></div>
						<?php } ?>
						</a>
					</div>
					<div class="span8">
						<div class="ho_social_shear">
							<?php if($enable_sharing=='checked'){?>
							   <div class="sharing">
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(get_the_ID()); ?>" data-lang="en" data-related="anywhereTheJavascriptAPI">Tweet</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								
									<!-- Facebook share button Start -->
									<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo get_permalink(get_the_ID());?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									<!-- Facebook share button End -->
								
									<div class="g-plusone" data-href="<?php the_permalink(get_the_ID()); ?>" data-annotation="none" data-size="medium"></div>
									<script type="text/javascript">
									  window.___gcfg = {parsetags: 'onload'};
									  (function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script>
								</div>
							<?php } ?>
							<!-- AddThis Button END -->
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="row-fluid">
					<div class="ho_title_box">
						<?php if($headline){ ?>
							<h1><?php echo $headline; ?></h1>
						<?php } ?>	
						<?php if($subhead){ ?>
						<h2><?php echo $subhead; ?></h2>
						<?php } ?>	
					</div>
				</div>
			</div>
		</div>
		<!-- End Header -->
	 	<div class="clear"></div>
		<!-- Start Content -->
		<div id="ho_content">
			<div class="container">
				<?php
				if($membership_pass=='1'){
					
					 $editorval= get_post_meta($post->ID,'ghanghout_make_live_option1editor',true);
					 echo $content1 = apply_filters('the_content', $editorval);
				}else { ?>
								<div class="row-fluid ff-hh">
									<div class="ho_contentin">
										<div class="ho_registation">
											
												<div class="ho_block"><h2><?php echo $member_msg; ?></h2></div>
												
												<div class="clear"></div>
											
										</div>
									</div>
								</div>
				<?php } ?>	

			</div>
		</div>
		<!-- End Content -->
		<div class="clear"></div>
	</div>
	
	<div class="clear"></div>
	
    <!-- Start Footer -->
	<div id="ho_footer">
		<div class="container">
			<div class="row-fluid">
				<div class="ho_copy">
				<?php 
					$attribution_link = get_option('attribution_link');
					if($attribution_link=='1'){
						
						if(get_option('hangout_affiliate_text')==''){
							$hangout_affiliate_text = 'Powered By RunClick';
						}else{
							$hangout_affiliate_text=get_option('hangout_affiliate_text');
						}
						$link = get_option('hangout_youtube_affiliate_link');
						if(get_option('hangout_youtube_affiliate_link')==''){
							$link = 'http://runclick.com';
						}
						echo '<a href="'.$link.'" target="_blank">'.$hangout_affiliate_text.'</a>';
					}
					?> 
				</div>
			</div>
		</div>
	</div>
	<!-- End Footer -->	
	<div class="clear"></div>	
<?php }  else { ?>
<?php include "ghangout-style.php"; ?>
<style type="text/css">
	.ho_title_box h1{
		font-family:<?php echo $headline_family; ?>; font-size:<?php echo $headline_size; ?>; font-weight:<?php echo $headline_weight; ?>; text-shadow:<?php echo $headline_shadow; ?>; line-height:<?php echo $headline_height; ?>; letter-spacing:<?php echo $headline_spacing; ?>px; color:<?php echo $headline_color; ?>;
	}
	.ho_title_box h2{
		font-family:<?php echo $subhead_family; ?>; font-size:<?php echo $subhead_size; ?>; font-weight:<?php echo $subhead_weight; ?>; text-shadow:<?php echo $subhead_shadow; ?>; line-height:<?php echo $subhead_height; ?>; letter-spacing:<?php echo $subhead_spacing; ?>px; color:<?php echo $subhead_color; ?>;
	}
</style>
<?php		$full_banner=get_post_meta($post->ID, "ghanghout_make_live_full_banner_image", true); ?>
<body style="background:url('<?php echo $uploads_dir.'/'. $full_banner; ?>') center center fixed no-repeat; 
-moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover;">
	<div id="wrap">
		<!-- Start Header -->
		<div id="ho_header">
			<div class="container">
				<div class="row-fluid">
					<div class="span4">
						<a class="logo" href="#">
						<?php if($logo){ ?>
							<?php if($enable_header == "checked"){ ?>
						  		<img border="0" src="<?php echo $logo; ?>">
						  	<?php } ?>		
						<?php }
						if($enable_header == "checked" and $logo == '') { ?>
						  <div class="logoText"><?php echo $logo_text; ?></div>
						<?php } ?>
						</a>
					</div>
					<div class="span8">
						<div class="ho_social_shear">
							<?php if($enable_sharing=='checked'){?>
							   <div class="sharing">
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(get_the_ID()); ?>" data-lang="en" data-related="anywhereTheJavascriptAPI">Tweet</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								
									<!-- Facebook share button Start -->
									<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo get_permalink(get_the_ID());?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
									<!-- Facebook share button End -->
								
									<div class="g-plusone" data-href="<?php the_permalink(get_the_ID()); ?>" data-annotation="none" data-size="medium"></div>
									<script type="text/javascript">
									  window.___gcfg = {parsetags: 'onload'};
									  (function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script>
								</div>
							<?php } ?>
							<!-- AddThis Button END -->
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="row-fluid">
					<div class="ho_title_box">
						<?php if($headline){ ?>
							<h1><?php echo $headline; ?></h1>
						<?php } ?>	
						<?php if($subhead){ ?>
						<h2><?php echo $subhead; ?></h2>
						<?php } ?>	
					</div>
				</div>
			</div>
		</div>
		<!-- End Header -->
	 	<div class="clear"></div>
		<!-- Start Content -->
		<div id="ho_content">
			<div class="container">
				<?php
				if($membership_pass=='1'){
					 $editorval = get_post_meta($post->ID,'ghanghout_make_live_option1editor',true);
					 echo $content1 = apply_filters('the_content', $editorval);
				}else { ?>
								<div class="row-fluid ff-hh">
									<div class="ho_contentin">
										<div class="ho_registation">
											
												<div class="ho_block"><h2><?php echo $member_msg; ?></h2></div>
												
												<div class="clear"></div>
											
										</div>
									</div>
								</div>
				<?php } ?>	

			</div>
		</div>
		<!-- End Content -->
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<!-- Start Footer -->
	<div id="ho_footer">
		<div class="container">
			<div class="row-fluid">
				<div class="ho_copy">
				<?php 
						$attribution_link = get_option('attribution_link');
						if($attribution_link=='1'){
							
							if(get_option('hangout_affiliate_text')==''){
								$hangout_affiliate_text = 'Powered By RunClick';
							}else{
								$hangout_affiliate_text=get_option('hangout_affiliate_text');
							}
							$link = get_option('hangout_youtube_affiliate_link');
							if(get_option('hangout_youtube_affiliate_link')==''){
								$link = 'http://runclick.com';
							}
							echo '<a href="'.$link.'" target="_blank">'.$hangout_affiliate_text.'</a>';
						}
						?> 
				</div>
			</div>
		</div>
	</div>
	<!-- End Footer -->
<?php																			
}
if(get_post_meta($post->ID,'chat_make_off_replay',true)==1){
	wp_google_hangout();
}
	
?>
<?php 
 if(get_post_meta($post_id,'vote_show_on_live',true)==""){
		$vote_show_on_live=1;
	 }else{
	 $vote_show_on_live          = get_post_meta($post_id,'vote_show_on_live',true);
	 $vote_show_on_live			=$vote_show_on_live+1;
	 }
	  $buybuttonshow_on_live = get_post_meta($post_id,'buybuttonshow_on_live',true);
	 if($buybuttonshow_on_live==""){
		$buybuttonshow_on_live=0;
	 }
$buybuttonhtml       = get_post_meta($post->ID,'buybuttonhtml',true);
$buybuttonhtml_array=unserialize(base64_decode($buybuttonhtml));

$total_questions       = get_post_meta($post->ID,"total_questions", true);
if($total_questions=='')
	$total_questions	=	110;

$vote_question       = json_decode(get_post_meta($post->ID,"vote_question", true));


if(empty($vote_question))
	$vote_question->{'110'}	=	'';
$vote_options        = json_decode(get_post_meta($post->ID,"vote_options", true));
if(empty($vote_options))
	$vote_options->{'110'}	=	'';
$vote_correct_option = json_decode(get_post_meta($post->ID,"vote_correct_option", true));
if(empty($vote_correct_option))
	$vote_correct_option->{'110'}	=	'';

$pop_up_vote_button	=	'';
$pop_vote_id=1;
for($i=110;$i<=$total_questions;$i++){ 
	if(!isset($vote_question->{$i}))
		continue;

$pop_up_vote_button.='<a href="javascript:void(0);" data-reveal-id="myvoteModal'.$pop_vote_id.'" id="clicktoopenpopup3'.$pop_vote_id.'">&nbsp;</a>
			<div id="myvoteModal'.$pop_vote_id.'" class="reveal-modal bottom" rel="0" style="top:400px;">
				<h1>Please Vote</h1><div class="md_body">';
				$pop_up_vote_button   .= '<div id="vote_hangout_form"><div id="voteoutput'.$i.'"></div>';
				$pop_up_vote_button   .= '<span>'.$vote_question->{$i}.'</span>'."<br />";
				$options = explode('__', $vote_options->{$i});
				foreach($options as $option)
				{
					$pop_up_vote_button   .= '<div class="hh_vote"><input type="radio" name="vote_answer" class="vote_options'.$i.'" value="'.$option.'">&nbsp;'.$option."</div>";
				}
				$pop_up_vote_button   .= '<input option_number='.$i.' type="button" class="hangout_btn btn btn-warning addvotefrompop" value="Vote" id="addvotefrompop'.$pop_vote_id.'">';
				$pop_up_vote_button   .= '</div></div>
			</div>';
$pop_vote_id++;	
}
$vote_options        = get_post_meta($post->ID, "vote_options", true);

$vote_correct_option = get_post_meta($post->ID, "vote_correct_option", true);

$form .= '<a href="javascript:void(0);" data-reveal-id="myModal23" id="clicktoopenpopup2">&nbsp;</a>
			<div id="myModal23" class="reveal-modal"  rel="0">
				'.stripcslashes($buybuttonhtml_array[$buybuttonshow_on_live]).'
				<a class="close-reveal-modal" style="display:none;">&nbsp;</a>
			</div>

				'.$pop_up_vote_button;

			$content1 .= '<div id="ajax_loader" style="position: fixed; width:300px; height: 300px; z-index: 1070; top: 600px; left: 600px; display: none; background: none; border: 0px solid #259BB8;"><img src="'.plugin_dir_url(__FILE__).'images/ajax-loader.gif"></div>';

	$content .=  $form;
	
	echo $content;


?>		

<input type="hidden" id="buy_now_model_status">
<input type="hidden" id="vote_model_status">
<script>

var setT;
jQuery(function ($) {

setT = setTimeout("pushPopCheck()",10000);


     });
 
function pushPopCheck(){
var  post_id=   <?php echo $post->ID; ?>;
		
		var ajaxurl = "<?php echo plugin_dir_url(__FILE__); ?>ajax_for_pop_up.php";
		jQuery.post(ajaxurl, function (response) {
 
                    // If the server returns '1', then we can mark this post as read, so we'll hide the checkbox
                    // container. Next time the user browses the index, this post won't appear
                 //alert(response);
				
				 //alert(post_id);
				var obj = jQuery.parseJSON( response );
				if(jQuery.isEmptyObject(obj[post_id])==false){
				 //alert(obj[post_id].vote);
					
				   buymodel = jQuery('#buy_now_model_status').val();
				   votemodel = jQuery('#vote_model_status').val();
				   if(obj[post_id].buy=='pull' && buymodel!='pull'){
						
					  jQuery('.close-reveal-modal').trigger('click');
					  jQuery('#buy_now_model_status').val('pull');
				   }
				   if(obj[post_id].vote=='pull' && votemodel!='pull'){
					
					  jQuery('.close-reveal-modal').trigger('click');
					  jQuery('#vote_model_status').val('pull');
				   }
				   if(obj[post_id].buy=='push' && buymodel!='push'){
						//alert('push');
						jQuery('#myModal23').reveal({
							animation: 'fadeAndPop',                   //fade, fadeAndPop, none
							animationspeed: 800,                       //how fast animtions are
							closeonbackgroundclick: false,              //if you click background will modal close?
							dismissmodalclass: 'close-reveal-modal'    //the class of a button or element that will close an open modal
						});
						jQuery('#buy_now_model_status').val('push');
						jQuery('#myModal23').attr('rel', 1);
				  } 
				  
				  
				  
				  if(obj[post_id].vote=='push' && votemodel!='push'){
				  //alert('ok');
						jQuery('#myvoteModal<?php echo $vote_show_on_live;?>').reveal({
							animation: 'fadeAndPop',                   //fade, fadeAndPop, none
							animationspeed: 800,                       //how fast animtions are
							closeonbackgroundclick: false,              //if you click background will modal close?
							dismissmodalclass: 'close-reveal-modal'    //the class of a button or element that will close an open modal
						});
						jQuery('#myvoteModal<?php echo $vote_show_on_live;?>').attr('rel', 1);
						jQuery('#vote_model_status').val('push');
				  }
				  }
				// alert (response);
				   clearTimeout(setT);
				   setT = setTimeout("pushPopCheck()",10000);
				  
			});
		} 

</script>						
		
</body>
</html>