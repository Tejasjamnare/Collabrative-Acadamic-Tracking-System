<?php
$host = "localhost";
$username = "root";
$password = '';  // Set password if required
$database = "education_platform";
$port = 3306; // Your MySQL port

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
