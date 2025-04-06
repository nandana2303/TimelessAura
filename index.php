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

            <!-- Top Bar -->
            <div class="top-bar d-flex justify-content-between p-2">
                <div class="contact-info">
                    <img src="./assets/email.png" alt="Email Icon" height="20">
                    timelessaura@gmail.com
                </div>
                <div class="contact-info">
                    <img src="./assets/phone.png" alt="Phone Icon" height="20">
                    +91 998773645 | +91 8065772305
                </div>
            </div>

            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container">
                    <!-- Logo -->
                    <a class="navbar-brand" href="index.php">
                        <img src="./assets/logo1.png" alt="TimelessAura Logo" height="100">
                    </a>

                    <!-- Toggle Button for Mobile View -->
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="men.php">MEN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="women.php">WOMEN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="kids.php">KIDS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="smart.php">SMART WATCHES</a>
                            </li>
                            <!-- <li class="nav-item"><a class="nav-link text-danger" href="#">SALE</a></li>
                            -->
                        </ul>
                    </div>

                    <!-- Account & Cart -->
                    <div class="d-flex">
                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <a
                                href="#"
                                class="me-3"
                                id="userDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="./assets/user.png" alt="User Icon" height="30">
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li>
                                    <span class="dropdown-item-text" id="userWelcome">
                                        <?php echo isset($_SESSION['UserName']) ? "Welcome, " . $_SESSION['UserName'] : "Welcome, Guest"; ?>
                                    </span>
                                </li>

                                <?php if (isset($_SESSION['UserName'])): ?>
                                <li>
                                    <a class="dropdown-item" href="logout.php" id="logoutBtn">Logout</a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a class="dropdown-item" href="login.html" id="loginBtn">Login</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="register.html" id="signupBtn">Signup</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Cart Icon -->
                        <div id="cart-icon" class="me-3">
                            <i class="ri-shopping-bag-4-fill"></i>
                            <span class="cart-item-count"></span>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="cart">
                <h2 class="card-title">Your Cart</h2>
                <div class="cart-content">
                    <!-- <div class="cart-box"> <img src="ppimg1.jpg" class="cart-img"> <div
                    class="cart-detail"> <h2 class="cart-product-title">Patek Watch</h2> <span
                    class="cart-price">$500</span> <div class="cart-quantity"> <button
                    id="decrement">-</button> <span class="number">1</span> <button
                    id="increment">+</button> </div> </div> <i class="ri-delete-bin-5-line
                    cart-remove"></i> </div> -->
                </div>
                <div class="total">
                    <div class="total-title">Total</div>
                    <div class="total-price">$0</div>
                </div>
                <button class="btn-buy" onclick="handleBuyNow()">Buy now</button>
                <i class="ri-close-line" id="cart-close"></i>
            </div>

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
                        <a href="product.php?id=<?php echo $products[$i]['product_id']; ?>" class="text-decoration-none text-dark">
                            <div class="card">
                                <img
                                    src="<?php echo $products[$i]['product_image']; ?>"
                                    class="card-img-top"
                                    alt="Product">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $products[$i]['product_name']; ?></h5>
                                    <p class="card-text">₹<?php echo $products[$i]['mrp_price']; ?></p>
                                    <button
                                        class="btn btn-primary add-to-cart"
                                        data-id="<?php echo $products[$i]['product_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($products[$i]['product_name'], ENT_QUOTES); ?>"
                                        data-price="<?php echo $products[$i]['mrp_price']; ?>">Add to Cart</button>
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
                        var product_id = $(this).data("id");
                        var product_name = $(this).data("name");
                        var price = $(this).data("price");
                        console.log("Adding to cart:", product_id, product_name, price); // Debug log
                        $.post("add_to_cart.php", {
                            product_id: product_id,
                            product_name: product_name,
                            price: price
                        }, function (response) {
                            alert(response); // You can replace this with a nicer alert or UI update
                            console.log("Server Response:", response); // Debug log
                        });
                    });
                });
            </script>
            <!-- <script src="script.js"></script> -->
            <!-- JavaScript Logic -->
            <script>
                // Check if user is logged in using PHP session data
                var isLoggedIn = <?php echo isset($_SESSION['UserName']) ? 'true' : 'false'; ?>;

                function handleBuyNow() {
                    if (isLoggedIn) {
                        window.location.href = "payment.html"; // Redirect to payment page
                    } else {
                        window.location.href = "login.html"; // Redirect to login page
                    }
                }
            </script>
        </body>

    </html>