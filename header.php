<?php session_start(); ?>
<header>
    <div class="user-cart-container">
        <span id="cart-icon">
            <i class="fa-solid fa-cart-plus fs-4"></i>
        </span>

        <?php if (isset($_SESSION['email'])) : ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span> 
            <a href="logout.php"><button>Logout</button></a>
        <?php else : ?>
            <div class="button-container">
                <a href="login.html"><button>Login</button></a>
                <a href="register.html"><button>Signup</button></a>
            </div>
        <?php endif; ?>
    </div>
</header>
