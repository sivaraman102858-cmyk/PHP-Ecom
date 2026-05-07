<?php
session_start();

if (!isset($_SESSION['access'])) {
    header('location:userlogin.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "project");
if (!$conn) {
    die("Database connection failed");
}

if (!isset($_GET['order_id'])) {
    die("Invalid Order");
}

$order_id = intval($_GET['order_id']);

/* 🔹 Fetch Order Securely */
$stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("Order not found");
}

/* 🔹 Handle Payment */
if (isset($_POST['pay_now'])) {

    $payment_method = $_POST['Payment_method'] ?? '';

    if ($payment_method == "") {
        $error = "Please select payment method.";
    } else {

        // COD = Payment Pending until delivery
        if ($payment_method == "Cash On Delivery") {
            $payment_status = "Pending";
        } else {
            $payment_status = "Paid";
        }

        $updateStmt = mysqli_prepare($conn,
            "UPDATE orders 
             SET Payment_status = ?, Payment_method = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param($updateStmt, "ssi", $payment_status, $payment_method, $order_id);

        if (mysqli_stmt_execute($updateStmt)) {
            header("Location: payment-success.php?order_id=" . $order_id);
            exit();
        } else {
            $error = "Payment failed. Try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Payment Gateway</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow">
<div class="card-header bg-success text-white text-center">
<h5>💳 Secure Payment Gateway</h5>
</div>

<div class="card-body">

<?php if(isset($error)) { ?>
<div class="alert alert-danger"><?= $error; ?></div>
<?php } ?>

<p><strong>Order ID:</strong> <?= $order['id']; ?></p>
<p><strong>Customer:</strong> <?= htmlspecialchars($order['Customer_name']); ?></p>
<p><strong>Total Amount:</strong> ₹<?= number_format($order['Total_amount'],2); ?></p>

<hr>

<form method="POST">

<label class="fw-bold mb-2">Choose Payment Method</label>

<!-- UPI -->
<div class="form-check mb-2">
<input type="radio" name="Payment_method" value="UPI" class="form-check-input" required>
<label class="form-check-label">UPI</label>
</div>

<div class="mb-3">
<input type="text" name="upi_id" class="form-control" placeholder="Enter UPI ID (example@upi)">
</div>

<!-- Card -->
<div class="form-check mb-2">
<input type="radio" name="Payment_method" value="Card" class="form-check-input">
<label class="form-check-label">Debit / Credit Card</label>
</div>

<div class="mb-2">
<input type="text" name="card_number" class="form-control" placeholder="Card Number">
</div>

<div class="row">
<div class="col">
<input type="text" name="expiry" class="form-control" placeholder="MM/YY">
</div>
<div class="col">
<input type="password" name="cvv" class="form-control" placeholder="CVV">
</div>
</div>

<!-- COD -->
<div class="form-check mt-3 mb-3">
<input type="radio" name="Payment_method" value="Cash On Delivery" class="form-check-input">
<label class="form-check-label">Cash On Delivery</label>
</div>

<button type="submit" name="pay_now" class="btn btn-success w-100">
✅ Confirm Payment ₹<?= number_format($order['Total_amount'],2); ?>
</button>

</form>

</div>
</div>

</div>
</div>
</div>

<footer class="bg-light text-center p-2 mt-5">
© 2026 Ecommerce.com
</footer>

</body>
</html>