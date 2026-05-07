<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
}

?>

<?php
session_start();

$id = $_POST['id'];
$qty = $_POST['qty'];

if ($qty > 0) {
    $_SESSION['cart'][$id]['qty'] = $qty;
}

header("Location: cart.php");
