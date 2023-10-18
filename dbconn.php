<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sunshine_db';

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
