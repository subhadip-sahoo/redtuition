jQuery(document).ready(function($) {
	$('.hide_show').hide();
	$('.btn_ss').click(function(){
	$('.hide_show').slideToggle();
	if ( $('.btn_ss').hasClass("act") ) {
	$('.btn_ss').removeClass('act');
	}
	else {
	$('.btn_ss').addClass('act');
	}
	});
	//$('.ss_sh').hide();
	$('.vv_hide').click(function(){
		$('.ss_sh').show();
		$('.ff-hh').hide();
	});
});
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
	
		jQuery(document).ready(function(){
			/*
				Aweber code Starts Here
			*/
			if(jQuery('#Aweber_hangout_form input[type="submit"]').length > 0)
			{
				jQuery('<input name="submit_dummy" class="submit" value="Submit" tabindex="502" type="button">').insertAfter('#Aweber_hangout_form input[type="submit"]');
				jQuery('#Aweber_hangout_form input[type="submit"]').hide();
			}
			else
			{
				jQuery('<input name="submit_dummy" class="submit" value="Submit" tabindex="502" type="button">').insertAfter('#Aweber_hangout_form button[type="submit"]');
				jQuery('#Aweber_hangout_form button[type="submit"]').hide();
			}
			jQuery('#Aweber_hangout_form input[type="button"]').click(function(event){
				//event.stopPropagation();
				//event.preventDefault();
				//var a	=	jQuery("#Aweber_hangout_form").html(); 
				//alert(a);
				//return false;
			namefield = jQuery('#hangout_name_field').val();
			emailfield = jQuery('#hangout_email_field').val();
			
			gname = jQuery('input[name='+namefield+']').val();
			gemail = jQuery('input[name='+emailfield+']').val();
			g_hangout_id = jQuery('#g_hangout_id').val();
			
			err='';
			if(gname==''){
				err  = 'Name Should not be Empty! \n';
			}
			if(gemail==''){
				err  = err  + 'Email Should not be Empty! \n';
			} else {
				
				if(validateEmail(gemail)==false){
					err  = err  +  'Email id is Invalid! \n';
				}
			}

			
			if(err!=''){
			alert(err);
			return false;
			} else{

				sendata = 'g_hangout_id='+g_hangout_id+'&event_reg_name='+gname+'&event_reg_email='+gemail+'&event_reg_reminder=0&event_reg_email_add=';
	
				
				jQuery.ajax({
					type: 'POST',
					url: site_url+'/wp-content/plugins/HangoutPlugin/ajax.php',					
					data: sendata,
					success:function(data)
					{
						if(jQuery('#Aweber_hangout_form input[type="submit"]').length > 0)
						{
							jQuery('#Aweber_hangout_form input[type="submit"]').trigger('click');
							jQuery('.replay_video').show();
						}
						else
						{
							jQuery('#Aweber_hangout_form button[type="submit"]').trigger('click');
							jQuery('.replay_video').show();
						}
					}
				});
				
				
				
				
				/*
				jQuery.ajax({
				type: 'POST',
				url: site_url+'/wp-content/plugins/HangoutPlugin/ajax.php',
				data: sendata,

				},
				success(function(data) {
					
					jQuery("#Aweber_hangout_form .af-form-wrapper").submit();
				});
				*/
			}
			
		});
		
		/*
				Aweber code Starts Here
		*/
			
		jQuery('#Aweber_hangout_form .wf-button').click(function(){
			namefield = jQuery('#hangout_name_field').val();
			emailfield = jQuery('#hangout_email_field').val();
			
			gname = jQuery('input[name='+namefield+']').val();
			gemail = jQuery('input[name='+emailfield+']').val();
			g_hangout_id = jQuery('#g_hangout_id').val();
			
			err='';
			if(gname==''){
				err  = 'Name Should not be Empty! \n';
			}
			if(gemail==''){
				err  = err  + 'Email Should not be Empty! \n';
			} else {
				
				if(validateEmail(gemail)==false){
					err  = err  +  'Email id is Invalid! \n';
				}
			}

			
			if(err!=''){
			alert(err);
			return false;
			} else{

				sendata = 'g_hangout_id='+g_hangout_id+'&event_reg_name='+gname+'&event_reg_email='+gemail+'&event_reg_reminder=0&event_reg_email_add=';
				
				
				
				jQuery.ajax({
				type: 'POST',
				url: site_url+'/wp-content/plugins/HangoutPlugin/ajax.php',
				data: sendata,

				}).done(function(data) {
					
					//jQuery("form:first").submit();
					
				});
			}
		});

		jQuery('#g_hangout_no').click(function(){
			jQuery('#google_hangout_video_url').show();	
			jQuery('#g_hangout_event_button').hide();
		});
		jQuery('#g_hangout_yes').click(function(){
			jQuery('#g_hangout_event_button').hide();
			jQuery('#ghangout_event_form').show();
		});
		jQuery('#additional_email').click(function(){
			jQuery('#additional_email_p').show();
		});
		jQuery('input[name=event_reg_reminder]').click(function(){
			if(jQuery('input[name=event_reg_reminder]:checked', '#g_hangout_reg_form').val()=="1"){
				jQuery('#reminder_status').show();
			} else {
				jQuery('#reminder_status').hide();
			}
			
		});


		jQuery('#g_hangout_reg_form1').submit(function(){
						
			err='';
			if(jQuery('#event_reg_name').val()==''){
				err  = 'Nameddddd Should not be Empty! \n';
			}
			if(jQuery('#event_reg_email').val()==''){
				err  = err  + 'Emailsss Should not be Empty! \n';
			} else {
				
				if(validateEmail(jQuery('#event_reg_email').val())==false){
					err  = err  +  'Email id is Invalid! \n';
				}
			}

			if(jQuery('#event_reg_email_add').val()!=''){

				if(validateEmail(jQuery('#event_reg_email_add').val())==false){
					err  = err  +  'Additional Email id is Invalid! \n';
				}
			}
			if(err!=''){
			alert(err);
			} else{

				sendata = jQuery('#g_hangout_reg_form').serialize();
				
				
				jQuery.ajax({
				type: "POST",
				url: site_url+"/wp-content/plugins/HangoutPlugin/ajax.php",
				data: sendata,
				
				}).done(function(data) {
					jQuery('.ho_vedio').show();
				jQuery('.ho_registation').hide();

				

					//jQuery('#ghangout_event_form').html(data);
					//window.location=thankyou_url;
					return false;
				});
			}
			return false;
		});

		jQuery('#g_hangout_reg_form').submit(function(){
						
			err='';
			if(jQuery('#event_reg_name').val()==''){
				err  = 'Nameddddd Should not be Empty! \n';
			}
			if(jQuery('#event_reg_email').val()==''){
				err  = err  + 'Emailsss Should not be Empty! \n';
			} else {
				
				if(validateEmail(jQuery('#event_reg_email').val())==false){
					err  = err  +  'Email id is Invalid! \n';
				}
			}

			if(jQuery('#event_reg_email_add').val()!=''){

				if(validateEmail(jQuery('#event_reg_email_add').val())==false){
					err  = err  +  'Additional Email id is Invalid! \n';
				}
			}
			if(err!=''){
			alert(err);
			} else{

				sendata = jQuery('#g_hangout_reg_form').serialize();
				
				
				jQuery.ajax({
				type: "POST",
				url: site_url+"/wp-content/plugins/HangoutPlugin/ajax.php",
				data: sendata,
				
				}).done(function(data) {
					//jQuery('.ho_vedio').show();
				//jQuery('.ho_registation').hide();

				
						alert(thankyou_url);
					//jQuery('#ghangout_event_form').html(data);
					window.location=thankyou_url;
					return false;
				});
			}
			return false;
		});

	});
	jQuery(document).ready(function(){
		/*jQuery('.f-chat-line').keyup(function(e){
			if(e.keyCode == 13){
				jQuery(this).removeClass('g-hangout-sending');
				var chat_val	=	jQuery('.f-chat-line').val();
				jQuery('.f-chat-line').val(chat_val);
				jQuery('#Reply_form').submit();
			}
		});*/
		/*jQuery('.f-chat-line').focus(function(e){
			var	chat_val	=	"";
			if(jQuery('#Reply_form .f-chat-line').find('.g-hangout-sending'))
			{
				alert('in');
				setInterval(function(){
					chat_val	=	jQuery('.f-chat-line').val();
					if(chat_val != "")
					{
						jQuery('.f-chat-line').val(chat_val);
						jQuery('#Reply_form').submit();
					}	
				},10000);
			}
		});*/
	});
	//admin email : support@hangoutplugin.com