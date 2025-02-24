<?php
if (!defined('ABSPATH')) {
  exit;
}
// Define constants
define('PLUGIN_SLUG', 'zoho-wp');
define('PLUGIN_ROLE', 'manage_options');
define('PLUGIN_DOMAIN', 'zoho-wp');

//Register menu
add_action('admin_menu', 'zoho_wp_integration');
function zoho_wp_integration()
{
  add_menu_page(
    __('Zoho WP', PLUGIN_DOMAIN),
    'Zoho WP',
    PLUGIN_ROLE,
    PLUGIN_SLUG,
    'zoho_wp_dashboard',
    ZOHO_WP_PLUGIN_URL . 'assets/media/favicon.svg',
    null
  );
  // add_submenu_page(
  //   PLUGIN_SLUG,
  //   __('Settings', PLUGIN_DOMAIN),
  //   'Settings',
  //   PLUGIN_ROLE,
  //   'morosoft-reviews-settings',
  //   'morosoft_reviews_settings',
  //   null
  // );
  // add_submenu_page(
  //   PLUGIN_SLUG,
  //   __('Docs', PLUGIN_DOMAIN),
  //   'Docs',
  //   PLUGIN_ROLE,
  //   'morosoft-reviews-documentation',
  //   'morosoft_reviews_docs',
  //   null
  // );
}

//Design Dashboard Page
function zoho_wp_dashboard()
{
  $zoho_client_id = get_option('zoho_wp_client_id');
  $zoho_client_code = get_option('zoho_wp_client_code');
  $zoho_client_code = !empty($zoho_client_code) ? $zoho_client_code : '<p class="disabled-option">Authorize to get code...</p>';
  $zoho_client_secret = get_option('zoho_wp_client_secret');
  $zoho_client_redirect = get_option('zoho_wp_client_redirect');
  $authurl = get_option('zoho_wp_auth_url');
  $authurl = !empty($authurl) ? $authurl : '<p class="disabled-option">Authorize to get code...</p>';
?>
  <div class="wrap zoho-wp-wrap">
    <div class="zoho-wp-main-contianer">
      <div class="zoho-wp-header-area">
        <div>
          <h1>General Settings</h1>
        </div>
        <div>
          <button class="zwp-button">Read Docs</button>
        </div>
      </div>
      <div class="zoho-wp-body-area">
        <div class="zoho-wp-grid-container two-cols">
          <div class="zoho-wp-grid-column grid-left">
            <h2>Zoho Client ID & Secret</h2>
            <form id="mainForm">
              <div class="zohowp-field-container">
                <label for="clientid">Client ID</label>
                <input type="text" name="clientid" id="clientid" placeholder="Client ID" value="<?php echo $zoho_client_id ?>">
              </div>
              <div class="zohowp-field-container">
                <label for="clientsecret">Client Secret</label>
                <input type="text" name="clientsecret" id="clientsecret" placeholder="Client Secret" value="<?php echo $zoho_client_secret ?>">
              </div>
              <div class="zohowp-field-container">
                <label for="clientsecret">Redirect Url</label>
                <input type="text" name="redirectUrl" id="redirectUrl" placeholder="Redirect Url" value="<?php echo $zoho_client_redirect ?>">
              </div>
              <div class="submit-container">
                <button class="zwp-button" type="submit" form="mainForm">Save Zoho Settings</button>
                <div class="message-wrapper">
                  <p class="sucess-message">Updated sucessfully.</p>
                  <p class="error-message">Error Updating.</p>
                </div>
              </div>
            </form>
          </div>
          <div class="zoho-wp-grid-column grid-right">
            <div style="display:flex;gap:5px;align-items:center;">
              <h2>Authorization Data</h2>
              <p class="auth-link">
                <?php
                if ($authurl) {
                  echo '<a href="' . $authurl . '" target="_blank" id="generatecode">Authorize</a>';
                }
                ?>
              </p>
            </div>
            <table>
              <thead>
                <tr>
                  <th>Params</th>
                  <th>Values</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>response_type</td>
                  <td>code</td>
                </tr>
                <tr>
                  <td>client_id</td>
                  <td><?php echo !empty($zoho_client_id) ? $zoho_client_id : '<p class="disabled-option">Please add Client Id</p>'; ?></td>
                </tr>
                <tr>
                  <td>scope</td>
                  <td>ZohoSheet.dataAPI.UPDATE,ZohoSheet.dataAPI.READ</td>
                </tr>
                <tr>
                  <td>redirect_uri</td>
                  <td><?php echo !empty($zoho_client_redirect) ? $zoho_client_redirect : '<p class="disabled-option">Please add Redirect Url</p>'; ?></td>
                </tr>
                <tr>
                  <td>access_type</td>
                  <td>offline</td>
                </tr>
                <tr>
                  <td>prompt</td>
                  <td>consent</td>
                </tr>
              </tbody>
            </table>
            <div class="authorize-zoho-contianer">
              <button id="generateauthorizeUrl" class="zwp-button">Get Authorization Code</button>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
<?php
}
