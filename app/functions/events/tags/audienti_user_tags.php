<?php
class audienti_user_tags{

	public function init(){
		add_filter('audienti_user_id',array($this,'user_ID'),1,1);
		add_filter('audienti_user_login',array($this,'user_login'),1,1);
		add_filter('audienti_user_email',array($this,'user_email'),1,1);
		add_filter('audienti_user_display_name',array($this,'user_display_name'),1,1);
		add_filter('audienti_user_first_name',array($this,'user_first_name'),1,1);
		add_filter('audienti_user_last_name',array($this,'user_last_name'),1,1);
		add_filter('audienti_user_country',array($this,'user_country'),1,1);
		add_filter('audienti_user_bio',array($this,'user_bio'),1,1);

		add_filter('audienti_user_url',array($this,'user_url'),1,1);
		add_filter('audienti_user_registered',array($this,'user_registered'),1,1);
		add_filter('audienti_user_roles',array($this,'user_roles'),1,1);
	}
	
	public function user_ID($param=''){
		return get_current_user_id();		
	}
	
	public function user_login(){
		
		return get_userdata(get_current_user_id())->data->user_nicename;		
	}
	
	public function user_email(){

		return get_userdata(get_current_user_id())->data->user_email;
		}

	public function user_display_name(){
		$user_id = get_current_user_id();

		return get_user_meta($user_id,'nickname', true);
		}

	public function user_first_name(){
		$user_id = get_current_user_id();

		return get_user_meta($user_id,'first_name', true);
		}

	public function user_last_name(){
		$user_id = get_current_user_id();

		return get_user_meta($user_id,'last_name', true);
		}

	public function user_country(){
		$user_id = get_current_user_id();

		return get_user_meta($user_id,'country', true);
		}

	public function user_bio(){
		$user_id = get_current_user_id();

		return get_user_meta($user_id,'description', true);
		}

	public function user_url(){
		return get_userdata(get_current_user_id())->data->user_url;
		}

	public function user_registered(){
		return get_userdata(get_current_user_id())->data->user_registered;
		}

	public function user_roles(){
		return explode(",",get_userdata(get_current_user_id())->data->roles);
		}
}

?>