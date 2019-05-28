<?php
class audienti_gf_tags{

	public function init(){
		add_filter('audienti_gf_title',array($this,'title'),1,1);
		add_filter('audienti_gf_description',array($this,'description'),1,1);
		add_filter('audienti_gf_date_created',array($this,'date_created'),1,1);
		add_filter('audienti_gf_source_url',array($this,'source_url'),1,1);
		add_filter('audienti_gf_user_agent',array($this,'user_agent'),1,1);
		add_filter('audienti_gf_form_id',array($this,'form_id'),1,1);
		add_filter('audienti_gf_list_of_submission',array($this,'list_of_submission'),1,1);
		
	}	
	
	public function parse_gravity_form_parser($param = []){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		$arr_val=[];
		foreach($form["fields"] as $val){
			array_push( $arr_val, [$val["label"] => $entries[$val["id"]]]);
		}

		return $arr_val;
	}

	public function title($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		return $entries['title'];
	}
	
	public function description($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		return $entries['description'];
	}

	public function date_created($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		return $form['date_created'];
	}
	
	public function source_url($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];
		//echo "***************************************************************";
		//var_dump($form);
		return $form['source_url'];
	}

	public function user_agent($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		return $form['user_agent'];
	}

	public function form_id($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		return $form['id'];
	}

	public function list_of_submission($param = [] ){
		$form=$param['data']['var1'];
		$entries=$param['data']['var2'];

		$list_of_submission='<table>';
		foreach ($entries['fields'] as $single_field) {
			$list_of_submission .='<tr><td>'.$single_field->label.'</td><td>'.$form[$single_field->id].'</td></tr>';
		}
		$list_of_submission .= '</table>';

		return $list_of_submission;
	}
}
?>