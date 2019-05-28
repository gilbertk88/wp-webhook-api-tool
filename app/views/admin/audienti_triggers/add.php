<div class = "wrap audienti_input">

<center><h2 class="audienti_main_title"> New Trigger </h2></center>

<?php echo $this->form->create($model->name); ?>

<hr>
	<div class="audienti_title_feild">Name</div>
	<div class="audienti_title_feild"><?php echo $this->form->input('name', array('label' => '','class'=>'audienti_input_feild')); ?></div>
	
	<div class="audienti_title_feild">Action</div>
	<div class="audienti_title_feild"><?php 
	$audienti_array_output=[];
	global $wp_filter;
	foreach($wp_filter as $key => $value){
		$audienti_array_output[$key] = $key;
	}
	
	echo $this->form->select('action',array('options'=> $audienti_array_output ,'class'=>'audienti_input_feild')); ?> </div>
	
<br>
<br>
<hr>
<?php echo "<center >".$this->form->end(' Create ')."</center>"; ?>

</div>

<div>
</div>