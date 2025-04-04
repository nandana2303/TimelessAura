<?php session_start();?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimelessAura</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="men.php">MEN</a></li>
                <li class="nav-item"><a class="nav-link" href="women.php">WOMEN</a></li>
                <li class="nav-item"><a class="nav-link" href="kids.php">KIDS</a></li>
                <li class="nav-item"><a class="nav-link" href="smart.php">SMART WATCHES</a></li>
                <!-- <li class="nav-item"><a class="nav-link text-danger" href="#">SALE</a></li> -->
            </ul>
        </div>

        <!-- Account & Cart -->
        <div class="d-flex">
            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="#" class="me-3" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./assets/user.png" alt="User Icon" height="30">
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li>
                        <span class="dropdown-item-text" id="userWelcome">
                            <?php echo isset($_SESSION['UserName']) ? "Welcome, " . $_SESSION['UserName'] : "Welcome, Guest"; ?>
                        </span>
                    </li>

                    <?php if (isset($_SESSION['UserName'])): ?>
                        <li><a class="dropdown-item" href="logout.php" id="logoutBtn">Logout</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="login.html" id="loginBtn">Login</a></li>
                        <li><a class="dropdown-item" href="register.html" id="signupBtn">Signup</a></li>
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
        <!-- <div class="cart-box">
            <img src="ppimg1.jpg" class="cart-img">
            <div class="cart-detail">
                <h2 class="cart-product-title">Patek Watch</h2>
<span class="cart-price">$500</span>
<div class="cart-quantity">
    <button id="decrement">-</button>
    <span class="number">1</span>
    <button id="increment">+</button>
</div>
</div>
<i class="ri-delete-bin-5-line cart-remove"></i>
      </div> -->
    </div>
    <div class="total">
       <div class="total-title">Total</div>
       <div class="total-price">$0</div>
    </div>
    <button class="btn-buy" onclick="handleBuyNow()">Buy now</button>
    <i class="ri-close-line" id="cart-close"></i>
   </div> 


    <!-- Carousel -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div><br>
    <div class="box">
        <img src="./assets/for-women-feb25.webp" alt="for her" width="750px" height="350px">
        <img src="./assets/360_F_221974381_JhOOrFXKcF429SajWlRo6f5A3jUbttS3.jpg" alt="for him" width="700px" height="350px">
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

    <!-- Product Slider -->
    <section class="container mt-5">
        <h2 class="text-center mb-4">Recommended for You</h2><br>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex flex-nowrap">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/ppimg1.jpg" class="card-img-top" alt="Product 1">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 1</h5>
                                    <p class="card-text">₹999</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/timg1.webp" class="card-img-top" alt="Product 2">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 2</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/ppimg2.jpg" class="card-img-top" alt="Product 3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 3</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/timg2.webp" class="card-img-top" alt="Product 4">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 4</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="carousel-item">
                    <div class="d-flex flex-nowrap">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/ppimg3.jpg" class="card-img-top" alt="Product 5">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 5</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/timg3.webp" class="card-img-top" alt="Product 6">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 6</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/ppimg4.jpg" class="card-img-top" alt="Product 7">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 7</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="./assets/timg4.webp" class="card-img-top" alt="Product 8">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Name 8</h5>
                                    <p class="card-text">₹799</p>
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
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
