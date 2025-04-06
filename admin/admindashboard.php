<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #222;
            padding: 15px 0;
        }

        header div {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        header a:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <header>
        <div>
        <a href="add_product.php">Add Product</a>
        <a href="add_to_cart.php">Add to cart</a>
</div>
</header>
</body>
</html>