<?php

	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); 
	$sql = "SELECT p_id, pname,price,display,owner_email, buyer_email, quantity FROM members_buy_products";
	$result = $conn->query($sql);
	$buyeremail = "";
	if(isset($_POST["buyeremail"])){
		$buyeremail = $_POST["buyeremail"];
	}

	$res = "";

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { 
			if (strcasecmp($row["buyer_email"], $buyeremail) == 0) { 
				
				$res= $res.$row["p_id"]."%".$row["pname"]."%".$row["price"]."%".$row["display"]."%".$row["owner_email"]."%".$row["quantity"]."%\n";

			}
		}
	} 

	echo $res;

?>