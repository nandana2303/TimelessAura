<?php
session_start();
$host = "127.0.0.1";
$port = "3307";
$dbname = "timelessdb";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $pass = $_POST['Password'];

    // Check if email already exists
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

    // Insert new admin
    $sql = "INSERT INTO admin (Name, Email, Password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);
    
    if ($stmt->execute()) {
        // ✅ Set session variables for admin
        $_SESSION['admin_id'] = $stmt->insert_id; // Gets the auto-incremented ID
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_name'] = $name;

        echo "<script>
                alert('Registration successful!');
                window.location.href = 'adminlogin.html';
              </script>";
    } else {
        echo "<script>
                alert('Registration failed! Try again.');
                window.location.href = 'adminregister.html';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
