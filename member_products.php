<?php 

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); 
		
	if(isset($_POST["index"])) {
		$index = $_POST["index"];
	}
	if(isset($_POST["email"])) {
		$email = $_POST["email"];
	}
	if(isset($_POST["type"])) {
		$type = $_POST["type"];
	}
	
	$sql = "SELECT name, id, owner_email, display FROM Products";
		$result = $conn->query($sql);
		$counter = 0;
		if ($result->num_rows > 0) {			
			while($row = $result->fetch_assoc()) { // Loop over all the rows
				if (strcasecmp($row["owner_email"], $email) == 0) { 
					if($index == $counter) {
						if($type == "display") {
							echo $row["display"];
						}
						if($type == "name") {
							echo $row["name"];
						}
						if($type == "id") {
							echo $row["id"];
						}
						
					}
					$counter = $counter+1;
				}
			}		
		} 
		

?>