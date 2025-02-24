console.log("Refreshtoken Script");
//Generate Code and save on db
function saveZohoAuthCode(code) {
  let formData = {
    code: code,
  };
  console.log("Code Received:", code);

  let ajaxUrl = zohoAjax.ajax_url;
  let ajaxnonce = zohoAjax.nonce;
  jQuery.ajax({
    url: ajaxUrl,
    type: "POST",
    data: {
      action: "zoho_auth_code",
      nonce: ajaxnonce,
      data: formData,
    },
    success: function (response) {
      console.log(response);
      if (response.error) {
        console.log(response.error);
      } else {
        console.log(response.data.access_token);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(errorThrown);
    },
  });
}
