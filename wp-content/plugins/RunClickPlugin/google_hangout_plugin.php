<?php
/* Plugin Name: RunClick Webinar Plugin
 * Plugin URI: http://runclick.com

  * Description: Another <a href="http://www.universalmedia-online.com" target="_blank">UMO</a> plugin. Allowing you to create Webinars from hangouts with registrations and follow ups. <a href="http://runclick.com/changelog.txt" target="_blank" />Change Log </a>
 * Author URI: http://waltbayliss.com 
 * Version: 4.0.3
 * Requires at least: 3.4
 * Tested up to: 4.1
 *
 * Domain Path: /languages/
 */
 ob_start();
 class Umohangoutupdater
	{
		public $pluginversion	=	0;
		
		public $pluginslug		=	'hangout';
		
		public $plugindir		= '';
		
		public $serverurl		=	'http://hangoutplugin.com/updatesystem/index.php';
		
		public $isupdaterunning	=	0;
		
		public $updateversion	=	0;
		
		public $filestodelete	=	array();
		
		public $excludefiles	=	array('google_hangout_plugin.php' ,'layout.xml');

		function __construct()
		{	
				$this->pluginversion	=	get_option('umo_hangout_version');
				
				$this->plugindir		=	plugin_dir_path( __FILE__ );
				
				$this->isupdaterunning	=	get_option('umo_hangout_update_running');
				
				
				require_once('google_hangout_plugin_connector.php');
				add_action( 'wp_ajax_nopriv_live_popup_check', array( &$this, 'live_popup_check' ) );
				add_action( 'wp_ajax_live_popup_check', array( &$this, 'live_popup_check' ) );
				
		}
		
		function live_popup_check(){
			
			$live_buy_form_push	=	get_post_meta($_POST['post_id'],"live_buy_form_push",true);	
			$live_vote_form_push	=	get_post_meta($_POST['post_id'],"live_vote_form_push",true);	
			echo $live_buy_form_push.'-'.$live_vote_form_push.'-'.$_POST['post_id'];
			
		}
		
		function getFilesToDelete()
		{
			$dh		=	opendir( $this->plugindir );
			
			
			
			while( false !== ($file = readdir($dh) ) )
			{
				if( $file!=='.' && $file!=='..')
				{
					if(! is_dir($this->plugindir.$file) )
					{
					
						$flag = 1;
						
						foreach($this->excludefiles as $ex)
						{
							if( $ex === $file )
							{
								$flag = 0;
							}
							
						}
						
						if($flag)
							{
								$this->filestodelete[]	= $file;
							}
					
					}
				}
				
			}
			

		}
		
		function checkupdates()
		{
			
			$datastring		=	'action=check&plugin_slug='.$this->pluginslug.'&plugin_version='.$this->pluginversion;
			
			$result			=	$this->requestServer($datastring);
			if(array_key_exists('files', $result))
			{
				if(count($result['files']) >0)
				{
					update_option('hangout_updated_message',0);
				}
				else
				{
					update_option('hangout_updated_message',1);
				}
			}
			else
			{
				update_option('hangout_updated_message',1);
			}
			
			
			$isupdating		=	isset( $_POST['umo_hangout_update'] )?1:0;
			
			$intruptedupdate=	get_option('umo_hangout_update_files');
			
		
			if(is_array($intruptedupdate) )
			{	
				if( count($intruptedupdate) )
				{
					$isupdating	=1;

					
				}
			} 
			
			if($isupdating)
			{
				
				if($result['update']==='1')
				{
					if(! is_writable( $this->plugindir ) )
					{
						add_action('admin_notices',array(&$this,'showpermissionerror') );
					}
					else
					{
						$allfiles	=	(array) $result['files'];
						
						$allfiles	=	$allfiles['file'];
						
						$this->updateversion	=	$result['version'];
						
						update_option('umo_hangout_update_files',$allfiles);
						
						$this->doupdate();
						
						$result['update']='0';
					}
				}
				
			}
			
			if($result['update']=='1')
			{
				
				
				return "update";
			}
			else
			{
				
				return "ok";
			}
			
		}
		
		function doupdate()
		{
			$this->getFilesToDelete();
			
			
			foreach($this->filestodelete as $delfile)
			{
				$path = $this->plugindir.$delfile;
				
				if( file_exists($path) )
				{
					unlink($path);
				}
			}
			
			$filesqueue	=	get_option('umo_hangout_update_files');
			
			$filequeuetemp	= array_reverse( $filesqueue );
			
			foreach($filesqueue as $file)
			{
				
				$datastring		=	'action=update&plugin_slug='.$this->pluginslug.'&plugin_version='.$this->pluginversion.'&file='.$file;
			
				$response			=	$this->requestServer($datastring);
				
				if( $response['update'] ==1)
				{ 
					
					
					$data		=	$response['filebinary'];
					
					$data		=	base64_decode($data);
					
					if($file !='layout.xml'){
						if( file_put_contents($this->plugindir.$file,$data) )
						{
							array_pop($filequeuetemp);
						}
					}else{
						array_pop($filequeuetemp);
					}
					
				}
				if(count($filequeuetemp)==1){
				array_pop($filequeuetemp);
				}
				
				
				update_option('umo_hangout_update_files',$filequeuetemp);
				
			}
		
			if( ! count($filequeuetemp) || count($filequeuetemp)==1 )
			{
			
			
				update_option('umo_hangout_version',$this->updateversion);
				
				add_action( 'admin_notices',array(&$this,'showupdatesuccessmessage') );
				
				$currenttime	=	time();
				
				$endtime		=	$currenttime + 300;
				
				while( time() < $endtime )
				{
					$flag = 1;
					
					foreach($filesqueue as $ftcheck)
					{
						if(! file_exists($this->plugindir.$ftcheck) )
						{
							$flag = 0;
						}
					}
					
					if($flag) break;
					
					
				}
				
				update_option('umo_hangout_updated',1);
				
				
			}
			update_option('umo_hangout_updated',1);
			update_option('umo_hangout_updated_message',1);
			
			
		}
		
		
		function showupdatesuccessmessage()
		{
			echo '<div id="server-seo-update-success-message" class="updated fade" style=" height: 44px !important; padding-top: 5px !important;"><p><strong>Updated successfully.</strong> Runclick Plugin.</p></div>';
		}
		
		function showupdatemessage()
		{
			
			echo '<div id="server-seo-update-message" class="error" style=" min-height: 44px !important; padding-top: 5px !important;"><p><strong>Please update</strong> Runclick Plugin. <span id="seo-server-update-progress" style="display:none;" >Updating <img src="http://www.tantrasxm.com/images/gallery-loader.gif"  /> Don\'t close window while update is in progress. </span> <a onclick="document.getElementById(\'seo-server-update-link\').style.display=\'none\';  document.getElementById(\'seo-server-update-progress\').style.display=\'block\';" id="seo-server-update-link" href="javascript:void(0);">click here to update</a></p></div>';
		}
		
		function showpermissionerror()
		{
			echo '<div id="server-seo-perm-message" class="error" style=" height: 44px !important; padding-top: 5px !important;"><p><strong>update failed </strong> Runclick Plugin folder is not writable. </p></div>';
		}
		

		function requestServer($datastring)
		{
		 
		
			$ch		=	curl_init($this->serverurl);
			
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$datastring);						
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			
			$output	=	curl_exec($ch);
			
			if($output === false)
			{
				curl_close($ch); 
				$response	=	"<response><update>0</update><version>0</version></response>";
				return $response;
			}
			else
			{
			curl_close($ch); //free system resources

			$response	=	simplexml_load_string($output);
			
			$response	=	(array) $response;
			
			return $response;
			}
		}		

		
	}

	$umohangoutupdater	=	new Umohangoutupdater();
	register_activation_hook( __FILE__, array('GoogleHangoutPlugin', 'install') );	    
	register_deactivation_hook( __FILE__, array('GoogleHangoutPlugin', 'uninstall') );
		
	/* Cron Job Code Edited By Varun */
	add_filter('cron_schedules','google_hangout_cron_definer');
	add_filter('cron_schedules','google_hangout_cron_schedule_definer');
	
	function google_hangout_cron_definer($schedules)
	{
		global $wpdb;
		$hourresult	=	'60';
		$per_tym	=	'hour';

				$intrate	= $hourresult.'perhour';
				
				$inttime	=	3600/$hourresult;
				
				$schedules[$intrate] = array(
				  'interval'=> $inttime,
				  'display'=>  __( $hourresult.'times/hour')
				);
		return $schedules;
	}
	function google_hangout_cron_schedule_definer($schedules)
	{
		global $wpdb;
		$quaterresult	=	'12';
		$per_tym		=	'hour';

				$intrate	= $quaterresult.'perhour';
		
				$inttime	=	3600/$quaterresult;
		
				$schedules[$intrate] = array(
				  'interval'=> $inttime,
				  'display'=>  __( $quaterresult.'times/hour')
				);
		return $schedules;		
	}
	//code handle the corn actions
	add_action('hangout_cron_event', 'google_hangout_cron_mail');
	add_action('hangout_reminder_cron_event', 'google_hangout_reminder_cron');
	add_action('hangout_follow_cron_event', 'google_hangout_follow_cron');
	
	function google_hangout_cron_mail(){
		global $wpdb;
		$time=date('h:i:s');
		$wpdb->query("INSERT INTO testing_cron VALUES('','inserting-$time ')");
		include('cron.php');
	}
	
	function google_hangout_reminder_cron()
	{
	global $wpdb;
		//$wpdb->query('INSERT INTO testing_cron VALUES("","inserting")');
		include('reminder_cron.php');
		include('reminder_cron_record.php');
	}

	function google_hangout_follow_cron()
	{
		include('follow_cron.php');
	}
/* Cron Job Code Edited By Varun */	
// Define Constants
define( 'G_HANGOUT_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'G_HANGOUT_PLUGIN_URL', plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) ) );

// Prepare chat plugin
require G_HANGOUT_PLUGIN_PATH . '/core/prepare.php';


if ( ! class_exists( 'G_Hangout' ) ) {

/**
 * Main Screets Chat Class
 *
 * Contains the main functions for SC Chat, stores variables, and handles error messages
 *
 * @class G_Hangout
 * @package	G_Hangout
 */
class G_Hangout {

	/**
	 * @var string
	 */
	var $version = '1.2.5';
	
	/**
	 * @var string
	 */
	var $skin_url;
	
	/**
	 * @var array
	 */
	var $g_hangout_default_opts = array();
	
	/**
	 * @var array
	 */
	var $opts = array();
	
	
	
	/**
	 * Chat Constructor
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		
		// Include required files
		$this->includes();
		
		// Installation
		if ( is_admin() && ! defined('DOING_AJAX') ) $this->install();
		
		// Actions
		add_action( 'init', array( &$this, 'init' ), 0 );
		add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ), 0 );
		add_action( 'after_setup_theme', array( &$this, 'compatibility' ) );
		add_action( 'wp_print_styles', 'g_hangout_custom_frontend_styles' );
		
		// Loaded action
		do_action( 'g_hangout_loaded' );
		
	}
	
	
	/**
	 * Init Screets Chat when WordPress Initialises
	 *
	 * @access public
	 * @return void
	 */
	function init() {
		
		// Get options
		$this->opts = g_hangout_get_options();
		
		// Start session
		g_hangout_session_start();
		

		// Variables
		$this->skin_url = apply_filters( 'g_hangout_skin_url', 'skins/' . $this->opts['default_skin'] );
		
		// Classes/actions loaded for the Frontend and for Ajax requests
		if ( ! is_admin() || defined('DOING_AJAX') ) {
			
			add_action( 'wp_enqueue_scripts', array(&$this, 'init_frontend_scripts') );
			
		}
		
		if( is_admin() || defined( 'DOING_AJAX' ) ) {
			
			// Register admin styles and scripts
			add_action('admin_print_scripts', array(&$this, 'init_backend_scripts') );
		
		}
		
		// Session control on user data
		add_action( 'wp_login', array(&$this, 'destroy_session') );
		add_action( 'wp_logout', array(&$this, 'destroy_session') );
		
		// Add operator name to user fields
		add_action( 'show_user_profile', array(&$this, 'xtra_profile_fields'), 10 );
		add_action( 'edit_user_profile', array(&$this, 'xtra_profile_fields'), 10 );
		add_action( 'personal_options_update', array(&$this, 'save_xtra_profile_fields') );
		add_action( 'edit_user_profile_update', array(&$this, 'save_xtra_profile_fields') );
		
		// Show Conversation Box
		add_action( 'wp_google_hangout', array(&$this, 'show_chatbox') );
		// Shortcodes
		add_shortcode( 'chat_online', 'g_hangout_shortcode_online' );
		add_shortcode( 'chat_offline', 'g_hangout_shortcode_offline' );
		
		// Init action
		do_action( 'g_hangout_init' );
		
	}
	
	
	/**
	 * Init Screets Chat for back-end
	 *
	 * @access public
	 * @return void
	 */
	function admin_init() {
		global $wpdb;
		
		$current_page = '';
		$current_action = '';
		$logs = '';
			
		/**
		 * Administration role
		 */
		
		$admin_role = get_role( 'administrator' );
			
		// Add capabilities to admin
		$admin_role->add_cap( 'chat_with_users' ); 
		
		
		
		// Add meta boxes
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ), 0 );
		add_action( 'save_post', 'g_hangout_save_chat_opts', 0 );
		
		/** 
		 * Check logs
		 */
		if( !empty( $_REQUEST['page'] ) )
			$current_page = $_REQUEST['page'];
		
		
		if( $current_page == 'g_hangout_m_chat_logs' ) {
			
			// Get current action
			if( !empty( $_REQUEST['action'] ) )
				$current_action = $_REQUEST['action'];
			
			if( 'delete' === $current_action ) {
				
				// Prepare logs for deleting
				if( !empty( $_REQUEST['log'] ) )
					$logs = $_REQUEST['log'];
				else
					$logs = array( $_REQUEST['visitor_ID'] );
				
				// Delete logs one by one
				foreach( $logs as $visitor_ID ) {
				
					$deleted = $wpdb->query(
						$wpdb->prepare(
							'DELETE FROM ' . $wpdb->prefix . 'chat_logs
							WHERE visitor_ID = %d',
							$visitor_ID
						)
					);
					
				}
				
				function g_hangout_log_notice(){
					echo '<div class="updated">
					   <p>' . __( 'Chat Log has been deleted successfully', 'g_hangout' ) . '</p>
					</div>';
				}
					
				if( $deleted )
					add_action('admin_notices', 'g_hangout_log_notice');
							
			}
		}
	}
	
	/**
	 * Destroy Session
	 *
	 * @access public
	 * @return void
	 */
	function destroy_session() {
		
		// Destroy session
		$_SESSION['g_hangout'] = array(); // Clears the $_SESSION variable
		
	}
	
	/**
	 * Include required core files
	 *
	 * @access public
	 * @return void
	 */
	function includes() {
		
		// Back-end includes
		if(  is_admin() ) $this->admin_includes();
		
		// Include core files
		require G_HANGOUT_PLUGIN_PATH . '/core/class.chat.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/class.chat_base.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/class.chat_user.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/class.chat_line.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/fn.init.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/fn.options.php';
		
	}
	
	/**
	 * Include required admin files
	 *
	 * @access public
	 * @return void
	 */
	function admin_includes() {
		
		// Include admin files
		require G_HANGOUT_PLUGIN_PATH . '/core/fn.admin.php';
		require G_HANGOUT_PLUGIN_PATH . '/core/class.logs.php';
		
	}
	
	/**
	 * Get Ajax URL
	 *
	 * @access public
	 * @return string
	 */
	function ajax_url() {
	
		return str_replace( array('https:', 'http:'), '', admin_url( 'admin-ajax.php' ) );
		
	}
	
	/**
	 * Return the URL with https if SSL is on
	 *
	 * @access public
	 * @param string/array $content
	 * @return string/array
	 */
	function force_ssl( $content ) {
	
		if ( is_ssl() ) {
			if ( is_array($content) )
				$content = array_map( array( &$this, 'force_ssl' ) , $content );
			else
				$content = str_replace( 'http:', 'https:', $content );
		}
		return $content;
		
	}
	
	/**
	 * Localisation
	 *
	 * @access public
	 * @return void
	 */
	function load_plugin_textdomain() {
		
		load_plugin_textdomain( 'g_hangout', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );
		
	}
	
	/**
	 * Show Chat Box
	 *
	 * @access public
	 * @return void
	 */
	function show_chatbox() {
		global $wpdb;

		
		// Is there any online operator?
		$this->any_online_op = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'chat_online WHERE `type` = 1 AND `status` = 1 LIMIT 1' );
		
		// User is operator already?
		$this->is_user_op = true;
		
		// Show skin file
		if(
			
				$this->opts['display_chatbox'] == 1 
				or ( 
					$this->opts['display_chatbox'] == 0 
					and get_post_meta( get_the_ID(), 'g_hangout_opt_show_chatbox', true ) == 'on' 
					and !is_home() 
					and !is_front_page() 
				)
			
			
			or ( $this->opts['always_show_homepage'] == 1 and ( $this->opts['hide_chat_when_offline'] == 0 or $this->any_online_op ) and ( is_home() or is_front_page() ) )
			
		)
			$this->opts['display_chatbox'] = 1;

			require G_HANGOUT_PLUGIN_PATH . '/' . $this->skin_url . '/chatbox.php';
			
		
	}
	
	/**
	 * Add meta boxes
	 *
	 * @access public
	 * @return void
	 */
	function add_meta_boxes() {
		
		$screens = array( 'post', 'page' );
		
		foreach ($screens as $screen) {
			add_meta_box(
				'g_hangout_opts',
				__( 'Chat Options', 'g_hangout' ),
				'g_hangout_chat_render_opts_meta',
				$screen,
				'side'
			);
		}
		
	}
	
	
	/**
	 * Add xtra profile fields
	 *
	 * @access public
	 * @return void
	 */
	function xtra_profile_fields( $user ) { ?>
		
		<h3><?php _e( 'Chat Options', 'g_hangout' ); ?></h3>
 
		<table class="form-table">
			<tr>
				<th><label for="f_chat_op_name"><?php _e( 'Operator Name', 'g_hangout' ); ?></label></th>
				<td>
					<input type="text" name="g_hangout_op_name" id="f_chat_op_name" value="<?php echo esc_attr( get_the_author_meta( 'g_hangout_op_name', $user->ID ) ); ?>" class="regular-text" />
				</td>
			</tr>
		</table>

		
	<?php }
	
	
	/**
	 * Save xtra profile fields
	 *
	 * @access public
	 * @return void
	 */
	function save_xtra_profile_fields( $user_id ) {
		
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;
			
		// Op name isn't defined yet, create new one for user
		if( empty( $_POST['g_hangout_op_name'] ) ) {
			
			global $current_user;
			
			// Get currently logged user info
			get_currentuserinfo();
			
			$op_name = sanitize_key( $current_user->display_name );
		
		
		// Sanitize OP name
		} else
			$op_name = sanitize_key( $_POST['g_hangout_op_name'] );
		
		
		// Update user meta now
		update_user_meta( $user_id, 'g_hangout_op_name', $op_name );
		
	}
	
	
	/**
	 * Installation
	 *
	 * @access public
	 * @return void
	 */
	function install() {
		
		// Install the plugin on activation
		register_activation_hook( __FILE__, 'g_hangout_activate' ); 
		
	}
	
	
    
    
    /**
	 * Add Compatibility for various bits
	 *
	 * @access public
	 * @return void
	 */
	function compatibility() {
		global $g_hangout_default_opts;
		
		// First we check if our default plugin have been applied.
		$the_plugin_status = get_option( 'g_hangout_setup_status' );
        
        // Get current plugin version
		$current_version = get_option( 'g_hangout_plugin_version' );
		
       
      
		
		// If the settings has not yet been used we want to run our default settings.
		if ( $the_plugin_status != '1' ) {
			
			// Setup default theme settings
			add_option( 'g_hangout_opts', g_hangout_get_default_options( $g_hangout_default_opts ) );
			
			// Once done, we register our setting to make sure we don't duplicate everytime we activate.
			update_option( 'g_hangout_setup_status', '1' );
			
		}
			
	}
	
	
	/**
	 * Backend styles and scripts
	 *
	 * @access public
	 * @return void
	 */
	function init_backend_scripts() {
		global $current_user;
		
		$page = '';
		
		// Get currently logged user info
		get_currentuserinfo();
		
		// Get current page
		if( !empty( $_REQUEST['page'] ) )
			$page = $_REQUEST['page'];
			
		// Load spectrum stylesheet for only options page
		if( $page == 'g_hangout_m_chat_opts' ) {
			
			wp_register_style(
				'jquery_spectrum_css', 
				G_HANGOUT_PLUGIN_URL . '/assets/js/jquery.spectrum/spectrum.css'
			);
			wp_enqueue_style( 'jquery_spectrum_css' );
			
		}
		
		// Main admin stylesheet
		wp_register_style( 
			'g_hangout_admin_styles', 
			G_HANGOUT_PLUGIN_URL . '/assets/css/admin-style.css'
		);
		wp_enqueue_style( 'g_hangout_admin_styles' );
		
		// Load spectrum script for only options page
		if( $page == 'g_hangout_m_chat_opts' ) {
			wp_register_script( 
				'jquery_spectrum', 
				plugins_url('assets/js/jquery.spectrum/spectrum.js', __FILE__,
				array( 'jquery' ) )
			);
			wp_enqueue_script( 'jquery_spectrum' );
			
		}
		
		// Chat application script
		if( $page == 'sc_opt_pg_a' or $page == 'sc_opt_pg'  ) {
		
			wp_register_script( 
				'g_hangout_app_script', 
				plugins_url('assets/js/App.js', __FILE__,
				array( 'jquery' ) )
			);
			wp_enqueue_script( 'g_hangout_app_script' );
			
		}
		
		// Options page script
		if( $page == 'g_hangout_m_chat_opts' ) {
			wp_register_script( 
				'g_hangout_opts', 
				plugins_url('assets/js/options.js', __FILE__,
				array( 'jquery' ) )
			);
			wp_enqueue_script( 'g_hangout_opts' );
		}
	
		// Custom Data
		$ajax_vars = array(
			'ajaxurl'   			=> admin_url( 'admin-ajax.php' ),
			'plugin_url'   			=> G_HANGOUT_PLUGIN_URL,
			'tr_no_one_online'		=> __( 'No one is online', 'g_hangout' ),
			'tr_1_person_online'	=> __( '1 person online', 'g_hangout' ),
			'tr_x_people_online'	=> __( '%s people online', 'g_hangout' ),
			'tr_write_a_reply'		=> __( 'Write a reply', 'g_hangout' ),
			'tr_click_to_chat'		=> __( 'Click ENTER to chat', 'g_hangout' ),
			'tr_logout'				=> __( 'Logout', 'g_hangout' ),
			'tr_online'				=> __( 'Online', 'g_hangout' ),
			'tr_offline'			=> __( 'Offline', 'g_hangout' ),
			'tr_cnv_ended'			=> __( 'This conversation has ended', 'g_hangout' ),
			'tr_sending'			=> __( 'Sending', 'g_hangout' ),
			'tr_chat_logs'			=> __( 'Chat Logs', 'g_hangout' ),
			'tr_loading'			=> __( 'Loading', 'g_hangout' ),
			'user_ID'				=> $current_user->user_ID,
			'username'				=> g_hangout_get_operator_name(),
			'email'					=> $current_user->user_email,
			'is_admin'   			=> true
		);

		wp_localize_script( 'g_hangout_app_script', 'g_hangout', $ajax_vars );
	}
	
	
	/**
	 * Frontend styles and scripts
	 *
	 * @access public
	 * @return void
	 */
	function init_frontend_scripts() {
		
		// Skin stylesheet
		$suffix_css = ( $this->opts['compress_css'] == 1 ) ? '.min' : '';
		
		if( $this->opts['load_skin_css'] == 1 ) {
			wp_register_style(
				'g_hangout_skin', 
				plugins_url( 'skins/basic', __FILE__ )  . '/style' . $suffix_css . '.css'
			);
			wp_enqueue_style( 'g_hangout_skin' );
		}
		
		// Use jquery on front-end
		wp_enqueue_script( 'jquery' );
		
		// Easing Plugin
		wp_register_script( 
			'jquery_easing', 
			plugins_url( 'assets/js/jquery.easing.min.js', __FILE__,
			array( 'jquery' ) )
		);
		wp_enqueue_script( 'jquery_easing' );
		
		// Autosize Plugin
		wp_register_script( 
			'jquery_autosize', 
			plugins_url( 'assets/js/jquery.autosize.min.js', __FILE__,
			array( 'jquery' ) )
		);
		wp_enqueue_script( 'jquery_autosize' );
		
		// Cookie Plugin
		wp_register_script( 
			'jquery_cookie', 
			plugins_url( 'assets/js/cookie.min.js', __FILE__,
			array( 'jquery' ) )
		);
		wp_enqueue_script( 'jquery_cookie' );
		
		// Application script
		wp_register_script( 
			'g_hangout_app_script', 
			plugins_url( 'assets/js/App.min.js', __FILE__,
			array( 'jquery' ) )
		);
		wp_enqueue_script( 'g_hangout_app_script' );
		
		
		// Custom Data
		$ajax_vars = array(
			'ajaxurl'   			=> admin_url( 'admin-ajax.php' ),
            'plugin_url'   			=> G_HANGOUT_PLUGIN_URL,
			'tr_no_one_online'		=> __( 'No one is online', 'g_hangout' ),
			'tr_logout'				=> __( 'Logout', 'g_hangout' ),
			'tr_sending'			=> __( 'Sending', 'g_hangout' ),
			'tr_in_chat_header'		=> $this->opts['in_chat_header'],
			'tr_offline_header'		=> $this->opts['offline_header'],
			'use_css_anim'			=> $this->opts['use_css_anim'],
			'delay'					=> $this->opts['delay'],
			'is_admin'   			=> false,
			'is_op'	   				=> current_user_can('chat_with_users') // Only for appearance fx
		);

		wp_localize_script( 'g_hangout_app_script', 'g_hangout', $ajax_vars );
		
	}
}

// Init Chat class
$GLOBALS['G_Hangout'] = new G_Hangout();


} // class_exists

// Take over the Plugin info screen
	

	function g_hangout_plugin_api_call($def, $action, $args) {
		global $g_hangout_plugin_slug, $g_hangout_api_url, $wp_version;
		
		if (!isset($args->slug) || ($args->slug != $g_hangout_plugin_slug))
			return false;
		
		// Get the current version
		$plugin_info = get_site_transient('update_plugins');
		$current_version = $plugin_info->checked[$g_hangout_plugin_slug .'/'. $g_hangout_plugin_slug .'.php'];
		$args->version = $current_version;
		
		$request_string = array(
				'body' => array(
					'action' => $action, 
					'request' => serialize($args),
					'api-key' => md5(get_bloginfo('url'))
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . site_url()
			);
		
		$request = wp_remote_post($g_hangout_api_url, $request_string);
		
		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
		} else {
			$res = unserialize($request['body']);
			
			if ($res === false)
				$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
		}
		
		return $res;
	}
	
add_action( 'wp_ajax_nopriv_ghangout_form_submit', 'ghangout_form_submit_callback' );
add_action( 'wp_ajax_ghangout_form_submit', 'ghangout_form_submit_callback' );
function ghangout_form_submit_callback(){

   include('ajax.php');

die;
}
add_action( 'wp_ajax_nopriv_ghangout_pop_up_form_submit', 'ghangout_pop_up_form_submit_callback' );
add_action( 'wp_ajax_ghangout_pop_up_form_submit', 'ghangout_pop_up_form_submit_callback' );
function ghangout_ghangout_pop_up_form_submit_callback(){

   include('ajax_popup_contact_form.php');

die;
}	
add_action( 'wp_ajax_nopriv_ghangout_template_form_submit', 'ghangout_template_form_submit_callback' );
add_action( 'wp_ajax_ghangout_template_form_submit', 'ghangout_template_form_submit_callback' );
function ghangout_template_form_submit_callback(){

   include('ajax_contact_form.php');

die;
}	
add_action( 'wp_ajax_nopriv_ghangout_aweber_set_up', 'ghangout_aweber_set_up_callback' );
add_action( 'wp_ajax_ghangout_aweber_set_up', 'ghangout_aweber_set_up_callback' );
function ghangout_aweber_set_up_callback(){

   include('ajax_set_up_aweber.php');

die;
}	
add_action( 'wp_ajax_nopriv_ghangout_webinar_status', 'ghangout_webinar_status_callback' );
add_action( 'wp_ajax_ghangout_webinar_status', 'ghangout_webinar_status_callback' );
function ghangout_webinar_status_callback(){

   include('hangout_status.php');

die;
}	
add_action( 'wp_ajax_nopriv_ghangout_pop_up_form_vote', 'ghangout_pop_up_form_vote_callback' );
add_action( 'wp_ajax_ghangout_pop_up_form_vote', 'ghangout_pop_up_form_vote_callback' );
function ghangout_pop_up_form_vote_callback(){

   include('submitvote.php');

die;
}

