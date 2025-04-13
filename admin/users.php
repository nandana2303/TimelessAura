<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

require '../db_connection.php';

// Delete user if delete button is clicked
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM registration WHERE userid = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: users.php"); // Refresh page after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f0f0f0;
        }

        .action-buttons a {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h2>Registered Users</h2>

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

</body>
</html>
