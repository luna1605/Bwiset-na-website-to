<?php
// Database configuration
$host = 'localhost'; // or the IP address of your database server
$username = 'root'; // default username for WAMP
$password = ''; // default password for WAMP is blank
$database = 'Aid_Alert'; // name of your database

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Connection successful
    // You can echo or log this message for debugging
    // echo "Connected successfully to the database.";
}
?>
