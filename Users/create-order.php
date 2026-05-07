<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: userlogin.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "project");

$email = $_SESSION['user_email'];

/* Get user details securely */
$userStmt = mysqli_prepare($conn, "SELECT Name, Email, Address FROM users WHERE Email = ?");
mysqli_stmt_bind_param($userStmt, "s", $email);
mysqli_stmt_execute($userStmt);
$userResult = mysqli_stmt_get_result($userStmt);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    die("User not found");
}

if (!isset($_GET['product_id'])) {
    die("Invalid Product");
}

$product_id = (int)$_GET['product_id'];

/* Get product details */
$productStmt = mysqli_prepare($conn, "SELECT id, product_name, product_price FROM product WHERE id = ?");
mysqli_stmt_bind_param($productStmt, "i", $product_id);
mysqli_stmt_execute($productStmt);
$productResult = mysqli_stmt_get_result($productStmt);
$product = mysqli_fetch_assoc($productResult);

if (!$product) {
    die("Product not found");
}

/* Place Order */
if (isset($_POST['place_order'])) {

    $stmt = mysqli_prepare($conn,
        "INSERT INTO orders 
        (Product_id, Customer_name, Customer_email, Customer_address, Total_amount, Order_status, Payment_status, Payment_method)
        VALUES (?, ?, ?, ?, ?, 'Pending', 'Pending', 'Cash On Delivery')"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isssd",
        $product_id,
        $user['Name'],
        $user['Email'],
        $user['Address'],
        $product['product_price']
    );

    mysqli_stmt_execute($stmt);

    echo "<script>alert('Order Placed Successfully'); window.location='my_orders.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Confirm Your Order</h3>

        <div class="row">
            <div class="col-md-6">
                <h5>Product Details</h5>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($product['product_name']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo number_format($product['product_price'],2); ?></p>
            </div>

            <div class="col-md-6">
                <h5>Shipping Details</h5>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['Address']); ?></p>
            </div>
        </div>

        <form method="POST" class="mt-4 text-center">
            <button type="submit" name="place_order" class="btn btn-success px-5">
                Place Order
            </button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>