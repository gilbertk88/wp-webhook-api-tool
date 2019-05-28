<div class = "wrap audienti_input">
    <hr>
	<?php echo '
				<span id="right_audienti_menu_item" class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_triggers", "action" => "add", "id" =>"" )).'">New Trigger</a></span>'; ?>
    <center><h2 class="audienti_main_title">All Triggers</h2></center>
    <center>
    <table class="audienti_list_table">
            <tr style="width:100%;">
                    <td class="audienti_sub_title">
                            <b>Name</b>
                    </td>
                    <td class="audienti_sub_title">
                            <b>Wordpress Action</b>
                    </td>
                    <td class="audienti_sub_title">
                           <b></b>
                    </td>
            </tr>
    <?php 
	foreach ($objects as $object): 
	$this->render_view('_item', array('locals' => array('object' => $object))); 
	endforeach; ?>
    </table>
    <?php //echo $this->pagination(); ?>
<hr>
</div>

