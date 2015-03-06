$(document).ready(function(){ //When the document is ready, execute the following functions
	
	var pvalid = false;
	var evalid = false;	
	var fileselected = false;
	
	$("#avatar").change(function (){ // If a file has been selected from the choose file browser
       if(fileselected){
  		   fileselected = false;
	   } else {
		   fileselected = true;
	   }
    });
	
	$("#password").keyup(function() { //Setting up a key event handler
		var regpass = document.getElementById("password").value;
		var regpassconf = document.getElementById("passwordconfirm").value;
		
		if(regpass === regpassconf)
		{
			if(regpass.length >= 8) {
				$("#passinv").hide();
				pvalid = true;
			} else {
				document.getElementById("passinv").innerHTML = "Password too short";
				$("#passinv").show();
				pvalid = false;
			}
		} else {
			document.getElementById("passinv").innerHTML = "Passwords do not match";
			$("#passinv").show();
			pvalid = false;
		}
	});
	
	$("#passwordconfirm").keyup(function() {
		var regpass = document.getElementById("password").value;
		var regpassconf = document.getElementById("passwordconfirm").value;
		
		if(regpass === regpassconf)
		{
			if(regpass.length >= 8) {
				$("#passinv").hide();
				pvalid = true;
			} else {
				document.getElementById("passinv").innerHTML = "Password too short";
				$("#passinv").show();
				pvalid = false;
			}
		} else {
			document.getElementById("passinv").innerHTML = "Passwords do not match";
			$("#passinv").show();
			pvalid = false;
		}
	});

	$("#regemail").keyup( function() {
		var email = document.getElementById("regemail").value;
		var arry = /\w+\@\D+\.com/i.exec(email); //The email has to be in the form of [alphanumeric]@[alpha].com, the function exec checks for the regex in the given string
		
		if(arry == null) {
			document.getElementById("emailinv").innerHTML = "Invalid Email";
			$("#emailinv").show();
			evalid = false;
		}
		else {
			$("#emailinv").hide();
			evalid = true;
			$.post('validateemail.php', {emailaddress: email}, function(returnedData) { 
			/*AJAX function to check if the email already exists or not, $.post requests data from the server file given in the first argument, passes data in 
			the second argument, and uses a callback function to be executed after the server replies in the third argument*/
				if(returnedData === "-1") {
					document.getElementById("emailinv").innerHTML = "Email already in use";
					$("#emailinv").show();
					evalid = false;
				} else {
					$("#emailinv").hide();
					evalid = true;
				}
			});			
		}
		}
	);
	
	$("#registerbutton").click(function() {
		
		if(evalid && document.getElementById("regemail").value.trim()) {
			$("#em").css("color","#000000");
		}
		
		if(document.getElementById("password").value.trim() && document.getElementById("passwordconfirm").value.trim() && pvalid) {
		    $("#pw").css("color","#000000");
			$("#pwcnf").css("color","#000000"); 	
		}
		
		if(evalid == true && pvalid == true && (document.getElementById("password").value.trim()) && (document.getElementById("regemail").value.trim())) { 
			// If all the values are valid and the email and password field are not empty
			$("#reqf").hide();		
			var form_data = new FormData(); // Creating a new form and filling it with input data
			form_data.append("firstname", document.getElementById("fname").value);
			form_data.append("lastname", document.getElementById("lname").value);
			form_data.append("useremail", document.getElementById("regemail").value);
			form_data.append("userpassword", document.getElementById("password").value);
			form_data.append("gender",$("#gen option:selected" ).val()); // Used to get selected data from list
			form_data.append("country",$("#country option:selected" ).val());
			form_data.append("telephone",$("#cc option:selected" ).val()+ document.getElementById("telephonenumber").value);				
			var bday = $("#DOBYear option:selected" ).val() + "/" + $("#DOBMonth option:selected" ).val() + "/" + $("#DOBDay option:selected" ).val();			
			form_data.append("birthday", bday );
								
			var file_data = "";
			if(fileselected){ // If no file has been selected
				file_data = $("#avatar").prop("files")[0]; //The prop() method returns properties and values of the selected elements.
				form_data.append("fileselected", "true"); 
			} else {
				form_data.append("fileselected", "false"); // This variable prevents the php file from processing an empty file element
			}
			form_data.append("useravatar", file_data);
			$.ajax({ // Here we didnt use the same technique used before to contact the php file using $.post, since we need to send a file object data 
					url: 'memreg.php', // point to server-side PHP script 
					dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false, // contentType is set to false for multipart/form-data forms that pass files.
					processData: false, // prevents jquery from converting the data object to a serialized parameter string
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						//Call this function after success						
						if(php_script_response === "0") {							
							$("#maindiv").hide(1200, function(){
								var em = document.getElementById("regemail").value;
								window.location.replace("userprofile.php?id="+em+"&owner=true");							
							});							
						}
					}
			});				
		} else {
			if(!evalid || !document.getElementById("regemail").value.trim()) { //If the email field is invalid
				document.getElementById("reqf").innerHTML = "Required Fields";
				$("#reqf").show();
				$("#em").css("color","#ff0000"); //.css() changes the style of an element
			} 
			if(!document.getElementById("password").value.trim() || !document.getElementById("passwordconfirm").value.trim() || !pvalid) { 
				document.getElementById("reqf").innerHTML = "Required Fields";
				$("#reqf").show();
				$("#pw").css("color","#ff0000");
				$("#pwcnf").css("color","#ff0000"); 
			}
		}		
	}	
	);	
	
	$("#login").click(function(){ //If the element with the ID #login is clicked, execute this function
		var email = document.getElementById("loginemail").value;
		var password = document.getElementById("loginpassword").value;
		var emailvalid = false;
		var passvalid = false;
		
		if(!email.trim()) //If the field is empty
		{
			document.getElementById("emailrequired").innerHTML = "Required Field"; //Set the value
			$("#emailrequired").show();
			emailvalid = false;
		} else {
			
			var arry = /\w+\@\D+\.com/i.exec(email); //The email has to be in the form of [alphanumeric]@[alpha].com, the function exec checks for the regex in the given string
		
			if(arry == null) {
				document.getElementById("emailrequired").innerHTML = "Invalid Email";
				$("#emailrequired").show();
				emailvalid = false;
			}
			else {
				$("#emailrequired").hide();
				emailvalid = true;
			}
		}	
		
		if(!password.trim()) 
		{
			document.getElementById("passwordrequired").innerHTML = "Required Field";
			$("#passwordrequired").show();
			passvalid = false;
		} else {
			$("#passwordrequired").hide();
			passvalid = true;
		}
		
		if(emailvalid && passvalid) {				
			$.post('validatelogindata.php', {useremail: email, userpassword: password}, function(returnedData) { 		
				if(returnedData === "-1") {
					document.getElementById("emailrequired").innerHTML = "Invalid Email/Password";
					$("#emailrequired").show();
					emailvalid = false;	
				} else {
					$("#membershipdiv").hide(1200, function(){ //Don't hide the div immediately (JQuery Effects), and after hiding, execute the following callback function
						window.location.replace("userprofile.php?id="+email+"&owner=true");
					}); 
				}
			});				
		}  
	});

	$("#DOBYear").on('change', function(e) {
		$("#d29").show();
		var year = parseInt($("#DOBYear option:selected" ).val());
		var selectedmonth = $("#DOBMonth option:selected" ).val();	
		if(selectedmonth == "February") {
			var leap = false;
			if(year % 4 == 0) {
				if(year % 100 != 0) {
					leap = true;
				} else {
					if(year % 400 == 0) {
						leap = true;
					}
				}
			} 					
			if(leap == false) {
				$("#d29").hide();
			}
		}	
	});
  
	 $("#DOBMonth").on('change', function (e) {
		var valueSelected = this.value;
		if(valueSelected === "February") {
			$("#d29").show();
			$("#d30").hide();
			$("#d31").hide();			
			var selectedyear = $("#DOBYear option:selected" ).val();			
			if(selectedyear != ""){
				var year = parseInt(selectedyear);
				var leap = false;
				if(year % 4 == 0) {
					if(year % 100 != 0) {
						leap = true;
					} else {
						if(year % 400 == 0) {
							leap = true;
						}
					}
				} 					
				if(leap == false) {
					$("#d29").hide();					
				}
			}			
		} else {
			$("#d29").show();
			$("#d30").show();
			if(valueSelected === "April" || valueSelected === "June" || valueSelected === "September" || valueSelected === "November") {
				$("#d31").hide();
			} else {
				$("#d31").show();
			}
		}
	});  
});
