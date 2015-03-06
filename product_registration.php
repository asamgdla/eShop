<!DOCTYPE html>

<html>
	<?php 
		$servername = "localhost"; 
		$username = "root"; 
		$password = ""; 
		$dbname = "eShop";
		$conn = new mysqli($servername, $username, $password, $dbname); 
		$sql = "SELECT firstname,email,avatar, gender FROM Members";
		$result = $conn->query($sql);
		$email = "";
		$fname = "";
		$avatar = "";
		$gender = "";
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) { 	
				if (strcasecmp($row["email"], $_GET["id"]) == 0) { 
					$email = $row["email"];
					$avatar = $row["avatar"];
					$fname = $row["firstname"];
					$gender = $row["gender"];
				}
			}
		} 
	?>		
<head>
	<title> Register Product </title>
	<style>
		h2 {
			color: #00008B;
			font-family: Brush Script MT,cursive; 
		}

		body {
			background-image: url("background.jpg");
			background-repeat: no-repeat;
		}

		#logo {
			width: 120px;
			height: 120px;
		}

		#logodiv {
			float:left;
			position: relative;
			right: -40px;
			top: 7px;
		}
			
		#titlediv {
			float:left;
			position: relative;
			right: -60px;
			top: 7px;
		}
		
		.animbutton { /* Defines a style for a class */
			background-color: #909090;
			-moz-border-radius: 5px; /* Mozilla Firefox */
			-webkit-border-radius: 5px; /* Chrome */
			border-radius:6px; /* Default */
			color: #fff;
			font-size: 15px;
			cursor: pointer; /* Defines the type of cursor to be displayed when pointing on an element */
		}

		.animbutton:hover {
			background:#202020;
		}
	</style>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			var fileselected = false;
			$("#requiredfields").hide();
	
			$("#display").change(function (){ // If a file has been selected from the choose file browser
			   if(fileselected){
				   fileselected = false;
			   } else {
				   fileselected = true;
			   }
			});
			
			$("#amt").keydown(function(event){ // Here we want to take numeric data only
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ); // allow backspace, delete and arrows
				else {
					// Ensure that it is a number and stop the keypress
					if (event.keyCode < 48 || event.keyCode > 57 ) {
						event.preventDefault();	
					}	
				}			
			});
			
			$("#price").keydown(function(event){ 
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ); 
				else {
					if (event.keyCode < 48 || event.keyCode > 57 ) {
						event.preventDefault();	
					}	
				}			
			});

			$("#description").keydown(function(event){ 
				if ( event.keyCode == 222 ){
					event.preventDefault();	
				}						
			});

			$("#pname").keydown(function(event){ 
				if ( event.keyCode == 222 ){
					event.preventDefault();	
				}						
			});

			$("#registerproduct").click(function(e) {
				
				var productname = $("#pname").val();
				var price = $("#price").val();
				var curr = $("#cur option:selected").val();
				var amount = $("#amt").val();
				var description = $("#description").val();	
				
				if(productname == "") {
					$("#namereq").css('color',"#ff0000");
					$("#requiredfields").show();
				} else {
					$("#namereq").css('color',"#000000");
				}
				
				if(price == "" || curr == "-") {
					$("#pricereq").css('color',"#ff0000");
					$("#requiredfields").show();
				} else {
					$("#pricereq").css('color',"#000000");
				}
				
				if(amount == "" || parseInt(amount) == 0) {
					$("#amtreq").css('color',"#ff0000");
					$("#requiredfields").show();
				} else {
					$("#amtreq").css('color',"#000000");
				}				
								
				if(productname !== "" && price !== "" && curr !== "" && amount !== "" && parseInt(amount) != 0) {
					$("#requiredfields").hide();
					var form_data = new FormData(); 
					form_data.append("email", $("#emvalue").val());
					form_data.append("productname", productname);	
					form_data.append("price", price+ " " + curr);					
					form_data.append("amount", amount);					
					form_data.append("description", description);						
					var file_data = "";
					if(fileselected){ // If no file has been selected
						file_data = $("#display").prop("files")[0]; //The prop() method returns properties and values of the selected elements.
						form_data.append("fileselected", "true"); 
					} else {
						form_data.append("fileselected", "false"); // This variable prevents the php file from processing an empty file element
					}
					form_data.append("avatar", file_data);	
					$.ajax({ 
					url: 'pregdb.php', 
					dataType: 'text',  
					cache: false,
					contentType: false, 
					processData: false, 
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){

						if(php_script_response == "0") {	
						alert("Product Registered Successfully");
							$("#maindiv").hide(1200, function(){
								var em = $("#emvalue").val();
								window.location.replace("userprofile.php?id="+em+"&owner=true");							
							});							
						} 
					}
					});						
				}				
			});
		});
	</script>
</head>

<body>
	<div id="maindiv">
	<?php echo "<option id='emvalue' value='".$email."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	
	
	<div id="logodiv">
		<img src="logo.png" id="logo" alt="eShop.com">
	</div>
	
	<div id= "titlediv">
		<h1> eShop </h1>
		<h2> Your Virtual Shop </h2>		
	</div>
	
	
<div id = "memwel" style="float:right; position: relative; right: 150px; top: 28px;">
		<div>		
			<?php 
				if(strcmp($avatar,"") == 0) {
					if(strcmp($gender, "Male") == 0){
						echo "<a href='userprofile.php?id=".$email."&owner=true'><img src='member_avatar/anonpp.jpg' alt='anonpp.jpg' style='position:relative;top:17px;width: auto;height: auto; max-width:70px; max-height:70px;border='0''></a>";
					} else {
						echo "<a href='userprofile.php?id=".$email."&owner=true'><img src='member_avatar/anonppf.jpg' alt='anonppf.jpg' style='position:relative;top:17px;width: auto;height: auto; max-width:70px; max-height:70px;border='0''></a>";
					}
				} else {
					echo "<a href='userprofile.php?id=".$email."&owner=true'><img src='member_avatar/".$avatar ."'alt='anonpp.jpg' style='position:relative;top:17px; width: auto;height: auto; max-width:70px; max-height:70px;'></a>";
				}
			?>		
		</div>
		
		<div>
		<p style="font-family:Arial,Helvetica Neue,Helvetica,sans-serif;  font-size: 20px; color:blue; font-weight:bold; position: relative; left:80px; bottom:63px;">Welcome, 
			<?php 
				if(strcmp($fname, "") != 0) {
					echo $fname;
				} else {
					echo $email;
				}
			?>
			</p>
		</div>
		<div style="position:relative; left: 80px; bottom:70px; font-size: 18px;">
			<?php 
			echo "<a href='homepage.php?loginemail=".$email."'>Home</a>";
			?>			
			<a href='homepage.php'>Sign Out</a>
		</div>
	</div>	
	
		
	
	<div style="clear: both;"> <!-- Clear the float -->
		<hr> 
	</div>
	
	<div>
		<p style="font-weight:bold; font-size:40px; position:relative; left:20px;"> Product Registration</p>
		
		<div>
			<table cellspacing="17" style="font-size: 20px; position:relative; left:20px; font-family: Lucida Bright,Georgia,serif;">
				<tr>
					<td> <label id="namereq">Product Name<label> </td>
					<td> <input type="text" id="pname" style="width: 275px; height: 22px; padding: 2px; border: 1px solid gray;"></input></td>
				<tr>
				
				<tr>
					<td> <label id="pricereq"> Price </label> </td>
					<td> <input type="text" id="price" style="width: 70px; height: 22px; padding: 2px; border: 1px solid gray;"></input>
					<select id = "cur" style="width: 200px; height: 28px; padding: 2px; border: 1px solid gray;"> 
						<option value="-"> Select Currency</option>
						<option value="EUR"> Euros (EUR)</option>
						<option value="USD"> US Dollars (USD)</option>
						<option value="AUD"> Australian Dollars (AUD)</option>
						<option value="CAD"> Canadian Dollars (CAD)</option>
						<option value="GBP"> Great Britain Pounds (GBP)</option>
						<option value="EGP"> Egyptian Pounds (EGP)</option>
					</select></td>
				</tr>
				
				<tr>
					<td> <label id="amtreq">Amount</label> </td>
					<td> <input type="text" id="amt" style="width: 70px; height: 22px; padding: 2px; border: 1px solid gray;"></input></td>
				</tr>
				
				<tr>
					<td> Description </td>
					<td> <textarea id="description" cols="37" rows="14"></textarea></td>
				</tr>
				
				<tr>
					<td> Display </td>
					<td> <input type="file" id="display"></input></td>
				</tr>
				<tr><td><i id="requiredfields" style="font-size: 15px;color: #ff0000;">Required Fields</i></td></tr>
				<tr>
					<td></td>
					<td align="center"> <button class="animbutton" id="registerproduct" class="animbutton" style="font-size:18px;">Register Product</button></td>
				</tr>
			
			</table>
		</div>

	</div>
</div>

	<div style="float:left;">
		<img src="shoppingcart.png" alt="shoppingcart.png" style="position: absolute; width:350px; height:271px; right: 170px; top:350px;">
	</div>	
</body>

</html>