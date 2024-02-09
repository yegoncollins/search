<?php
$servername = "localhost"; // or your MySQL server address
$username = "root"; // your MySQL username
$password = "Yegon#236"; // your MySQL password
$database = "search_data"; // your MySQL database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// // Close connection
// $conn->close();
?>
