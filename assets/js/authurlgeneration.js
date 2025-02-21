let authurl =
  "https://accounts.zoho.com/oauth/v2/auth?response_type=code&client_id=1000.68ZW0XC91CPR15IBJGAWKI5HJ0GFGI&scope=ZohoSheet.dataAPI.UPDATE,ZohoSheet.dataAPI.READ&redirect_uri=http://zoho.local/&access_type=offline&prompt=consent";
document.getElementById("acceptButton").addEventListener("click", function () {
  var popup = window.open(authurl, "Zoho Login", "width=600,height=600");
});
