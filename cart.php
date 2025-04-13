<?php
session_start();
require 'db_connection.php';

$userid = $_SESSION['userid']; // fallback user ID for testing
$_SESSION['from_cart'] = true;
if(!isset($userid)){
    echo '       <script>alert("Please login to view cart");window.location.href ="login.html" </script>';
}

// Updated table and column names
$sql = "SELECT c.*, p.product_name, p.product_image 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.userid = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $row_total = $row['price'] * $row['quantity'];
    $row['total'] = $row_total;
    $cart_items[] = $row;
    $total_price += $row_total;
}

//remove cart item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE userid = ? AND product_id = ?");
    $stmt->bind_param("ii", $userid, $remove_product_id);
    $stmt->execute();

    // Refresh the page to reflect changes
    header("Location: cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="script.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <style>
        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-item img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .cart-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Your Shopping Cart</h2>

    <?php if (count($cart_items) > 0): ?>
        <?php foreach ($cart_items as $item): ?>
            <form id="checkoutForm" action="checkout.php" method="post" style="display: none;">
                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['product_name'], ENT_QUOTES) ?>">
                    <input type="hidden" name="price" value="<?= $item['mrp_price'] ?>">
                </form>
            <div class="row cart-item align-items-center">
                <div class="col-md-2">
                    <img src="<?= htmlspecialchars($item['product_image']) ?>" alt="Product Image">
                </div>
                <div class="col-md-6">
                    <h5><?= htmlspecialchars($item['product_name']) ?></h5>
                    <div class="d-flex align-items-center">
    <button class="btn btn-outline-secondary btn-sm quantity-decrease" data-id="<?= $item['product_id'] ?>">−</button>
    <span class="mx-2 quantity" id="qty-<?= $item['product_id'] ?>"><?= $item['quantity'] ?></span>
    <button class="btn btn-outline-secondary btn-sm quantity-increase" data-id="<?= $item['product_id'] ?>">+</button>
</div>

                    <p class="text-muted">Price: ₹<?= number_format($item['price'], 2) ?></p>
                    <form method="post" class="d-inline">
                <input type="hidden" name="remove_product_id" value="<?= $item['product_id'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger ms-2" title="Remove from Cart">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </form>
                </div>
                <div class="col-md-4 text-end">
                    <strong>₹<?= number_format($item['total'], 2) ?></strong>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-6">
                <div class="cart-summary">
                    <h4>Total: ₹<?= number_format($total_price, 2) ?></h4>
                    <button onclick="handleBuyNow()" class="btn btn-primary w-100 mt-3">Proceed to Checkout</button>
                </div>
            </div>
        </div>
        <script>
            var isLoggedIn = <?php echo isset($_SESSION['UserName']) ? 'true' : 'false'; ?>;
            function handleBuyNow() {
                if (!isLoggedIn) {
                    window.location.href = "login.html";
                    return;
                }

                document.getElementById("checkoutForm").submit();
            }
        </script>
    

    <?php else: ?>
        <p class="text-muted">Your cart is empty. </p>
    <?php endif; ?>

</div>
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
        updateCartCount();
        // Handle + and - quantity buttons
$(document).on("click", ".quantity-increase", function () {
    const productId = $(this).data("id");
    updateQuantity(productId, 1);
});

$(document).on("click", ".quantity-decrease", function () {
    const productId = $(this).data("id");
    updateQuantity(productId, -1);
});
 // Load count on page load

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
  
    function updateQuantity(productId, change) {
        fetch('update_cart_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, change: change })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.action === 'removed') {
                    updateCartCount(); // 👈 Update cart count
                    location.reload();
                } else {
                    document.getElementById('qty-' + productId).textContent = data.new_quantity;
                    updateCartCount(); // 👈 Update cart count
                    location.reload(); // Optional, for total price
                }
            } else {
                alert(data.message || 'Update failed');
            }
        });
    }

</script>
</body>
</html>
