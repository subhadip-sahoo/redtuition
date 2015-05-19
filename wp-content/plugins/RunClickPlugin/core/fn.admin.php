<?php
/**
 * SCREETS © 2013
 *
 * Administration functions
 *
 */

add_action( 'admin_menu', 'g_hangout_admin_menu', 9 );


/**
 * Install the plugin on activation
 *
 * @access public
 * @return void
 */
function g_hangout_activate() {
	global $wpdb;
	
	
	// Create chat lines
	$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "chat_lines` (
		  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `author` varchar(32) DEFAULT NULL,
		  `gravatar` varchar(32) DEFAULT NULL,
		  `receiver_ID` varchar(32) NOT NULL DEFAULT 'OP',
		  `chat_line` varchar(700) NOT NULL,
		  `chat_date` int(10) NOT NULL,
		  PRIMARY KEY (`ID`),
		  KEY `chat_date` (`chat_date`)
		) DEFAULT CHARSET=utf8;"
	);
				
				
	// Create chat logs table
	$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "chat_logs` (
		  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `visitor_ID` int(10) unsigned NOT NULL,
		  `chat_date` int(10) NOT NULL,
		  `sender` varchar(32) DEFAULT NULL,
		  `sender_email` varchar(64) DEFAULT NULL,
		  `chat_line` varchar(700) NOT NULL,
		  PRIMARY KEY (`ID`),
		  KEY `chat_date` (`chat_date`)
		) DEFAULT CHARSET=utf8;"
	);
	

	// Create chat online table
	$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "chat_online` (
		  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `visitor_ID` int(10) unsigned DEFAULT NULL,
		  `name` varchar(32) DEFAULT NULL,
		  `email` varchar(64) DEFAULT NULL,
		  `gravatar` varchar(32) DEFAULT NULL,
		  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `ip_address` int(11) unsigned DEFAULT NULL,
		  `user_agent` varchar(120) DEFAULT NULL,
		  `type` tinyint(1) NOT NULL DEFAULT '1',
		  `status` tinyint(1) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`ID`),
		  UNIQUE KEY `name` (`name`),
		  KEY `last_activity` (`last_activity`),
		  KEY `status` (`status`)
		) DEFAULT CHARSET=utf8;"
	);

	// Create chat visitors table
	$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "chat_visitors` (
		  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) DEFAULT NULL,
		  `email` varchar(64) DEFAULT NULL,
		  `gravatar` varchar(32) DEFAULT NULL,
		  `ip_address` int(11) unsigned DEFAULT NULL,
		  `user_agent` varchar(120) DEFAULT NULL,
		  PRIMARY KEY (`ID`),
		  UNIQUE KEY `gravatar` (`gravatar`)
		) DEFAULT CHARSET=utf8;"
	);
	
	// Add user roles (Chat Operator and Chat User)
	add_role( 'g_hangout_op', __( 'Chat Operator', 'g_hangout' ), array('read' => true) );
	
		
}

/**
 * Render Chat Console Template
 *
 * @access public
 * @return void
*/
function g_hangout_console_template() {
	
	require G_HANGOUT_PLUGIN_PATH . '/core/templates/chat_console.php';
	
}


/**
 * Setup the Admin menu in WordPress
 *
 * @access public
 * @return void
 */
function g_hangout_admin_menu() {
	
	/**
	 * Menu for Admins
	 */

	 $hangout_chat_settings = get_option("hangout_chat_settings",true);
	 if($hangout_chat_settings==0){
			add_menu_page('', __('Chat Logs', 'g_hangout'), 'administrator', 'g_hangout_m_chat_logs', 'g_hangout_render_chat_logs', G_HANGOUT_PLUGIN_URL .'/assets/img/sc-icon-16.png', 40);
	
	 } else {
	 add_menu_page('', __('Chat Logs', 'g_hangout'), 'administrator', 'g_hangout_m_chat_logs', 'g_hangout_render_chat_logs', G_HANGOUT_PLUGIN_URL .'/assets/img/sc-icon-16.png', 40);
	//add_menu_page('', __('Chat Console', 'g_hangout'), 'administrator', 'sc_opt_pg_a', 'g_hangout_console_template', G_HANGOUT_PLUGIN_URL .'/assets/img/sc-icon-16.png', 40);
	
	// Chat logs
	add_submenu_page( 
		'g_hangout_m_chat_logs', 
		__('Chat Console', 'g_hangout'),
		__('Chat Console', 'g_hangout'),
		'administrator',
		'sc_opt_pg_a',
		'g_hangout_console_template'
	);
	
	// Options
	/*add_submenu_page( 
		'sc_opt_pg_a', 
		__('Chat Options', 'g_hangout'),
		__('Options', 'g_hangout'),
		'administrator',
		'g_hangout_m_chat_opts',
		'g_hangout_render_chat_opts'
	);*/
	 }
	
	/**
	 * Menu for Operators
	 */
	add_menu_page('', 'Chat Console', 'g_hangout_op', 'sc_opt_pg', 'g_hangout_console_template', G_HANGOUT_PLUGIN_URL .'/assets/img/sc-icon-16.png', 41);
	
	// Chat logs
	add_submenu_page( 
		'sc_opt_pg', 
		__('Chat Logs', 'g_hangout'),
		__('Logs', 'g_hangout'),
		'g_hangout_op',
		'g_hangout_m_chat_logs',
		'g_hangout_render_chat_logs'
	);
	

	// Call register options function
	//add_action( 'admin_init', 'g_hangout_register_options' );
	
}


/**
 * Get operator name
 *
 * @access public
 * @return string Operator name of user
 */
function g_hangout_get_operator_name( $user_id = null ) {
	
	if( empty( $user_id) )
		$user_id = get_current_user_id();
	
	// Get operator name
	$op_name = get_user_meta( $user_id, 'g_hangout_op_name', true );
	
	// Op name isn't defined yet, create new one for user
	if( empty( $op_name ) ) {
		
		global $current_user;
		
		// Get currently logged user info
		get_currentuserinfo();
		
		$op_name = sanitize_key( $current_user->display_name );
		
		// Update user meta as well (for later usage)
		update_user_meta( $user_id, 'g_hangout_op_name', $op_name );
	}
	
	return $op_name;
}


/**
 * Render chat options metabox
 *
 * @access public
 * @return void
 */
function g_hangout_chat_render_opts_meta( $post ) {
	global $post;
	
	// Get fields
    $f_show_chatbox = get_post_meta( $post->ID, 'g_hangout_opt_show_chatbox', true );  
	
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'g_hangout_opts_nonce' );
	
	// Print Show Chatbox field
	echo '<label for="g_hangout_opt_show_chatbox">';
	
	echo '<input type="checkbox" name="g_hangout_opt_show_chatbox" id="g_hangout_opt_show_chatbox" ' . checked( $f_show_chatbox, 'on', false ) . ' value="on" /> ' . __( 'Always show chatbox here', 'g_hangout' );
	 
	echo '</label>';

}


/**
 * Save chat options
 *
 * @access public
 * @return void
 */
function g_hangout_save_chat_opts( $post_id ) {
	
	$_nonce = '';
	
	// Verify if this is an auto save routine. 
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if( !empty( $_POST['g_hangout_opts_nonce'] ) )
		$_nonce = $_POST['g_hangout_opts_nonce'];
	
	// Verify this came from the our screen and with proper authorization
	if ( !wp_verify_nonce( $_nonce, plugin_basename( __FILE__ ) ) )
		return;
		
	// Check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
	}
	
	// Sanitize user input
	$f_show_chat_box = ( isset($_POST['g_hangout_opt_show_chatbox']) ) ? 'on' : 'off';
	
	// Add / update post metas
	add_post_meta( $post_id, 'g_hangout_opt_show_chatbox', $f_show_chat_box, true ) or update_post_meta( $post_id, 'g_hangout_opt_show_chatbox', $f_show_chat_box );

}


/**
 * Render chat logs page
 *
 * @access public
 * @return void
 */
function g_hangout_render_chat_logs() {
	global $wpdb;
	
	// Create an instance of our package class...
	$logs = new G_hangout_logs();
	
	// Fetch, prepare, sort, and filter our data...
	$logs->prepare_items();
    
	// Get visitor information
	if( !empty( $_REQUEST['visitor_ID'] ) ) {
		$visitor = $wpdb->get_row(
			$wpdb->prepare( 
				'SELECT * FROM ' . $wpdb->prefix . 'chat_visitors 
				WHERE `ID` = %d LIMIT 1',
				$_REQUEST['visitor_ID']
			)
		);
	}
	
	
    ?>
	
	<script type="text/javascript">
		jQuery(document).ready( function() {
			
			jQuery('.wp-list-table .delete a').click( function() {
				ask = confirm('<?php _e( 'Are you sure you want to delete?', 'g_hangout' ); ?>');
				
				if( ask == false )
					return false;
			});
			
		});
	</script>
	<style>
		.sc-page-icon { 
			background:url('<?php echo G_HANGOUT_PLUGIN_URL; ?>/assets/img/sc-icon-32.png') no-repeat; 
		}
	</style>
	
    <div class="wrap">
        
		<?php if( !empty( $visitor) or empty( $_REQUEST['action'] ) or isset( $_REQUEST['log_s']) ) { ?>
			<div class="sc-page-icon icon32"><br/></div>
			<h2>
				<?php 
				
				// Chat logs
				if( @$_REQUEST['action'] != 'edit' ) {
					
					_e( 'Chat Logs', 'g_hangout' );
				
				// Add visitor name and email
				} else {
					
					echo '<a href="?page=' . $_REQUEST['page'] .'">' . __( 'Chat Logs', 'g_hangout' ) . '</a>';
					
					echo ': ' . $visitor->name . ' (' . $visitor->email . ')';
					
				}
					
				?>
			
			</h2>
        
			<?php
			/**
			 * Show chat logs list
			 */
			if( @$_GET['action'] != 'edit' ): ?>
			
				<form method="get">
					
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
					
					<?php $logs->display(); ?>
					
				</form>
			
			<?php 
			/**
			 * Show single chat transcript
			 */
			else: 
				// Get log transcipt
				$transcript = $wpdb->get_results(
					$wpdb->prepare(
						'SELECT * FROM ' . $wpdb->prefix . 'chat_logs
						WHERE visitor_ID = %d',
						$_REQUEST['visitor_ID']
					)
				);
				
				
				?>
				
				<div class="g-hangout-transcript">
					<ul>
				
				<?php
				$i = 0;
				foreach( $transcript as $log ): ?>
					
					<li>
						
						<!-- Time -->
						<div class="g-hangout-trans-time">
							<?php echo date_i18n( get_option('date_format') .' H:i:s', $log->chat_date ); ?>
						</div>
						
						<!-- Author -->
						<div class="g-hangout-trans-author <?php echo ( !empty( $log->sender ) ) ? 'sc-sender' : 'sc-visitor'; ?>">
							<?php 
							if( !empty( $log->sender ) ) 
								echo '<a href="mailto:'.$log->sender_email.'">' . $log->sender . '</a>';
							else 
								echo '<a href="mailto:'.$visitor->email.'">' . $visitor->name . '</a>';
							?>
						</div>
						
						<!-- Message -->
						<div class="g-hangout-trans-msg">
							<?php echo $log->chat_line; ?>
						</div>
						
					</li>
					
				<?php
					$i++;
				
				endforeach;
				
				echo '</ul></div>';
			
			endif; ?>
		
		<?php } else { ?>
			
			<p>No chat log found for this user.</p>
			
		<?php } ?>
	</div>

<?php

}


/**
 * Get browser info
 *
 * @access public
 * @return array Browser info
 */
function g_hangout_browser_info( $user_agent = null ) {
	
	if( empty( $user_agent ) )
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = "";

	// First get the platform

	if (preg_match('/linux/i', $user_agent)) {
		$platform = 'Linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
		$platform = 'Mac';
	}
	elseif (preg_match('/windows|win32/i', $user_agent)) {
		$platform = 'Windows';
	}

	// Next get the name of the useragent yes seperately and for good reason

	if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
		$bname = 'Internet Explorer';
		$ub = "IE";
	}
	elseif (preg_match('/Firefox/i', $user_agent)) {
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	}
	elseif (preg_match('/Chrome/i', $user_agent)) {
		$bname = 'Google Chrome';
		$ub = "Chrome";
	}
	elseif (preg_match('/Safari/i', $user_agent)) {
		$bname = 'Apple Safari';
		$ub = "Safari";
	}
	elseif (preg_match('/Opera/i', $user_agent)) {
		$bname = 'Opera';
		$ub = "Opera";
	}
	elseif (preg_match('/Netscape/i', $user_agent)) {
		$bname = 'Netscape';
		$ub = "Netscape";
	}

	// Finally get the correct version number

	$known = array(
		'Version',
		$ub,
		'other'
	);
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

	if ( !preg_match_all( $pattern, $user_agent, $matches) ) {

		// We have no matching number just continue

	}

	// See how many we have

	$i = count($matches['browser']);

	if ($i != 1) {

		// we will have two since we are not using 'other' argument yet
		// See if version is before or after the name

		if (strripos($user_agent, "Version") < strripos($user_agent, $ub)) {
			$version = $matches['version'][0];
		}
		else {
			$version = $matches['version'][1];
		}
	}
	else
		$version = $matches['version'][0];
	

	// Check if we have a number

	if ($version == null || $version == "")
		$version = "?";

	
	// Make version simpler
	$_version = explode( '.', $version );
	
	$version = $_version[0];

	return array(
		'user_agent' 	=> $user_agent,
		'name' 			=> $ub,
		'version' 		=> $version,
		'platform' 		=> $platform,
		'pattern' 		=> $pattern
	);
	
}
?>