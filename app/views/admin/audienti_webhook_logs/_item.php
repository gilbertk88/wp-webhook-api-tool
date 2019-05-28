<tr style="width:100%;">
    <td style="padding:20px 30px;">
		<?php  
			if (isset($object->id)){
				
				echo '<span class="audienti_list_name">'.mvc_model('AudientiWebhook')->find_by_id(mvc_model('AudientiWebhookEvent')->find_by_id($object->webhook_event_id)->webhook_id)->name.'</span>';
			}
			else{
				echo '(Not Set)';
			}
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php  
			if (isset($object->successful)){
				$audienti_successful=array('failed','successful');
				echo $audienti_successful[$object->successful];
			}
			else
				echo '(Not Set)';
		?>
	</td>	
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->retry)){
				$audienti_retry=array('first attempt','retry');
				echo $audienti_retry[$object->successful];
			}
			else
				echo '(Not Set)'
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->log_type)){
				$audienti_log_type=array(1=>'Notification trigger',2=>'Notification modification');
				echo $audienti_log_type[$object->log_type];
			}
			else
				echo '(Not Set)'
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->log_type)){
				echo $object->timestamp;
			}
			else
				echo '(Not Set)'
		?>
	</td>
</tr>