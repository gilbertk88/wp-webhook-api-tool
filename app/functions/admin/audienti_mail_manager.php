<?php
class audienti_mail_manager{
	public function init(){
		add_action("wp_ajax_audienti_delete_recipient",  array($this, "delete_recipient"))	;	
	}
	
	public function show_main_view($webhook_id){
            $show_main_view=$this->list_recipients($webhook_id);
            $show_main_view.=$this->add_recepient($webhook_id);
		
            return $show_main_view;
	}
	
	
	public function delete_recipient(){
		
		echo json_encode(["deleted_recipient"=>mvc_model('AudientiMailRecipient')->delete($_POST['audienti_recipient_id'])]);
			
		wp_die();		
	}
	
	public function list_recipients($webhook_id=0){
		$audienti_next_recipient_node=0;
		$AudientiMailRecipient=[];
		if($webhook_id>0){
			$AudientiMailRecipient = mvc_model('AudientiMailRecipient')->find(array(
				'conditions'=>array(
					'webhook_id'=>$webhook_id,
				)));
		}
		
		$Recipientlist	=	'<table>';
		$Recipientlist .= 	'<tr><td><b>Recipient Type</b></td><td><b>Recipient Details</b></td></td><td></td></tr>';
            
		if(count($AudientiMailRecipient)>0){
            foreach($AudientiMailRecipient as $Recipient){
				$Recipientlist .= '<tr id="audienti_main_row_recipient_'.$audienti_next_recipient_node.'"><td>
				<select name="more_data[AudientiMailRecipient]['.$audienti_next_recipient_node.'][type]" type="text" value="'.$Recipient->type.'" class="audienti_input_feild">
					<option value=""></option>
					<option value="email" selected="selected">Email</option>
				</select>
				</td><td><input id="" name="more_data[AudientiMailRecipient]['.$audienti_next_recipient_node.'][recipient]" type="text" value="'.$Recipient->recipient.'" class="audienti_input_feild"><input id="audienti_id_recipient_'.$audienti_next_recipient_node.'" name="more_data[AudientiMailRecipient]['.$audienti_next_recipient_node.'][id]" type="hidden" value="'.$Recipient->id.'" class="audienti_input_feild"></td><td><center><span class="audienti_close_recipient_class" id="audienti_close_recipient_'.$audienti_next_recipient_node.'">[X]</span></center></td></tr><br>';
				$audienti_next_recipient_node++;
            }
		}
		else{
			$Recipientlist .= '<tr><td>Please add a recipient </td><td></td></tr>';
		}
		$Recipientlist .= '<tr id="audienti_additional_mail_recipient"><script type="text/javascript">audienti_next_recipient_node='.$audienti_next_recipient_node.'</script></tr><br>';
		return $Recipientlist;
	}
	
	public function add_recepient($webhook_id){
		$Recipientform = '<tr><td></td><td></td></td><td><input type="submit" value="Add Recipient" id="audienti_add_recipient_node" class="audienti_add_node"></td></tr>';
		$Recipientform .= '</table><br>';
		return $Recipientform ;
	}
}
?>