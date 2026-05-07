<?php
session_start();

if (!isset($_SESSION['access'])) {
    header('location:userlogin.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "project");
if (!$conn) die("Database Connection Failed");

if (!isset($_GET['order_id'])) die("Invalid Order");

$order_id = intval($_GET['order_id']);

$stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) die("Order not found");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Successful</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#e8f5e9,#ffffff);
    overflow-x:hidden;
}

/* Fade-in animation */
.fade-in {
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    from { opacity:0; transform: translateY(20px); }
    to { opacity:1; transform: translateY(0); }
}

/* Card Style */
.success-card {
    border-radius:20px;
    transition: transform 0.3s ease;
}
.success-card:hover {
    transform: scale(1.02);
}

/* Animated Checkmark */
.checkmark {
    font-size: 80px;
    color: #28a745;
    animation: pop 0.6s ease-in-out;
}
@keyframes pop {
    0% { transform: scale(0); }
    80% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

/* Button Hover */
.btn-primary {
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>
</head>

<body>

<div class="container mt-5 mb-5 col-lg-6 fade-in">

    <div class="card shadow-lg p-4 text-center success-card">

        <div class="checkmark">✔</div>

        <h2 class="text-success mt-3">Payment Successful</h2>
        <p class="text-muted">Thank you for your purchase 🎉</p>

        <hr>

        <h5>Order ID: <strong>#<?= $order['id']; ?></strong></h5>

        <p><strong>Name:</strong> <?= htmlspecialchars($order['Customer_name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['Customer_email']); ?></p>

        <?php if (!empty($order['Customer_mobile'])) { ?>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($order['Customer_mobile']); ?></p>
        <?php } ?>

        <h4 class="text-success mt-3">
            ₹<?= number_format($order['Total_amount'],2); ?>
        </h4>

        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-primary px-4">
                Continue Shopping 🛍
            </a>
        </div>

    </div>
</div>

<!-- Confetti Animation -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
confetti({
    particleCount: 150,
    spread: 120,
    origin: { y: 0.6 }
});
</script>

<footer class="bg-light text-center p-3">
    © 2026 Ecommerce.com | Secure Payment 🔒
</footer>

</body>
</html>