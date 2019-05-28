<?php
class audienti_wpf_tags{

	public function init(){
		add_filter('audienti_wpforms_submission_values',array($this,'submission_values'));
		add_filter('audienti_wpforms_post_id',array($this,'post_id'));
		add_filter('audienti_wpforms_author',array($this,'form_author'));		
	}

	public function submission_values($param){
		
		$submission_list="<ul>";

		foreach($param['data']["var1"] as $value) {
			$submission_list .= "<li>". $value["name"]." : ".$value["value"]."</li>";
		}
		
		$submission_list .="</ul>";

		return $submission_list;
	}

	public function post_id($param){
		return $param['data']["var2"]["id"];
	}

	public function form_author($param){
		return $param['data']["var2"]['author'];
	}	
}
?>