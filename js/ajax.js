// JavaScript Document
var JcJquery = jQuery.noConflict();
function callAjax(moduleid)
{
	JcJquery(".loadingimg_free_"+moduleid).show();
	basepath = getBaseURL();
	var subject = document.getElementById("subject_emailconnector_"+moduleid).value;
	var message = document.getElementById("message_emailconnector_"+moduleid).value;
	var username = document.getElementById("username_"+moduleid).value;	
	var useremail = document.getElementById("email_"+moduleid).value;
	var successmsg = document.getElementById("successmessage_"+moduleid).value;
	var service_board_emailid = document.getElementById("service_board_emailid_"+moduleid).value;
	if(service_board_emailid == 'all')
	{
		alert("Please Select Service Board");
		JcJquery(".loadingimg_free").hide();
		return false;
	}
	else
	{
		var emailids = service_board_emailid+',';
	}
	if(username == '')
	{
		alert("Please enter your name");
		JcJquery(".loadingimg_free_"+moduleid).hide();
		return false;
	}
	if(useremail == '')
	{
		alert("Please enter your email address");
		JcJquery(".loadingimg_free_"+moduleid).hide();
		return false;
	}
	if(subject == '')
	{
		alert("Please enter the ticket subject");
		JcJquery(".loadingimg_free_"+moduleid).hide();
		return false;
	}
	if(message == '')
	{
		alert("Please enter the ticket message");
		JcJquery(".loadingimg_free_"+moduleid).hide();
		return false;
	}
	url = basepath+'wp-content/plugins/joomconnect-quick-ticket-lite/progressajax.php';
	JcJquery.ajax({
		type: "POST",
		url: url,
		data: "subject="+subject+"&message="+message+"&emailids="+emailids+"&username="+username+"&useremail="+useremail+"&successmsg="+successmsg,
		success: function(msg){
		JcJquery(".success_msg_"+moduleid).html(msg);
		document.getElementById("subject_emailconnector_"+moduleid).value = '';
		document.getElementById("message_emailconnector_"+moduleid).value = '';
		document.getElementById("username_"+moduleid).value = '';
		document.getElementById("email_"+moduleid).value = '';
		document.getElementById("successmessage_"+moduleid).value = '';
		JcJquery(".loadingimg_free_"+moduleid).hide();
	  }
	});
}

function getBaseURL() {
	if (document.URL.indexOf("http://localhost") != -1) {
		// Base Url for localhost
		var url = location.href;  // window.location.href;
		var pathname = location.pathname;  // window.location.pathname;
		var index1 = url.indexOf(pathname);
		var index2 = url.indexOf("/", index1 + 1);
		var baseLocalUrl = url.substr(0, index2);

		return baseLocalUrl + "/";
	}
	else {
		// Root Url for domain name
		return document.URL;
	}
}