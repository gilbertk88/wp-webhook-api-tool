<?php
require_once dirname(__FILE__).'/tags/audienti_user_tags.php';
require_once dirname(__FILE__).'/tags/audienti_post_tags.php';
require_once dirname(__FILE__).'/tags/audienti_wpf_tags.php';
require_once dirname(__FILE__).'/tags/audienti_ump_tags.php';
require_once dirname(__FILE__).'/tags/audienti_gf_tags.php';
require_once dirname(__FILE__).'/tags/audienti_events_tags.php';
//require_once dirname(__FILE__).'/tags/audienti_cpt_tags.php';
require_once dirname(__FILE__).'/tags/audienti_cf7_tags.php';
require_once dirname(__FILE__).'/tags/audienti_acf_tags.php';



function audienti_acf(){
              global $wpdb;
              $type='acf-field';
              $result = $wpdb->get_results($wpdb->prepare(
                  "SELECT post_name, post_excerpt FROM wp_posts WHERE post_type = %s ", $type 
              ), ARRAY_A);
               return $result;
          }



class audienti_merge_tags{
	public $audienti_tags;
	
	public function __construct(){
		$this->audienti_tags = array(
		'audienti_user_tags'=>array(
			'tags' => array(
				array('tag_name'=>'{user_id}','filter_name'=>'audienti_user_id','filter_params'=>1),
				array('tag_name'=>'{user_login}','filter_name'=>'audienti_user_login','filter_params'=>1),
				array('tag_name'=>'{user_email}','filter_name'=>'audienti_user_email','filter_params'=>1),
				array('tag_name'=>'{user_display_name}','filter_name'=>'audienti_user_display_name','filter_params'=>1),
				array('tag_name'=>'{user_first_name}','filter_name'=>'audienti_user_first_name','filter_params'=>1),
				array('tag_name'=>'{user_last_name}','filter_name'=>'audienti_user_last_name','filter_params'=>1),
				array('tag_name'=>'{user_country}','filter_name'=>'audienti_user_country','filter_params'=>1),
				array('tag_name'=>'{user_bio}','filter_name'=>'audienti_user_bio','filter_params'=>1),
				array('tag_name'=>'{user_url}','filter_name'=>'audienti_user_url','filter_params'=>1),
				array('tag_name'=>'{user_registered}','filter_name'=>'audienti_user_registered','filter_params'=>1),
				array('tag_name'=>'{user_roles}','filter_name'=>'audienti_user_roles','filter_params'=>1),
			),
			'more_info'=>'It returns data for the currentlly logged in user'
			),
		'audienti_post_tags'=>array(
			'tags' => array(
				array('tag_name'=>'{post_ID}','filter_name'=>'audienti_post_ID','filter_params'=>1),
				array('tag_name'=>'{post_permalink}','filter_name'=>'audienti_post_permalink','filter_params'=>1),
				array('tag_name'=>'{post_title}','filter_name'=>'audienti_post_title','filter_params'=>1),
				array('tag_name'=>'{post_excerpt}','filter_name'=>'audienti_post_excerpt','filter_params'=>1),
				array('tag_name'=>'{post_content}','filter_name'=>'audienti_post_content','filter_params'=>1),
				array('tag_name'=>'{post_status}','filter_name'=>'audienti_post_status','filter_params'=>1),
				array('tag_name'=>'{post_modified}','filter_name'=>'audienti_post_modified','filter_params'=>1),			
				array('tag_name'=>'{post_type}','filter_name'=>'audienti_post_type','filter_params'=>1),
				array('tag_name'=>'{post_creation_datetime}','filter_name'=>'audienti_post_creation_datetime','filter_params'=>1),
				array('tag_name'=>'{post_author_user_ID}','filter_name'=>'audienti_post_author_user_ID','filter_params'=>1),
				array('tag_name'=>'{post_author_user_email}','filter_name'=>'audienti_post_author_user_email','filter_params'=>1),
				array('tag_name'=>'{post_author_user_display_name}','filter_name'=>'audienti_post_author_user_display_name','filter_params'=>1),
				array('tag_name'=>'{post_author_user_firstname}','filter_name'=>'audienti_post_author_user_firstname','filter_params'=>1),
				array('tag_name'=>'{post_author_user_lastname}','filter_name'=>'audienti_post_author_user_lastname','filter_params'=>1),
			),
			'more_info'=>''),
		'audienti_gf_tags'=>array(
			'tags' => array(
				array('tag_name'=>'{gf_title}','filter_name'=>'audienti_gf_title','filter_params'=>1),
				array('tag_name'=>'{gf_description}','filter_name'=>'audienti_gf_description','filter_params'=>1),
				array('tag_name'=>'{gf_date_created}','filter_name'=>'audienti_gf_date_created','filter_params'=>1),
				array('tag_name'=>'{gf_source_url}','filter_name'=>'audienti_gf_source_url','filter_params'=>1),
				array('tag_name'=>'{gf_user_agent}','filter_name'=>'audienti_gf_user_agent','filter_params'=>1),
				array('tag_name'=>'{gf_form_id}','filter_name'=>'audienti_gf_form_id','filter_params'=>1),
				array('tag_name'=>'{gf_list_of_submission}','filter_name'=>'audienti_gf_list_of_submission','filter_params'=>1),
			),
			'more_info'=>'Requires Gravity form submit action<br> "gform_after_submission" to be set as trigger'),
		'audienti_wpf_tags'=>array(
			'tags' => array(
				array('tag_name'=>'{wpforms_submission_values}','filter_name'=>'audienti_wpforms_submission_values','filter_params'=>1),
				array('tag_name'=>'{wpforms_post_id}','filter_name'=>'audienti_wpforms_post_id','filter_params'=>1),
				array('tag_name'=>'{wpforms_author}','filter_name'=>'audienti_wpforms_author','filter_params'=>1),
			),
			'more_info'=>'Requires Wpforms submit action<br> "wpforms_process_complete"'),

		'audienti_acf_tags'=>array(
			'tags' => array(),
			'more_info'=>'Requires advanced custom field <br> plugin installed and activated'),		
		
		'audienti_cf7_tags'=>array(
			'tags' => array(
				array('tag_name'=>'{wpcf7_form_data_list}','filter_name'=>'audienti_wpcf7_form_data_list','filter_params'=>1)
			),
			'more_info'=>'Requires Contact form 7 plugin <br>activated and action <br>"wpcf7_post_data" hook <br>activated, it fires when<br> a contact form 7 is submitted'),
		'audienti_ump_tags'=>array(
			'tags' => array(),
			'more_info'=>'Requires Ultimate Member Plugin <br>installed and user logged in'),
		);

		$this->audienti_tags['audienti_ump_tags']['tags'] = $this->um_array_of_tags();
		$this->audienti_tags['audienti_acf_tags']['tags'] = $this->acf_array_of_tags();

	}
	
	public function init(){
		audienti_class('audienti_user_tags')->init();
		audienti_class('audienti_post_tags')->init();
		audienti_class('audienti_wpf_tags')->init();
		audienti_class('audienti_ump_tags')->init();
		audienti_class('audienti_gf_tags')->init();
		audienti_class('audienti_events_tags')->init();
		audienti_class('audienti_cf7_tags')->init();
		audienti_class('audienti_acf_tags')->init(); 
	}

	public function acf_array_of_tags(){
		
		$acf_array_of_tags=[];

		foreach(audienti_acf() as $value){
			//create array of tags
			array_push($acf_array_of_tags,array(
				'tag_name'=>'{acf_'.$value['post_excerpt'].'}',
				'filter_name'=>'audienti_acf',
				'filter_params'=>1,
				'tag_custom_info'=>$value['post_name']));
		}

		return $acf_array_of_tags;
	}
	
	public function um_array_of_tags(){

		$uid = get_current_user_id();		
		$a_um_usertags = get_user_meta($uid);		
		$um_array_of_tags=[];

		if (!is_array($a_um_usertags )) {
			$a_um_usertags = [];
		}
		foreach($a_um_usertags as $key => $value){
			//create array of tags
			array_push($um_array_of_tags,array(
				'tag_name'=>'{um_'.$key.'}',
				'filter_name'=>'audienti_um',
				'filter_params'=>1,
				'tag_custom_info'=>'{um_'.$key.'}'));
		}

		return $um_array_of_tags;
	}

	public function replace_tags_with_values($param){
	
		$array_of_tags= $this->audienti_tags;
			
		foreach($array_of_tags as $single_array_of_tags){
			foreach($single_array_of_tags as $single_tag_type){
				foreach ($single_tag_type as $single_merge_tag_arr) {
					$param['data_text'] = $this->process_single_tag($param,$single_merge_tag_arr);
				}
			}
		}
		
		return $param['data_text'];
	}
	
	public function display_tag_onsidebar($category='audienti_user_tags'){
		return 
		$final_html ='
                <ul id= "audienti_webhook_tags">
		<li class="adienienti_tag_copier_header"><b><h3>Merge Tags</h3></b>(Click on tag to copy)</li>
                <li class="adienienti_tag_copier_header">
                <select id="audienti_tags_switcher" name="" class="">
					<option selected value="audienti_user_tags">Users</option>
                    <option value="audienti_post_tags">Posts</option>
					<option value="audienti_wpf_tags">WP Forms</option>
					<option value="audienti_ump_tags">Ultimate Member plugin</option>
					<option value="audienti_gf_tags">Gravity Forms</option>
					<option value="audienti_cf7_tags">Contact Form 7</option>
					<option value="audienti_acf_tags">Advanced Custom Fields</option>
                </select>
                </li>'.
		$this->single_tag_display()
		.'</ul>
		<script>
    var btns = document.querySelectorAll("code");
    var clipboard = new ClipboardJS(btns);

    clipboard.on("success", function(e) {
        console.log(e);
    });

    clipboard.on("error", function(e) {
        console.log(e);
    });
    </script>
		
		';
		return $final_html;
	}
	
	public function single_tag_display(){
		$final_html = "";
                foreach ($this->audienti_tags as $category => $value) {
                    $final_html .='<li class=" btn '.$category.' adienienti_tag_copier_body" >'.$value['more_info'].'</li>';
                    foreach($value['tags'] as $single_tag){                    	
                        $final_html .= '<li class=" btn '.$category.' adienienti_tag_copier_body" ><div class="adienienti_tag_copier_body" ><code data-clipboard-text="'.$single_tag['tag_name'].'"  >'.$single_tag['tag_name'].'</code></div></li>';
                    }
		}
		return $final_html;
	}
	
	public function process_single_tag($param, $merge_tag){
		
		if(strpos($param['data_text'],$merge_tag['tag_name']) == true){

			if ($merge_tag['filter_params'] > 0) {
				
				if (!empty($merge_tag['tag_custom_info'])) {					
					$param['tag_custom_info']=$merge_tag['tag_custom_info'];				
				}
				$new_value = apply_filters($merge_tag['filter_name'],$param);
				
			}
			else{
				$new_value = apply_filters($merge_tag['filter_name']);
			}

			return str_replace($merge_tag['tag_name'],$new_value,$param['data_text']);			
		}
		else{
			return $param['data_text'];
		}
	}
}

?>
