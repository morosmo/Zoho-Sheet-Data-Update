<?php
if (!defined('ABSPATH')) {
  exit;
}

function handle_zoho_auth_url()
{
  $client_id =  get_option('zoho_wp_client_id');
  $redirect_uri =  get_site_url();

  // Verify nonce
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zoho-wp-ajax-nonce')) {
    wp_send_json_error('Invalid nonce');
  }
  // Check Client ID
  if (!isset($client_id)) {
    wp_send_json_error('Please Set client ID');
  }
  //Get Data From Ajax
  $data = $_POST['data'];

  //Extract Data & check if JS extracted the code from parameters
  $code = $data['data'];
  if (!isset($code)) {
    $error = [
      'data' => $data,
      'message' => "Code not found...",
      'success' => false,
    ];
    wp_send_json_error($error);
  }
  $zohoAuthorizedUrl = `https://accounts.zoho.com/oauth/v2/auth?response_type=code&client_id=$client_id&scope=ZohoSheet.dataAPI.UPDATE,ZohoSheet.dataAPI.READ&redirect_uri=$redirect_uri&access_type=offline&prompt=consent`;

  //Update Options
  update_option('zoho_wp_client_code', $code, 'yes');
  update_option('zoho_wp_auth_url', $code, 'yes');

  $sucess = [
    'data' => $data,
    'authUrl' => $zohoAuthorizedUrl,
    'message' => "Code added sucessfully.",
    'success' => true,
  ];
  wp_send_json_success($sucess);
}

add_action('wp_ajax_zoho_auth_url', 'handle_zoho_auth_url');
