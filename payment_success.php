<?php
session_start();
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success | TimelessAura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1 class="text-success">🎉 Payment Successful!</h1>
        <p>Your order #<?= $order_id ?> has been placed successfully.</p>
        <a href="my_orders.php" class="btn btn-primary mt-3">View My Orders</a>
    </div>
</body>
</html>
