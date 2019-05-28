<?php
class audienti_post_tags{
	
	
	public function init(){
		add_filter('audienti_post_ID',array($this,'post_ID'));
		add_filter('audienti_post_permalink',array($this,'post_permalink'));
		add_filter('audienti_post_title',array($this,'post_title'));
		add_filter('audienti_post_content',array($this,'post_content'));
		add_filter('audienti_post_date',array($this,'post_date'));
		add_filter('audienti_post_status',array($this,'post_status'));
		add_filter('audienti_post_modified',array($this,'post_modified'));	
		add_filter('audienti_post_type',array($this,'post_type'));
		add_filter('audienti_post_creation_datetime',array($this,'post_creation_datetime'));
		add_filter('audienti_post_excerpt',array($this,'post_excerpt'));

		add_filter('audienti_post_author_user_ID',array($this,'post_author_user_ID'));
		add_filter('audienti_post_author_user_email',array($this,'post_author_user_email'));
		add_filter('audienti_post_author_user_display_name',array($this,'post_author_user_display_name'));
		add_filter('audienti_post_author_user_firstname',array($this,'post_author_user_firstname'));
		add_filter('audienti_post_author_user_lastname',array($this,'post_author_user_lastname')); 
			
	}
	
	public function post_ID(){
		global $post;
		
		return $post->ID;
	}
	
	public function post_permalink(){
		global $post;
		
		return $post->guid;
	}
	
	public function post_title(){
		global $post;
		
		return $post->post_title;
	}
	
	public function post_excerpt(){
		global $post;
		
		return $post->post_excerpt;
	}
	
	public function post_content(){
		global $post;
		
		return $post->post_content;
	}
	
	public function post_status(){
		global $post;
		
		return $post->post_status;
	}		
	
	public function post_type(){
		global $post;
		
		return $post->post_type;
	}

	public function post_modified(){
		global $post;
		
		return $post->post_modified;
	}

	public function post_creation_datetime(){
		global $post;
		
		return $post->post_date;
	}
	
	public function post_author_user_ID(){
		global $post;
		
		return $post->post_author;
	}
	
	public function post_author_user_email(){
		global $post;
		return get_userdata($post->post_author)->data->user_email;
	}
	
	public function post_author_user_display_name(){
		global $post;
		return get_userdata($post->post_author)->data->nickname;
	}
	
	public function post_author_user_firstname(){
		global $post;
		return get_userdata($post->post_author)->data->first_name;
	}
	
	public function post_author_user_lastname(){
		global $post;
		return get_userdata($post->post_author)->data->last_name;
	}
	
}
?>