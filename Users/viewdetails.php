<?php  
session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
  exit();
}
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "project");
if (!$conn) die("Database connection failed");

if (!isset($_GET['id'])) die("Invalid Product ID");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM product WHERE id='$id'");
$product = mysqli_fetch_assoc($result);

if (!$product) die("Product not found");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['Product_name']); ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#f8f9fa,#e9f5ff);
}

/* Glass Card */
.glass-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity:0; transform:translateY(20px);}
    to { opacity:1; transform:translateY(0);}
}

.product-img {
    width:100%;
    max-height:450px;
    object-fit:contain;
}

.size-btn {
    border-radius: 50px;
    padding: 6px 18px;
}

.size-btn.active {
    background:#198754;
    color:white;
}

.qty-box {
    width:60px;
    text-align:center;
}

.buy-bar {
    position: fixed;
    bottom:0;
    width:100%;
    background:white;
    padding:10px 0;
    box-shadow: 0 -3px 10px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">
      🛍 Ecommerce
    </a>
  </div>
</nav>

<div class="container my-5">
<div class="row g-4">

<!-- IMAGE -->
<div class="col-lg-6">
  <div class="glass-card p-5 m-1 text-center">
    <img src="../uploads/<?= htmlspecialchars($product['Product_image']); ?>" class="product-img">
  </div>
</div>

<!-- DETAILS -->
<div class="col-lg-6">
  <div class="glass-card p-5 py-5">

    <span class="badge bg-primary mb-3">
      <?= htmlspecialchars($product['Product_category']); ?>
    </span>

    <h2 class="fw-bold"><?= htmlspecialchars($product['Product_name']); ?></h2>

    <h3 class="text-success fw-bold mt-2">
      ₹<span id="unitPrice"><?= $product['Product_price']; ?></span>
    </h3>

    <p class="text-muted mt-3">
      <?= htmlspecialchars($product['Description']); ?>
    </p>

    <!-- SIZE SELECT -->
    <div class="mt-4">
        <label class="fw-bold mb-2">Select Size</label><br>
        <button class="btn btn-outline-success size-btn active" data-size="M">M</button>
        <button class="btn btn-outline-success size-btn" data-size="L">L</button>
        <button class="btn btn-outline-success size-btn" data-size="XL">XL</button>
        <button class="btn btn-outline-success size-btn" data-size="XXL">XXL</button>
    </div>

    <!-- QUANTITY -->
    <div class="mt-4">
        <label class="fw-bold mb-2">Quantity</label>
        <div class="input-group" style="max-width:150px;">
            <button class="btn btn-outline-secondary" id="minus">-</button>
            <input type="text" id="qty" class="form-control qty-box" value="1">
            <button class="btn btn-outline-secondary" id="plus">+</button>
        </div>
    </div>

    <!-- TOTAL -->
    <h4 class="text-primary mt-4">
        Total: ₹<span id="totalPrice"><?= $product['Product_price']; ?></span>
    </h4>

    <!-- BUTTONS -->
    <div class="d-flex gap-2 mt-4">
      <a href="dashboard.php" class="btn btn-outline-dark px-4">
        ⬅ Back
      </a>

      <button id="buyNowBtn" class="btn btn-success px-4">
        🛒 Buy Now
      </button>
    </div>

  </div>
</div>

</div>
</div>

<!-- MOBILE BUY BAR -->
<div class="buy-bar d-lg-none">
  <div class="container d-flex justify-content-between align-items-center">
    <strong class="text-success">
      ₹<span id="mobileTotal"><?= $product['Product_price']; ?></span>
    </strong>
    <button id="mobileBuyBtn" class="btn btn-success btn-sm">
      Buy Now
    </button>
  </div>
</div>

<script>
let selectedSize = "M";
let unitPrice = parseFloat(document.getElementById("unitPrice").innerText);

function updateTotal(){
    let qty = parseInt(document.getElementById("qty").value);
    if(qty < 1) qty = 1;
    let total = qty * unitPrice;
    document.getElementById("totalPrice").innerText = total;
    document.getElementById("mobileTotal").innerText = total;
}

// Size select
document.querySelectorAll(".size-btn").forEach(btn=>{
    btn.addEventListener("click", function(){
        document.querySelectorAll(".size-btn").forEach(b=>b.classList.remove("active"));
        this.classList.add("active");
        selectedSize = this.dataset.size;
    });
});

// Quantity
document.getElementById("plus").onclick = function(){
    let qty = document.getElementById("qty");
    qty.value = parseInt(qty.value) + 1;
    updateTotal();
};

document.getElementById("minus").onclick = function(){
    let qty = document.getElementById("qty");
    if(parseInt(qty.value) > 1){
        qty.value = parseInt(qty.value) - 1;
        updateTotal();
    }
};

document.getElementById("qty").oninput = updateTotal;

// Buy Now
function goToBuy(){
    let qty = document.getElementById("qty").value;
    window.location.href = 
    "buynow.php?id=<?= $product['id']; ?>&size=" + selectedSize + "&qty=" + qty;
}

document.getElementById("buyNowBtn").onclick = goToBuy;
document.getElementById("mobileBuyBtn").onclick = goToBuy;

</script>

</body>
</html>