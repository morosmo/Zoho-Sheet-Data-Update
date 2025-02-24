jQuery(document).ready(function ($) {
  // if (typeof zoho_wp_ajax_request === "function") {
  //   console.info("Ajax Function Accessible! => zoho_wp_ajax_request");
  // } else {
  //   console.error("Function not accessible! => zoho_wp_ajax_request");
  // }

  //Save Client ID & Client Secret on Database
  const mainForm = $("#mainForm");
  mainForm.on("submit", function (e) {
    e.preventDefault();
    let formContainer = e.target;
    let sucessContainer = $(formContainer).find(".sucess-message")[0];
    let failedContainer = $(formContainer).find(".error-message")[0];

    let formElements = e.target.elements;

    //Generate Data to send on server
    let clientID = formElements["clientid"].value;
    let clientSR = formElements["clientsecret"].value;
    let clientRD = formElements["redirectUrl"].value;
    let formData = {
      clientid: clientID,
      clientsecret: clientSR,
      clientredirect: clientRD,
    };

    //Call Ajax Request
    zoho_wp_ajax_request(
      "save_client_id_secret",
      formData,
      function (response) {
        console.log(response);

        if (response.success) {
          $(sucessContainer, "sucess-message").addClass("show");
          setTimeout(() => {
            $(sucessContainer, "sucess-message").removeClass("show");
            setTimeout(() => {
              location.reload();
            }, 200);
          }, 1500);
        }
      },
      function (error) {
        console.error(error);
      }
    );
  });

  //Save Client ID & Client Secret on Database
  const generateAuthUrl = $("#generateauthorizeUrl");
  generateAuthUrl.click(function (e) {
    let formData = {
      currentTime: new Date(),
    };

    //Call Ajax Request
    zoho_wp_ajax_request(
      "zoho_auth_url",
      formData,
      function (response) {
        console.log(response);
        if (response.success) {
          alert("Generated");
          // location.reload();
        }
      },
      function (error) {
        console.error(error);
      }
    );
  });
});
