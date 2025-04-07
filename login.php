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
    $email = $_POST['Email'];
    $pass = $_POST['Password'];

    // Query to fetch user data
    $sql = "SELECT userid, Name, Password FROM registration WHERE Email = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['userid'] = $user['userid']; // Store user ID for cart & orders
        $_SESSION['Email'] = $email;
        $_SESSION['UserName'] = $user['Name']; // Store user's name for navbar

        header("Location: index.php");
        exit();
    } else {
        echo "<script>
            var register = confirm('User not found or incorrect password! Do you want to register?');
            if (register) {
                window.location.href = 'register.html';
            } else {
                window.location.href = 'login.html';
            }
        </script>";
        exit();
    }
}
?>
<script>
    <script>
    // After login, check if there's a pending item
    const item = localStorage.getItem("pendingAddToCart");
    if (item) {
        const product = JSON.parse(item);

        // Send to add_to_cart.php
        $.post("add_to_cart.php", {
            product_id: product.product_id,
            product_name: product.product_name,
            price: product.price
        }, function (response) {
            alert("Item added to cart after login!");
            localStorage.removeItem("pendingAddToCart"); // clean up
            window.location.href = "index.php"; // or wherever you want to send them
        });
    }
</script>

