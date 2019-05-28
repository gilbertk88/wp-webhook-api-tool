<?php
class audienti_ump_tags{

	public function init(){
		add_filter('audienti_um',array($this,'um_tag'));
	}
	
 	public function um_tag($param=[]){
		$tag_name_var_key= trim($param['tag_custom_info'],"{um_}");
		return um_user($tag_name_var_key);
	}
	
}
?>