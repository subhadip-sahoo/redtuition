<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" >

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
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


<link rel='stylesheet' id='g_hangout_inline_style'  href='<?php echo site_url();?>/wp-content/plugins/RunClickPlugin/css/g_hangout_inline_style.css?ver=4.0.3' type='text/css' media='all' />

<!-- Developed By Ravi Prakash
25 May 2013 -->
</head>


<?php
include('ghangout-style.php');
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

if($logo_shadow=='Small'){$logo_shadow="'1px 1px #777'";}
elseif($logo_shadow=='Medium'){$logo_shadow="'2px 2px #777'";}
elseif($logo_shadow=='Large'){$logo_shadow="'3px 3px #777'";}
else{$logo_shadow = 'false';}
$layout	=	get_post_meta($post->ID,'g_hangout_make_live_layout_type',true);

$post_id = $post->ID;


$headline=get_post_meta($post->ID, "ghanghout_make_live_headline", true);
$headline = str_replace("\n","<br>", $headline);

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

if($headline_shadow=='Small'){$headline_shadow="'1px 1px #777'";}
elseif($headline_shadow=='Medium'){$headline_shadow="'2px 2px #777'";}
elseif($headline_shadow=='Large'){$headline_shadow="'3px 3px #777'";}
else{$headline_shadow = 'false';}

$subhead=get_post_meta($post->ID, "ghanghout_subhead", true);
$subhead = str_replace("\n","<br>", $subhead);
$subhead_family=get_post_meta($post->ID, "ghanghout_make_live_subhead_family", true);
$subhead_size=get_post_meta($post->ID, "ghanghout_make_live_subhead_size", true);
$subhead_style=get_post_meta($post->ID, "ghanghout_make_live_subhead_style", true);
$subhead_color=get_post_meta($post->ID, "ghanghout_make_live_subhead_color", true);
$subhead_height=get_post_meta($post->ID, "ghanghout_make_live_subhead_height", true);
$subhead_spacing=get_post_meta($post->ID, "ghanghout_make_live_subhead_spacing", true);
$subhead_shadow=get_post_meta($post->ID, "ghanghout_make_live_subhead_shadow", true);

if($subhead_style=='Normal')$subhead_style='normal';$subhead_weight='normal';
if($subhead_style=='Italic')$subhead_style='italic';$subhead_weight='normal';
if($subhead_style=='Bold')$subhead_style='normal';$subhead_weight='bold';
if($subhead_style=='Bold/Italic')$subhead_style='italic';$subhead_weight='bold';

if($subhead_shadow=='Small'){$subhead_shadow="'1px 1px #777'";}
elseif($subhead_shadow=='Medium'){$subhead_shadow="'2px 2px #777'";}
elseif($subhead_shadow=='Large'){$subhead_shadow="'3px 3px #777'";}
else{$subhead_shadow = 'false';}


$editorval =	get_post_meta($post_id,"ghanghout_make_live_option1editor",true);






?>
<?php include "ghangout-style.php"; ?>
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
						if($enable_header != "checked" and $logo=='') { ?>
						  <div class="logoText"><?php echo $logo_text; ?></div>
						<?php } ?>
						</a>
					</div>
					<div class="span8">
						<div class="ho_social_shear">
							<?if($enable_sharing=='checked'):?>
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
							<?endif;?>
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
				<p style="style='text-align: center;'"><h2>Your Webinar is Closed</h2></p>
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
<?php  	 
//wp_google_hangout();
?>

</body>
</html>
