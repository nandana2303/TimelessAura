<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}
require '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        

        .product-table-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 14px 16px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f1f1f1;
            color: #333;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        img {
            border-radius: 6px;
            max-height: 60px;
        }

        .btn-edit {
            background-color: #0d6efd;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-edit:hover {
            background-color: #0b5ed7;
        }
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #f0f4ff, #eaf6ff);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #2b3a55;
            width: 100%;
            padding: 15px 0;
        }

        header div {
            display: flex;
            justify-content: center;
            gap: 40px;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 17px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        header a:hover {
            background-color: #435b78;
        }

    </style>
</head>
<body>
<header>
        <div>
        <a href="admindashboard.php">HOMEPAGE</a>
        <a href="add_product.php">ADD PRODUCT</a>
        <a href="users.php">USERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>
<div class="container product-table-container">
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['product_id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['brand']}</td>
                <td>₹{$row['mrp_price']}</td>
                <td>{$row['quantity']}</td>
                <td><img src='{$row['product_image']}' alt='Product Image'></td>
                <td><a class='btn-edit' href='edit_products.php?id={$row['product_id']}'>Edit</a></td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent immediate redirection
            let confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = "adminlogout.php"; // Redirect if confirmed
            }
        });
    }
});
</script>
</body>
</html>
