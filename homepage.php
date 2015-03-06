<!DOCTYPE html>

<html>


<?php 
	// We can set our variables here and use them later in other php tags
	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); 
	$sql = "SELECT id, owner_email, name, price, display FROM Products";
	$result = $conn->query($sql);
	$products_id=array();
	$products_email=array();
	$products_name=array();
	$products_price=array();
	$products_display=array();
	$current = 0;

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { // Loop over all the rows		
			array_push($products_id, $row["id"]);
			array_push($products_email, $row["owner_email"]);
			array_push($products_name, $row["name"]);
			array_push($products_price, $row["price"]);

			if(strcasecmp($row["display"],"") == 0){
				array_push($products_display, "noimage.jpg");
			} else {
				array_push($products_display, $row["display"]);
			}
		}
	} 

	if(isset($_GET["current"])) {
		$current = $_GET["current"];
	} 

	$loginem = "";
	$logingender = "Male";
	$loginavatar = "";
	$firstname = "";

	if(isset($_GET["loginemail"])) {
		$loginem = $_GET["loginemail"];
		$conn = new mysqli($servername, $username, $password, $dbname); 
		$sql = "SELECT email, firstname, lastname, gender, avatar FROM Members";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) { // Loop over all the rows		
				if(strcasecmp($row["email"], $loginem) == 0) {
					$loginname = $loginem;
					if(strcasecmp($row["firstname"], "") != 0) {
						$loginname = $row["firstname"]; 
						$firstname = $row["firstname"];
					}
					if(strcasecmp($row["avatar"],"") == 0) {
						if(strcasecmp($row["gender"], "Female") == 0) {
							$loginavatar = "anonppf.jpg";
							$logingender = "Female";
						} else {
							$loginavatar = "anonpp.jpg";
							$logingender = "Male";
						}
					} else {
						$loginavatar = $row["avatar"];
					}
				}		
			}
		} 

	}
?>


<head> <!-- Head is used to declare information about the web-page -->

	<title>eShop - Homepage</title>
	
	<meta name="description" content="On-line Shopping"> <!-- The meta tag defines page description, keywords and other data -->
	
	<link rel="stylesheet" type="text/css" href="homepage-style.css">

	<link rel="shortcut icon" href="logo.png">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script language="javascript" type="text/javascript" src="homepage-jscript.js"></script>

</head>

<body> <!-- Visible part of the web-page -->
	

<?php echo "<option id='currentval' value='".$current."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->
<?php echo "<option id='emailval' value='".$loginem."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->

<div id="maindiv">
	<div id="logodiv">
		<img src="logo.png" id="logo" alt="eShop.com">
	</div>
	
	<div id= "titlediv">
		<h1> eShop </h1>
		<h2> Your Virtual Shop </h2>		
	</div>

<?php 	

if(strcasecmp($loginem,"") == 0){
echo "
	<div id= 'membershipdiv' style='position:relative;left:620px;top:20px;'>
		<table id='memtable'>
						
			<tr> 
				<td style='color:#333333'> Email: </td> 
				<td> <input type='text' name='useremail' id='loginemail'> </td>
				<td id='emailrequired' style ='color:red; font-family: TimesNewRoman,serif;'> </td>
			</tr>
			
			<tr>
				<td style='color:#333333'> Password: </td>
				<td> <input type='password' name='userpassword' id='loginpassword'> </td>
				<td id='passwordrequired' style = 'color:red; font-family: TimesNewRoman,serif;'></td>
			</tr>
			
			<tr>
				<td> <input type='submit' id='login' value='Login'> </td> 				
			
				<td colspan = '3'> Not a Member Yet? <a href='registration.html'> Sign Up Now!</a> </td> 
			</tr>
			
		</table>	
	</div>";
} else {
	echo "<div id = 'memwel' style='float:right; position: relative; right: 150px; top: 28px;'>
		<div>					
		<a href='userprofile.php?id=".$loginem."&owner=true'>
		<img src='member_avatar/".$loginavatar."' alt='anonpp.jpg' style='position:relative;top:17px;width: auto;height: auto; max-width:70px; max-height:70px;border='0''>
		</a>
		</div>
		<div style = 'float: left'>
		<p style='font-family:Arial,Helvetica Neue,Helvetica,sans-serif;  font-size: 20px; color:blue; font-weight:bold; position: 
		relative; left:80px; bottom:63px;'>Welcome, ".$loginname."</p>
		</div>
		<div style='position:relative; left:80px; bottom:70px; font-size: 18px;'>
						
			<a href='homepage.php?loginemail=".$loginem."'>Home</a>
						
			<a href='homepage.php'>Sign Out</a>
		</div>
	</div>";	
}
?>
		
	
	<div style="clear: both;"> <!-- Clear the float -->
		<hr> 
	</div>
	
</div>


<table style="clear:both;">
	<?php 
		for($i = $current; $i < $current+6; $i++) {
			if($i%3==0) {
				echo "<tr>";
			}
			if($i < count($products_id)) {
				echo "
				<td style='padding: 85px;'> 
				<a id='plnk' href='";

				if(strcasecmp($loginem, "") != 0) {
				echo "product_page.php?id=".$products_id[$i]."&avt=".$loginavatar."&gen=".$logingender."&fnm=".$firstname."&nveml=".$loginem;
				} else {
					echo "registration.html";
				}

				echo "'>
				<img id='proddisp' src='product_display/".$products_display[$i]."'style='display: block;width:250px;height:250px;border:3px solid #707070;'>
				</img>
				<p align=center style='font-weight:bold; font-size:20px; font-family:Franklin Gothic Medium,Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; '>".$products_name[$i]."</p>
				</a>
				<p align=center style='font-weight:bold; font-size:20px; font-family:Franklin Gothic Medium,Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif;'>
				".$products_price[$i]."	
				</p>
				<p align=center style='font-weight:bold; font-size:20px; font-family:Franklin Gothic Medium,Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif;'>
				Offered by: <a href='userprofile.php?id=".$products_email[$i]."&owner=";

				if(strcasecmp($loginem, $products_email[$i]) == 0) {
					echo "true";
				} else {
					echo "false&navemail=".$loginem;
				}


				echo "'>".$products_email[$i]."</a>	
				</p>
				</td>";
			}
			if($i+1%3==0) {
				echo "</tr>";
			}
		}
	?>
</table>

<center>

	<?php 

		if($current + 6 < count($products_id)) {
		echo "<button id='nextpage' style='font-size:20px;font-family:Franklin Gothic Medium,Franklin 
		Gothic,ITC Franklin Gothic,Arial,sans-serif;'>Next Page</button>";
		}

		if($current - 6 >= 0) {
		echo "<button id='previouspage' style='font-size:20px;font-family:Franklin Gothic Medium,Franklin 
		Gothic,ITC Franklin Gothic,Arial,sans-serif;'>Previous Page</button>";
		}
	?>
</center>



<br><br><br>
</body>


</html>
