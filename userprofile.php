<!DOCTYPE html>

<html>

<?php 
	// We can set our variables here and use them later in other php tags
	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); 
	$sql = "SELECT firstname, lastname, email, gender, country, telephone, birthday, avatar FROM Members";
	$result = $conn->query($sql);
	$fname = "";
	$lname = "";
	$email = "";
	$gender = "-";
	$country = "-";
	$telephone = "-";
	$birthday = "";
	$avatar = "";
	$fullname = "-";
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { // Loop over all the rows		
			if (strcasecmp($row["email"], $_GET["id"]) == 0) { //$_GET["id"] gets the value embedded in the URL
				$fname = $row["firstname"];
				$lname = $row["lastname"];
				$email = $row["email"];
				$gender = $row["gender"];
				$country = $row["country"];
				$telephone = $row["telephone"];
				$birthday = $row["birthday"];
				$avatar = $row["avatar"];
			}
		}
	} 
	$fullname = $fname . " " . $lname;
	$ownedproducts_disp=array();
	$ownedproducts_id=array();
	$ownedproducts_name=array();
	$sql = "SELECT id, name,owner_email, display FROM Products";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { 	
			if (strcasecmp($row["owner_email"], $_GET["id"]) == 0) { 
				array_push($ownedproducts_disp, $row["display"]); //Pushes an array element at the end
				array_push($ownedproducts_id, $row["id"]);
				array_push($ownedproducts_name, $row["name"]);
			}
		}
	} 
?>		

<head>
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
			font-family:Arial,Helvetica Neue,Helvetica,sans-serif;
			font-size:20px; 
			font-weight:bold;
			
		}
		
		info {
			font-family:Arial,Helvetica Neue,Helvetica,sans-serif;
			font-size:18px; 
			font-weight:bold;
		}
		
		.links {
			font-size: 20px;
			cursor: pointer; /* Defines the type of cursor to be displayed when pointing on an element */
		}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="shortcut icon" href="logo.png">

	<script>
		$(document).ready(function(){
			var noproducts = $("#noproducts").val()-1;

			$("#preglink").click(function(){
				$("#pagediv").hide(1200, function(){	
					var email = $("#emvalue").val();
					window.location.replace("product_registration.php?id="+email);
				});	
			});	

			
			$("#historylink").click(function(){
				$("#pagediv").hide(1200, function(){	
					var email = $("#emvalue").val();
					window.location.replace("user_history.php?id="+email);
				});	
			});	

			setInterval(function() {
				var form_data = new FormData(); 
				form_data.append("index",noproducts);
				form_data.append("email",$("#emvalue").val());	
				form_data.append("type", "display");
				$.ajax({ 
					url: 'member_products.php', 
					dataType: 'text',  
					cache: false,
					contentType: false, 
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						if(php_script_response !== "") {
							$("#proddisp").attr('src',"product_display/"+php_script_response);							
						} else {
							$("#proddisp").attr('src',"product_display/noimage.jpg");
						}
					}
				});
				form_data = new FormData(); 
				form_data.append("index",noproducts);
				form_data.append("email",$("#emvalue").val());	
				form_data.append("type", "name");
				$.ajax({ 
					url: 'member_products.php', 
					dataType: 'text',  
					cache: false,
					contentType: false, 
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						document.getElementById("prodnm").innerHTML = php_script_response;						
					}
				});
				form_data = new FormData(); 
				form_data.append("index",noproducts);
				form_data.append("email",$("#emvalue").val());	
				form_data.append("type", "id");
				$.ajax({ 
					url: 'member_products.php', 
					dataType: 'text',  
					cache: false,
					contentType: false, 
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						if($("#ownervalue").val() == "true"){
							$("#plnk").attr('href', "product_page.php?id="+php_script_response+"&avt="+$("#avtvalue").val()+"&gen="+$("#genvalue").val()+"&fnm="+$("#fnmvalue").val()+"&nveml="+$("#emvalue").val());
						} else {
							$("#plnk").attr('href', "product_page.php?id="+php_script_response+
								"&avt="+$("#navgavtvalue").val()+"&gen="+$("#navggenvalue").val()+
								"&fnm="+$("#navgfnmvalue").val()+"&nveml="+$("#navgemvalue").val());
						}
					}
				});				
				if(noproducts > 0) {
					noproducts--;
				} else {
					noproducts = $("#noproducts").val()-1;
				}
			}, 3000);
		});
	</script>
	
	<title>
		<?php 		
			$title = "";		
			if(strcmp($fname, "") != 0) {
				$title = $fname;
				if(strcmp($lname, "") != 0) {
					$title = $title." ".$lname;
				}
			} else {
				$title = $email;
			}		
			echo $title;
		?>
	</title>
	
</head>


<body>
	<?php
 	echo "<option id='ownervalue' value='".$_GET["owner"]."' style='display:none'></option>";
	if(isset($_GET["navemail"])) {
		if(strcasecmp($_GET["navemail"],"") != 0 && strcasecmp($_GET["owner"],"true") != 0) {
			$conn = new mysqli($servername, $username, $password, $dbname); 
			$sql = "SELECT firstname, email, gender, country, telephone, birthday, avatar FROM Members";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) { // Loop over all the rows		
					if (strcasecmp($row["email"], $_GET["navemail"]) == 0) { //$_GET["id"] gets the value embedded in the URL
						echo "<option id='navgemvalue' value='".$row["email"]."' style='display:none'></option>";
						echo "<option id='navgavtvalue' value='".$row["avatar"]."' style='display:none'></option>"; 
	 					echo "<option id='navggenvalue' value='".$row["gender"]."' style='display:none'></option>"; 
					 	echo "<option id='navgfnmvalue' value='".$row["firstname"]."' style='display:none'></option>";
					}
				}
			}
		}
	} 
	echo "<option id='emvalue' value='".$email."' style='display:none'></option>";
	echo "<option id='avtvalue' value='".$avatar."' style='display:none'></option>"; 
	echo "<option id='genvalue' value='".$gender."' style='display:none'></option>"; 
	echo "<option id='fnmvalue' value='".$fname."' style='display:none'></option>";
	 
	 ?> 

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
				$tempemail = $email;
				$tempavatar = $avatar;
				$tempfname = $fname;
				$tempgender = $gender;

				if(isset($_GET["navemail"])) {
					if(strcasecmp($_GET["navemail"], "")!=0) {
						$conn = new mysqli($servername, $username, $password, $dbname); 
						$sql = "SELECT firstname, email, gender, country, telephone, birthday, avatar FROM Members";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) { // Loop over all the rows		
								if (strcasecmp($row["email"], $_GET["navemail"]) == 0) { //$_GET["id"] gets the value embedded in the URL
									$fname = $row["firstname"];
									$email = $row["email"];
									$gender = $row["gender"];
									$avatar = $row["avatar"];
								}
							}
						} 
					}
				}
			?>
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
		<?php 
			$email = $tempemail;
			$avatar = $tempavatar;
			$fname = $tempfname;
			$gender = $tempgender;
		?>
	</div>	
	
	<div style="clear: both;"> <!-- Clear the float -->
		<hr> 
	</div>

	<div id="meminfo">
		<div style = "float:left; position:relative; left:40px; top:35px;">		
			<?php 
				if(strcmp($avatar,"") == 0) {
					if(strcmp($gender, "Male") == 0){
						echo "<img src='member_avatar/anonpp.jpg' alt='anonpp.jpg' style='border:3px solid #707070;width: auto;height: auto; max-width:150px; max-height:150px'>";
					} else {
						echo "<img src='member_avatar/anonppf.jpg' alt='anonppf.jpg' style='border:3px solid #707070;width: auto;height: auto; max-width:150px; max-height:150px'>";
					}
				} else {
					echo "<img src='member_avatar/".$avatar ."'alt='anonpp.jpg' style='border:3px solid #707070;width: auto;height: auto; max-width:150px; max-height:150px;'>";
				}
			?>		
		</div>
		
		<div>
			<p style="float:left; position:relative; font-family: Franklin Gothic Medium,
			Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; font-size:23px; top: 11px; left: 70px; font-weight:bold;">
			Personal Information</p>
			<br><br>
			<div style="float:left; position: relative;right:120px; top:55px;">
			
				<labels>Name: <info><?php echo $fullname; ?></info> </labels>
				<br><br><br>
				<labels>Email: <info><?php echo $email; ?><info></labels>
				<br><br><br>
				<labels>Telephone: <info><?php echo $telephone; ?><info></labels>
				<br><br><br>
				<labels>Gender: <info><?php echo $gender; ?><info></labels>
				<br><br><br>
				<labels>Country: <info><?php echo $country; ?><info></labels>
				<br><br><br>
				<labels>Date of Birth: <info><?php echo $birthday; ?><info></labels>
				<br><br><br>
				<?php if(strcasecmp($_GET["owner"], "true")==0) {echo "<button class = 'links' id='preglink'> Register your Product </button> ";}?>
				<br><br><br>
				<?php if(strcasecmp($_GET["owner"], "true")==0) {echo "<button class = 'links' id='historylink'> View Purchases</button> ";}?>
				<br><br><br>
			</div>
			
		</div>
	</div>
	
	<div>
			<p style="float:left; position:relative; font-family: Franklin Gothic Medium, Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; font-size:23px; bottom: 24px; left: 70px; font-weight:bold;">
			Offered Products</p>
			<div style="position:relative; top:50px; right:40px;">
			<table>
			<?php 
				$tempavatar = $avatar;
				$tempgender = $gender;
				$tempfname = $fname;
				$tempemail = $email;

				if(isset($_GET["navemail"])) {
					if(strcasecmp($_GET["navemail"], "")!=0) {
						$conn = new mysqli($servername, $username, $password, $dbname); 
						$sql = "SELECT firstname, email, gender, country, telephone, birthday, avatar FROM Members";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) { // Loop over all the rows		
								if (strcasecmp($row["email"], $_GET["navemail"]) == 0) { //$_GET["id"] gets the value embedded in the URL
									$fname = $row["firstname"];
									$email = $row["email"];
									$gender = $row["gender"];
									$avatar = $row["avatar"];
								}
							}
						} 
					}
				}

				if(count($ownedproducts_disp) > 0) {
					echo "<tr><td><a id='plnk' href='product_page.php?id=".$ownedproducts_id[0]."&avt=".$avatar."&gen=".$gender."&fnm=".$fname."&nveml=".$email.
					"'><img id='proddisp' src='product_display/".$ownedproducts_disp[0]."' 
					style='width:250px;height:250px;border:3px solid #707070;'>".
					"<p id='prodnm' style='font-weight:bold; font-size:20px;word-wrap:break-word; text-align:center;'>".$ownedproducts_name[0]."</p></td></tr></a>";
				}

				$avatar = $tempavatar;
				$gender = $tempgender;
				$fname = $tempfname;
				$email = $tempemail;
			?>
			</table>
			</div>
	</div>


<div>

<?php echo "<option id='noproducts' value='".count($ownedproducts_disp)."' style='display:none'></option>"; ?>
</body>

</html>