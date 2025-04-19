<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}
?>
<?php
include '../db_connection.php'; // Your DB connection script

$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$transactionTotals = array_fill(0, 12, 0);
$orderCounts = array_fill(0, 12, 0);
$paymentMethods = [];

// 1. Monthly total_amount from orders
$totalQuery = "SELECT MONTH(order_date) AS month, SUM(total_amount) AS total FROM orders GROUP BY MONTH(order_date)";
$totalResult = mysqli_query($conn, $totalQuery);
while ($row = mysqli_fetch_assoc($totalResult)) {
    $transactionTotals[$row['month'] - 1] = (float)$row['total'];
}

// 2. Monthly order count
$countQuery = "SELECT MONTH(order_date) AS month, COUNT(*) AS count FROM orders GROUP BY MONTH(order_date)";
$countResult = mysqli_query($conn, $countQuery);
while ($row = mysqli_fetch_assoc($countResult)) {
    $orderCounts[$row['month'] - 1] = (int)$row['count'];
}

// 3. Payment method breakdown
$methodQuery = "SELECT payment_method, COUNT(*) as count FROM transactions WHERE payment_status = 'Success' GROUP BY payment_method";
$methodResult = mysqli_query($conn, $methodQuery);
while ($row = mysqli_fetch_assoc($methodResult)) {
    $paymentMethods[$row['payment_method']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        .charts-container {
    width: 90%;
    max-width: 1000px;
    background: white;
    padding: 30px;
    margin-top: 40px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.chart-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.chart-row.center {
    justify-content: center;
}

.chart-box {
    flex: 1;
    min-width: 300px;
    max-width: 48%;
}

.chart-box.pie {
    max-width: 250px;
    height: 250px;
}


    </style>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <header>
        <div>
        <a href="add_product.php">ADD PRODUCT</a>
        <a href="view_products.php">VIEW PRODUCT</a>
        <a href="users.php">USERS</a>
        <a href="view_orders.php">ORDERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>
<center><h1>Welcome Admin</h1></center>

<div class="charts-container">
    <div class="chart-row">
        <div class="chart-box">
            <canvas id="transactionChart"></canvas>
        </div>
        <div class="chart-box">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
    <div class="chart-row center">
        <div class="chart-box pie">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
</div>



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
<script>
    const months = <?php echo json_encode($months); ?>;
    const transactionData = <?php echo json_encode($transactionTotals); ?>;
    const ordersData = <?php echo json_encode($orderCounts); ?>;
    const paymentLabels = <?php echo json_encode(array_keys($paymentMethods)); ?>;
    const paymentCounts = <?php echo json_encode(array_values($paymentMethods)); ?>;
</script>
<script>
// Transaction (Line)
new Chart(document.getElementById('transactionChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Monthly Revenue (₹)',
            data: transactionData,
            borderColor: '#2b3a55',
            backgroundColor: 'rgba(43, 58, 85, 0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Total Transaction Amount (Monthly)'
            }
        }
    }
});

// Orders (Bar)
new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Orders Placed',
            data: ordersData,
            backgroundColor: '#2b3a55'
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Total Orders Placed (Monthly)'
            }
        }
    }
});

// Payment Method (Pie)
new Chart(document.getElementById('paymentChart'), {
    type: 'pie',
    data: {
        labels: paymentLabels,
        datasets: [{
            label: 'Payment Method Breakdown',
            data: paymentCounts,
            backgroundColor: ['#2b3a55', '#5584AC', '#A3C7D6', '#F8F6E3']
        }]
    },
    options: {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
        title: {
            display: true,
            text: 'Payment Method Distribution'
        }
    }
}

});
</script>


</body>

</html>