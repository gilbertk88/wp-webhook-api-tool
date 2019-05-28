<tr style="width:100%;">
   <td style="padding:20px 30px;">
		<?php
			if (isset($object->name)){
				
				echo '<span class="audienti_list_name">'.$object->name.'</span>';
			}
			else{
				echo '(anonymous)';
			}
		?>
	</td>
	<td style="padding:20px 30px;">
		<?php
			if (isset($object->name))
				echo $object->name;
			else
				echo '(undefined)';
		?>
	</td>
	<td class="audienti_house_keeping">
		<?php   
			if (isset($object->__id)){
					echo "<center>
					<a class='audienti_house_keeping_link' href=".mvc_admin_url(array('controller' => 'admin_audienti_triggers', 'action' => 'edit', 'id' => $object->__id)).">Edit</a></center>";
				}				
				else
					echo '---';
		?>
	</td>
</tr>