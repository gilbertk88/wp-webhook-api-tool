<?php
class audienti_cf7_tags{

	public function init(){
		add_filter('audienti_wpcf7_form_data_list',array($this,'form_data_list'));
		
	}

	public function form_title($param=''){
		
		//var_dump($param['data']['var1']);
		$html='<table><li>';


		foreach ($param['data']['var1'] as $key => $value) {
			
			if (strpos($key, '_') !== 0){
				$html .= '<tr><td>'.$key.':</td><td>'.$value.'</td></tr>';
			}
		}

		$html.='</table>';

		return $html;
	}

	
	
}
?>