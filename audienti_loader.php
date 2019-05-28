<?php

class AudientiLoader extends MvcPluginLoader {

    var $db_version = '1.0';
    var $tables = array();

    function activate() {
    
        // This call needs to be made to activate this app within WP MVC
        
        $this->activate_app(__FILE__);
        
        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';
    
        add_option('audienti_db_version', $this->db_version);
        
        // Use dbDelta() to create the tables for the app here
                 $sql = ["
        CREATE TABLE `wp_audienti_mail_recipients` (
          `id` int(11) NOT NULL,
          `webhook_id` int(11) DEFAULT NULL,
          `type` varchar(150) DEFAULT NULL,
          `recipient` varchar(150) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_triggers` (
          `id` int(11) NOT NULL,
          `name` varchar(150) DEFAULT NULL,
          `action` varchar(150) DEFAULT NULL,
          `active` tinyint(1) DEFAULT '1'
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_webhooks` (
          `id` int(11) NOT NULL,
          `notification_is_active` tinyint(4) NOT NULL DEFAULT '0',
          `name` varchar(150) DEFAULT NULL,
          `webhook_trigger` int(11) DEFAULT NULL,
          `webhook_trigger_action` varchar(250) DEFAULT NULL,
          `mail_active` tinyint(4) DEFAULT NULL,
          `mail_subject` varchar(150) DEFAULT NULL,
          `mail_body` varchar(5000) DEFAULT NULL,
          `webhook_active` tinyint(4) DEFAULT NULL,
          `args_encoding` tinyint(4) DEFAULT NULL COMMENT '1 => ''Form-encoded body'' 2 => ''JSON-encoded body'' 3 => ''URL parameters encoded (no body)''',
          `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `last_time_event_is_triggered` datetime NOT NULL,
          `number_of_times_event_was_trigger` int(11) NOT NULL DEFAULT '0',
          `unsuccessful_attempts_to_send_webhook` int(11) NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_webhook_args` (
          `id` int(11) NOT NULL,
          `webhook_id` int(11) DEFAULT NULL,
          `key_name` varchar(150) DEFAULT NULL,
          `value` longtext,
          `type` varchar(10) DEFAULT 'body'
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_webhook_events` (
          `id` int(11) NOT NULL,
          `webhook_id` int(11) NOT NULL,
          `args` longtext,
          `processed_successfully` tinyint(4) NOT NULL COMMENT '0->pending process 1->done 2-> failed 3->to be retried'
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_webhook_logs` (
          `id` int(11) NOT NULL,
          `webhook_event_id` int(11) DEFAULT NULL,
          `successful` int(1) DEFAULT NULL COMMENT '1->successful 2->failiure',
          `retry` int(1) DEFAULT NULL COMMENT '0->first_attempt 1->retry',
          `log_type` int(1) DEFAULT NULL COMMENT '1->notification event 2->notification modification',
          `schedule_id` int(11) DEFAULT NULL,
          `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `finally_done` int(1) DEFAULT NULL,
          `webhook_id` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","

        CREATE TABLE `wp_audienti_webhook_urls` (
          `id` int(11) NOT NULL,
          `webhook_id` int(11) DEFAULT NULL,
          `type` varchar(100) DEFAULT NULL,
          `url` varchar(250) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ","
        ALTER TABLE `wp_audienti_mail_recipients`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_triggers`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_webhooks`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_webhook_args`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_webhook_events`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_webhook_logs`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_webhook_urls`
          ADD PRIMARY KEY (`id`);
        ","
        ALTER TABLE `wp_audienti_mail_recipients`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_triggers`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_webhooks`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_webhook_args`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_webhook_events`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_webhook_logs`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        ","
        ALTER TABLE `wp_audienti_webhook_urls`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        COMMIT;
        "];

        global $wpdb;
        foreach ($sql as $single_sql) {
            $wpdb->query($single_sql);
        }
        
    }

    function deactivate() {
    
        // This call needs to be made to deactivate this app within WP MVC
        
        $this->deactivate_app(__FILE__);
        
        // Perform any databases modifications related to plugin deactivation here, if necessary
    
    }

}

?>