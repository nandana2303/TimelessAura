<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}
require '../db_connection.php';
$ip_address = "http://127.0.0.1/javaproject/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $product_image = $_FILES['product_image']['name'] ?? '';
    $mrp_price = $_POST['mrp_price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;

    if (empty($product_name) || empty($brand) || empty($mrp_price) || empty($quantity)) {
        die("All fields are required except description and image.");
    }

    $image_url = "";
    if (!empty($product_image)) {
        $target_dir = "../watches/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_url = $ip_address . "watches/" . $product_image;
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (product_name, brand, category, description, product_image, mrp_price, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdi", $product_name, $brand, $category, $description, $image_url, $mrp_price, $quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully.');window.location.href='view_products.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="../jquery-3.7.1.min.js"></script>
    <style>
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

        h2 {
            margin-top: 30px;
            font-size: 28px;
            color: #2b3a55;
        }

        form {
            background: #ffffff;
            padding: 30px;
            margin: 20px auto;
            width: 450px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
            font-weight: 500;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        form textarea {
            resize: vertical;
        }

        form button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #2b3a55;
            color: #fff;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        form button:hover {
            background-color: #3e5271;
        }
    </style>
</head>
<body>
<header>
        <div>
        <a href="admindashboard.php">HOME</a>
        <a href="view_products.php">VIEW PRODUCT</a>
        <a href="users.php">USERS</a>
        <a href="view_orders.php">ORDERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>

<h2 id="addProductHeading" style="display:none;">ADD PRODUCT</h2>

<form action="add_product.php" method="post" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required>

    <label for="brand">Brand:</label>
    <input type="text" name="brand" required>

    <label for="category">Category:</label>
    <input type="text" name="category" required>

    <label for="description">Description:</label>
    <textarea name="description" rows="3"></textarea>

    <label for="product_image">Product Image:</label>
    <input type="file" name="product_image">

    <label for="mrp_price">MRP Price:</label>
    <input type="number" name="mrp_price" required step="0.01" min="0">

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required min="0">

    <button type="submit">Add Product</button>
</form>

<script>
  $(document).ready(function() {
    $('#addProductHeading').fadeIn(1500);
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function(event) {
            event.preventDefault(); 
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
