<?php

class AdminAudientiTriggersController extends MvcAdminController {
    
    var $default_columns = array('id', 'name');
	public $before = ['domenu'];

    public function domenu() {
        $menu_html="";
        $menu_html.="<div class='audienti_menu_html'><center>";
		$menu_html.='<div>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a" href="'.menu_page_url("audienti",false).'">General</a></span>
				<span class="audienti_menu_item" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_webhooks", "action" => "index", "id" =>"" )).'">Notifications</a></span>
				<span class="wp-core-ui button-primary" ><a class="audienti_menu_item_a"  href="'.mvc_admin_url(array("controller" => "audienti_triggers", "action" => "index", "id" =>"" )).'">Triggers</a></span>
			</div>';
        
        $menu_html.="</center></div>";

        echo $menu_html;
    }
	
	public function add() {
		if (!empty($this->params['data']) && !empty($this->params['data'])) {
		  $object = $this->params['data'];
		  if (empty($object['id'])) {			
			$this->model->create($object);
			$id = $this->model->insert_id;
			$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'edit', 'id' => $id));
			$this->flash('notice', 'Successfully created!');
			$this->redirect($url);
		 }
		}
	}
	
	public function edit() {
		if (!empty($this->params['data'])) {
			$object = $this->params['data'];			
		  if ($this->model->save($object)) {
			$this->flash('notice', 'Successfully saved!');
			$this->refresh();
		  } else {
			$this->flash('error', $this->model->validation_error_html);
		  }
		}
		$this->set_object();		
	}
}

?>