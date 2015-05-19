<?php

/**

 * SCREETS © 2013

 *

 * Chat Class

 *

 */

 

class Chat {



	/**

	 * Send contact form

	 *

	 * @access public

	 * @return array

	 */

	public static function send_contact_from( $data ) {

		

		$message = '';		

		$response = array( 'status' => 0, 'error' => null );

		

		// Check if all fields filled out correctly?

		if( empty( $data['f_chat_user_name'] ) or empty( $data['f_chat_user_email'] ) or empty( $data['f_chat_user_question'] ) ) {

			

			$response['error'] = __( 'Please fill out all required fields', 'g_hangout' );

			

			return $response;

		}

		

		// Check if email is correct

		if( !is_email( $data['f_chat_user_email'] ) ) {

		

			$response['error'] = __( 'E-mail is invalid', 'g_hangout' );

			

			return $response;

			

		}

		

		// Get options

		$sc_opts = g_hangout_get_options();

		

		// Fields

		$username = strip_tags( trim ( $data['f_chat_user_name'] ) );

		$email = trim ( $data['f_chat_user_email'] );

		$question = strip_tags( trim ( stripslashes( $data['f_chat_user_question'] ) ) );

		

		// Add prefix into message

		if( !empty( $data['prefix'] ) )

			$message = $data['prefix'];

			

		// Prepare message

		$message .= __( 'Name', 'g_hangout' ) .': ' . $username . "\r\n";

		$message .= __( 'E-mail', 'g_hangout' ) .': ' . $email . "\r\n\r\n";

		$message .= __( 'Message', 'g_hangout' ) .': ' . "\r\n" . $question . "\r\n\r\n";

		$message .= get_bloginfo( 'name' ) . " - " . site_url();

		

		// Prepare headers

		$headers = "From: \"$username\" <$email>\r\n";

		

		// Prepare data

		$to = get_bloginfo('admin_email');

		$subject = sprintf( __( '%s wrote a note', 'g_hangout' ), $data['f_chat_user_email'] );

		

		// Send email

		if( wp_mail( $to, $subject, $message, $headers ) ) {

			

			$response['message'] = __( 'Successfully sent! Thank you', 'g_hangout' );

			$response['status'] = 1;

			

		} else {

			

			// ERROR: Something went wrong! Try again

			$response['error'] = __( 'Something went wrong! Try again', 'g_hangout' );

			

		}



		return $response;

		

	}

	



	/**

	 * Log in chat

	 *

	 * @access public

	 * @return array

	 */

	public static function login( $name, $email, $is_admin = false ) {

		global $wpdb;

		

		// First logout if logged already

		Chat::logout();

		

		// Start session again

		g_hangout_session_start();

		

		// Get options

		$opts = g_hangout_get_options();

		

		// Check if fields are not empty

		if( ( $opts['ask_name_field'] == 1 and empty( $name ) ) or empty( $email ) ) {

			

			throw new Exception( __('Please fill out all required fields', 'g_hangout' ) );

			

		}

		

		// Check if email is correct

		if( !is_email( $email) ) {

			

			throw new Exception( __('Email is invalid', 'g_hangout' ) );

			

		}

		

		// Sanitize name

		$name = sanitize_key( trim( $name ) );

		

		// Use localpart of email if no chars supported in given name

		// or name is not active already

		if( empty( $name ) ) {

			list( $email_name, $email_domain ) = explode( '@', $email );

			

			$name = sanitize_key( $email_name );

		}

		

		// Preparing the gravatar hash:

		$gravatar = md5( strtolower( trim( $email) ) );

		

		// Find user type

		if( $is_admin and current_user_can('chat_with_users') )

			$user_type = 1; // Operator



		else

			$user_type = 2; // Visitor

		

		// Get user IP Address (ip2long can't return negative now)

		$ip_address = sprintf( '%u', ip2long( g_hangout_get_IP() ) );

		

		// Create new user

		$user = new Chat_user( array(

			'name' 			=> $name,

			'email'			=> $email,

			'gravatar'		=> $gravatar,

			'type'			=> $user_type,

			'ip_address'	=> $ip_address,

			'user_agent'	=> $_SERVER['HTTP_USER_AGENT']

		));

		

		// Save user into DB

		$user = $user->save();

		

		// Display error

		if( !$user )

			return false;

		

		// Remove current conversations of current OPERATOR

		if( $is_admin and current_user_can('chat_with_users') ) {

			/*$wpdb->query(

				$wpdb->prepare( '

					DELETE FROM ' . $wpdb->prefix . 'chat_lines

					WHERE `author` = %s OR `receiver_ID` = %s',

					$name, $name

				)

			);*/

		}

		

		// Save user into session

		$_SESSION['g_hangout']['chat_user_ID'] = $user['user_id'];

		$_SESSION['g_hangout']['chat_user_name'] = $user['name'];

		$_SESSION['g_hangout']['chat_user_gravatar'] = $user['gravatar'];

		$_SESSION['g_hangout']['chat_user_email'] = $user['email'];

		

		return array(

			'user_id'	=> $user['user_id'],

			'status'	=> 1,

			'name'		=> $user['name'],

			'gravatar'	=> Chat::gravatar_from_hash( $user['gravatar'] )

		);

	}

	

	

	/**

	 * Check if user logged in

	 *

	 * @access public

	 * @return array

	 */

	public static function is_user_logged_in() {

		

		$response = array( 'logged' => false, 'user' => null );

		

		if( !empty( $_SESSION['g_hangout']['chat_user_name'] ) ) {

			

			$response['logged'] = true;

			$response['user'] = array(

				'name'		=> $_SESSION['g_hangout']['chat_user_name'],

				'email'		=> $_SESSION['g_hangout']['chat_user_email']

			);

			

		}

		

		return $response;

		

	}

	

	

	/**

	 * Log out

	 *

	 * @access public

	 * @return array

	 */

	public static function logout() {

		global $wpdb;

		

		// Delete chat user

		if( isset( $_SESSION['g_hangout']['chat_user_name'] ) ) {

			$wpdb->query(

				$wpdb->prepare(

					'DELETE FROM ' . $wpdb->prefix . 'chat_online WHERE `name` = %s',

					$_SESSION['g_hangout']['chat_user_name']

				)

			);

		}

				

		// Destroy session

		$_SESSION['g_hangout'] = array(); // Clears the $_SESSION variable



		return array( 'status' => 1 );

	}

	

	

	/**

	 * Online

	 *

	 * @access public

	 * @return array

	 */

	public static function online() {

		global $wpdb;

		

		// Get user name from session

		$chat_user_name = $_SESSION['g_hangout'][ 'chat_user_name' ];

		

		// Prepare data

		$data = array( 'status' => 1 );

		

		// Update user status as OFFLINE

		$wpdb->update($wpdb->prefix . 'chat_online', $data, array( 'name' => $chat_user_name ), null, '%s' );

		

		return array( 'status' => 1 );

	}

	

	

	/**

	 * Offline

	 *

	 * @access public

	 * @return array

	 */

	public static function offline() {

		global $wpdb;

		

		// Get user name from session

		$chat_user_name = $_SESSION['g_hangout'][ 'chat_user_name' ] ;

		

		// Prepare data

		$data = array( 'status' => 0 );

		

		// Update user status as OFFLINE

		$wpdb->update($wpdb->prefix . 'chat_online', $data, array( 'name' => $chat_user_name ), null, '%s' );

				

		return array( 'status' => 1 );

	}

	

	

	/**

	 * Send chat message

	 *

	 * @access public

	 * @return array

	 */

	public static function send_chat_msg( $params ) {

		

		// Get user data from session

		$chat_user_name = $_SESSION['g_hangout'][ 'chat_user_name' ];

		$chat_user_gravatar = $_SESSION['g_hangout'][ 'chat_user_gravatar' ];

		$chat_user_email = $_SESSION['g_hangout'][ 'chat_user_email' ];

		

		// First check if any OP is online

		if( !Chat::check_if_any_op_online() ) {

			

			// Logout user

			Chat::logout();

			

			// Prepare email data for last message

			$data = array(

				'f_chat_user_name'	=> $chat_user_name,

				'f_chat_user_email'	=> $chat_user_email,

				'f_chat_user_question'	=> $params['chat_line'],

				'prefix' => '(!) ' . strtoupper( __( 'User has been sent this message after you disconnected from chat', 'g_hangout' ) ) . ": \r\n\r\n"

			);

			

			// Send email now

			$email = Chat::send_contact_from( $data );

			

			if( !empty( $email['error']) )

				throw new Exception( $email['error'] );

				

			else

				throw new Exception( __( "We are offline now. However, your message has been sent to us by email. We will contact you as soon as possible", 'g_hangout' ) );

			

		}

		

		

		if( empty( $chat_user_name ) )

			throw new Exception( __( 'You are not logged in', 'g_hangout' ) );

		

		if( empty( $params['chat_line'] ) )

			throw new Exception( __( "You haven't entered a chat message", 'g_hangout' ) );

			

		

		// If receiver ID empty, make it __OP__

		if( current_user_can( 'chat_with_users' ) and !empty( $params['receiver_ID'] ) )

			$receiver_ID = sanitize_key( $params['receiver_ID'] ); // sent by operator

			

		else

			$receiver_ID = '__OP__'; // sent by visitor

		

		// Prepare chat line data

		$chat = new Chat_line( array(

			'author'		=> $chat_user_name,

			'gravatar'		=> $chat_user_gravatar,

			'visitor_ID'	=> ( !empty( $params['visitor_ID'] ) ) ? $params['visitor_ID'] : null,

			'receiver_ID'	=> $receiver_ID,

			'email'			=> $chat_user_email,

			'chat_line'		=> Chat::sanitize_chat_line( $params['chat_line'] )

		) );

		

		// Save chat message

		$insert_ID = $chat->save();

		

		return array(

			'status'	=> 1,

			'insert_ID'	=> $insert_ID

		);

		

	}

	

	

	/**

	 * Sanitize chat line

	 *

	 * @access public

	 * @return string Sanitized chat line

	 */

	public static function sanitize_chat_line( $chat_line ) {

		

		// Convert special characters to HTML entities

		$chat_line = htmlspecialchars( stripslashes( $chat_line ) );

		

		// Replace new lines with <br/> tag

		$chat_line = str_replace( array("\r\n"), '<br/>', $chat_line );

		

		return $chat_line;

	}

	

	/**

	 * Get online users

	 *

	 * @access public

	 * @return array

	 */

	public static function get_online_users() {

		global $wpdb;

		

		$users = array();



		// Update user

		if( isset( $_SESSION['g_hangout']['chat_user_name'] ) ) {

			

			// Find user type

			if( current_user_can( 'chat_with_users' ) )

				$user_type = 1; // Operator



			else

				$user_type = 2; // Visitor

			

			$user = new Chat_user( array(

				'name' 		=> $_SESSION['g_hangout']['chat_user_name'],

				'email'		=> $_SESSION['g_hangout']['chat_user_email'],

				'gravatar'	=> $_SESSION['g_hangout']['chat_user_gravatar'],

				'type'		=> $user_type

			));

			

			$user->update();

			

		}

		

		// Deleting chat logs older than 5 minutes and users inactive for 30 seconds

	//	$wpdb->query( "DELETE FROM " . $wpdb->prefix . "chat_lines WHERE chat_date < UNIX_TIMESTAMP(SUBTIME(NOW(),'0:5:0'))" );

		//Jcasp
		$wpdb->query( "DELETE FROM " . $wpdb->prefix . "chat_online  WHERE visitor_ID!=0 and last_activity < SUBTIME(NOW(),'0:0:30')" );
		
		//Old
		//$wpdb->query( "DELETE FROM " . $wpdb->prefix . "chat_online  WHERE last_activity < SUBTIME(NOW(),'0:0:30')" );

		

		// Get chat users

		if( current_user_can('chat_with_users') ) {

		

			$online_users = $wpdb->get_results( 'SELECT `ID`, visitor_ID, name, email, gravatar, `type` FROM ' . $wpdb->prefix . 'chat_online WHERE `status` = 1 ORDER BY `name` ASC LIMIT 18' );

			

			// Update user gravatar

			foreach( $online_users as $user ) {

				$user->{'gravatar'} = Chat::gravatar_from_hash( $user->gravatar );

				

				// find user type and tagline

				if( $user->type == 1 and @$_SESSION['g_hangout']['chat_user_name'] == $user->name )

					$user->{'tagline'} = __( 'You', 'g_hangout' );

				

				else if( $user->type == 1 )

					$user->{'tagline'} = __( 'Operator', 'g_hangout' );

					

				else if( $user->type == 2 )

					$user->{'tagline'} = __( 'Visitor', 'g_hangout' );

				

				else if( $user->type == 3 )

					$user->{'tagline'} = __( 'Web User', 'g_hangout' );

				

				

				$users[] = $user;

			}

			

			// Total online users

			$total_users = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'chat_online WHERE `status` = 1' );

                        

			return array(

				'users' => $users,

				'total' => $total_users

			);

			

		}

        

	}

	

	/**

	 * Get chat logs

	 *

	 * @access public

	 * @return array

	 */

	public static function get_chat_lines( $last_log_ID, $sender = null ) {

		global $wpdb;

		

		$chats = array();

		

		if( !isset( $_SESSION['g_hangout']['chat_user_name'] ) )

			return array( 'chats' => $chats );

			

			

		$sql_sender = '';

		$last_log_ID = (int) $last_log_ID;

		$username = $_SESSION['g_hangout']['chat_user_name'];

		

		// Prepare sql with sender

		if( !empty( $sender ) and current_user_can( 'chat_with_users' ) ) {

			

			$sql = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'chat_lines 

						WHERE `ID` > %d AND

							( `author` = %s OR `receiver_ID` IN( %s, %s, %s ) )

							ORDER BY `ID` ASC',

							$last_log_ID, $username, $username, '__OP__', $sender

					);

						

			

		// Prepare sql

		} else {

			

			if( current_user_can( 'chat_with_users' ) ) {

			

				$sql = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'chat_lines 

							WHERE `ID` > %d AND

								( `author` = %s OR `receiver_ID` IN( %s, %s ) )

								ORDER BY `ID` ASC',

								$last_log_ID, $username, $username, '__OP__'

					);

					

					

			} else {

				

				$sql = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'chat_lines 

							WHERE `ID` > %d AND

								( `author` = %s OR `receiver_ID` = %s )

								ORDER BY `ID` ASC',

								$last_log_ID, $username, $username

					);

					

			}

			

		}

		

		// Get new chat lines

		$new_chat_lines = $wpdb->get_results( $sql );

		

		

		// Update lines data

		foreach( $new_chat_lines as $chat ) {

			

			// Returning the GMT (UTC) time of the chat creation:

			$chat->time = array(

				'hours'		=> gmdate( 'H', $chat->chat_date ),

				'minutes'	=> gmdate( 'i', $chat->chat_date )

			);

			

			// Make urls to links

			$chat->chat_line = g_hangout_make_url_to_link( $chat->chat_line );

			

			// Update gravatar

			$chat->gravatar = Chat::gravatar_from_hash( $chat->gravatar );

			

			$chats[] = $chat;

		}

        

		return array( 'chats' => $chats );

		

	}

	

	

	/**

	 * Check if any operator is online

	 *

	 * @access public

	 * @return bool TRUE when any operator is online

	 */

	public static function check_if_any_op_online() {

		global $wpdb;

		

		if( $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'chat_online WHERE `status` = 1 AND `type` = 1 LIMIT 1' ) )

			return true;

			

		return false;

		

		

	}

	

	

	/**

	 * Get user info

	 *

	 * @access public

	 * @return array User info

	 */

	public static function user_info( $user_id ) {

		global $wpdb;

		

		$data = array( 'device_name' => 'null' );

				

		// Get user data

		$user = $wpdb->get_row( 

			$wpdb->prepare(

				'SELECT `user_agent`, `ip_address`

					FROM ' .$wpdb->prefix . 'chat_visitors 

					WHERE `ID` = %d

					LIMIT 1', 

					$user_id

			)

		);

		

									

		

		// Prepare user data

		if( !empty( $user ) ) {

			$device = g_hangout_browser_info( $user->user_agent );

			

			$data['device_name'] = $device['name'];

			$data['device_version'] = $device['version'];

			$data['platform'] = $device['platform'];

			$data['ip_address'] = long2ip( $user->ip_address );

		

		}

		

		return $data;

		

	}

	

	/**

	 * Get gravatar from Hash

	 *

	 * @access public

	 * @return array

	 */

	public static function gravatar_from_hash( $hash, $size = 38 ){

					

		return 'http://www.gravatar.com/avatar/' . $hash . '?size=' . $size . '&amp;default=' .

				urlencode('http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?size=' .$size );

				

	}

	

}

?>