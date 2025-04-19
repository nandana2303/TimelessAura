<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}
include '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #f0f4ff, #eaf6ff);
        }

        header {
            background-color: #2b3a55;
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
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2b3a55;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<header>
    <div>
    <a href="admindashboard.php">HOME</a>
        <a href="add_product.php">ADD PRODUCT</a>
        <a href="view_products.php">VIEW PRODUCT</a>
        <a href="users.php">USERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
    </div>
</header>

<h2>All Orders</h2>

<table>
    <tr>
        <th>User Name</th>
        <th>User ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Order Date</th>
    </tr>

<?php
$query = "
SELECT r.name AS username, o.userid, p.product_name, oi.quantity, o.order_date
FROM orders o
JOIN registration r ON o.userid = r.userid
JOIN order_items oi ON o.order_id = oi.order_id
JOIN products p ON oi.product_id = p.product_id
ORDER BY o.order_date DESC
";


$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['userid']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['order_date']}</td>
      </tr>";

          }
              }
                    else {
    echo "<tr><td colspan='5'>No orders found.</td></tr>";
}
?>

</table>

<script>
document.getElementById("logoutBtn").addEventListener("click", function(e) {
    e.preventDefault();
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "adminlogout.php";
    }
});
</script>

</body>
</html>
