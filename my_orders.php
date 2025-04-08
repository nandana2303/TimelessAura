<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['userid'])) {
    echo "You must be logged in to view your orders.";
    exit;
}

$userid = $_SESSION['userid'];

$orders = mysqli_query($conn, "SELECT * FROM orders WHERE userid = '$userid' ORDER BY order_date DESC");

if (!$orders) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'navbar.php'; ?>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">My Orders</h2>

    <?php
    if (mysqli_num_rows($orders) === 0) {
        echo "<div class='alert alert-info'>You have no orders yet.</div>";
    } else {
        while ($order = mysqli_fetch_assoc($orders)) {
            // Format date to DD-MM-YYYY
            $formattedDate = date("d-m-Y", strtotime($order['order_date']));
            ?>
            <div class="card mb-3 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Order #<?= htmlspecialchars($order['order_id']) ?></h5>
                <p class="card-text">
                  <strong>Total:</strong> ₹<?= number_format($order['total_amount'], 2) ?><br>
                  <strong>Date:</strong> <?= $formattedDate ?>
                </p>
                <!-- <a href="order_details.php?order_id=<?= urlencode($order['order_id']) ?>" class="btn btn-primary btn-sm">View Details</a> -->
              </div>
            </div>
            <?php
        }
    }
    ?>
  </div>
</body>
</html>
