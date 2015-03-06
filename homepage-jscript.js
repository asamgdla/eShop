$(document).ready(function(){ //When the document is ready, execute this function

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

	$("#nextpage").click(function(){ 
		var current = parseInt($("#currentval").val()) + 6;
		$("#hbody").hide(1200, function(){
		window.location.replace("homepage.php?current="+current+"&loginemail="+$("#emailval").val());
		});
	});

	$("#previouspage").click(function(){ 
		var current = parseInt($("#currentval").val()) - 6;
		$("#hbody").hide(1200, function(){
		window.location.replace("homepage.php?current="+current+"&loginemail="+$("#emailval").val());
		});
	});
});
