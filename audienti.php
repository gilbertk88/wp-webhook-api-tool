<?php
/*
Plugin Name: Audienti Webhooks
Plugin URI: 
Description: Easily create web hooks and entries within the WordPress admin.
Author: Audienti
Version: 1.0.1
Author URI: 
*/

register_activation_hook(__FILE__, 'audienti_activate');
register_deactivation_hook(__FILE__, 'audienti_deactivate');

require_once dirname(__FILE__).'/app/functions/functions.php';

function audienti_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/audienti_loader.php';
    $loader = new AudientiLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function audienti_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/audienti_loader.php';
    $loader = new AudientiLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true );
}

?>