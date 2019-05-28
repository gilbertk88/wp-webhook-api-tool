<?php
require_once dirname(__FILE__).'/audienti_webhook_manager.php';
require_once dirname(__FILE__).'/audienti_mail_manager.php';
audienti_class('audienti_mail_manager')->init();
audienti_class('audienti_webhook_manager')->init();
function audientiSettingsInit()
{
    // register a new setting for "wporg" page
    register_setting('audienti', 'audienti_allow_retrys');
	//register_setting('audienti', 'audienti_number_of_retrys');
    register_setting('audienti', 'audienti_parameter_encoding_type');
	
    // register a new section in the "wporg" page
    add_settings_section(
        'audienti_section',
        __('Settings', 'audienti_settings'),
        'audientiSectionInput',
        'audienti'
    );
	
    // allow the user to enable or disable retries.
    add_settings_field(
        'audienti_allow_retrys',
        'Allow retrys',
        'audientiAllowRetrys',
        'audienti',
        'audienti_section',
        array(
            'label_for' => 'audienti_allow_retrys',
            'class' => 'audienti-row',
            'audienti_custom_data' => 'custom'
        )
    );
}

add_action('admin_init', 'audientiSettingsInit');

function audientiSectionInput($args)
{
?>
    <p id="<?php echo esc_attr($args['id']); ?>">
        <?php esc_html_e('Use this page to change your settings.', 'audienti_settings'); ?>
    </p>
<?php
}

function audientiAllowRetrys($args)
{
    $path = get_option('audienti_allow_retrys');
    $var = esc_attr($args['label_for']);
?>
    <select name="<?php echo $var?>" id="<?php echo $var?>" class="large-text" >
		<option class="" value="yes" <?php ($path=='yes' || !isset($path))? $Selected='selected="selected"':$Selected=""; echo $Selected; unset($Selected); ?> >Yes</option>
        <option class="" value="no"  <?php ($path=='no')? $Selected='selected="selected"':$Selected=""; echo $Selected; unset($Selected); ?> >No</option>
    </select>
<?php
}

function audientiOptionsPage()
{
    // add top level menu page
    add_submenu_page(
        'options-general.php',
        'Audienti',
        'Audienti',
        'manage_options',
        'audienti',
        'audientiOptionsPageHTML'
    );
}

add_action('admin_menu', 'audientiOptionsPage');


function audientiOptionsPageHTML()
{
    /**
     * Check user capabilities
     */
    if (!current_user_can('manage_options')) {
        return;
    }
?>
<center>
	<div class = "audienti_menu_html" style="margin-left:25px;	margin-top:40px;">	
		<div>
			<span class="wp-core-ui button-primary" >
				<a class="audienti_menu_item_a" style="padding:20px; color:#fff; text-decoration:none;" href="<?php menu_page_url("audienti"); ?>">General</a>
			</span>
			<span class="audienti_menu_item" style="background-color:gray;
				color:#fff;
				padding:5px;
				text-decoration:none;
				border-radius:2px;
				margin:2px;">
				<a class="audienti_menu_item_a" style="padding:20px; color:#fff; text-decoration:none;" href="<?php echo mvc_admin_url(array("controller" => "audienti_webhooks", "action" => "index", "id" =>"" )); ?>">Notifications</a>
			</span>
			
			<span class="audienti_menu_item" style="background-color:gray;
				color:#fff;
				padding:5px;
				text-decoration:none;
				border-radius:2px;
				margin:2px;">
				<a class="audienti_menu_item_a" style="padding:20px; color:#fff; text-decoration:none;" href="<?php echo mvc_admin_url(array("controller" => "audienti_triggers", "action" => "index", "id" =>"")); ?>">Triggers</a>
			</span>
			
		</div>
	</div>
</center>
	
<div class="wrap">
<div class="wrap audienti_input" style="border-radius:5px;
 padding:30px;
 margin:20px;
 background:#fff;">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	
	<hr>
    <form action="options.php" method="post">
        <?php
        settings_fields('audienti');
        do_settings_sections('audienti');
        ?><br><br>
		<center id='final' >
	<input class="wp-core-ui button-primary" type="submit" name="submit" id="submit" value="Save Settings">
</center>
    </form>
</div>
</div>
<?php
}
?>
