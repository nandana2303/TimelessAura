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
                <li class="nav-item"><a class="nav-link" href="all.php">ALL</a></li>
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
         <!-- Cart Icon with Counter -->
<a href="cart.php" class="text-dark text-decoration-none">
    <?php
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<a href="cart.php" class="text-dark text-decoration-none">
  <div id="cart-icon" class="me-3 position-relative" style="cursor: pointer;">
    <i class="ri-shopping-bag-4-fill fs-4"></i>
    <span id="cart-count" style="font-size: 0.75rem;min-width: 18px;height: 18px;display: inline-flex;align-items: center;justify-content: center;"
    class="badge bg-danger rounded-circle px-2 position-absolute top-0 start-100 translate-middle"><?php echo $cartCount; ?></span>
  </div>
</a>

  </div>
</a>



</nav>
<script src="script.js"></script>

   <script>
        document.getElementById("logoutBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent immediate redirection
        let confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            window.location.href = "logout.php"; // Redirect if confirmed
        }
    });
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
   