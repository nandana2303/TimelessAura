<?php session_start();?>
    <?php
    require 'db_connection.php'; // Ensure database connection

    // Fetch 10 random products
    $sql = "SELECT product_id, product_name, product_image, mrp_price FROM products ORDER BY RAND() LIMIT 10";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    $conn->close();
    ?>
    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>TimelessAura</title>

            <!-- Bootstrap CSS -->
            <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                rel="stylesheet">
            <link
                href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
                rel="stylesheet">
            <link rel="stylesheet" href="index.css">
            <script src="jquery-3.7.1.min.js"></script>
            
        </head>

        <body>

        <?php include 'navbar.php'?>

            <!-- Carousel -->
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./assets/img1.webp" class="d-block w-100" alt="Featured Product 1">
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/img2.webp" class="d-block w-100" alt="Featured Product 2">
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/img5.webp" class="d-block w-100" alt="Featured Product 3">
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/img3.webp" class="d-block w-100" alt="Featured Product 4">
                    </div>
                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExampleFade"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExampleFade"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div><br>
            <div class="box">
                <img
                    src="./assets/for-women-feb25.webp"
                    alt="for her"
                    width="750px"
                    height="350px">
                <img
                    src="./assets/360_F_221974381_JhOOrFXKcF429SajWlRo6f5A3jUbttS3.jpg"
                    alt="for him"
                    width="700px"
                    height="350px">
            </div>
            <!-- Brands Section -->
            <section class="container text-center my-5">
                <h2 class="mb-4">Brands</h2>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-6">
                        <img src="./assets/titan-logo.svg" class="img-fluid brand-logo" alt="Titan">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <img src="./assets/seiko logo1.png" class="img-fluid brand-logo" alt="Seiko">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <img src="./assets/logo fast.jpeg" class="img-fluid brand-logo" alt="Fasttrack">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <img src="./assets/sonataLogo.svg" class="img-fluid brand-logo" alt="Sonata">
                    </div>
                </div>
            </section>

            <section class="container mt-5">
                <h2 class="text-center mb-4">Recommended for You</h2><br>
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                if (!empty($products)) {
                    for ($i = 0; $i < count($products); $i++) {
                        $activeClass = ($i == 0) ? "active" : "";
                        if ($i % 4 == 0) { // Start a new carousel-item every 4 products
                            echo '<div class="carousel-item ' . $activeClass . '"><div class="d-flex flex-nowrap">';
                        }
                ?>
                      <div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card">
        <!-- Link only wraps image and product name -->
        <a href="product.php?id=<?php echo $products[$i]['product_id']; ?>" class="text-decoration-none text-dark">
            <img
                src="<?php echo $products[$i]['product_image']; ?>"
                class="card-img-top"
                alt="Product">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo $products[$i]['product_name']; ?></h5>
            </div>
        </a>

        <!-- Price and Add to Cart Button outside the link -->
        <div class="card-body text-center">
            <p class="card-text">₹<?php echo $products[$i]['mrp_price']; ?></p>
            <button
                class="btn btn-primary add-to-cart"
                data-id="<?php echo $products[$i]['product_id']; ?>"
                data-name="<?php echo htmlspecialchars($products[$i]['product_name'], ENT_QUOTES); ?>"
                data-price="<?php echo $products[$i]['mrp_price']; ?>">
                Add to Cart
            </button>
        </div>
    </div>
</div>

                    <?php
                        if ($i % 4 == 3 || $i == count($products) - 1) { // Close the carousel-item after 4 products
                            echo '</div></div>';
                        }
                    }
                } else {
                    echo "<p class='text-center'>No products available</p>";
                }
                ?>
                    </div>
                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </section>
            <?php include 'footer.php'; ?>

            <!-- Bootstrap JS -->
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
</script>

        </body>

    </html>