<?php
$servername = 'db'; // Service name defined in Docker Compose
$username = 'user1'; // Your MySQL username
$password = '123456'; // Your MySQL password
$dbname = 'db1'; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>