<?php
	if(isset($_POST["useremail"]) && isset($_POST["userpassword"])) { 
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "eShop";
		$conn = new mysqli($servername, $username, $password, $dbname); 
		$sql = "SELECT email, password FROM Members";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {			
			$found = false;			
			while($row = $result->fetch_assoc()) { // Loop over all the rows
				if (strcasecmp($row["email"], $_POST["useremail"]) == 0 && strcasecmp($row["password"], $_POST["userpassword"]) == 0) { 
					$found = true;
					echo "0";					
				}
			}			
			if($found == false) {
				echo "-1";
			}
		} else {
			echo "-1"; 
		}		
	}
?>