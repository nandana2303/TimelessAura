<?php
$servername = "127.0.0.1"; 
$username = "root";       
$password = ""; 
$database = "timelessdb";    
$port = 3307; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
