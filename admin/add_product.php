<?php
require '../db_connection.php'; // Ensure this file contains your database connection code
$ip_address = "http://127.0.0.1/javaproject/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting input data
    $product_name = $_POST['product_name'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $product_image = $_FILES['product_image']['name'] ?? '';
    $mrp_price = $_POST['mrp_price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;
    
    // Validate input
    if (empty($product_name) || empty($brand) || empty($mrp_price) || empty($quantity)) {
        die("All fields are required except description and image.");
    }
    
    // Handle image upload
    $image_url = "";
    if (!empty($product_image)) {
        $target_dir = "../watches/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if not exists
        }
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_url = $ip_address . "watches/" . $product_image; // Store the relative path
        }
    }
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO products (product_name, brand, category, description, product_image, mrp_price, quantity) VALUES (?, ?,? , ?, ?, ?, ?)");
    $stmt->bind_param("sssssdi", $product_name, $brand, $category, $description, $image_url, $mrp_price, $quantity);
    
    // Execute statement
    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" required><br>
        
        <label for="brand">Brand:</label>
        <input type="text" name="brand" required><br>

        <label for="category">Category:</label>
        <input type="text" name="category" required><br>
        
        <label for="description">Description:</label>
        <textarea name="description"></textarea><br>
        
        <label for="product_image">Product Image:</label>
        <input type="file" name="product_image"><br>
        
        <label for="mrp_price">MRP Price:</label>
        <input type="number" name="mrp_price" required><br>
        
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
