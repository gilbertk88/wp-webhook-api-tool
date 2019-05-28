<?php

if (!function_exists('MvcPublicLoader')){
    require_once dirname(__FILE__).'/lib/audienti_wpframework.php';
}


function audienti_class($class_name){
	$class_instance = new $class_name();
	return $class_instance;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//if (class_exists('AudientiWebhook')) { audienti-webhooks-master
if (is_plugin_active('audienti/audienti.php') || is_plugin_active('audienti-webhooks/audienti.php') || is_plugin_active('audienti-webhooks-master/audienti.php')) {
    
require_once dirname(__FILE__).'/lib/load_libs.php';
require_once dirname(__FILE__).'/admin/audienti_settings.php';
require_once dirname(__FILE__).'/events/audienti_events_manager.php';

class audienti_init{
	
    public function init(){
		$this->load_hooks();
    }
	
    public function load_hooks(){
		audienti_class('audienti_events_manager')->init();
    }
}

audienti_class('audienti_init')->init();

if(isset($_GET['id'])){
	if($_GET['id']=='audienti_doanload_logs' ){
		add_action( 'admin_init', 'audienti_csv_export' );
	}
}

function audienti_csv_export() {
    
    ob_start();
    $domain = $_SERVER['SERVER_NAME'];
    $filename = 'users-' . $domain . '-' . time() . '.csv';
    
    $header_row = array(
        'Email',
        'Name'
    );
    $data_rows = array();
    global $wpdb;
    $array=[
        'Id','Webhook Name','Executed successful','First attempt or Retry','Log Type','Time'
        ];
            
        $AudientiWebhookLog = mvc_model('AudientiWebhookLog')->find();
        $audienti_retry=array('first attempt','retry');
        $audienti_log_type=array(1=>'Notification trigger',2=>'Notification modification');				
        $audienti_successful=array('failed','successful');
			
        foreach ($AudientiWebhookLog as $value) {
            array_push($data_rows ,
				[$value->id,mvc_model('AudientiWebhook')->find_by_id($value->webhook_id)->name ,$audienti_successful[$value->successful],$audienti_retry[$value->retry],$audienti_log_type[$value->log_type],$value->timestamp]
			);
        }
			
    $fh = @fopen( 'php://output', 'w' );
    fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $array );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );
    
    ob_end_flush();
    
    die();
}    
}

?>
