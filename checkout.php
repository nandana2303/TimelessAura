<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect if accessed directly
    header("Location: index.php");
    exit;
}

$from_cart = $_SESSION['from_cart'] ?? false; //This is used to determine if the request is coming from cart or product page

$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$price = $_POST['price'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="checkout.css">
</head>
<body>
<form method="POST" action="buy_now.php">
  <!-- Hidden product info -->
  <input type="hidden" name="product_id[]" value="<?= htmlspecialchars($product_id) ?>">
  <input type="hidden" name="product_name[]" value="<?= htmlspecialchars($product_name) ?>">
  <input type="hidden" name="price[]" value="<?= htmlspecialchars($price) ?>">
  <input type="hidden" name="from_cart" value="<?= $from_cart ? 'true' : 'false' ?>">

  <!-- Form content starts -->
  <article class="card">
    <div class="container">
      <div class="card-title">
        <h2>Payment</h2>
      </div>
      <div class="card-body">
        <div class="payment-type">
          <h4>Choose payment method below</h4>
          <div class="types flex justify-space-between">
            <div class="type selected" data-method="card">
              <div class="logo"><i class="far fa-credit-card"></i></div>
              <div class="text"><p>Pay with Card</p></div>
            </div>
            <div class="type" data-method="upi">
              <div class="logo"><i class="fas fa-mobile-alt"></i></div>
              <div class="text"><p>Pay with UPI</p></div>
            </div>
          </div>
          <!-- Selected method -->
          <input type="hidden" name="payment_method" id="payment_method" value="card">
        </div>

        <div class="payment-info flex justify-space-between">
          <div class="column billing">
            <div class="title"><div class="num">1</div><h4>Billing Info</h4></div>

            <div class="field full">
              <label for="name">Full Name</label>
              <input id="name" name="full_name" type="text" placeholder="Full Name" required>
            </div>

            <div class="field full">
              <label for="address">Billing Address</label>
              <input id="address" name="shipping_address" type="text" placeholder="Billing Address" required>
            </div>

            <div class="flex justify-space-between">
              <div class="field half">
                <label for="city">City</label>
                <input id="city" name="city" type="text" placeholder="City">
              </div>
              <div class="field half">
                <label for="state">State</label>
                <input id="state" name="state" type="text" placeholder="State">
              </div>
            </div>

            <div class="field full">
              <label for="zip">Zip</label>
              <input id="zip" name="zip" type="text" placeholder="Zip">
            </div>
          </div>

          <div class="column payment-fields">
            <div class="title"><div class="num">2</div><h4>Payment Info</h4></div>

            <div id="card-fields">
              <div class="field full">
                <label for="card-name">Cardholder Name</label>
                <input id="card-name" type="text" placeholder="Full Name">
              </div>
              <div class="field full">
                <label for="card-number">Card Number</label>
                <input id="card-number" type="text" placeholder="1234-5678-9012-3456">
              </div>
              <div class="flex justify-space-between">
                <div class="field half">
                  <label for="exp-month">Exp. Month</label>
                  <input id="exp-month" type="text" placeholder="12" maxlength="2">
                </div>
                <div class="field half">
                  <label for="exp-year">Exp. Year</label>
                  <input id="exp-year" type="text" placeholder="25" maxlength="2">
                </div>
              </div>
              <div class="field full">
                <label for="cvc">CVC</label>
                <input id="cvc" type="text" placeholder="123" maxlength="3">
              </div>
            </div>

            <div id="upi-fields" style="display: none;">
              <div class="field full">
                <label for="upi-id">UPI ID</label>
                <input id="upi-id" type="text" placeholder="example@upi">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-actions flex justify-space-between">
        <div class="flex-start">
          <button class="button button-secondary" onclick="backtohome(); return false;">Return to Store</button>
        </div>
        <div class="flex-end">
          <button class="button button-link" onclick="history.back(); return false;">Back to Cart</button>
          <button type="submit" class="button button-primary">Proceed</button>
        </div>
      </div>
    </div>
  </article>
</form>

<script>
  // Toggle between card and UPI fields and set payment_method hidden input
  document.querySelectorAll('.type').forEach(el => {
    el.addEventListener('click', () => {
      document.querySelectorAll('.type').forEach(t => t.classList.remove('selected'));
      el.classList.add('selected');

      const method = el.getAttribute('data-method');
      document.getElementById('payment_method').value = method;

      document.getElementById('card-fields').style.display = method === 'card' ? 'block' : 'none';
      document.getElementById('upi-fields').style.display = method === 'upi' ? 'block' : 'none';
    });
  });

  // Format card number: allow only digits, max 12, space every 4
  document.getElementById('card-number').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.substring(0, 16); // Max 12 digits
    let formatted = value.match(/.{1,4}/g);
    e.target.value = formatted ? formatted.join(' ') : '';
  });

  // Allow only digits in CVC, Exp. Month, and Exp. Year
['cvc', 'exp-month', 'exp-year'].forEach(id => {
  document.getElementById(id).addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // remove non-digit characters
  });
});

  // Validation on form submit
  document.querySelector('form').addEventListener('submit', function (e) {
    const method = document.getElementById('payment_method').value;

    if (method === 'card') {
      const cvc = document.getElementById('cvc').value.trim();
      const month = document.getElementById('exp-month').value.trim();
      const year = document.getElementById('exp-year').value.trim();

      // CVC: 3 or 4 digits only
      if (!/^\d{3,4}$/.test(cvc)) {
        alert("CVC must be 3 or 4 digits");
        e.preventDefault();
        return;
      }

      // Month: 01 - 12
      if (!/^(0?[1-9]|1[0-2])$/.test(month)) {
        alert("Enter a valid month (1-12)");
        e.preventDefault();
        return;
      }

      // Year: 2 digits
      if (!/^\d{2}$/.test(year)) {
        alert("Enter a valid 2-digit year (e.g. 25 for 2025)");
        e.preventDefault();
        return;
      }
    }

    if (method === 'upi') {
      const upi = document.getElementById('upi-id').value.trim();
      // Only letters, digits, dots, dashes, and one @ symbol
      const upiRegex = /^[a-zA-Z0-9.\-]{2,256}@[a-zA-Z]{2,64}$/;

      if (!upiRegex.test(upi)) {
        alert("Enter a valid UPI ID (only letters, numbers, dot, dash, and '@' allowed)");
        e.preventDefault();
        return;
      }
    }
  });

  function backtohome() {
    window.location = "index.php";
  }
</script>



</body>
</html>