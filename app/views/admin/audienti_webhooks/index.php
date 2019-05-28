<div class = "wrap audienti_input"><hr><br>
<?php echo '<span id="right_audienti_menu_item" class="right audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_webhooks", "action" => "add", "id" =>"")).'">New Notification</a></span>'; ?>
    
    <center><h2 class="audienti_main_title">All Notifications</h2></center>
    <center>
    <table class="audienti_list_table">
            <tr style="width:100%;">
					<td class="audienti_sub_title">
                            <b>Active</b>
                    </td>
                    <td class="audienti_sub_title">
                            <b>Title</b>
                    </td>
                    <td class="audienti_sub_title">
                            <b>Trigger</b>
                    </td>  
                    <td class="audienti_sub_title">
                            <b>Last Event Trigger</b>
                    </td>
					<td class="audienti_sub_title">
                            <b>Number of Triggers</b>
                    </td>
					<td class="audienti_sub_title">
                            <b>Unsuccessful Attempts</b>
                    </td>
                    </td>
                    <td class="audienti_sub_title">
                           <b>Active Retries</b>
                    </td>
            </tr>
    <?php  foreach ($objects as $object): ?>

        <?php  $this->render_view('_item', array('locals' => array('object' => $object))); ?>

    <?php endforeach; ?>
    </table>
    <?php //echo $this->pagination(); ?>
<hr>
</div>
<?php  foreach ($objects as $object): ?>
	<script type="text/javascript">
		audienti_number_of_notifications={};
		<?php echo  "audienti_number_of_notifications.AudientiWebhookNotificationIsActive".$object->id." = ".$object->id.";"; ?>		
	</script>
<?php endforeach; ?>
