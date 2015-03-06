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
	$avatar = "";
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { // Loop over all the rows		
			if (strcasecmp($row["email"], $_GET["id"]) == 0) { //$_GET["id"] gets the value embedded in the URL
				$fname = $row["firstname"];
				$lname = $row["lastname"];
				$email = $row["email"];
				$gender = $row["gender"];
				$avatar = $row["avatar"];
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
		table, th, td {
			border-collapse: collapse;
		    border: 3px solid gray;
		    padding: 8px;
		}
		labels {
			font-family: Franklin Gothic Medium, Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; 
			font-size:23px;
			font-weight: bold;
		}
		data {
			font-family:Arial,Helvetica Neue,Helvetica,sans-serif;
			font-size:18px; 
		}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="shortcut icon" href="logo.png">

	<script>
		$(document).ready(function(){
			var email = $("#emvalue").val();
			var form_data = new FormData(); 
			form_data.append("buyeremail",email);
			$.ajax({ 
				url: 'history_search.php', 
				dataType: 'text',  
				cache: false,
				contentType: false, 
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					var productsarray = php_script_response.split("\n");
					var acc = "";
					for(var i = 0; i < productsarray.length-1; i++) {
						var current = productsarray[i].split("%");
						acc = acc + "<tr>";
						for(var j = 0; j < current.length-1; j++) {
							if(j != 3) {
								acc = acc + "<td><data>"+current[j]+"</data></td>";
							} else {
								acc = acc + "<td><img style='width:50px;height;50px;' src='product_display/"+current[j]+"'></img>"  
							}
						}
						acc = acc + "</tr>";
					}
					$("#historytable").append(acc);
				}
			});

		});
	</script>
	<title> Purchases History </title>
<head>
<body>
	<?php echo "<option id='emvalue' value='".$email."' style='display:none'></option>";?> <!-- Storing a PHP value in an HTML tag for use in JQuery -->

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
	<br><br>
<p style="float:left; position:relative; font-family: Franklin Gothic Medium, Franklin Gothic,ITC Franklin Gothic,Arial,sans-serif; font-size:23px; 
bottom: 24px; left: 560px; font-weight:bold;">
			Purchases History</p><br>

			<table id='historytable' style='position:relative; left:100px; top:45px;' >

				<tr> <td><labels>Product Id</labels></td>
					<td><labels>Product Name</labels></td>
					<td><labels>Price</labels></td>
					<td><labels>Display</labels></td>
					<td><labels>Owner</labels></td>
					<td><labels>Quantity</labels></td>
				</tr>

			</table>

</div>




</body>
</html>






