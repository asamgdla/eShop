<?php
	if(isset($_POST["emailaddress"])) { // Here we want to check if an email address already exists in the database

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "eShop";
		$conn = new mysqli($servername, $username, $password, $dbname); 
		$sql = "SELECT email FROM Members";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {			
			while($row = $result->fetch_assoc()) { // Loop over all the rows				
				if (strcasecmp($row["email"], $_POST["emailaddress"]) == 0) { //If one of the rows has an email equal to the entered email
					echo "-1"; //Error
				}
			}
		} else {
			echo "0"; //OK (if there are no members)
		}		
	}
?>