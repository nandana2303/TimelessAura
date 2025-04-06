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
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
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
                        <li><a class="dropdown-item" href="adminregister.html" id="signupBtn">Admin Signup</a></li>
                        <li><a class="dropdown-item" href="adminlogin.html" id="signupBtn">Admin Login</a></li>
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
   