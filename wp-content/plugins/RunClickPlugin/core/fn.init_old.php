<?php
/**
 * SCREETS © 2013
 *
 * Initialization functions
 *
 */

/**
 * Ajax Callback
 *
 * @access public
 * @return void
 */
function g_hangout_ajax_callback() {
	
    
	$response = array();
	
	try {
		
		// Handling the supported actions:
		switch( $_GET['mode'] ) {
			
			case 'login':
				$response = Chat::login( 
									@$_POST['f_chat_user_name'], 
									@$_POST['f_chat_user_email'], 
									$_POST['f_chat_is_admin'] 
								);
			break;
			
			case 'send_contact_from':
				$response = Chat::send_contact_from( $_POST );
			break;
			
			case 'is_user_logged_in':
				$response = Chat::is_user_logged_in();
			break;
			
			case 'logout':
				$response = Chat::logout();
			break;
			
			case 'online':
				$response = Chat::online();
			break;
			
			case 'offline':
				$response = Chat::offline();
			break;
			
			case 'send_chat_msg':
				$response = Chat::send_chat_msg( $_POST );
			break;
			
			case 'get_online_users':
				$response = Chat::get_online_users();
			break;
			
			case 'get_chat_lines':
				$response = Chat::get_chat_lines( $_GET['last_log_ID'], $_GET['sender'] );
			break;
			
			case 'user_info':
				$response = Chat::user_info( $_GET['ID'] );
			break;
			
			default:
				throw new Exception( 'Wrong action' );
		}
	
	} catch ( Exception $e ) {
		
		$response['error'] = $e->getMessage();
		
	}
	
    
	// Response output
	header( "Content-Type: application/json" );
	echo json_encode( $response );
	exit;
	
}

/**
 * Chat online shortcode
 *
 * @access public
 * @return string
 */
 
function g_hangout_shortcode_online( $atts, $content = '' ) {
	
	// Check if any OP online
	if( Chat::check_if_any_op_online() )
		return $content;
	
}


/**
 * Chat offline shortcode
 *
 * @access public
 * @return string
 */
 
function g_hangout_shortcode_offline( $atts, $content = '' ) {
	
	// Check if all OPs offline
	if( !Chat::check_if_any_op_online() )
		return $content;
	
}


/**
 * Check if name is available
 *
 * @access public
 * @return bool True if name is available
 */
 
function g_hangout_name_is_available( $name ) {
	global $wpdb;
	
	// Get all operator names
	$op_names = $wpdb->get_col( 'SELECT meta_value FROM ' . $wpdb->usermeta . ' WHERE meta_key = "g_hangout_op_name" AND meta_value != ""');
	
	if( in_array( $name, $op_names ) )
		return false;
	
	// Check if online users have same name
	$check_online_users = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'chat_online
			 WHERE `name` = %s LIMIT 1',
			$name
		)
	);
	
	if( $check_online_users > 0 )
		return false;
	
	return true;
							  
}


/**
 * Start session
 *
 * @access public
 * @return string
 */
 
function g_hangout_session_start() {
		
	
	if( !session_id() ) {
	
		// Start sessions
		session_start();
		
	}
	
}

/**
 * Create random string
 *
 * @access public
 * @return string Random string
 */
 
function g_hangout_rand_str( $length, $chars = 'abcdefghiklmnprsxyz') {
	
	return substr( str_shuffle( $chars ), 0, $length );
	
}


/**
 * Make URLs into links 
 *
 * @access public
 * @return string Edited string
 */
 
function g_hangout_make_url_to_link( $string ){

	// Make sure there is an http:// on all URLs
	$string = preg_replace( "/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2", $string );
	
	// Make all URLs links
	$string = preg_replace( "/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</a>", $string );
	
	// Make all emails hot links
	$string = preg_replace( "/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i", "<a href=\"mailto:$1\">$1</a>", $string );

	return $string;
	
}

/**
 * Adjusting a hex colour
 *
 * @param $hex string Example input: #222222
 * @param $steps int Btw. -255 and 255. Negative = darker, positive = lighter
 * @access public
 * @return string Hex color
 */
function g_hangout_adjust_brightness( $hex, $steps ) {

    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}

/**
 * Custom stylesheets for skin
 *
 * @access public
 * @return void
 */
function g_hangout_custom_frontend_styles() {
	
	// Get options
	$opts = g_hangout_get_options();
	
	// Set color tones (Btw. -255 and 255)
	$tone_5 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -5 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 5 );
	
	$tone_10 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -10 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 10 );
	
	$tone_20 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -20 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 20 );
	
	$tone_50 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -50 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 50 );
	
	$tone_70 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -70 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 70 );
	
	$tone_120 = ( $opts['skin_type'] == 'light' ) ? g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], -120 ) : g_hangout_adjust_brightness( $opts['skin_chatbox_bg'], 120 );
	
    ?>
    <style type="text/css">
		
		
		<?php
		// Change chatbox body colors
		?>
		.g-hangout-toolbar,
		.sc-cnv-wrap,
		.sc-msg-wrap,
		.g-hangout-wrapper,
		#g_hangout_box textarea.f-chat-line,
		#g_hangout_box p.sc-lead,
		#g_hangout_box .g-hangout-wrapper input, 
		#g_hangout_box .g-hangout-wrapper textarea {
			color: <?php echo $opts['skin_chatbox_fg']; ?>;
			background-color: <?php echo $opts['skin_chatbox_bg']; ?>;
		}

		.g-hangout-toolbar a { color: <?php echo $tone_70; ?>; }
		.g-hangout-toolbar a:hover { color: <?php echo $tone_120; ?>; }
		
		#g_hangout_box .g-hangout-wrapper input, 
		#g_hangout_box .g-hangout-wrapper textarea,
		#g_hangout_box textarea.f-chat-line {
			border-color: <?php echo $tone_50; ?>;
		}
		#g_hangout_box .g-hangout-wrapper input:focus,
		#g_hangout_box .g-hangout-wrapper textarea:focus {
			background-color: <?php echo $tone_10; ?>;
			border-color: <?php echo $tone_70; ?>;
		}
		
		#g_hangout_box textarea.f-chat-line:focus {
			background-color: <?php echo $tone_5; ?>;
			border-color: <?php echo $tone_70; ?>;
		}
		
		#g_hangout_box .g-hangout-wrapper label {
			color: <?php echo $tone_120; ?>;
		}
		
		#g_hangout_box form.g-hangout-reply {
			border-top: 1px solid <?php echo $tone_50; ?>;
			background-color: <?php echo $tone_10; ?>;
		}
		
		#g_hangout_box {
			width: <?php echo $opts['skin_box_width']; ?>px;
		}
		
		#g_hangout_box textarea.f-chat-line {
			width: <?php echo $opts['skin_box_width'] - 42; ?>px;
		}
		
		<?php 
		/*
		 * Default radius
		 */
		if( $opts['default_radius'] ): ?>
		
			#g_hangout_box div.g-hangout-header {
				-webkit-border-radius: <?php echo $opts['default_radius']; ?>px <?php echo $opts['default_radius']; ?>px 0 0;
				   -moz-border-radius: <?php echo $opts['default_radius']; ?>px <?php echo $opts['default_radius']; ?>px 0 0;
					   border-radius: <?php echo $opts['default_radius']; ?>px <?php echo $opts['default_radius']; ?>px 0 0;
			}
			
			.g-hangout-notification.warning,
			#g_hangout_box .g-hangout-wrapper .sc-start-chat-btn a,
			#g_hangout_box .g-hangout-wrapper input, #g_hangout_box .g-hangout-wrapper textarea {
				-webkit-border-radius: <?php echo $opts['default_radius']; ?>px;
				   -moz-border-radius: <?php echo $opts['default_radius']; ?>px;
					   border-radius: <?php echo $opts['default_radius']; ?>px;
			}
		
		<?php endif; ?>
		
		#g_hangout_box .g-hangout-wrapper input, #g_hangout_box .g-hangout-wrapper textarea {
			width: <?php echo $opts['skin_box_width'] - 70; ?>px;
		}
		
		.g-hangout-wrapper {
			border-color: <?php echo $tone_20; ?>;
			max-height: <?php echo $opts['skin_box_height']; ?>px;
		}
		
		.sc-cnv-wrap {
			border-color: <?php echo $tone_20; ?>;
			max-height: <?php echo $opts['skin_box_height'] - 30; ?>px;
		}
		
		#g_hangout_box .g-hangout-wrapper .sc-start-chat-btn > a {
			color: <?php echo $opts['skin_submit_btn_fg']; ?>;
			background-color: <?php echo $opts['skin_submit_btn_bg']; ?>;
		}
		
		#g_hangout_box .g-hangout-wrapper .sc-start-chat-btn > a:hover {
			color: <?php echo $opts['skin_header_fg']; ?>;
			background-color: <?php echo $opts['skin_header_bg']; ?>;
		}
		
		#g_hangout_box div.g-hangout-header {
			color: <?php echo $opts['skin_header_fg']; ?>;
			background-color: <?php echo $opts['skin_header_bg']; ?>;
		}
        
       <?php
        
        // Use CSS Animations
        if( $opts['use_css_anim'] ): ?>
            
            .g-hangout-css-anim {
                -webkit-transition: bottom .2s;
                   -moz-transition: bottom .2s;
                     -o-transition: bottom .2s;
                        transition: bottom .2s;
            }
            
        <?php endif; ?>
		
    </style>
    <?php
}

/**
 * Get user IP Address
 *
 * @access public
 * @return string IP Adreess
 */
function g_hangout_get_IP() {

	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                {
                    return $ip;
                }
            }
        }
    }
	
}
?>