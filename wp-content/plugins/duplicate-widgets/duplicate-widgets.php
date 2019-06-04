<?php
/**
 * Plugin Name: Duplicate Widgets
 * Version: 1.2
 * Plugin URI: https://github.com/aleksandargubecka
 * Description: Easily duplicate or clone a widget with all of its settings in just one click.
 * Author: themesfactory
 * Author URI: https://github.com/aleksandargubecka/Duplicate-Widgets
 * Text Domain: duplicate-widget
 * Domain Path: /languages/
 * License: GPL v3
 */

/**
 * Adding Localization
 */
add_action('plugins_loaded', 'ag_duplicate_widgets_localization');
function ag_duplicate_widgets_localization()
{
    load_plugin_textdomain('duplicate-widgets', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

/**
 * Enqueueing script with translatable strings. Note: this script will be added only to WordPress widgets page,
 */
add_filter('admin_head', 'ag_enqueue_duplicate_widgets_script');
if (!function_exists('ag_enqueue_duplicate_widgets_script')):
    function ag_enqueue_duplicate_widgets_script()
    {
        global $pagenow;

        if ($pagenow != 'widgets.php')
            return;

        wp_enqueue_script('ag_duplicate_widgets_script', plugin_dir_url(__FILE__) . '/ag-widgets.js', array('jquery'), false, true);

        wp_localize_script('ag_duplicate_widgets_script', 'ag_duplicate_widgets', array(
            'text' => __('Clone', 'ag-duplicate-widgets'),
            'title' => __('Clone this Widget', 'ag-duplicate-widgets')
        ));
    }
endif;