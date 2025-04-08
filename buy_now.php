<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['userid'])) {
    die("You must be logged in to proceed.");
}

$userid = $_SESSION['userid'];

// Get address & payment method
$shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
$from_cart = $_POST['from_cart'] ?? 'false';

$cart_items = [];
$total_amount = 0;


 if ($from_cart === 'true') {
    // Normal Cart Checkout
    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE userid = $userid");
    

    if (mysqli_num_rows($cart_query) == 0) {
        die("Your cart is empty!");
    }

    while ($row = mysqli_fetch_assoc($cart_query)) {
        $cart_items[] = $row;
        $total_amount += $row['total_price'];
    }
} else { //check if it is from product.php
    $product_ids = $_POST['product_id'];
    $product_names = $_POST['product_name'];
    $prices = $_POST['price'];

    foreach ($product_ids as $index => $pid) {
        $pid = intval($pid);
        $pname = mysqli_real_escape_string($conn, $product_names[$index]);
        $price = floatval($prices[$index]);

        $cart_items[] = [
            'product_id' => $pid,
            'product_name' => $pname,
            'quantity' => 1, // Buy Now is always 1
            'total_price' => $price
        ];
        $total_amount += $price;
    }
}

// Insert into orders table
$order_insert = mysqli_query($conn, "INSERT INTO orders (userid, total_amount, shipping_address) 
    VALUES ($userid, $total_amount, '$shipping_address')");

if (!$order_insert) {
    die("Failed to create order.");
}

$order_id = mysqli_insert_id($conn);

// Insert into order_items table
foreach ($cart_items as $item) {
    $pid = intval($item['product_id']);
    $pname = mysqli_real_escape_string($conn, $item['product_name']);
    $qty = intval($item['quantity']);
    $subtotal = floatval($item['total_price']);

    $item_insert = mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, product_name, quantity, subtotal)
        VALUES ($order_id, $pid, '$pname', $qty, $subtotal)");

    if (!$item_insert) {
        die("Failed to insert order item.");
    }
}

// Insert into transactions
$payment_status = 'success'; // Make this dynamic later
$transaction_insert = mysqli_query($conn, "INSERT INTO transactions (order_id, payment_method, payment_status)
    VALUES ($order_id, '$payment_method', '$payment_status')");

if (!$transaction_insert) {
    die("Failed to create transaction.");
}

// Decrease the product quantity from inventory
foreach ($cart_items as $item) {
    $pid = intval($item['product_id']);
    // $pname = mysqli_real_escape_string($conn, $item['product_name']);
    $qty = intval($item['quantity']);

    $update_stock = mysqli_query($conn, "UPDATE products SET quantity = quantity - $qty WHERE product_id = $pid");

}

if (!$update_stock) {
    die("Order placed but failed to update product stock.");
}


// Clear the cart only if it's NOT a Buy Now
if ($from_cart === 'true') {
    $clear_cart = mysqli_query($conn, "DELETE FROM cart WHERE userid = $userid");
    $_SESSION['from_cart'] = false;

    if (!$clear_cart) {
        die("Order placed but failed to clear cart.");
    }
}

// Success message
header("Location: payment_success.php?order_id=$order_id");
die();
?>
