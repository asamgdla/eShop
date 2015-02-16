<?php
	$servername = "localhost";
	$username = "root";
	$password = "Saruman1";
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
		avatar blob
		)";

		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}

		$sql = "CREATE TABLE Products (
		name VARCHAR(30) PRIMARY KEY, 
		price INT NOT NULL,
		available INT NOT NULL,
		display blob
		)";

		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}

		$sql = "CREATE TABLE Members_Buy_Products (
		p_name VARCHAR(30), 
		m_email VARCHAR(30),
		quantity INT NOT NULL,
		PRIMARY KEY(p_name,m_email),
		FOREIGN KEY (p_name) REFERENCES Products(name),
		FOREIGN KEY (m_email) REFERENCES Members(email)
		)";

		if (mysqli_query($conn, $sql)) {
			echo "Table created successfully"."<br>";
		}

		$conn->close();		
	}
	
	
	function insert_members(String email, String firstname, String lastname, String password, ) { 

		global $servername, $username, $password, $dbname;
		// Step 1: Create Connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		$sql = "INSERT INTO Members (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		}
		$conn->close();
	}
	
	function insert_products() {
	
	}
	
	function insert_members_buy_products() {
	
	}

	
	create_db();
	create_tables();


?>