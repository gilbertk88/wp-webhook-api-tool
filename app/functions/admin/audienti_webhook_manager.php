<?php
class audienti_webhook_manager{
	public function init(){
		add_action("wp_ajax_audienti_delete_url",  array($this, "delete_url"));	
		add_action("wp_ajax_audienti_delete_args",  array($this, "delete_args"));
		add_action("wp_ajax_audienti_change_activate_notification",  array($this, "audienti_change_activate_notification"));
	}
	
	public function show_main_view_url($webhook_id){
            $show_main_view=$this->list_url($webhook_id);
            $show_main_view.=$this->add_url($webhook_id);
		
            return $show_main_view;
	}
	
	public function delete_url(){
		
		echo json_encode(["deleted_url"=>mvc_model('AudientiWebhookUrl')->delete($_POST['audienti_url_id'])]);
		
		wp_die();		
	}
	
	public function list_url($webhook_id=0){
		$audienti_next_url_node=0;
		$AudientiWebhookUrl=[];
		if($webhook_id>0){
			$AudientiWebhookUrl = mvc_model('AudientiWebhookUrl')->find(array(
				'conditions'=>array(
					'webhook_id'=>$webhook_id,
				)));
		}
		
		$URLlist	=	'<table>';
		$URLlist .= 	'<tr><td><b>Url Type</b></td><td><b>Url Details</b></td></td><td></td></tr>';
            
		if(count($AudientiWebhookUrl)>0){
			$post_selected="";
			$get_selected="";
			$delete_selected="";
			
            foreach($AudientiWebhookUrl as $Url){
				if($Url->type=='POST'){
					$post_selected='selected="selected"';
				}
				elseif($Url->type=='GET'){
					$get_selected='selected="selected"';
				}
				elseif($Url->type=='PUT'){
					$delete_selected='selected="selected"';
				}
				$URLlist .= '<tr id="audienti_main_row_url_'.$audienti_next_url_node.'"><td>
				<select name="more_data[AudientiWebhookUrl]['.$audienti_next_url_node.'][type]" type="text" value="'.$Url->type.'" class="audienti_input_feild">
					<option value=""></option>
					<option value="POST" '.$post_selected.'>POST</option>
					<option value="GET" '.$get_selected.'>GET</option>
					<option value="PUT" '.$put_selected.'>PUT</option>
				</select>
				</td><td><input id="" name="more_data[AudientiWebhookUrl]['.$audienti_next_url_node.'][url]" type="text" value="'.$Url->url.'" class="audienti_input_feild"><input id="audienti_id_url_'.$audienti_next_url_node.'" name="more_data[AudientiWebhookUrl]['.$audienti_next_url_node.'][id]" type="hidden" value="'.$Url->id.'" class="audienti_input_feild"></td><td><center><span class="audienti_close_url_class" id="audienti_close_url_'.$audienti_next_url_node.'">[X]</span></center></td></tr><br>';
				$audienti_next_url_node++;
            }
		}
		else{
			$URLlist .= '<tr><td>Please add a url </td><td></td></tr>';
		}
		$URLlist .= '<tr id="audienti_additional_url"><script type="text/javascript">audienti_next_url_node='.$audienti_next_url_node.'</script></tr><br>';
		return $URLlist;
	}
	
	public function add_url($webhook_id){
		$URLform = '<tr><td></td><td></td></td><td><input type="submit" value="Add Url" id="audienti_add_url_node" class="audienti_add_node"></td></tr>';
		$URLform .= '</table><br>';
		return $URLform ;
	}
	
	
	public function audienti_change_activate_notification(){
			
		//find notification
		$notification_is_active=mvc_model('AudientiWebhook')->find_by_id($_POST['audienti_notification_id'])->notification_is_active;
		//change notification
		if($notification_is_active > 0 ){
			mvc_model('AudientiWebhook')->update($_POST['audienti_notification_id'],array(
				'notification_is_active'=>0
			));
		}
		else{
			mvc_model('AudientiWebhook')->update($_POST['audienti_notification_id'],array(
				'notification_is_active'=>1
			));
		}
		echo json_encode(["notification_is_active"=>mvc_model('AudientiWebhook')->find_by_id($_POST['audienti_notification_id'])->notification_is_active]);
		
		wp_die();	
	}
	
	//------------------------------body args section----------------------------------------
	
	public function show_main_view_body_args($webhook_id){
            $show_main_view=$this->list_args($webhook_id);
            $show_main_view.=$this->add_args($webhook_id);
		
            return $show_main_view;
	}
		
	public function delete_args(){
		
		echo json_encode(["deleted_args"=>mvc_model('AudientiWebhookArgs')->delete($_POST['audienti_args_id'])]);
		
		wp_die();		
	}
	
	public function list_args($webhook_id=0){
		$audienti_next_args_node=0;
		$AudientiWebhookArgs=[];
		if($webhook_id>0){
			$AudientiWebhookArgs = mvc_model('AudientiWebhookArgs')->find(array(
				'conditions'=>array(
					'webhook_id'=>$webhook_id,
					'type'=>'body',
				)));
		}
		
		$Argslist	=	'<table>';
		$Argslist .= 	'<tr><td><b>Key</b></td><td><b>Value</b></td></td><td></td></tr>';
            
		if(count($AudientiWebhookArgs)>0){
            foreach($AudientiWebhookArgs as $args){
				$Argslist .= '<tr id="audienti_main_row_args_'.$audienti_next_args_node.'"><td>
					<input id="" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][key_name]" type="text" value="'.$args->key_name.'" class="audienti_input_feild">
				</td><td>
					<input id="" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][value]" type="text" value="'.$args->value.'" class="audienti_input_feild"><input id="audienti_id_args_'.$audienti_next_args_node.'" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][id]" type="hidden" value="'.$args->id.'" class="audienti_input_feild"> <input id="audienti_id_args_'.$audienti_next_args_node.'" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][type]" type="hidden" value="body" >
				</td><td><center><span class="audienti_close_args_class" id="audienti_close_args_'.$audienti_next_args_node.'">[X]</span></center></td></tr><br>';
				$audienti_next_args_node++;
            }
		}
		else{
			$Argslist .= '<tr><td>Please add values below </td><td></td></tr>';
		}
		$Argslist .= '<tr id="audienti_additional_args"><script type="text/javascript">audienti_next_args_node='.$audienti_next_args_node.'</script></tr><br>';
		return $Argslist;
	}
	
	public function add_args($webhook_id){
		$Argsform = '<tr><td></td><td></td></td><td><input type="submit" value="Add args" id="audienti_add_args_node" class="audienti_add_node"></td></tr>';
		$Argsform .= '</table><br>';
		return $Argsform ;
	}
	
	//-----------------------------------------------header args------------------------------------------------------------------------------
	
	
	public function show_main_view_header_args($webhook_id){
            $show_main_view=$this->list_header_args($webhook_id);
            $show_main_view.=$this->add_header_args($webhook_id);
		
            return $show_main_view;
	}
	
	public function list_header_args($webhook_id=0){
		$audienti_next_args_node=50;
		$AudientiWebhookArgs=[];
		if($webhook_id>0){
			$AudientiWebhookArgs = mvc_model('AudientiWebhookArgs')->find(array(
				'conditions'=>array(
					'webhook_id'=>$webhook_id,
					'type'=>'header',
				)));
		}
		
		$Argslist	=	'<table>';
		$Argslist .= 	'<tr><td><b>Key</b></td><td><b>Value</b></td></td><td></td></tr>';
            
		if(count($AudientiWebhookArgs)>0){
            foreach($AudientiWebhookArgs as $args){
				$Argslist .= '<tr id="audienti_main_row_args_'.$audienti_next_args_node.'"><td>
					<input id="" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][key_name]" type="text" value="'.$args->key_name.'" class="audienti_input_feild">
				</td><td>
					<input id="" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][value]" type="text" value="'.$args->value.'" class="audienti_input_feild"><input id="audienti_id_args_'.$audienti_next_args_node.'" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][id]" type="hidden" value="'.$args->id.'" class="audienti_input_feild"> <input id="audienti_id_args_'.$audienti_next_args_node.'" name="more_data[AudientiWebhookArgs]['.$audienti_next_args_node.'][type]" type="hidden" value="header" >
				</td><td><center><span class="audienti_close_args_class" id="audienti_close_args_'.$audienti_next_args_node.'">[X]</span></center></td></tr><br>';
				$audienti_next_args_node++;
            }
		}
		else{
			$Argslist .= '<tr><td>Please add values below </td><td></td></tr>';
		}
		$Argslist .= '<tr id="audienti_additional_header_args"><script type="text/javascript">audienti_next_args_node='.$audienti_next_args_node.'</script></tr><br>';
		return $Argslist;
	}
	
	public function add_header_args($webhook_id){
		$Argsform = '<tr><td></td><td></td></td><td><input type="submit" value="Add Header args" id="audienti_add_header_args_node" class="audienti_add_node"></td></tr>';
		$Argsform .= '</table><br>';
		return $Argsform ;
	}
	
	
	
}
?>