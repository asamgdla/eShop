<?php 

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eShop";
	$conn = new mysqli($servername, $username, $password, $dbname); //NOTE: To insert in a database, the connection must be made prior to the inserting function

	
	global $fname, $lname, $email, $password, $avatar, $telephone, $birthday, $gender, $country;

	if(isset($_POST["firstname"])){
		 $fname = $_POST["firstname"];
	} else {
		$fname = "";
	}
	
	if(isset($_POST["lastname"])){
		 $lname = $_POST["lastname"];
	} else {
		$lname = "";
	}
	
	if(isset($_POST["useremail"])){
		 $email = $_POST["useremail"];
	} else {
		$email = "";
	}
	
	if(isset($_POST["userpassword"])){
		 $password = $_POST["userpassword"];
	} else {
		$password = "";
	}
	
	if(isset($_POST["gender"])){
		 $gender = $_POST["gender"];
	} else {
		$gender = "";
	}
	
	if(isset($_POST["country"])){
		 $country = $_POST["country"];
	} else {
		$country = "";
	}
	
	if(isset($_POST["telephone"])){
		 $telephone = $_POST["telephone"];
	} else {
		$telephone = "";
	}
	
	if(isset($_POST["birthday"])){
		 $birthday = $_POST["birthday"];
	} else {
		$birthday = "";
	}
	
	function handle_image() {
		global $avatar;
		$avatar = "";
		$target_dir = "member_avatar/"; // Where the file will be stored
		$target_file = $target_dir . basename($_FILES["useravatar"]["name"]); // The path of the file

		if(!empty($_FILES["useravatar"]["tmp_name"])){
			$check = getimagesize($_FILES["useravatar"]["tmp_name"]); // Check if image file is a actual image or fake image
			
			if($check !== false) {			
				move_uploaded_file($_FILES["useravatar"]["tmp_name"], $target_file); //If its an actual image, move it to the directory
				$avatar = basename( $_FILES["useravatar"]["name"]);			
			} 
		}
	}
	
	function insert_members($email, $firstname, $lastname, $password, $gender, $country, $telephone, $birthday) { 
		global $conn, $avatar;						
		if(isset($_POST["fileselected"])){
		
			if(strcmp($_POST["fileselected"], "true") == 0){
				handle_image();
			}
		}		
		$sql = "INSERT INTO Members (email, firstname, lastname, password, gender, country, telephone, birthday, avatar) VALUES 
		('$email','$firstname','$lastname','$password','$gender','$country','$telephone','$birthday','$avatar')";

		if ($conn->query($sql) === TRUE) {
			echo "0"; //Success
		} else {
			echo "-1"; //Error
		}
		$conn->close();
	}
	
	if(!empty($email) && !empty($password)) {
		insert_members($email, $fname, $lname, $password, $gender, $country, $telephone, $birthday);
	}	
?>