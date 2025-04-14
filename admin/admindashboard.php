<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
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

    </style>
   
</head>
<body>
    <header>
        <div>
        <a href="add_product.php">ADD PRODUCT</a>
        <a href="view_products.php">VIEW PRODUCT</a>
        <a href="users.php">USERS</a>
        <a href="adminlogout.php" id="logoutBtn">Logout</a>
</div>
</header>
<center><h1>Welcome Admin</h1><center>
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

</body>

</html>