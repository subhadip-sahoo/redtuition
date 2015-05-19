<?php
/**
 * SCREETS © 2013
 *
 * Prepare chat plugin
 *
 */


// Ajax Requests
add_action( 'wp_ajax_nopriv_g_hangout_ajax_callback', 'g_hangout_ajax_callback' );
add_action( 'wp_ajax_g_hangout_ajax_callback', 'g_hangout_ajax_callback' );

/**
 * Default plugin options
 *
 * DO NOT CHANGE DEFAULT OPTIONS.
 * INSTEAD, USE ADMIN PANEL.
 */
$g_hangout_default_opts = array(
	'default_skin'			=> 'basic',
	'use_css_anim'			=> 1,
	'skin_box_width'		=> 300,
	'skin_box_height'		=> 380,
	'skin_type'				=> 'light',
	'skin_chatbox_bg'		=> '#ffffff',
	'skin_chatbox_fg'		=> '#222222',
	'skin_header_bg'		=> '#bf3723',
	'skin_header_fg'		=> '#ffffff',
	'skin_submit_btn_bg'	=> '#3a99d1',
	'skin_submit_btn_fg'	=> '#ffffff',
	'before_chat_header'	=> __( 'Talk to us', 'g_hangout' ),
	'in_chat_header'		=> __( 'Now Chatting', 'g_hangout' ),
	'prechat_welcome_msg'	=> __( "Questions? We're here. Send us a message!", 'g_hangout' ),
	'welcome_msg'			=> __( "Questions, issues or concerns? I'd love to help you!", 'g_hangout' ),
	'chat_btn'				=> __( "Start Chat", 'g_hangout' ),
	'send_btn'				=> __( "Send", 'g_hangout' ),
	'input_box_msg'			=> __( "Click ENTER to chat", 'g_hangout' ),
	'input_box_placeholder'	=> __( "Write a reply", 'g_hangout' ),
	'name_field'			=> __( "Your name", 'g_hangout' ),
	'email_field'			=> __( "E-mail", 'g_hangout' ),
	'question_field'		=> __( 'Got a question?', 'g_hangout' ),
	'req_text'				=> __( "Required", 'g_hangout' ),
	'ask_name_field'		=> 1,
	'display_chatbox'		=> 1,
	'hide_chat_when_offline'=> 0,
	'always_show_homepage'	=> 0,
	'delay'					=> 2, // sec.
	'default_radius'		=> 4, // px
	'load_skin_css'			=> 1,
	'compress_css'			=> 1,
	'offline_header'		=> __( 'Contact us', 'g_hangout' ),
	'offline_body'			=> __( "We're not around right now. But you can send us an email and we'll get back to you, asap.", 'g_hangout' ),
	'end_chat_field'			=> __( 'End chat', 'g_hangout' ),
	'offline_msg_email'		=> '', // Where should offline messages go?
	'purchase_key'			=> ''
);


