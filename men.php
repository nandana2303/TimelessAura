<?php
include 'db_connection.php'; // make sure DB connection is available
$sql = "SELECT * FROM products where category='men'";
$result = mysqli_query($conn, $sql);
$products = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                rel="stylesheet">
            <link
                href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
                rel="stylesheet">
    <link rel="stylesheet" href="allpages.css">
    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-5">
    <h2 class="text-center mb-4">All Watches</h2>
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <a href="product.php?id=<?= $product['product_id']; ?>" class="text-decoration-none text-dark">
                            <div class="img-container">
                                <img src="<?= $product['product_image']; ?>" class="card-img-top" alt="Product">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= $product['product_name']; ?></h5>
                            </div>
                        </a>
                        <div class="card-body text-center">
                            <p class="card-text">₹<?= $product['mrp_price']; ?></p>
                            <button class="btn btn-primary add-to-cart"
                                    data-id="<?= $product['product_id']; ?>"
                                    data-name="<?= htmlspecialchars($product['product_name'], ENT_QUOTES); ?>"
                                    data-price="<?= $product['mrp_price']; ?>">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No watches available</p>
        <?php endif; ?>
    </div>
</section>
<?php include 'footer.php'; ?> 
<script
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
               $(document).ready(function () {
    $(".add-to-cart").click(function () {
        const $btn = $(this);
        $btn.prop("disabled", true).text("Adding...");

        var product_id = $btn.data("id");
        var product_name = $btn.data("name");
        var price = $btn.data("price");

        $.post("add_to_cart.php", {
            product_id: product_id,
            product_name: product_name,
            price: price
        }).done(function (response) {
            response = response.trim();

            if (response === "login_required") {
                // Save for after login
                localStorage.setItem("pendingAddToCart", JSON.stringify({
                    product_id: product_id,
                    product_name: product_name,
                    price: price
                }));

                // Wait a bit before redirecting
                setTimeout(() => {
                    window.location.href = "login.html";
                }, 300);
            } else {
                alert(response);
            }
        }).fail(function () {
            alert("Something went wrong. Please try again.");
        }).always(function () {
            $btn.prop("disabled", false).text("Add to Cart");
        });
    });
});

            </script>
            
            <script src="script.js"></script>
            <!-- JavaScript Logic -->
           
            <script>
                // Check if user is logged in using PHP session data
                var isLoggedIn = <?php echo isset($_SESSION['UserName']) ? 'true' : 'false'; ?>;

    window.onload = function () {
        const item = localStorage.getItem("pendingAddToCart");
        if (item) {
            const data = JSON.parse(item);
            $.post("add_to_cart.php", data, function (res) {
                alert(res);
                localStorage.removeItem("pendingAddToCart");
            });
        }
    };
</script>
<script>
    // ✅ Add this function first
    function updateCartCount() {
        console.log("Updating cart count...");
        $.get("cartcount.php", function (count) {
            console.log("Cart count received:", count);
            $("#cart-count").text(count);
        });
    }

    // ✅ Then your main code
    $(document).ready(function () {
        updateCartCount(); // Load count on page load

        $(document).on("click", ".add-to-cart", function () {
            const $btn = $(this);
            $btn.prop("disabled", true).text("Adding...");

            var product_id = $btn.data("id");
            var product_name = $btn.data("name");
            var price = $btn.data("price");

            $.post("add_to_cart.php", {
                product_id: product_id,
                product_name: product_name,
                price: price
            }).done(function (response) {
    response = response.trim();
    
    if (response === "login_required") {
        localStorage.setItem("pendingAddToCart", JSON.stringify({
            product_id: product_id,
            product_name: product_name,
            price: price
        }));
        setTimeout(() => {
            window.location.href = "login.html";
        }, 300);
    } else if (response === "out_of_stock") {
        alert("Currently out of stock");
    } else {
        alert(response);
        updateCartCount(); // ✅ Update cart count after successful add
    }
})
.fail(function () {
    alert("Something went wrong. Please try again.");
})
.always(function () {
    $btn.prop("disabled", false).text("Add to Cart");
});

    });

    });
    $(document).ready(function () {
    $(".add-to-cart").click(function () {
        const productId = $(this).data("id");
        const productName = $(this).data("name");
        const productPrice = $(this).data("price");

        $.ajax({
            url: "add_to_cart.php",
            type: "POST",
            data: {
                id: productId,
                name: productName,
                price: productPrice
            },
            success: function (response) {
                // Optionally parse JSON response
                const res = JSON.parse(response);
                if (res.status === "success") {
                    // Update cart count on navbar
                    $("#cart-count").text(res.count);
                }
            }
        });
    });
});

</script>
</body>
</html>