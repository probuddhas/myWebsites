<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE shopping";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully <br>";
} else {
    echo "Error creating database: " . $conn->error;
}

$sql="USE shopping";
if ($conn->query($sql) === TRUE) {
    echo "Database selected successfully <br>";
} else {
    echo "Error selecting database: " . $conn->error;
}

$sql="CREATE TABLE users (
id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
uname VARCHAR(30),
pwd VARCHAR(30),
name VARCHAR(128),
email VARCHAR(50),
addr VARCHAR(300),
sex VARCHAR(10),
dob DATE,
mob VARCHAR(12),
bankname VARCHAR(128),
cardno VARCHAR(128),
pin VARCHAR(30)
) ENGINE MyISAM";
if ($conn->query($sql) === TRUE) {
    echo "users Table created successfully <br>";
} else {
    echo "Error creating users table: " . $conn->error;
}

$sql="CREATE TABLE stock (
pid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
pname VARCHAR(150),
pdesc VARCHAR(2000),
price INT UNSIGNED,
ptype VARCHAR(50),
pstock INT UNSIGNED
) ENGINE MyISAM";
if ($conn->query($sql) === TRUE) {
    echo "stock Table created successfully <br>";
} else {
    echo "Error creating stock table: " . $conn->error;
}

$cmd="md pimages";
exec($cmd, $output, $status);
echo "pimages directory created<br>";


$sql="CREATE TABLE cart (
uid INT UNSIGNED,
pid INT UNSIGNED,
qty INT UNSIGNED
) ENGINE MyISAM";
if ($conn->query($sql) === TRUE) {
    echo "cart Table created successfully <br>";
} else {
    echo "Error creating cart table: " . $conn->error;
}

$sql="CREATE TABLE orders (
oid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
uid INT UNSIGNED,
pid INT UNSIGNED,
qty INT UNSIGNED,
status VARCHAR(5)
) ENGINE MyISAM";
if ($conn->query($sql) === TRUE) {
    echo "orders Table created successfully <br>";
} else {
    echo "Error creating orders table: " . $conn->error;
}

$conn->close();
?>


</body>
</html>