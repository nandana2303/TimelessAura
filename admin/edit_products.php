<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
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
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
        }

        .edit-form-container {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            margin-top: 12px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn-update {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 25px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-update:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

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

</body>
</html>
