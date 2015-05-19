
<script type="text/javascript">
	
	/**
	 * Warn user while leaving page
	 */
	function sc_ask_confirm() {
		return '<?php _e( 'If you leave, you will lose all your conversations' , 'g_hangout' ); ?>.';
	}
	window.onbeforeunload = sc_ask_confirm;

</script>


<div id="Chat_console">

	<!-- Error Message -->
	<div id="G_hangout_error"></div>
	
	<!-- Title -->
	<div class="g-hangout-title">
		<h1><?php _e( 'Chat Console', 'g_hangout' ); ?></h1>
	</div>
	
	<!-- Primary Buttons -->
	<div class="g-hangout-primary-btns">
		<!-- Online Button -->
		<a href="javascript:void(0)" class="g-hangout-login-btn button button-large"><i class="sc-icon-connecting"></i> <?php _e( 'Connecting', 'g_hangout' ); ?>...</a>
		
		<!-- Log out -->
		<a href="javascript:void(0)" class="g-hangout-btn-logout button button-large"><?php _e( 'Logout from Chat', 'g_hangout' ); ?></a>
	</div>
	
	<div class="clear"></div>
	
	
	<!-- Online People -->
	<div id="People_list">
		
		<h2><?php _e( 'Online Users', 'g_hangout' ); ?></h2>
		
		<div class="g-hangout-users"></div>
		
	</div>
	
	<!-- Conversations -->
	<div id="Conversations">
		<div class="inner">
		
			<!-- Wall -->
			<div class="g-hangout-wall">
				<ul class="g-hangout-tabs">
					<li class="console-tab"><a href="#Console"><?php _e( 'Welcome', 'g_hangout' ); ?></a></li>
				</ul>
				
				<div class="g-hangout-tab-contents">
					<div id="Console" class="active g-hangout-tab-content">&nbsp;</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="clear"></div>
	
</div>