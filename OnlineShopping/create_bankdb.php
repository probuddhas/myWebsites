<?php
	$servername="localhost";
	$dbusername="root";
	$dbpassword="";
	$dbname="shopping";
	$conn=new mysqli($servername,$dbusername,$dbpassword,$dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql="CREATE TABLE bank (
	cardno VARCHAR(50) NOT NULL PRIMARY KEY,
	pin VARCHAR(50),
	bankname VARCHAR(50),
	amount BIGINT
	) ENGINE MyISAM";
	if ($conn->query($sql) === TRUE) {
    echo "bank Table created successfully <br>";
	} 
	else {
    echo "Error creating bank table: " . $conn->error;
	}

$conn->close();
?>