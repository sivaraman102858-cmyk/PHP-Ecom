<?php
require('razorpay-config.php');

$conn = mysqli_connect("localhost", "root", "", "project");

$order_id = intval($_GET['order_id']);
$payment_id = $_GET['payment_id'];
$signature = $_GET['signature'];

$orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'");
$order = mysqli_fetch_assoc($orderQuery);

$attributes  = array(
    'razorpay_order_id' => $_GET['razorpay_order_id'] ?? '',
    'razorpay_payment_id' => $payment_id,
    'razorpay_signature' => $signature
);

try {
    $api->utility->verifyPaymentSignature($attributes);

    mysqli_query($conn, "
        UPDATE orders 
        SET Payment_status='Paid',
            Payment_method='Razorpay',
            Razorpay_payment_id='$payment_id'
        WHERE id='$order_id'
    ");

    header("Location: payment-success.php?order_id=".$order_id);
    exit();

} catch(SignatureVerificationError $e) {
    die("Payment verification failed");
}