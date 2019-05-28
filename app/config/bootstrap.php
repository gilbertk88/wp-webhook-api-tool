<?php

MvcConfiguration::set(array(
    'Debug' => false
));

MvcConfiguration::append(array(
'AdminPages' => array(
	'audienti_webhooks' => array(        
            'add'=> array(
                'label' => 'Statistics',
                'in_menu' => false,
            ),
            'add'=> array(
                'label' => __('ad', 'wpmvc'). ' ',
                'in_menu' => false,
            ),
            'delete'=> array(
                'label' => __('Delete', 'wpmvc'). ' ',
                'in_menu' => false
            ),
            'edit'=> array(
                'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
            ),
			'resend_failed_webhook'=>array(
				'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
			),
			'view_logs'=>array(
				'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
			),
			'parent_slug'=>'audienti',
        ),
	'audienti_triggers' => array(  
            'add'=> array(
                'label' => 'Statistics',
                'in_menu' => false,
            ),
            'add'=> array(
                'label' => __('ad', 'wpmvc'). ' ',
                'in_menu' => false,
            ),
            'delete'=> array(
                'label' => __('Delete', 'wpmvc'). ' ',
                'in_menu' => false
            ),
            'edit'=> array(
                'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
            ),
			'parent_slug'=>'audienti',
        ),
	'audienti_webhook_logs' => array(  
            'add'=> array(
                'label' => 'Statistics',
                'in_menu' => false,
            ),
            'add'=> array(
                'label' => __('ad', 'wpmvc'). ' ',
                'in_menu' => false,
            ),
            'delete'=> array(
                'label' => __('Delete', 'wpmvc'). ' ',
                'in_menu' => false
            ),
            'edit'=> array(
                'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
            ),
			'download_logs'=> array(
                'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
            ),
			'clear_logs'=> array(
                'label' => __('edit', 'wpmvc'). ' ',
                'in_menu' => false
            ),
			'parent_slug'=>'audienti',
        ),
	)
	));
 
add_action('mvc_admin_init', 'audienti_on_mvc_admin_init');


function audienti_on_mvc_admin_init($options) {
	
    wp_enqueue_style('audienti-mvc_admin', mvc_css_url('audienti-webhooks-master', 'style'));
    
	wp_enqueue_script( 'audienti-clipboard-js', mvc_js_url('audienti-webhooks-master', 'clipboard.min.js') , array() );
    
    // Your custom js file
    wp_enqueue_script( 'audienti-media-lib-uploader-js', mvc_js_url('audienti-webhooks-master', 'main-script') , array('jquery') );
    
	wp_localize_script( 'audienti-media-lib-uploader-js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}
?>