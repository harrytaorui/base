$(document).ready(function() {
	$("#username").keyup(function(){
		var name = $("#username").val();
		if (name.length >= 4) {
			$("#checking_name").html('<img src="/INFS7202project/public/images/loader.gif" align="absmiddle" height="20" width="20">&nbsp;Checking availability...');
			$.post( '/INFS7202project/public/Users/validation_check', { username: $("#username").val() }, function (data){
				console.log(data);
				if(data == "0"){ 
					$("#checking_name").html('&nbsp;<img src="/INFS7202project/public/images/tick.gif" align="absmiddle" height="20" width="20">this name is valid!');
					$("#checking_name").removeClass("error");
				} else if(data == "1"){
					$("#checking_name").html('this username is already taken');
					$("#checking_name").addClass("error");
				}
			});
		}
	});

	$("#email").blur(function(){
		var email = $("#email").val();
		if (email.indexOf("@") > -1 && email.indexOf(".") > -1) {
			$("#checking_email").html('<img src="/INFS7202project/public/images/loader.gif" align="absmiddle" height="20" width="20">&nbsp;Checking availability...');
			$.post( '/INFS7202project/public/Users/validation_check', { email: $("#email").val() }, function (data){
				if(data == "0"){ 
					$("#checking_email").html('&nbsp;<img src="/INFS7202project/public/images/tick.gif" align="absmiddle" height="20" width="20">this email is valid!');
					$("#checking_email").removeClass("error");
				} else if(data == "1"){
					$("#checking_email").html('this email is already taken');
					$("#checking_email").addClass("error");
				}
			});
		}
	});

	$("#password").keyup(function(){
		var psd = $("#password").val();
		var strength = 0;
		if (psd.length < 5) {
			$("#checking_password").html('your password is too short');
			$('.progress-bar').attr('aria-valuenow', '0%').css({'width':'0%'});
			return;
		}
	    if (/\d/.test(psd)) strength++ ;
	    if (/[a-z]/.test(psd)) strength++;
	    if (/[A-Z]/.test(psd)) strength++;
	    if (/\W/.test(psd)) strength++;
	    console.log(strength);
	    switch (strength) {
	        case 1:
	            $("#checking_password").html('your password strength is weak');
	            $('.progress-bar').attr('aria-valuenow', '25%').css({'width':'25%','background-color':'red'});
	            break;
	        case 2:
	        	$('.progress-bar').attr('aria-valuenow', '50%').css({'width':'50%','background-color':'Orange'});
	        	break;   
	        case 3:
	        	$("#checking_password").html('your password strength is medium');
	        	$('.progress-bar').attr('aria-valuenow', '75%').css({'width':'75%','background-color':'MediumSeaGreen'});
	        	break;
	        case 4:
	            $("#checking_password").html('your password strength is strong');
	            $('.progress-bar').attr('aria-valuenow', '100%').css({'width':'100%','background-color':'DodgerBlue'});
	            break;
    	}
	});

	$("input").click(function() {
		$(this).css("border-color","black");
	});

	$("#signupform").submit(function(e){
		var isvalid;
		var username = document.forms["signupform"]["username"].value;
        var password = document.forms["signupform"]["password"].value;
        var conpass = document.forms["signupform"]["conpass"].value;

        if (username.length < 4) {
            $("#username").css("border-color","red");
            isvalid = false;
        }
        if (conpass == "" || password != conpass) {
            $("#conpass").css("border-color","red");
            isvalid = false;
        }
        if ($("#checking_email").hasClass("error") || $("#checking_name").hasClass("error")) {
        	isvalid = false;
        }
        if (isvalid == false) {
        	e.preventDefault();
        }
	})

})