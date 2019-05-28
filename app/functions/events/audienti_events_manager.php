<?php

require_once dirname(__FILE__).'/audienti_merge_tags.php';

function audienti_replace_tags($param=''){
    return audienti_class('audienti_merge_tags')->replace_tags_with_values($param);
}

class audienti_events_manager{
    public function init(){
            add_action('audienti_process_pending_events', array($this, 'audienti_process_pending_events'),1,1);
            add_action('wp_footer',array($this,'retry_processing_failed_events'));
            $this->initialize_triggers();            
            audienti_class('audienti_merge_tags')->init();
	}
	
	
    public function initialize_triggers(){
		$AudientiWebhook = mvc_model('AudientiWebhook')->find(array('conditions'=>array(
                    'notification_is_active '=> true,
		)));
		
                foreach($AudientiWebhook as $single_hook){
                    if(isset($single_hook->webhook_trigger_action) && is_string($single_hook->webhook_trigger_action)){
                        $webhook_id = $single_hook;
                        add_action($single_hook->webhook_trigger_action, function($var1='var', $var2='var2') use ($webhook_id){
                            $this->schedule_an_event($webhook_id,array('var1'=>$var1,'var2'=>$var2, 'var3'=>$var3,'var4'=>$var4));                             
                        }, 10,4);
                    }
		}
	}

    public function set_up_hook_data($single_hook_object,$data){
    	$args=[
			'mail'=>[
				'recipients'=> $this->get_mail_recipient($single_hook_object),
				'content'=>[
					'subject'=>$single_hook_object->mail_subject,
					'content'=>audienti_replace_tags(array('data_text' => $single_hook_object->mail_body, 'data'=> $data))
				],
				'mail_active'=>$single_hook_object->mail_active,
			],
			'webhook'=>[
				'urls'=>$this->get_webhook_url($single_hook_object),
				'header_args'=>$this->get_webhook_args($single_hook_object,'header'),
				'body_args'=>$this->get_webhook_args($single_hook_object,'body'),
                                'webhook_active'=>$single_hook_object->webhook_active,
			]
		];
		
		return $args;
	}
	
    public function schedule_an_event($single_hook='',$data=''){
        
        $number_of_times_event_was_trigger = $single_hook->number_of_times_event_was_trigger;
        $number_of_times_event_was_trigger++;
        
		mvc_model('AudientiWebhook')->update( $single_hook->id,array(           
			'last_time_event_is_triggered'=> date('Y-m-d H:i:s'),
			'number_of_times_event_was_trigger' =>$number_of_times_event_was_trigger
			));
			
		$webhook_event_id = mvc_model('AudientiWebhookEvent')->create(array(
			'webhook_id'=>$single_hook->id,
			'args'=>maybe_serialize($this->set_up_hook_data($single_hook,$data))
			));

        $AudientiWebhookEventdata=maybe_unserialize(mvc_model('AudientiWebhookEvent')->find_by_id($webhook_event_id)->args);
        
        $timestamp = current_time('timestamp');
        $hook = 'audienti_process_pending_events';
        $args = array($webhook_event_id);
        $group = 'audienti_pending_events';

        as_schedule_single_action( $timestamp , $hook , $args , $group );
    }
    
    public function retry_processing_failed_events() {
        $webhook_events_to_be_retried = mvc_model('AudientiWebhookEvent')->find(array('conditions'=>array(
			'processed_successfully'=>3
            )));

        $log_results='';
        $number_of_failed_results=0;

        foreach ($webhook_events_to_be_retried as $single_event) {
            $arg = maybe_unserialize($single_event->args);
            //retry notifications
            if( $arg['mail']['mail_active'] > 0 ){
                $send_mails_success = $this->send_mails($arg['mail']);
            }
            if( $arg['webhook']['webhook_active'] > 0 ){
                $send_arg_success = $this->send_arg($arg['webhook']);
            }
            
            if($send_mails_success == true && $send_arg_success == true){//create log - successful & update webhook event 3 -> successful	
            
                $log_results.='Webhook event id '.$single_event->id.': Successful <br>';
            }
            else {
                $AudientiWebhook = mvc_model('AudientiWebhook')->find_by_id($single_event->webhook_id);
                $unsuccessful_attempts_to_send_webhook=	$AudientiWebhook->unsuccessful_attempts_to_send_webhook;
                $unsuccessful_attempts_to_send_webhook++;
                mvc_model('AudientiWebhook')->save(array(
                    'id'=> $AudientiWebhook->id,
                    'unsuccessful_attempts_to_send_webhook'=>$unsuccessful_attempts_to_send_webhook
                    ));
                $log_results.='Webhook event id '.$single_event->id.': Failed <br>';
                $number_of_failed_results++;
           }
        }
        
        $number_of_failed_results= 'Resend succesfully executed, there are <b>'.$number_of_failed_results.'</b>  failed events<br>'.$log_results;

        return $number_of_failed_results;
    }
	
    public function audienti_process_pending_events($args=''){
        //get webhook event
        $webhook_event = mvc_model('AudientiWebhookEvent')->find_by_id($args);
    
		//if (successfully_processed is not processed or retry) -> process
        //do process
        $arg = maybe_unserialize($webhook_event->args);
        if( $arg['mail']['mail_active'] > 0 ){
            $send_mails_success = $this->send_mails($arg['mail']);
        }
        if( $arg['webhook']['webhook_active'] > 0 ){
            $send_arg_success = $this->send_arg($arg['webhook']);
        }
		
        if($send_mails_success == true && $send_arg_success == true){//create log - successful & update webhook event 3 -> successful
			$this->record_success_attempt_to_do_notification(['webhook_event_object'=>$webhook_event]);
        }
		else{//create log - failiar
			$this->record_failed_attempt_to_do_notification(['webhook_event_object'=>$webhook_event]);
		}
	}
	
    public function record_failed_attempt_to_do_notification($specific_args){
		$args=[
			'success_log'=> false,
			'webhook_event_webhook_event_object'=> $specific_args['webhook_event_object'],
			'webhook_event_webhook_id'=> $specific_args['webhook_event_object']->webhook_id,
			'number_of_retrys' => mvc_model('AudientiWebhookLog')->count(array('webhook_id'=>$specific_args['webhook_event_id']->webhook_id)),
			'AudientiWebhookEvent_processed_successfully'=>3,
		];
	
		//update webhook event
		$this->record_webhook_event($args);
		//update webhook
		$this->record_webhook_stats($args);
		//create log - failed (new or update)
		$this->record_log($args);
	}
	
	public function record_success_attempt_to_do_notification($specific_args){
		$args=[
			'success_log'=> true,
			'webhook_event_webhook_event_object'=> $specific_args['webhook_event_object'],
			'webhook_event_webhook_id'=> $specific_args['webhook_event_object']->webhook_id,
			'number_of_retrys' => mvc_model('AudientiWebhookLog')->count(array('webhook_id'=>$specific_args['webhook_event_id']->webhook_id)),
			'AudientiWebhookEvent_processed_successfully'=>2,
		];
	
		//update webhook event
		$this->record_webhook_event($args);
		//update webhook
		$this->record_webhook_stats($args);
		//create log - failed (new or update)
		$this->record_log($args);
	}
	
	public function record_log($args){ 
		$retry=0;
		if( $args['number_of_retrys'] > 0 ){
				$retry=1;
			}
		
        mvc_model('AudientiWebhookLog')->create(array(
            'webhook_event_id' => $webhook_event->id,
            'successful'=>2,
            'retry'=>$retry,
            'log_type'=>1,
            'timestamp'=>date('Y-m-d H:i:s'),
            'finally_done'=>0,
			'webhook_id'=>$args['webhook_event_object']->webhook_id
            ));
	}
	
	public function record_webhook_event($args){
		mvc_model('AudientiWebhookEvent')->update($args['webhook_event_id'],array(
                'processed_successfully'=>$args['AudientiWebhookEvent_processed_successfully'] //failed 
                )); 
	}
	
	public function record_webhook_stats($args){
		//unsuccessful_attempts_to_send_webhook
        $AudientiWebhook=mvc_model('AudientiWebhook')->find_by_id($args['webhook_event_webhook_id']);
        $unsuccessful_attempts_to_send_webhook=	$AudientiWebhook->unsuccessful_attempts_to_send_webhook;
		$number_of_times_event_was_trigger =	$AudientiWebhook->number_of_times_event_was_trigger ;
        $number_of_times_event_was_trigger++;
		
		if(!$args['success_log']){
			$unsuccessful_attempts_to_send_webhook++;
		}
		
		mvc_model('AudientiWebhook')->update($AudientiWebhook->id,array(
			'unsuccessful_attempts_to_send_webhook'=>$unsuccessful_attempts_to_send_webhook,
			'last_time_event_is_triggered'=>date('Y-m-d H:i:s'),
			'number_of_times_event_was_trigger'=>$number_of_times_event_was_trigger
			));
	}
	
    public function send_mails($single_hook_data_mail){
		$AudientiMailRecipient = $single_hook_data_mail['recipients'];
		
		$recipient_arr=[];
		foreach($AudientiMailRecipient as $single_recipient){
                    array_push($recipient_arr,$single_recipient['recipient']);
		}
		
                $recipient_arr=implode(',',$recipient_arr);
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
                $headers .= 'From: no_reply@'.$_SERVER['HTTP_HOST'] . "\r\n";
		$email_sent= wp_mail( $recipient_arr, $single_hook_data_mail['content']['subject'] , $single_hook_data_mail['content']['content'],$headers);
                //var_dump(array("Email sent"=>$email_sent));		
	}
	
	public function get_email_address($single_recipient){
		if( $single_recipient['type']=='email' ){
			return $single_recipient['recipient'];
		}
	}
	
	public function send_arg($single_hook_data){
            $response='';
            foreach($single_hook_data['urls'] as $single_url){ 
                $response= wp_remote_post($single_url['url'],array(
                            'method'=>$single_url['type'],
                            'timeout'=>45,
                            'redirect'=>5,
                            'httpversion'=>'1.0',
                            'blocking'=>true,
                            'headers'=> array(),
                            'body'=>  $single_hook_data['body_args'],
                    ));
                    	
                    if(is_wp_error($response)){
						$error_message = $response->get_error_message();
						error_log("Something went wrong: ". $error_message );
                    }
		}
        mvc_model('AudientiWebhookEvent')->create(array(
			'webhook_id'=>88,
			'args'=> maybe_serialize($response)
			));
	}
	
	//return an array of args - default type is body. the alternative would be a header
	public function get_webhook_args($single_hook,$type='body'){
		$AudientiWebhookArgs = mvc_model('AudientiWebhookArgs')->find(array('conditions'=>array(
			'webhook_id'=> $single_hook->id,
			'type'=>$type,
		)));
		$arr_args=[];
	
		foreach($AudientiWebhookArgs as $single_arg){
			switch($single_hook->args_encoding){
				case '1':
					$single_arg_value = $single_arg->value;
				break;
				case '2':
					$single_arg_value = json_encode($single_arg->value);
				break;
				case '3':
					$single_arg_value='';
				break;
			}
			array_push($arr_args, array( $single_arg->key_name => $single_arg_value));
		}
		
		return $arr_args;
	}
	
	//return an array of webhook urls
	public function get_webhook_url($single_hook){
		$AudientiWebhookUrl = mvc_model('AudientiWebhookUrl')->find(array('conditions'=>array(
			'webhook_id'=> $single_hook->id,
		)));
		$arr_urls=[];
	
		foreach($AudientiWebhookUrl as $single_url){
			array_push($arr_urls, array( "type"=>$single_url->type, "url" => $single_url->url));
		}
		
		return $arr_urls;
	}
	
	//return an array of webhook urls
	public function get_mail_recipient($single_hook){
		$AudientiMailRecipient = mvc_model('AudientiMailRecipient')->find(array('conditions'=>array(
			'webhook_id'=> $single_hook->id,
		)));
		$arr_mail_recipient=[];
	
		foreach($AudientiMailRecipient as $single_mail_recipient){
			array_push($arr_mail_recipient, array( 'type'=>$single_mail_recipient->type, 'recipient' => $single_mail_recipient->recipient));
		}
		
		return $arr_mail_recipient;
	}
        
    public function WebhookLog_unsuccessful_count($webhook_id) {
        $AudientiWebhookLog_unsuccessful_count=0;
        
        $AudientiWebhookEvent_unsucessful = mvc_model('AudientiWebhookEvent')->find(array('conditions'=>array(
                'processed_successfully'=>3,
                'webhook_id'=>$webhook_id,
            )));

        foreach ($AudientiWebhookEvent_unsucessful as $value) {
                $AudientiWebhookLog_unsuccessful_count= 1+ mvc_model('AudientiWebhookLog')->count(array('conditions'=>array(
                    'webhook_event_id' => $value->id,
                )));
            }
        
		return $AudientiWebhookLog_unsuccessful_count;
    }
    
} ?>