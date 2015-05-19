jQuery(document).ready(function($) {

	$('.reveal-modal').css('height','400px!important');

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
		
	$('.vv_hide').click(function(){
		$('.ss_sh').show();
		$('.ff-hh').hide();
	});
	
	
	$('iframe').each(function() {
		var url = $(this).attr("src");
		if(typeof url!='undefined'){
			if (url.indexOf("?") > 0) {
				$(this).attr({
					"src" : url + "&wmode=transparent",
					"wmode" : "Opaque"
				});
			}
			else {
				$(this).attr({
					"src" : url + "?wmode=transparent",
					"wmode" : "Opaque"
				});
			}
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

	
	/* Registration Form Submit Action
	   Sep 29,2014 comment wits
	*/
	jQuery('#g_hangout_reg_form').submit(function(){
					
		err='';
		if(jQuery('#event_reg_name').val()==''){
			err  = 'Name Should not be Empty! \n';
		}
		if(jQuery('#event_reg_email').val()==''){
			err  = err  + 'Email Should not be Empty! \n';
		} 
		else{
			if(validateEmail(jQuery('#event_reg_email').val())==false){
				err  = err  +  'Email id is Invalid! \n';
			}
			else if(($('#select_date').val()=='' || $('#datepicker').val()=='Select Date*') && !$('#watch_now').is(":checked")){
				$('#select_date').focus();
				$('#datepicker').focus();
				alert('Date field is required.');
				return false;
			}			
			else if($('#select_time').val()==''  && !$('#watch_now').is(":checked") ){
				$('#select_time').focus();				
				alert('Time field is required.');
				return false;
			}			
			else if($('#locationsearch').val()==''  && !$('#watch_now').is(":checked") ){
				$('#locationsearch').focus();
				alert('Time Zone field is required.');
				return false;
			}
		}

		/*if(jQuery('#event_reg_email_add').val()!=''){

			if(validateEmail(jQuery('#event_reg_email_add').val())==false){
				err  = err  +  'Additional Email id is Invalid! \n';
			}
		}*/
		
		if(err!=''){
			alert(err);
		}
		else{
				
				if(jQuery('#watch_now').is(":checked"))
					var makenow	=	1;
				else	
					var makenow	=	0;
					
				
				if(jQuery('#datepicker').length>0)
					var select_date	=		jQuery('#datepicker').val();
				else
					var select_date	=		jQuery('#select_date').val();
					
				//sendata = jQuery('#g_hangout_reg_form').serialize();
				var data = {
					action: 'ghangout_form_submit',
					g_hangout_id: jQuery("input[name=g_hangout_id]").val(),
					event_reg_name: jQuery('#event_reg_name').val(),
					event_reg_email: jQuery('#event_reg_email').val(),
					event_reg_reminder: jQuery('#event_reg_reminder').val(),
					reminder_time: jQuery('#reminder_time').val(),
					makenow: makenow,
					locationsearch: jQuery('#locationsearch').val(),
					select_date: select_date,
					select_time: jQuery('#select_time').val(),
				};
				
			$('#ajax_loader').show();
			$('#g_hangout_submit_form').hide();
					
			$.post(g_hangout.ajaxurl, data, function(response) {
					
				if(jQuery.trim(response)=='You are already subscribed'){
					$('#ajax_loader').hide();	
					$('#g_hangout_submit_form').show(); 
					alert(response); 
				} 
				else {
					var split_data=response.split("ab#ab");
					
					var selected_date=split_data[0];					
					var selected_time=split_data[1];	
					var email=split_data[2];	
					var city=split_data[3];	
					if($('#watch_now').is(":checked")){		
						window.location=replay_url;						
					}else{
						if(selected_date!="" || selected_time!="" ){
							var schedule=selected_date+'_a_b_'+selected_time+'_a_b_'+email+'_a_b_'+city;
						}else{
							var schedule="";
						}
						
						if( selected_date!="ok" ){
							var add_url="&schedule="+schedule;
						}
						else{
							var add_url="";
						}
						
						window.location=thankyou_url+add_url;
					}
					
				}
				return false;
			});
		}
		return false;
	});
	
		
	jQuery('#g_hangout_reg_form1').submit(function(){
					
		err='';
		if(jQuery('#event_reg_name').val()==''){
			err  = 'Name Should not be Empty! \n';
		}
		if(jQuery('#event_reg_email').val()==''){
			err  = err  + 'Email Should not be Empty! \n';
		} else {
			
			if(validateEmail(jQuery('#event_reg_email').val())==false){
				err  = err  +  'Email id is Invalid! \n';
			}
		}

		/*if(jQuery('#event_reg_email_add').val()!=''){

			if(validateEmail(jQuery('#event_reg_email_add').val())==false){
				err  = err  +  'Additional Email id is Invalid! \n';
			}
		}*/
		if(err!=''){
			alert(err);
		} 
		else{

			var data = {
				action: 'ghangout_form_submit',
				g_hangout_id: jQuery("input[name=g_hangout_id]").val(),
				event_reg_name: jQuery('#event_reg_name').val(),
				event_reg_email: jQuery('#event_reg_email').val(),
				event_reg_reminder: jQuery('#event_reg_reminder').val(),
				reminder_time: jQuery('#reminder_time').val(),
				makenow: jQuery('#watch_now').val(),
				locationsearch: jQuery('#locationsearch').val(),
			};
				
				
			$.post(g_hangout.ajaxurl, data, function(response) {
				jQuery('.ho_vedio').show();
				jQuery('.ho_registation').hide();
				
				return false;
			});
		}
		return false;
	});
		
		// code for aweber setting add by thath singh ////
				
	$('#set_connection').click(function(){
		var auth_code=$('#hangout_Aweber_auth_code').val();
		var data = {
				action: 'ghangout_aweber_set_up',
				auth_code : auth_code

		};
		$.post(g_hangout.ajaxurl, data, function(response) {
			$('#set_up_data').html(data);
		});	
	});

});


	
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
		} 
		else{
			sendata = 'g_hangout_id='+g_hangout_id+'&event_reg_name='+gname+'&event_reg_email='+gemail+'&event_reg_reminder=0&event_reg_email_add=';
			
			jQuery.ajax({
				type: 'POST',
				url: site_url+'/wp-content/plugins/RunClickPlugin/ajax.php',					
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
			url: site_url+'/wp-content/plugins/RunClickPlugin/ajax.php',
			data: sendata,

			}).done(function(data) {
				
				//jQuery("form:first").submit();
				
			});
		}
	});	
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
		} 
		else{

			sendata = 'g_hangout_id='+g_hangout_id+'&event_reg_name='+gname+'&event_reg_email='+gemail+'&event_reg_reminder=0&event_reg_email_add=';

			
			jQuery.ajax({
				type: 'POST',
				url: site_url+'/wp-content/plugins/RunClickPlugin/ajax.php',					
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
		} 
		else{

			sendata = 'g_hangout_id='+g_hangout_id+'&event_reg_name='+gname+'&event_reg_email='+gemail+'&event_reg_reminder=0&event_reg_email_add=';
			
			
			
			jQuery.ajax({
				type: 'POST',
				url: site_url+'/wp-content/plugins/RunClickPlugin/ajax.php',
				data: sendata,

			}).done(function(data) {
				
				//jQuery("form:first").submit();
				
			});
		}
	});	
		
});
		

		

		

	
	
jQuery(document).ready(function(){
		

	$('#watch_now').click(function(){

		if ($('#watch_now').is(":checked")){
			$('#datepicker').attr("disabled","disabled");
			$('#select_date').attr("disabled","disabled");
			$('#select_time').attr("disabled","disabled");
			$('#locationsearch').attr("disabled","disabled");

		}
		else{
			$('#datepicker').removeAttr("disabled","disabled");
			$('#select_date').removeAttr("disabled","disabled");
			$('#select_time').removeAttr("disabled","disabled");
			$('#locationsearch').removeAttr("disabled","disabled");
		}
	});
	$('#reg_popup_form_submit').click(function(){
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var email	=	$('#event_reg_email').val();

		if($('#event_reg_name').val()=='' || $('#event_reg_name').val()=='Enter Your Full Name'){
			alert("First Name field is required.");
			$('#event_reg_name').focus();
			return false;
		}
		else if($('#event_reg_email').val()=='' || $('#event_reg_email').val()=='Enter Your Email' || !regex.test(email) ){
			$('#event_reg_email').focus();
			alert('Enter valid email.');
			return false;
		}
		else{

			var data = {
				action: 'ghangout_pop_up_form_submit',
				g_hangout_id: jQuery("input[name=g_hangout_id]").val(),
				event_reg_name: jQuery('#event_reg_name').val(),
				event_reg_email: jQuery('#event_reg_email').val(),
				event_reg_reminder: jQuery('#event_reg_reminder').val(),
				reminder_time: jQuery('#reminder_time').val(),
				makenow: jQuery('#watch_now').val(),
				locationsearch: jQuery('#locationsearch').val(),
			};

				

			$.post(g_hangout.ajaxurl, data, function(response) {
				if($.trim(response)=='You are already subscribed'){		
					alert(response); } else {
					window.open(thankyou_url);
				}

				return false;

			});
		}

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
	
	