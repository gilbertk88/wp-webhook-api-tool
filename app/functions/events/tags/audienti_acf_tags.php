<?php
class audienti_acf_tags{

	public function init(){
		add_filter('audienti_acf',array($this,'acf_tag'));		
	}

	public function acf_tag($param=[]){
		$tag_name_var_key= trim($param['tag_custom_info'],"{acf_}");

		global $post;
		return get_field( $param['tag_custom_info'] ); //$tag_name_var_key;//get_field($tag_name_var_key);
	}
	
}
?>