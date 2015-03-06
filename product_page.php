<DOCTYPE html>
<html>
<?php 
	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); 
	$sql = "SELECT id, owner_email, name, price, available, description, display FROM Products";
	$result = $conn->query($sql);
	$email = "";
	$pname = "";
	$price = "";
	$available = 0;
	$description = "";
	$display = "";
	$avatar = "";
	$gender = "";
	$fname = "";
	$pid = $_GET["id"];
	$navigatoremail = "";
	if(isset($_GET["avt"])) {
		$avatar = $_GET["avt"];	
	}
	if(isset($_GET["nveml"])) {
		$navigatoremail = $_GET["nveml"];	
	}
	if(isset($_GET["gen"])) {
		$gender = $_GET["gen"];	
	}
	if(isset($_GET["fnm"])) {
		$fname = $_GET["fnm"];	
	}
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { 		
			if (strcasecmp($row["id"], $_GET["id"]) == 0) { 
				$email = $row["owner_email"];
				$pname = $row["name"];
				$price = $row["price"];
				$available = $row["available"];
				$description = $row["description"];
				$display = $row["display"];
			}
		}
	}
	if(strcmp($display, "") == 0) {
		$display = "noimage.jpg";
	}
	if(strcmp($description, "") == 0) {
		$description = "No Description Available";
	}
?>

<head>
		<link rel="shortcut icon" href="logo.png">

	<title> <?php echo $pname; ?></title>
	<style>
		h2 {
			color: #00008B;
			font-family: Brush Script MT,cursive; 
		}
		body {
			background-image: url("background.jpg");
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

		labels {
			font-family: Franklin Gothic Medium,
			Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; 
			font-size:23px;
			font-weight: bold;
		}

		data {
			font-family:Arial,Helvetica Neue,Helvetica,sans-serif;
			font-size:18px;
			font-weight: bold;
			word-wrap:break-word;
			max-width: 10px;
		}

	</style>


	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


	<script>
	$(document).ready(function(){

		$("#amtreq").keydown(function(event){ // Here we want to take numeric data only
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ); // allow backspace, delete and arrows
				else {
					// Ensure that it is a number and stop the keypress
					if (event.keyCode < 48 || event.keyCode > 57 ) {
						event.preventDefault();	
					}	
				}			
		});

		$("#buybutn").click(function() {

			var valid = true;

			var amountrequired = $("#amtreq").val();
			var amountavailable = $("#availablevalue").val();

			if(amountrequired == "") {
				valid = false;
			}

			if(parseInt(amountrequired) > parseInt(amountavailable)) {
				valid = false;
			}

			if(valid == false) {

				$("#invalid").css("visibility","visible");

			} else {
				$("#invalid").css("visibility","hidden");
				form_data = new FormData(); 
				form_data.append("id",$("#pidvalue").val());
				form_data.append("buyer",$("#buyeremail").val());
				form_data.append("amount", amountrequired);
				form_data.append("available", amountavailable);
				form_data.append("price", $("#pricevalue").val());
				form_data.append("pname", $("#pnamevalue").val());
				form_data.append("display", $("#displayvalue").val());
				form_data.append("owner", $("#ownervalue").val());


				$.ajax({ 
					url: 'buy_product.php', 
					dataType: 'text',  
					cache: false,
					contentType: false, 
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						alert("Transaction Completed Successfully");
						$("#body").hide(1200, function(){
							window.location.replace("userprofile.php?id="+$("#buyeremail").val()+"&owner=true");
						});
					}
				});
			}

		}); 
	});
	</script>
</head>

<body id = 'body'>
	<?php echo "<option id='pidvalue' value='".$pid."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='buyeremail' value='".$navigatoremail."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='availablevalue' value='".$available."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='pricevalue' value='".$price."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='pnamevalue' value='".$pname."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='displayvalue' value='".$display."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
	<?php echo "<option id='ownervalue' value='".$email."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->

	
	<div id="pagediv">
	<div id="logodiv" style = "float:left">
		<img src="logo.png" id="logo" alt="eShop.com">
	</div>
	
	<div id= "titlediv" style = "float:left">
		<h1> eShop </h1>
		<h2> Your Virtual Shop </h2>		
	</div>
	
	<div id = "memwel" style="float:right; position: relative; right: 150px; top: 28px;">
		<div>		
			<?php 
				if(strcmp($avatar,"") == 0) {
					if(strcmp($gender, "Male") == 0){
						echo "<a href='userprofile.php?id=".$navigatoremail."&owner=true'><img src='member_avatar/anonpp.jpg' alt='anonpp.jpg' style='position:relative;top:17px;width: auto;height: auto; max-width:70px; max-height:70px;border='0''></a>";
					} else {
						echo "<a href='userprofile.php?id=".$navigatoremail."&owner=true'><img src='member_avatar/anonppf.jpg' alt='anonppf.jpg' style='position:relative;top:17px;width: auto;height: auto; max-width:70px; max-height:70px;border='0''></a>";
					}
				} else {
					echo "<a href='userprofile.php?id=".$navigatoremail."&owner=true'><img src='member_avatar/".$avatar ."'alt='anonpp.jpg' style='position:relative;top:17px; width: auto;height: auto; max-width:70px; max-height:70px;'></a>";
				}
			?>		
		</div>
		
		<div>
		<p style="font-family:Arial,Helvetica Neue,Helvetica,sans-serif;  font-size: 20px; color:blue; font-weight:bold; position: relative; left:80px; bottom:63px;">Welcome, 
			<?php 
				if(strcmp($fname, "") != 0) {
					echo $fname;
				} else {
					echo $navigatoremail;
				}
			?>
			</p>
		</div>
		<div style="position:relative; left: 80px; bottom:70px; font-size: 18px;">
			<?php 
			echo "<a href='homepage.php?loginemail=".$navigatoremail."'>Home</a>";
			?>			
			<a href='homepage.php'>Sign Out</a>
		</div>
	</div>	
	
	<div style="clear: both;"> <!-- Clear the float -->
		<hr> 
	</div>
	<br>
			<center>

	<h1> <?php echo $pname; ?> </h1> </center>
	
	<center>
	<div>
		<table style="border-collapse:separate; border-spacing:2em;" align="center">
	<?php 
		echo "<tr><td align = 'center'><img style='position:relative; width:250px;height:250px;border:3px solid #707070;' src=product_display/".$display. "></img></td></tr>";
		echo "<tr><td align = 'center'><labels> Price: </labels><data>".$price. "</data></td></tr>";
		echo "<tr><td align = 'center'><labels> Amount available: </labels><data>".$available. "</data></td></tr>";
		echo "<tr><td align = 'center'><labels> Description: </labels><data>".$description."</data></td></tr>";
		echo "<tr><td align = 'center'><labels> Owner Email: </labels><data>".$email."</data></td></tr>";
	?>
		</table>

		<?php 		
		if(strcasecmp($navigatoremail, $email) != 0) {
			echo "<center><labels style='position:relative;'> Amount Required: </labels><input style='position:relative; width:70px;height:30px;' type=text id ='amtreq'></center>";
			echo "<br>";
			echo "<center><labels id='invalid' style = 'position:relative; color:#ff0000; font-size:20px; visibility:hidden;'>Invalid Amount Entered</labels></center>";
			echo "<br>";
			echo "<center><button id='buybutn' style='position:relative; font-size: 20px;cursor: pointer;'> Buy This Product </button></center>";
			echo "<br><br><br>";
		}
		?>
	</div>

		</center>

</body>
</html>