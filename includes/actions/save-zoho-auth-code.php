<?php
if (!defined('ABSPATH')) {
  exit;
}

function handle_zoho_auth_code()
{
  // Verify nonce
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zoho-wp-token-nonce')) {
    wp_send_json_error('Invalid nonce');
  }
  //Get Data From Ajax
  $data = $_POST['data'];

  //Extract Data
  $code = $data['code'];
  if (!isset($code)) {
    $error = [
      'data' => $data,
      'message' => "Code not found...",
      'success' => false,
    ];
    wp_send_json_error($error);
  }

  //Update Options
  update_option('zoho_wp_auth_code', $code, 'yes');

  $client_id = get_option('zoho_wp_client_id');
  $client_secret = get_option('zoho_wp_client_secret');
  $redirect_uri = get_option('zoho_wp_client_redirect');

  // Zoho Token API URL
  $url = 'https://accounts.zoho.com/oauth/v2/token';

  // Request Arguments
  $args = [
    'body' => [
      'code' => $code,
      'grant_type' => 'authorization_code',
      'client_id' => $client_id,
      'client_secret' => $client_secret,
      'redirect_uri' => $redirect_uri
    ],
    'timeout' => 45,
    'headers' => [
      'Content-Type' => 'application/x-www-form-urlencoded'
    ]
  ];

  // Make the POST Request
  $response = wp_remote_post($url, $args);

  // Decode Response
  $body = wp_remote_retrieve_body($response);
  $data =  json_decode($body, true);
  $access_token = $data['access_token'];
  $refresh_token = $data['refresh_token'];
  $expire = $data['expires_in'];

  update_option('zoho_wp_access_token', $access_token, 'yes');
  update_option('zoho_wp_refresh_token', $refresh_token, 'yes');

  $access = get_option('zoho_wp_client_id');
  $refresh = get_option('zoho_wp_client_id');
  wp_send_json_success(array(
    'access_token' => $access,
    'refresh_token' => $refresh,
    'expire' => $expire,
    'success' => true
  ));
}

add_action('wp_ajax_zoho_auth_code', 'handle_zoho_auth_code');
