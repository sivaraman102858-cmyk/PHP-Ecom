<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
}

?>

<?php 
$conn = mysqli_connect("localhost", "root", "", "project");

if (!isset($_GET['id'])) {
    die("Product not found");
}

$product_id = intval($_GET['id']);

$query = mysqli_query($conn, "SELECT * FROM product WHERE id = $product_id");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Invalid product ID");
}

$product = mysqli_fetch_assoc($query);

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty'] += 1;
} else {
    $_SESSION['cart'][$product_id] = [
        'id'    => $product['id'], // FIXED
        'name'  => $product['Product_name'],
        'price' => $product['Product_price'],
        'image' => $product['Product_image'],
        'qty'   => 1
    ];
}

header("Location: cart.php");
exit;
?>

