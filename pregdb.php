<?php 

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); //NOTE: To insert in a database, the connection must be made prior to the inserting function

	global $owneremail, $pname, $price, $amount, $description, $avatar;
	
	if(isset($_POST["email"])) {
		$owneremail = $_POST["email"];
	} else {
		$owneremail = "";
	}
	
	if(isset($_POST["productname"])) {
		$pname = $_POST["productname"];
	} else {
		$pname = "";
	}
	
	if(isset($_POST["price"])) {
		$price = $_POST["price"];
	} else {
		$price = "";
	}
	
	if(isset($_POST["amount"])) {
		$amount = $_POST["amount"];
	} else {
		$amount = 0;
	}
	
	if(isset($_POST["description"])) {
		$description = $_POST["description"];
	} else {
		$description = "";
	}
	
	if(isset($_POST["fileselected"])){
		if(strcmp($_POST["fileselected"], "true") == 0){
			$avatar = "";
			$target_dir = "product_display/"; // Where the file will be stored
			$target_file = $target_dir . basename($_FILES["avatar"]["name"]); // The path of the file

			if(!empty($_FILES["avatar"]["tmp_name"])){
				$check = getimagesize($_FILES["avatar"]["tmp_name"]); // Check if image file is a actual image or fake image
				
				if($check !== false) {			
					move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file); //If its an actual image, move it to the directory
					$avatar = basename( $_FILES["avatar"]["name"]);			
				} 
			}
		}
	}	
	
	$sql = "INSERT INTO Products VALUES (DEFAULT, '$owneremail','$pname','$price','$amount','$description','$avatar')";
	
	if ($conn->query($sql) === TRUE) {
		echo "0"; //Success
	} else {
		echo $conn->error; //Error
	}
	$conn->close();	
		
?>