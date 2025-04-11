<?php
session_start();
require 'db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['UserName']) || !isset($_SESSION['userid'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo "login_required";
    } else {
        header("Location: login.html");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $userid = $_SESSION['userid'];
    $quantity = 1;

    // Check how many of this product are already in the user's cart
    $checkCart = $conn->prepare("SELECT quantity FROM cart WHERE userid = ? AND product_id = ?");
    $checkCart->bind_param("ii", $userid, $product_id);
    $checkCart->execute();
    $cartResult = $checkCart->get_result();
    $cartQuantity = 0;

    if ($row = $cartResult->fetch_assoc()) {
        $cartQuantity = $row['quantity'];
    }

    // Check available stock in product_table
    $checkStock = $conn->prepare("SELECT quantity FROM products WHERE product_id = ?");
    $checkStock->bind_param("i", $product_id);
    $checkStock->execute();
    $stockResult = $checkStock->get_result();

    if ($stockRow = $stockResult->fetch_assoc()) {
        $availableStock = $stockRow['quantity'];

        // If cart quantity already reached stock limit
        if ($cartQuantity >= $availableStock) {
            echo "The product is currently out of stock";
            exit();
        }
    } else {
        echo "Product not found";
        exit();
    }

    $total_price = $price * ($cartQuantity + 1);

    if ($cartQuantity > 0) {
        // Update cart
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1, total_price = total_price + ? WHERE userid = ? AND product_id = ?");
        $update->bind_param("dii", $price, $userid, $product_id);
        $update->execute();
        echo "Cart updated";
    } else {
        // Add new item to cart
        $stmt = $conn->prepare("INSERT INTO cart (userid, product_id, product_name, price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdid", $userid, $product_id, $product_name, $price, $quantity, $total_price);
        $stmt->execute();
        echo "Added to cart";
    }
}
?>
