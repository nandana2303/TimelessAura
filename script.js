const cartIcon = document.querySelector("#cart-icon");
const cart = document.querySelector(".cart");
const cartClose = document.querySelector("#cart-close");
const cartContent = document.querySelector(".cart-content");
const totalPriceElement = document.querySelector(".total-price");

// Open and close the cart
cartIcon.addEventListener("click", () => cart.classList.add("active"));
cartClose.addEventListener("click", () => cart.classList.remove("active"));

// Select all Add to Cart buttons
const addCartButtons = document.querySelectorAll(".btn-primary");

addCartButtons.forEach(button => {
    button.addEventListener("click", event => {
        const productBox = event.target.closest(".card");
        addToCart(productBox);
    });
});

const addToCart = (productBox) => {
    const productImgSrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".card-title").textContent;
    const productPrice = parseFloat(productBox.querySelector(".card-text").textContent.replace("₹", "").trim()); // Convert price to number

    // Check if the product is already in the cart
    const cartItems = document.querySelectorAll(".cart-product-title");
    for (let item of cartItems) {
        if (item.textContent === productTitle) {
            alert("This item is already in the cart!");
            return;
        }
    }

    // Create a cart item
    const cartBox = document.createElement("div");
    cartBox.classList.add("cart-box");
    cartBox.innerHTML = `
        <img src="${productImgSrc}" class="cart-img">
        <div class="cart-detail">
            <h2 class="cart-product-title">${productTitle}</h2>
            <span class="cart-price">₹${productPrice.toFixed(2)}</span>
            <div class="cart-quantity">
                <button class="decrement">-</button>
                <span class="number">1</span>
                <button class="increment">+</button>
            </div>
        </div>
        <i class="ri-delete-bin-5-line cart-remove"></i>
    `;

    cartContent.appendChild(cartBox);

    // Add event listeners for quantity update and remove
    updateCartFunctions(cartBox);
    
    // Update total after adding an item
    updateTotal();
};

// Function to handle quantity change and remove button
const updateCartFunctions = (cartBox) => {
    const decrementBtn = cartBox.querySelector(".decrement");
    const incrementBtn = cartBox.querySelector(".increment");
    const removeBtn = cartBox.querySelector(".cart-remove");
    let quantityElement = cartBox.querySelector(".number");

    decrementBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityElement.textContent);
        if (quantity > 1) {
            quantityElement.textContent = quantity - 1;
            updateTotal();
        }
    });

    incrementBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityElement.textContent);
        quantityElement.textContent = quantity + 1;
        updateTotal();
    });

    removeBtn.addEventListener("click", () => {
        cartBox.remove();
        updateTotal();
    });
};

// Function to update total price
const updateTotal = () => {
    let total = 0;
    document.querySelectorAll(".cart-box").forEach(cartBox => {
        const price = parseFloat(cartBox.querySelector(".cart-price").textContent.replace("₹", "").trim());
        const quantity = parseInt(cartBox.querySelector(".number").textContent);
        total += price * quantity;
    });

    totalPriceElement.textContent = `₹${total.toFixed(2)}`;
};

    document.getElementById("logoutBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent immediate redirection
        let confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            window.location.href = "logout.php"; // Redirect if confirmed
        }
    });

    

