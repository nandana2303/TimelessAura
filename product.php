<?php
session_start();
require 'db_connection.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Product Details | TimelessAura</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap + Remixicon -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
            rel="stylesheet">
        <link rel="stylesheet" href="index.css">
    </head>
    <body>

        <?php include 'navbar.php'; ?>

        <div class="container my-5">
            <?php if ($product): ?>
            <div class="row">
                <div class="col-md-6 text-center">
                <form id="checkoutForm" action="checkout.php" method="post" style="display: none;">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name'], ENT_QUOTES) ?>">
                    <input type="hidden" name="price" value="<?= $product['mrp_price'] ?>">
                </form>

                    <img
                        src="<?= $product['product_image'] ?>"
                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                        class="img-fluid"
                        style="max-height: 500px;">
                </div>
                <div class="col-md-6">
                    <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                    <p class="lead text-muted">₹<?= $product['mrp_price'] ?></p>
                    <p>
                        <strong>Brand:</strong>
                        <?= htmlspecialchars($product['brand'] ?? 'N/A') ?></p>
                    <p>
                        <strong>Description:</strong>
                        <?= htmlspecialchars($product['description'] ?? 'No description available.') ?></p>

                    <div class="d-flex align-items-center mt-4">
                        <button
                            class="btn btn-primary me-3 add-to-cart"
                            data-id="<?= $product['product_id'] ?>"
                            data-name="<?= htmlspecialchars($product['product_name'], ENT_QUOTES) ?>"
                            data-price="<?= $product['mrp_price'] ?>">Add to Cart</button>
                        <button class="btn btn-success" onclick="handleBuyNow()">Buy Now</button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h3 class="text-center text-danger">Product not found</h3>
            <?php endif; ?>
        </div>

        <?php include 'footer.php'; ?>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="jquery-3.7.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".add-to-cart").click(function () {
                    var product_id = $(this).data("id");
                    var product_name = $(this).data("name");
                    var price = $(this).data("price");
                    $.post("add_to_cart.php", {
    product_id: product_id,
    product_name: product_name,
    price: price
}, function (response) {
    alert(response);
    // ✅ Redirect to cart page after successful add
    if (response.includes("Added") || response.includes("updated")) {
        window.location.href = "cart.php"; // Or whatever your cart page is
    }
});
                });
            });

            var isLoggedIn = <?php echo isset($_SESSION['UserName']) ? 'true' : 'false'; ?>;
            function handleBuyNow() {
                if (!isLoggedIn) {
                    window.location.href = "login.html";
                    return;
                }

                document.getElementById("checkoutForm").submit();
            }
        </script>
    </body>
</html>