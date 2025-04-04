<?php
session_start();
include 'db_connection.php'; // Ensure this file connects to logindb

if (isset($_SESSION['email'])) { // ✅ Checking if user email is stored in session
    $email = $_SESSION['email'];
    
    $query = "SELECT name FROM registeration WHERE email = ?"; // Fetch user by email
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    
    echo json_encode(['name' => $name]); // ✅ Return name in JSON format
} else {
    echo json_encode(['name' => "Guest"]); // If not logged in, return Guest
}
?>
