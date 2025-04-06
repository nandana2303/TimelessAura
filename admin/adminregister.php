<?php
session_start();
$host = "127.0.0.1"; // Use 127.0.0.1 instead of localhost
$port = "3307"; // Use 3308 if needed
$dbname = "timelessdb";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = ($_POST['Name']);
    $email = ($_POST['Email']);
    $pass = ($_POST['Password']); // Storing password as plain text (not recommended)
    // To check if email already exists
    $check_sql = "SELECT * FROM admin WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email already exists! Choose a different Email.');
                window.location.href = 'adminregister.html';
              </script>";
        exit();
    }
    
    // Insert into database
    $sql = "INSERT INTO admin (Name,  Email, Password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please log in.');
                window.location.href = 'adminlogin.html';
              </script>";
    } else {
        echo "<script>
                alert('Registration failed! Try again.');
                window.location.href = 'admiregister.html';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>