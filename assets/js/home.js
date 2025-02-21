console.log("home script");
window.onload = function () {
  var urlParams = new URLSearchParams(window.location.search);
  var code = urlParams.get("code");

  if (code && window.opener) {
    console.log("Authorization Code Found:", code);

    // Send the code to the main page (popup opener)
    window.opener.postMessage({ zohoAuthCode: code }, "http://zoho.local");

    // Close the popup after sending data
    // window.close();
  }
};
