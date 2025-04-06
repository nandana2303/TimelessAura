<?php
session_start();
$host = "127.0.0.1"; // Use 127.0.0.1 instead of localhost
$port = "3307"; // Change to 3308 if necessary
$dbname = "timelessdb";
$username = "root";
$password = "";

// Database connection
$conn = mysqli_connect($host, $username, $password, $dbname, $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminEmail = $_POST['adminEmail'];
$adminPassword = $_POST['adminPassword'];

    // Query to fetch user data
    $sql = "SELECT userid, Name, Password FROM admin WHERE Email = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param("ss", $adminEmail, $adminPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['userid'] = $user['userid']; // Store user ID for cart & orders
        $_SESSION['Email'] = $adminEmail;
        $_SESSION['UserName'] = $user['Name']; // Store user's name for navbar

        header("Location: admindashboard.php");
        exit();
    } else {
        echo "<script>
            var register = confirm('User not found or incorrect password! Do you want to register?');
            if (register) {
                window.location.href = 'adminregister.html';
            } else {
                window.location.href = 'adminlogin.html';
            }
        </script>";
        exit();
    }
}
?>
