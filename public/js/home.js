jQuery(document).ready(function ($) {
  console.log("home script");
  var urlParams = new URLSearchParams(window.location.search);
  var code = urlParams.get("code");
  var server = urlParams.get("accounts-server");
  console.log(code);
  console.log(server);

  if (code && server === "https://accounts.zoho.com") {
    console.log("Authorization Code Found:", code);

    saveZohoAuthCode(code);
  }
});
