<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #222;
            padding: 15px 0;
        }

        header div {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        header a:hover {
            background-color: #444;
        }
    </style>
   
</head>
<body>
    <header>
        <div>
        <a href="products.php">Products</a>
        <a href="add_product.php">Add Product</a>
        <a href="add_to_cart.php">Add to cart</a>
        <a href="users.php">Users</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>
<center><h1>Welcome Admin</h1><center>
<script>
document.getElementById("logoutBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent immediate redirection
        let confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            window.location.href = "adminlogout.php"; // Redirect if confirmed
        }
    });
    </script>

</body>

</html>