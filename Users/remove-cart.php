<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
}

?>
<?php
session_start();

$id = $_GET['id'];
unset($_SESSION['cart'][$id]);

header("Location: cart.php");
