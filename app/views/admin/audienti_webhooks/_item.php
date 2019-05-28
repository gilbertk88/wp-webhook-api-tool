<tr style="width:100%;">
	<td style="padding:20px 30px;">
		<span class="sl_list_name">
		<input id="AudientiWebhookNotificationIsActive<?php echo  $object->id; ?>" name="AudientiWebhookNotificationIsActive<?php echo  $object->id; ?>" type="checkbox" <?php if($object->notification_is_active){ ?>checked="checked" value="1" <?php } ?>  class="audienti_input_feild">
		</span>
	</td>
    <td style="padding:20px 30px;">
		<?php  
			if (isset($object->name)){
				
				echo '<span class="sl_list_name">'.$object->name.'</span>';
			}
			else{
				echo '(Not Set)';
			}
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php  
			if (isset($object->webhook_trigger) && $object->webhook_trigger>0)
				echo mvc_model('AudientiTrigger')->find_by_id($object->webhook_trigger)->name;
			else
				echo '(Not Set)';
		?>
	</td>	
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->last_time_event_is_triggered ))
				echo $object->last_time_event_is_triggered ;
			else
				echo '(Not Set)';
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->number_of_times_event_was_trigger ))
				echo $object->number_of_times_event_was_trigger ;
			else
				echo '(Not Set)';
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->unsuccessful_attempts_to_send_webhook ))
				echo $object->unsuccessful_attempts_to_send_webhook ;
			else
				echo '(Not Set)';
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php    
			if (isset($object->id))
				echo audienti_class('audienti_events_manager')->WebhookLog_unsuccessful_count($object->id);
			else
				echo '(Not Set)';
		?>
	</td>
	<td class="audienti_house_keeping">
		<?php   
			if (isset($object->__id)){
					echo "<center><a class='audienti_house_keeping_link' href=".mvc_admin_url(array('controller' => 'audienti_webhooks', 'action' => 'edit', 'id' => $object->__id)).">View</a>";
					}				
				else
					echo '---';
		?>
	</td>
</tr>