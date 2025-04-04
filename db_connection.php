<?php
$servername = "127.0.0.1"; 
$username = "root";       
$password = ""; 
$port="3307"; 
$database = "timelessdb";    
// Create connection
$conn = new mysqli($servername, $username, $password, $port, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
