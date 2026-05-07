<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "project");

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("Cart empty");
}

$name = $_POST['Customer_name'];
$email = $_POST['Customer_email'];
$address = $_POST['Customer_address'];

$total_amount = 0;
foreach ($cart as $item) {
    $total_amount += $item['price'] * $item['qty'];
}

// Save ONE order for all products
mysqli_query($conn, "
INSERT INTO orders 
(Customer_name, Customer_email, Customer_address, Total_amount, Order_status, Payment_status)
VALUES 
('$name', '$email', '$address', '$total_amount', 'Pending', 'Unpaid')
");

$order_id = mysqli_insert_id($conn);

// Clear cart
unset($_SESSION['cart']);

// Redirect payment
header("Location: payment.php?order_id=$order_id");
exit;
?>
