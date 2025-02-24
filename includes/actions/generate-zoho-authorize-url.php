<?php
if (!defined('ABSPATH')) {
  exit;
}

function handle_zoho_auth_url()
{
  $client_id = get_option('zoho_wp_client_id');
  $redirect_uri = get_option('zoho_wp_client_redirect');

  // Verify nonce
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zoho-wp-ajax-nonce')) {
    wp_send_json_error(['message' => 'Invalid nonce']);
  }

  // Check if Client ID & Redirect URI exist
  if (empty($client_id) || empty($redirect_uri)) {
    wp_send_json_error(['message' => 'Please set Client ID & Redirect URL']);
  }

  // Get Data From AJAX Request
  $data = isset($_POST['data']) ? sanitize_text_field($_POST['data']) : '';

  $zohoAuthorizedUrl = "https://accounts.zoho.com/oauth/v2/auth?response_type=code&client_id=$client_id&scope=ZohoSheet.dataAPI.UPDATE,ZohoSheet.dataAPI.READ&redirect_uri=$redirect_uri&access_type=offline&prompt=consent";

  // Do not update the redirect URL option (preserve original redirect URI)
  update_option('zoho_wp_auth_url', $zohoAuthorizedUrl, 'yes');

  $authUrl = get_option('zoho_wp_auth_url');

  $success = [
    'data' => $data,
    'authUrl' => $authUrl,
    'message' => "Authorization URL generated successfully.",
    'success' => true,
  ];

  wp_send_json_success($success);
}

add_action('wp_ajax_zoho_auth_url', 'handle_zoho_auth_url');
