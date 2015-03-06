<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eShop";

	function create_db() {
		global $servername, $username, $password, $dbname;
		
		// Step 1: Create connection
		$conn = mysqli_connect($servername, $username, $password);
		echo "Connected successfully"."<br>";
		
		// Step 2: Create Database
		$sql = "CREATE DATABASE ".$dbname;
		if (mysqli_query($conn, $sql)) {
			echo "Database created successfully"."<br>";
		}
		$conn->close();		
	}
	
	function create_tables() {
		
		global $servername, $username, $password, $dbname;
		// Step 1: Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Step 2: Create the table
		$sql = "CREATE TABLE Members (
		email VARCHAR(30) PRIMARY KEY, 
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		password VARCHAR(50) NOT NULL,
		gender VARCHAR(10),
		country VARCHAR(30),
		telephone VARCHAR(30),
		birthday VARCHAR(25),
		avatar VARCHAR(100)
		)";

		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}

		$sql = "CREATE TABLE Products (
		id INT AUTO_INCREMENT,
		owner_email VARCHAR(30),
		name VARCHAR(50) NOT NULL, 
		price VARCHAR(20) NOT NULL,
		available INT NOT NULL,
		description VARCHAR(700),
		display VARCHAR(100),
		PRIMARY KEY(id, owner_email),
		FOREIGN KEY (owner_email) REFERENCES Members(email)
		)";

		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}
		
		$sql = "CREATE TABLE Members_Buy_Products (
		p_id INT, 
		pname VARCHAR(50),
		price VARCHAR(20),
		display VARCHAR(100),
		owner_email VARCHAR(30),
		buyer_email VARCHAR(30),
		quantity INT NOT NULL
		)";
		
		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}

		$conn->close();		
	}	
	
	create_db();
	create_tables();
    
?>