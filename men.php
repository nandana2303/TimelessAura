<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <script src="jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<?php include 'navbar.php'; ?>
<!-- Men's Watch Products -->
<section class="container mt-5">
    <h2 class="text-center mb-4">Men's Watches</h2><br>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/ppimg1.jpg" class="card-img-top" alt="Watch 1">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 1</h5>
                    <p class="card-text">₹999</p>
                    <p class="watch-description">Classic analog watch with leather strap.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/timg1.webp" class="card-img-top" alt="Watch 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 2</h5>
                    <p class="card-text">₹799</p>
                    <p class="watch-description">Minimalist stainless steel wristwatch.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/timg1.webp" class="card-img-top" alt="Watch 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 2</h5>
                    <p class="card-text">₹799</p>
                    <p class="watch-description">Minimalist stainless steel wristwatch.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/timg1.webp" class="card-img-top" alt="Watch 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 2</h5>
                    <p class="card-text">₹799</p>
                    <p class="watch-description">Minimalist stainless steel wristwatch.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/timg1.webp" class="card-img-top" alt="Watch 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 2</h5>
                    <p class="card-text">₹799</p>
                    <p class="watch-description">Minimalist stainless steel wristwatch.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card watch-card">
                <img src="./assets/timg1.webp" class="card-img-top" alt="Watch 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Watch Name 2</h5>
                    <p class="card-text">₹799</p>
                    <p class="watch-description">Minimalist stainless steel wristwatch.</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        
        
        

    </div>
</section>

<!-- CSS for Hover Effect -->
<style>
    .watch-card {
        position: relative;
        overflow: hidden;
    }
    .watch-description {
        display: none;
        font-size: 14px;
        color: #555;
        margin-top: 10px;
    }
    .watch-card:hover .watch-description {
        display: block;
    }
</style>

<?php include 'footer.php'; ?>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</html>