<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}

require '../db_connection.php';

// Delete user
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM registration WHERE userid = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: users.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
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

        h2 {
            text-align: center;
            margin: 40px 0 20px;
            font-size: 32px;
            color: #333;
        }

        .table-container {
            width: 90%;
            max-width: 1000px;
            overflow-x: auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
            color: #444;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .action-buttons a {
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-right: 5px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        @media (max-width: 600px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }

            h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
<header>
        <div>
        <a href="admindashboard.php">HOME</a>
        <a href="add_product.php">ADD PRODUCT</a>
        <a href="view_products.php">VIEW PRODUCT</a>
        <a href="view_orders.php">ORDERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>
<h2>Registered Users</h2>

<div class="table-container">
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM registration");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['userid']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Email']}</td>
                <td class='action-buttons'>
                    <a href='users.php?delete={$row['userid']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function(event) {
            event.preventDefault(); 
            let confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = "adminlogout.php"; 
            }
        });
    }
});
</script>
</body>
</html>

