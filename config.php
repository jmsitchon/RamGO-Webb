<?php
$host = 'localhost';
$dbname = 'ramgo';
$username = 'root';  // Default XAMPP user
$password = '';      // Default XAMPP password (empty)

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
