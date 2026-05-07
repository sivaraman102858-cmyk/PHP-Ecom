<?php
session_start();

if (!isset($_SESSION['access']) || !isset($_SESSION['user_email'])) {
    header('location:userlogin.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "project");
if (!$conn) die("Database Connection Failed");

$email = $_SESSION['user_email'];

if (!isset($_GET['id'])) die("Invalid Product");

$product_id = intval($_GET['id']);

/* 🔹 Get Product Details */
$productStmt = mysqli_prepare($conn,
    "SELECT id, Product_name, Product_price, Product_image, Product_category, Description 
     FROM product WHERE id = ?"
);
mysqli_stmt_bind_param($productStmt, "i", $product_id);
mysqli_stmt_execute($productStmt);
$product = mysqli_fetch_assoc(mysqli_stmt_get_result($productStmt));

if (!$product) die("Product not found");

/* 🔹 Get User Details */
$userStmt = mysqli_prepare($conn,
    "SELECT Name, Email, Address, Mobile FROM users WHERE Email = ?"
);
mysqli_stmt_bind_param($userStmt, "s", $email);
mysqli_stmt_execute($userStmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($userStmt));

if (!$user) die("User not found");

/* 🔹 Place Order */
if (isset($_POST['place_order'])) {

    $size = $_POST['size'];
    $qty  = intval($_POST['quantity']);
    $price = $product['Product_price'];
    $total = $price * $qty;

    $stmt = mysqli_prepare($conn,
        "INSERT INTO orders 
        (Product_id, Product_image, Product_size, Quantity,
         Customer_name, Customer_email, Customer_mobile, 
         Customer_address, Total_amount, Order_Status, Payment_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Unpaid')"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ississssd",
        $product_id,
        $product['Product_image'],
        $size,
        $qty,
        $user['Name'],
        $user['Email'],
        $user['Mobile'],
        $user['Address'],
        $total
    );

    if (mysqli_stmt_execute($stmt)) {
        $order_id = mysqli_insert_id($conn);
        header("Location: payment.php?order_id=" . $order_id);
        exit();
    } else {
        $error = "Order failed! Try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Confirm Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#e3f2fd,#ffffff);
}
.order-card {
    border-radius: 15px;
}
.product-img {
    max-height: 250px;
    object-fit: cover;
    border-radius: 10px;
}
.summary-box {
    background:#f8f9fa;
    border-radius:10px;
    padding:15px;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">🛍 Ecommerce</a>
  </div>
</nav>

<div class="container mt-5 mb-5 col-lg-8">

<div class="card shadow-lg order-card">

<div class="card-header bg-primary text-white">
<h4 class="mb-0">🛒 Confirm Your Order</h4>
</div>

<div class="card-body p-4">

<?php if(isset($error)) { ?>
<div class="alert alert-danger"><?= $error; ?></div>
<?php } ?>

<div class="row align-items-center mb-4">

<div class="col-md-5 text-center">
<img src="../uploads/<?= htmlspecialchars($product['Product_image']); ?>" 
     class="img-fluid shadow product-img">
</div>

<div class="col-md-7">
<span class="badge bg-secondary mb-2">
<?= htmlspecialchars($product['Product_category']); ?>
</span>

<h3 class="fw-bold"><?= htmlspecialchars($product['Product_name']); ?></h3>

<p class="text-muted small">
<?= htmlspecialchars($product['Description']); ?>
</p>

<h4 class="text-success fw-bold mt-3">
₹<?= number_format($product['Product_price'],2); ?>
</h4>
</div>

</div>

<hr>

<!-- SIZE + QUANTITY FORM -->
<form method="POST">

<h5>Select Size & Quantity</h5>

<div class="row mb-3">
<div class="col-md-6">
<label class="form-label">Size</label>
<select name="size" class="form-select" required>
<option value="S">Small (S)</option>
<option value="M" selected>Medium (M)</option>
<option value="L">Large (L)</option>
<option value="XL">XL</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Quantity</label>
<input type="number" name="quantity" value="1" min="1" class="form-control" required>
</div>
</div>

<hr>

<h5>🚚 Shipping Details</h5>

<div class="summary-box mb-4">
<p><strong>Name:</strong> <?= htmlspecialchars($user['Name']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['Email']); ?></p>
<p><strong>Mobile:</strong> <?= htmlspecialchars($user['Mobile']); ?></p>
<p><strong>Address:</strong> <?= htmlspecialchars($user['Address']); ?></p>
</div>

<div class="d-grid gap-2">
<button type="submit" name="place_order" 
class="btn btn-success btn-lg shadow">
✅ Place Order & Proceed to Payment
</button>

<a href="dashboard.php" class="btn btn-outline-secondary">
⬅ Continue Shopping
</a>
</div>

</form>

</div>
</div>
</div>

<footer class="bg-light text-center p-3 mt-5">
© 2026 Ecommerce.com | Secure Checkout 🔒
</footer>

</body>
</html>