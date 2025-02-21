<?php
/*
 * Plugin Name:       Custom Zoho Integration
 * Description:       Send custom data to zoho sheet & updates rows based on wordpress updates.
 * Version:           1.0.0
 * Author:            Mohsin Shakeel
 */


//Define Constants
global $wpdb;
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__)); //Plugin Folder Url with server directory
define('ZOHO_WP_PLUGIN_URL', plugin_dir_url(__FILE__)); //Plugin Folder Url with site url.

/*Hook JS And Css Files*/
function enqueue_zoho_wp_styles_and_scripts()
{
  //Css Styles
  wp_enqueue_style('google-font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);
  wp_enqueue_style('zoho-wp-backend-styles', ZOHO_WP_PLUGIN_URL . 'assets/css/backend.css', array(), '1.0');
  wp_enqueue_style('zoho-wp-frontend-styles', ZOHO_WP_PLUGIN_URL . 'assets/css/frontend.css', array(), '1.0', 'all');



  //Register JS Scripts only on admin area
  if (is_admin()) {
    wp_register_script('zoho-wp-ajax-script', ZOHO_WP_PLUGIN_URL . '/assets/js/ajaxfunction.js', array('jquery'), '1.0', true);
    wp_register_script('zoho-wp-script', ZOHO_WP_PLUGIN_URL . '/assets/js/main.js', array('jquery', "zoho-wp-ajax-script"), '1.0', true);
  }

  // Localize AJAX URL for main.js
  wp_localize_script(
    'zoho-wp-ajax-script',
    'zohoAjax',
    array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('zoho-wp-ajax-nonce')
    )
  );

  //Load Scripts on Page
  wp_enqueue_script('jquery');
  wp_enqueue_script('zoho-wp-ajax-script');
  wp_enqueue_script('zoho-wp-script');
}
add_action('admin_enqueue_scripts', 'enqueue_zoho_wp_styles_and_scripts');


function laod_wp_home_script()
{
  wp_register_script('zoho-wp-home-script', ZOHO_WP_PLUGIN_URL . 'assets/js/home.js', array(), '1.0', true);
  wp_enqueue_script('zoho-wp-home-script');
}
add_action('init', 'laod_wp_home_script');
//Run on Plugin Activation...
function activate_zoho_wp() {}
register_activation_hook(__FILE__, "activate_zoho_wp");

//Run on Plugin Deactivation...
function deactivate_zoho_wp() {}
register_deactivation_hook(__FILE__, "deactivate_zoho_wp");

/* Hook Additonal Files*/
require_once MY_PLUGIN_PATH . 'includes/admin/admin-menu.php';
require_once MY_PLUGIN_PATH . 'includes/actions/save-zoho-client-keys.php';
require_once MY_PLUGIN_PATH . 'includes/actions/generate-zoho-authorize-url.php';
