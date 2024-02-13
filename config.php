<?php
$servername = "localhost";
$username = "root";
$password = "Yegon#236";
$database = "search_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

}

// Close connection (not necessary if you plan to execute queries later)
//$conn->close();
?>
