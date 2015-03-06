<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); //NOTE: To insert in a database, the connection must be made prior to the inserting function

	if(isset($_POST["id"])){
		 $pid = $_POST["id"];
	}


	if(isset($_POST["buyer"])){
		 $buyer = $_POST["buyer"];
	}


	if(isset($_POST["amount"])){
		 $amount = $_POST["amount"];
	}

	if(isset($_POST["price"])){
		 $price = $_POST["price"];
	}

	if(isset($_POST["pname"])){
		 $pname = $_POST["pname"];
	}

	if(isset($_POST["display"])){
		 $display = $_POST["display"];
	}

	if(isset($_POST["owner"])){
		 $owner = $_POST["owner"];
	}

	$sql = "INSERT INTO members_buy_products VALUES ('$pid','$pname','$price','$display','$owner','$buyer','$amount')";
	$conn->query($sql);
	
	if(isset($_POST["available"])){
		 $available = $_POST["available"];
	}

	$newval = (int)$available - (int)$amount;
	

	if($newval == 0) {

		$sql = "DELETE FROM Products WHERE id=$pid";

		if ($conn->query($sql) === TRUE) {
			echo "0"; //Success
		} else {
			echo $conn->error; //Error
		}

	} else {
		$sql = "UPDATE Products SET available=$newval WHERE id=$pid";

		if ($conn->query($sql) === TRUE) {
			echo "0"; //Success
		} else {
			echo $conn->error; //Error
		}
	}

	

?>