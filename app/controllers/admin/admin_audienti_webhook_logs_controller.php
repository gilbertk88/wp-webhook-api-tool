<?php

class AdminAudientiWebhookLogsController extends MvcAdminController {
    
    var $default_columns = array('id', 'name');
	public $before = ['domenu'];
	
    public function domenu() {
        $menu_html="";
        $menu_html.="<div class='audienti_menu_html'><center>";
		$menu_html.='<div>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a" href="'.menu_page_url("audienti",false).'">General</a></span>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_webhooks", "action" => "index", "id" =>"" )).'">All Notifications</a></span>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_webhooks", "action" => "add", "id" =>"")).'">New Notification</a></span>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_triggers", "action" => "index", "id" =>"" )).'">All Triggers</a></span>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_triggers", "action" => "add", "id" =>"" )).'">New Trigger</a></span>
			</div>';
        
        $menu_html.="</center></div>";

        echo $menu_html;
    }
	
	public function add() {
		if (!empty($this->params['data']) && !empty($this->params['data'])) {
		  $object = $this->params['data'];
		  $more_data=$this->params['more_data'];
		  if (empty($object['id'])) {
			  
			$object['AudientiWebhook']['webhook_trigger_action'] = mvc_model('AudientiTrigger')->find_by_id($object['AudientiWebhook']['webhook_trigger'])->action;
			
			$this->model->create($object);
			$id = $this->model->insert_id;
			$this->save_additional_data($more_data,$id );
			$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'edit', 'id' => $id));
			$this->flash('notice', 'Successfully created!');
			$this->redirect($url);
		 }
		}
	}
	
	public function save_additional_data($more_data,$id ){
		foreach($more_data as $key=>$value){
			foreach($value as $single){
				$single['webhook_id']=$id;
				mvc_model($key)->save($single);
			}
		}
	}
    
	public function edit() {
		if (!empty($this->params['data'])) {
		  $object = $this->params['data'];
		  $object['AudientiWebhook']['webhook_trigger_action'] = mvc_model('AudientiTrigger')->find_by_id($object['AudientiWebhook']['webhook_trigger'])->action;
		  $object['AudientiWebhook']['last_modified'] = time();
		  if ($this->model->save($object)) {
			$more_data=$this->params['more_data'];
			$id=$object['AudientiWebhook']['id'];
			$this->save_additional_data($more_data,$id );
			
			$this->flash('notice', 'Successfully saved!');
			$this->refresh();
		  } else {
			$this->flash('error', $this->model->validation_error_html);
		  }
		}
		$this->set_object();		
	}

	public function clear_logs(){
		mvc_model('AudientiWebhookLog')->delete_all();
		$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index', 'id' =>''));
		$this->flash('notice', 'Logs have been successfully cleared!');
		$this->redirect($url);		
	}
	
	public function download_logs(){
		//mvc_model('audienti_events_manager')->download_logs();
		//redirect to edit with
		$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index', 'id' => ''));
		$this->flash('notice', 'Csv downloaded' );
		$this->redirect($url); 
	}

}

?>