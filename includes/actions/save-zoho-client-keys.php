<?php
if (!defined('ABSPATH')) {
  exit;
}

function handle_save_client_id_secret()
{
  // Verify nonce
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zoho-wp-ajax-nonce')) {
    wp_send_json_error('Invalid nonce');
  }
  //Get Data From Ajax
  $data = $_POST['data'];

  //Extract Data
  $clientID = $data['clientid'];
  $clientSR = $data['clientsecret'];

  //Update Options
  update_option('zoho_wp_client_id', $clientID, 'yes');
  update_option('zoho_wp_client_secret', $clientSR, 'yes');

  $sucess = [
    'data' => $data,
    'message' => "Credentials Updated sucessfully.",
    'success' => true,
  ];
  wp_send_json_success($sucess);
}

add_action('wp_ajax_save_client_id_secret', 'handle_save_client_id_secret');
