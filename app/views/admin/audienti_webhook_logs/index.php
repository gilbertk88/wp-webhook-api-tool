<div class = "wrap audienti_input">
    <hr>
    <center><h2 class="audienti_main_title">Notification Logs</h2><br>
	
	<br>
    <table class="audienti_list_table">
            <tr style="width:100%;">
                    <td class="audienti_sub_title">
                            <b>Notification</b>
                    </td>
                    <td class="audienti_sub_title">
                            <b>Executed successful</b>
                    </td>
                    <td class="audienti_sub_title">
                            <b>Retry</b>
                    </td>
                    </td>
                    <td class="audienti_sub_title">
                           <b>Log Type</b>
                    </td>
					<td class="audienti_sub_title">
                           <b>Time</b>
                    </td>
            </tr>
    <?php  foreach ($objects as $object): ?>

        <?php  $this->render_view('_item', array('locals' => array('object' => $object))); ?>

    <?php endforeach; ?>
    </table>
    <?php //echo $this->pagination(); ?>
<hr>
</div>

