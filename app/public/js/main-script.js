jQuery(document).ready(function($) {
	function audienti_change_activate_notification(notification_id){
		//alert('activate');
		//replace info on relevant location
		var data_l= {
			"action": "audienti_change_activate_notification",
			"audienti_notification_id":notification_id
		};
		
		jQuery.post(ajax_object.ajaxurl, data_l, function(response) {
			if(response !== undefined){
				response = JSON.parse(response);
				console.log(response);
			}
		});
	}
	
	if(typeof(audienti_number_of_notifications) !== 'undefined'){
		$.each(audienti_number_of_notifications,function(index, value){
			$("#"+index).change(function(){
				audienti_change_activate_notification(value);
			});
		});
	}
	function audienti_close_recipient(i){
		$("#audienti_close_recipient_"+i).click(function(){
			$("#audienti_main_row_recipient_"+i).html('');
		});
	}
		
	function audienti_del_recipient(recipient_id){
		var data_l = {
			"action": "audienti_delete_recipient",
			"audienti_recipient_id":recipient_id
		};
		
		jQuery.post(ajax_object.ajaxurl, data_l, function(response) {
			if(response !== undefined){
				response = JSON.parse(response);
			}
		});
	}
	
	function audienti_delete_recipient_on_server(i){
		$("#audienti_close_recipient_"+i).click(function(){
			recipient_id= $("#audienti_id_recipient_"+i).val();
			if(recipient_id>0){
				audienti_del_recipient(recipient_id);
			}
		});
	}
	
	$('#audienti_add_recipient_node').click(function(e){
		e.preventDefault();
		$('#audienti_additional_mail_recipient').before('<tr id="audienti_main_row_recipient_'+audienti_next_recipient_node+'"><td>	<select name="more_data[AudientiMailRecipient]['+ audienti_next_recipient_node +'][type]" type="text"  class="audienti_input_feild">	<option value=""></option> <option value="email" selected="selected">Email</option>  </select> </td><td><input id="" name="more_data[AudientiMailRecipient]['+audienti_next_recipient_node+'][recipient]" type="email" value="" class="audienti_input_feild"></td><td><center><span class="audienti_close_recipient_class" id="audienti_close_recipient_'+audienti_next_recipient_node+'">[X]</span></center></td></tr><br>');
		audienti_close_recipient(audienti_next_recipient_node);
		audienti_next_recipient_node++;
	});
	
	for(var i=0; i < audienti_next_recipient_node ; i++ ){		
		audienti_delete_recipient_on_server(i);
		audienti_close_recipient(i);
	}
	
	//-----------------------url -------------------------------------
	
	function audienti_close_url(i){
		$("#audienti_close_url_"+i).click(function(){
			$("#audienti_main_row_url_"+i).html('');
		});
	}
		
	function audienti_del_url(url_id){
		
		var data_l= {
			"action": "audienti_delete_url",
			"audienti_url_id":url_id
		};
		
		jQuery.post(ajax_object.ajaxurl, data_l, function(response) {
			if(response !== undefined){
				response = JSON.parse(response);
			}
		});
	}
	
	function audienti_delete_url_on_server(i){
		$("#audienti_close_url_"+i).click(function(){
			url_id= $("#audienti_id_url_"+i).val();
			
			if(url_id>0){
				audienti_del_url(url_id);
			}
		});
	}
	
	$('#audienti_add_url_node').click(function(e){
		e.preventDefault();
		$('#audienti_additional_url').before('<tr id="audienti_main_row_url_'+audienti_next_url_node+'"><td>	<select name="more_data[AudientiWebhookUrl]['+audienti_next_url_node+'][type]" class="audienti_input_feild"><option value=""></option><option value="POST" selected="selected">POST</option><option value="GET" >GET</option>	<option value="PUT" >PUT</option></select> </td><td><input id="" name="more_data[AudientiWebhookUrl]['+audienti_next_url_node+'][url]" type="url" value="" class="audienti_input_feild"></td><td><center><span class="audienti_close_url_class" id="audienti_close_url_'+audienti_next_url_node+'">[X]</span></center></td></tr><br>');
		audienti_close_url(audienti_next_url_node);
		audienti_next_url_node++;
	});
	
	for(var i=0; i < audienti_next_url_node ; i++ ){		
		audienti_delete_url_on_server(i);
		audienti_close_url(i);
	}

	//-----------------------args -------------------------------------
	
	function audienti_close_args(i){
		$("#audienti_close_args_"+i).click(function(){
			$("#audienti_main_row_args_"+i).html('');
		});
	}
		
	function audienti_del_args(args_id){
		//replace info on relevant location
		var data_l= {
			"action": "audienti_delete_args",
			"audienti_args_id":args_id
		};
		
		//ajax_object.ajax_url="http://localhost/wordpress/wp-admin/admin-ajax.php";
		jQuery.post(ajax_object.ajaxurl, data_l, function(response) {
			if(response !== undefined){
				response = JSON.parse(response);
				console.log(response);
			}
		});
	}
	
	function audienti_delete_args_on_server(i){
		$("#audienti_close_args_"+i).click(function(){
			args_id= $("#audienti_id_args_"+i).val();
			if(args_id>0){
				audienti_del_args(args_id);
			}
		});
	}
	
	$('#audienti_add_args_node').click(function(e){
		e.preventDefault();
		$('#audienti_additional_args').before('<tr id="audienti_main_row_args_'+audienti_next_args_node+'"><td><input id="" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][key_name]" type="text" value="" class="audienti_input_feild"></td><td><input id="" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][value]" type="text" value="" class="audienti_input_feild"> <input id="audienti_id_args_'+audienti_next_args_node+'" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][type]" type="hidden" value="body" > </td><td><center><span class="audienti_close_args_class" id="audienti_close_args_'+audienti_next_args_node+'">[X]</span></center></td></tr><br>');
		audienti_close_args(audienti_next_args_node);
		audienti_next_args_node++;
	});
	
	$('#audienti_add_header_args_node').click(function(e){
		e.preventDefault();
		$('#audienti_additional_header_args').before('<tr id="audienti_main_row_args_'+audienti_next_args_node+'"><td><input id="" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][key_name]" type="text" value="" class="audienti_input_feild"></td><td><input id="" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][value]" type="text" value="" class="audienti_input_feild"> <input id="audienti_id_args_'+audienti_next_args_node+'" name="more_data[AudientiWebhookArgs]['+audienti_next_args_node+'][type]" type="hidden" value="header" > </td><td><center><span class="audienti_close_args_class" id="audienti_close_args_'+audienti_next_args_node+'">[X]</span></center></td></tr><br>');
		audienti_close_args(audienti_next_args_node);
		audienti_next_args_node++;
	});
	$('#audienti_tags_switcher').change(function(){
		console.log('audienti_tags_switcher');
		audienti_tags_switcher = $('#audienti_tags_switcher').val();
		console.log(audienti_tags_switcher);
		if(audienti_tags_switcher == 'audienti_user_tags'){
			$('.audienti_user_tags').show();
			
			$('.audienti_wpf_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_ump_tags').hide();
			$('.audienti_cf7_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_post_tags'){
			$('.audienti_post_tags').show();
			
			$('.audienti_wpf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_ump_tags').hide();
			$('.audienti_cf7_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_gf_tags'){
			$('.audienti_gf_tags').show();
			
			$('.audienti_wpf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_ump_tags').hide();
			$('.audienti_cf7_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_wpf_tags'){
			$('.audienti_wpf_tags').show();
			
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_ump_tags').hide();
			$('.audienti_cf7_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_ump_tags'){			
			$('.audienti_ump_tags').show();
			
			$('.audienti_wpf_tags').hide();
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_cf7_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_cf7_tags'){	
			$('.audienti_cf7_tags').show();
			
			$('.audienti_ump_tags').hide();			
			$('.audienti_wpf_tags').hide();
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_events_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_events_tags'){	
			$('.audienti_events_tags').show();
			
			$('.audienti_cf7_tags').hide();			
			$('.audienti_ump_tags').hide();			
			$('.audienti_wpf_tags').hide();
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_cpt_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_cpt_tags'){
			$('.audienti_cpt_tags').show();
			
			$('.audienti_events_tags').hide();			
			$('.audienti_cf7_tags').hide();			
			$('.audienti_ump_tags').hide();			
			$('.audienti_wpf_tags').hide();
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
			$('.audienti_acf_tags').hide();
		}
		else if(audienti_tags_switcher == 'audienti_acf_tags'){
			$('.audienti_acf_tags').show();
			
			$('.audienti_cpt_tags').hide();			
			$('.audienti_events_tags').hide();			
			$('.audienti_cf7_tags').hide();			
			$('.audienti_ump_tags').hide();			
			$('.audienti_wpf_tags').hide();
			$('.audienti_gf_tags').hide();
			$('.audienti_user_tags').hide();
			$('.audienti_post_tags').hide();
		}
	});
	
	for(var i=0; i < audienti_next_args_node ; i++ ){
		audienti_delete_args_on_server(i);
		audienti_close_args(i);
	}

});

