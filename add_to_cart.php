<?php
// Redirect if user not logged in
session_start();
require 'db_connection.php';

// If user is not logged in
if (!isset($_SESSION['userid'])) {
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
    $total_price = $price * $quantity;

    // Check if product already exists in cart
    $check = $conn->prepare("SELECT * FROM cart WHERE userid = ? AND product_id = ?");
    $check->bind_param("ii", $userid, $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update quantity and total_price
        $conn->query("UPDATE cart SET quantity = quantity + 1, total_price = total_price + $price WHERE userid = $userid AND product_id = $product_id");
        echo "Cart updated";
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (userid, product_id, product_name, price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdid", $userid, $product_id, $product_name, $price, $quantity, $total_price);
        $stmt->execute();
        echo "Added to cart";
    }
}
?>
