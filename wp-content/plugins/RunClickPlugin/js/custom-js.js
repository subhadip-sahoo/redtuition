//added by thath singh	
jQuery(document).ready(function($) {
		jQuery('#add_new_hangout_event').click(function(){
		
		if(jQuery('#hangout_title').val()==''){
		alert('Title field is must');
		return false;
		}
		
		});
			
		jQuery('#checkAll').click(function(){
		
		if(jQuery('#checkAll').is(':checked')){
		
		jQuery(".select_time").prop("checked", true);
		}else{
		jQuery(".select_time").prop("checked", false);
		}
		if(jQuery('.select_time').is(':checked')){
		jQuery('#checkAll').prop("checked", true)
		}
		
		
		});		
		jQuery('#selectday').click(function(){		
		jQuery('#showdayarea').show();				
		});	
		jQuery('#select_cal').click(function(){		
		jQuery('#showdayarea').hide();				
		});
		jQuery('#select_date_sys').click(function(){		
		jQuery('#showdayarea').hide();				
		});		
		jQuery('#make_now_yes').click(function(){		
		jQuery('#date_system_area').hide();				
		});	
		jQuery('#make_now_no').click(function(){		
		jQuery('#date_system_area').show();				
		});	
		jQuery('#checkAllday').click(function(){
		if(jQuery('#checkAllday').is(':checked')){
		jQuery(".select_day").prop("checked", true);
		}else{		
		jQuery(".select_day").prop("checked", false);		
		}		
		if(jQuery('.select_day').is(':checked')){		
		jQuery('#checkAllday').prop("checked", true)	
		}						
		});
		jQuery('#show_by_button_yes').click(function(){		
		jQuery('#by_button').show();				
		});	
		jQuery('#show_by_button_no').click(function(){		
		jQuery('#by_button').hide();				
		});	
		jQuery('#show_vote_form_yes').click(function(){		
		jQuery('#vote_form').show();				
		});	
		jQuery('#show_vote_form_no').click(function(){		
		jQuery('#vote_form').hide();				
		});	
		jQuery('#show_optin_form_yes').click(function(){		
		jQuery('#optin_form').show();				
		});	
		jQuery('#show_optin_form_no').click(function(){		
		jQuery('#optin_form').hide();				
		});
		
		
		
});