<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}

$product = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE product_id = $id");
    $product = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $brand = $_POST['brand'];
    $price = $_POST['mrp_price'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, brand=?, mrp_price=?, quantity=? WHERE product_id=?");
    $stmt->bind_param("ssdii", $name, $brand, $price, $quantity, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully.'); window.location.href = 'view_products.php';</script>";
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ..edit-form-container {
    background: #ffffff;
    max-width: 600px;
    margin: 30px auto;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
}

h2 {
    text-align: center;
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: 600;
}

label {
    font-weight: 600;
    margin-top: 15px;
    display: block;
    font-size: 16px;
    color: #555;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    color: #333;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus {
    border-color: #0d6efd;
    background-color: #fff;
    box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
    outline: none;
}

.btn-update {
    background-color: #0d6efd;
    color: white;
    border: none;
    padding: 12px 20px;
    margin-top: 25px;
    border-radius: 8px;
    width: 100%;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-update:hover {
    background-color: #0b5ed7;
    transform: translateY(-2px);
}

.btn-update:active {
    transform: translateY(0);
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
        <a href="view_products.php">VIEW PRODUCTS</a>
        <a href="users.php">USERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>

<div class="edit-form-container">
    <h2>Edit Product</h2>
    <?php if ($product): ?>
    <form method="post">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
        
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required>

        <label>Brand:</label>
        <input type="text" name="brand" value="<?= $product['brand'] ?>" required>

        <label>Price:</label>
        <input type="number" name="mrp_price" value="<?= $product['mrp_price'] ?>" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" required>

        <button type="submit" class="btn-update">Update Product</button>
    </form>
    <?php else: ?>
        <p style="text-align:center;">Product not found.</p>
    <?php endif; ?>
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
