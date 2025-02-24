function zoho_wp_ajax_request(action, data, successCallback, errorCallback) {
  let ajaxUrl = zohoAjax.ajax_url;
  let ajaxnonce = zohoAjax.nonce;

  jQuery.ajax({
    url: ajaxUrl,
    type: "POST",
    data: {
      action: action,
      nonce: ajaxnonce,
      data: data,
    },
    success: function (response) {
      if (response.success) {
        if (successCallback && typeof successCallback === "function") {
          successCallback(response.data);
        }
      } else {
        if (errorCallback && typeof errorCallback === "function") {
          errorCallback(response.data);
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      if (errorCallback && typeof errorCallback === "function") {
        errorCallback({
          status: textStatus,
          error: errorThrown,
        });
      }
    },
  });
}
jQuery(document).ready(function ($) {
  console.log("Ajax File Loaded....");
});
