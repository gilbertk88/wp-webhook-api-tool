<div class = "wrap audienti_input"  id="audienti_webhook_input">

<center><h2 class="audienti_main_title"> New Notifications </h2></center>

<?php echo $this->form->create($model->name); ?>

<hr>
	<div class="audienti_title_feild">Notification active</div>
	<div><?php echo $this->form->checkbox_input('notification_is_active',array('label' => '','value'=>1,'class'=>'audienti_input_feild')); ?></div>

	<div class="audienti_title_feild">Name</div>
	<div class="audienti_title_feild"><?php  echo $this->form->input('name', array('label' => '','class'=>'audienti_input_feild')); ?></div>

	<div class="audienti_title_feild">Trigger</div>
	<div><?php  echo $this->form->select_from_model('webhook_trigger',mvc_model('AudientiTrigger'), array(), array('label' => '','class'=>'audienti_input_feild')); ?></div>
	<br><br><br><br>
	<hr>
	<div><center><h2>EMAIL</h2></center></div>
	<hr>
	<div class="audienti_title_feild">Send email</div>
	<div><?php echo $this->form->checkbox_input('mail_active',array('label' => '','class'=>'audienti_input_feild')); ?></div>
	
	<div class="audienti_title_feild">Email subject</div>
	<div><?php echo $this->form->input('mail_subject',array('label' => '','class'=>'audienti_input_feild')); ?></div>

	<div class="audienti_title_feild">Email body</div>
	<div><?php echo $this->form->editor('mail_body',array('label' => '','class'=>'audienti_input_feild')); ?></div>

	<div>
	<center>
	<?php
		echo audienti_class('audienti_mail_manager')->show_main_view(0);
	?>
	</center>
	</div>
	<br><br><br><br>
	<hr>
	<div><center><h2>Webhooks</h2></center></div>
	<hr>
	<div class="audienti_title_feild">Notification active</div>
	<div><?php echo $this->form->checkbox_input('webhook_active',array('label' => '','value'=>1,'class'=>'audienti_input_feild')); ?></div>
	<div class="audienti_title_feild">Parameter Encoding Type</div>
	<div>
	<?php 
		$audienti_array_output=[];	
		$audienti_array_output['1'] = 'Form-encoded body';
		$audienti_array_output['2'] = 'JSON-encoded body';
		$audienti_array_output['3'] = 'URL parameters encoded (no body)';
		echo $this->form->select('args_encoding',array('options'=> $audienti_array_output ,'class'=>'audienti_input_feild'));
	?></div>
	<div>
	
		URLs
		<?php
			echo audienti_class('audienti_webhook_manager')->show_main_view_url(0);
		?>
			Body Arguments
		<?php		
			echo audienti_class('audienti_webhook_manager')->show_main_view_body_args(0);
		?>
	
	
	

		Header Arguments
		<?php		
			echo audienti_class('audienti_webhook_manager')->show_main_view_header_args(0);
		?>
	
	</div>
	
<br>z

<br>
<hr>
<?php echo "<center >".$this->form->end(' Add ')."</center>"; ?>

</div>
<?php echo audienti_class('audienti_merge_tags')->display_tag_onsidebar(); ?>