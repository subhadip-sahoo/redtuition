<?php
/**
 * SCREETS © 2013
 *
 * Basic Skin
 * Author: Screets
 * Author URI: http://screets.com
 *
 */

?>

<div id="g_hangout_box">
	
	<div class="g-hangout-header">
		<span class="g-hangout-header-title">
			<?php 
			if( !$this->any_online_op )
				echo $this->opts['offline_header'];
				
			else
				echo $this->opts['before_chat_header']; 
			
			?>
		</span>
		<i></i>
	</div>
	
	<div class="g-hangout-wrapper">
		
		<?php
		/*
		 * Don't allow chat for operators
		 */
	if( !$this->any_online_op ) : ?>
			
			<form action="" id="SC_contact_form">
				
				<input type="hidden" name="action" value="g_hangout_ajax_callback" />
				
				<p class="sc-lead"><?php echo $this->opts['offline_body']; ?></p>
				
				<?php
				/**
				 * Ask for name
				 */
				?>
				
				<label for="f_chat_user_name"><?php echo $this->opts['name_field']; ?> <span class="sc-req">*</span>:</label>
				
				<input type="text" name="f_chat_user_name" id="f_chat_user_name" placeholder="<?php echo $this->opts['name_field']; ?> (<?php echo $this->opts['req_text']; ?>)" />
				
				<?php
				/**
				 * Ask for email
				 */
				?>
				<label for="f_chat_user_email"><?php echo $this->opts['email_field']; ?> <span class="sc-req">*</span>:</label>
				
				<input type="email" name="f_chat_user_email" id="f_chat_user_email" placeholder="<?php echo $this->opts['email_field']; ?> (<?php echo $this->opts['req_text']; ?>)" />
				
				<?php
				/**
				 * Got a question?
				 */
				?>
				<label for="f_chat_user_question"><?php echo $this->opts['question_field']; ?> <span class="sc-req">*</span>:</label>
				
				<textarea type="text" name="f_chat_user_question" id="f_chat_user_question" placeholder="<?php echo $this->opts['question_field']; ?> (<?php echo $this->opts['req_text']; ?>)" rows="1"></textarea>
				
				<!-- Notifications -->
				<div class="g-hangout-notification"></div>
				
				<!-- Start Chat Button -->
				<div class="sc-start-chat-btn">
					<a href="javascript:void(0)" id="SC_send_form_btn"><?php echo $this->opts['send_btn']; ?></a>
				</div>
				
			</form>
		
		<?php
		/*
		 * Login form
		 */
		else :
		?>
			<form id="SC_login_form" action="">
				
				<input type="hidden" name="action" value="g_hangout_ajax_callback" />
				<input type="hidden" name="f_chat_is_admin" value="false" />
				
				<p class="sc-lead"><?php echo $this->opts['prechat_welcome_msg']; ?></p>
				
				<?php
				/**
				 * Ask for name
				 */
				if( $this->opts['ask_name_field'] ):
					$is_req = ( $this->opts['ask_name_field'] == 1 ) ? true : false;
				?>
				
					<label for="f_chat_user_name"><?php echo $this->opts['name_field']; ?> 
						<?php if( $is_req ): ?>
							<span class="sc-req">*</span>
						<?php endif; ?>	
					:</label>
					
					<input type="text" name="f_chat_user_name" id="f_chat_user_name" placeholder="<?php echo $this->opts['name_field']; ?> <?php echo ( $is_req ) ? '(' . $this->opts['req_text'] . ')' : ''; ?>" />
				
				<?php
				endif;
				
				/**
				 * Ask for email
				 */
				?>
				<label for="f_chat_user_email"><?php echo $this->opts['email_field']; ?> <span class="sc-req">*</span>:</label>
				
				<input type="email" name="f_chat_user_email" id="f_chat_user_email" placeholder="<?php echo $this->opts['email_field']; ?> (<?php echo $this->opts['req_text']; ?>)" />
				
				<!-- Notifications -->
				<div class="g-hangout-notification"></div>
				
				<!-- Start Chat Button -->
				<div class="sc-start-chat-btn">
					<a href="javascript:void(0)" id="SC_start_chat_btn"><?php echo $this->opts['chat_btn'] ?></a>
				</div>
				
			</form>
		
		<?php endif; ?>
	
	</div>
	
	<div id="Conversation">

		
		<div class="sc-cnv-wrap">
			
			<p class="sc-lead"><?php echo $this->opts['welcome_msg'] ?></p>
			
		</div>
		
		
		<!-- Notifications -->
		<div class="g-hangout-notification"></div>
		
		<div class="g-hangout-toolbar">
			<div class="g-hangout-toolbar-btns">
				<!--<a href="javascript:void(0)" class="g-hangout-btn-logout"><?php /* echo $this->opts['end_chat_field'];*/ ?></a>-->
				<!--  bhuvnesh -->
				 <a href="javascript:void(0)" class="g-hangout-btn-logout"><?php echo "Refresh"; //$this->opts['end_chat_field']; ?></a> (auto refresh in 20 seconds)
			</div>
		</div>
				
		<?php 
		// Reply form
		?>
		<form id="Reply_form" method="post" action="" class="g-hangout-reply">
			<input type="hidden" name="action" value="g_hangout_ajax_callback" />
			
			<textarea name="chat_line" class="f-chat-line" maxlength="255" placeholder="<?php echo $this->opts['input_box_placeholder']; ?>"></textarea>
			
			<small class="g-hangout-note"><?php echo $this->opts['input_box_msg']; ?></small>
		</form>
		
	</div>
	
</div>