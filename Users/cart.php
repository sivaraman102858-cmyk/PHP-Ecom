<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="/ecom/css/userdashboard.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid p-0">
    <div class="row container-fluid">
        <div class="col-md-2 d-none d-md-block vh-100 sticky-top sidebar">
            <div class="d-flex flex-column p-4 h-100">
                <a href="#" class="d-flex align-items-center justify-content-center link-dark text-decoration-none">
                    <span class="fs-3 fw-bold text-primary">Sivaraman.D</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="my_profile.php" class="nav-link">
                            <i class="bi bi-person"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="my_orders.php" class="nav-link">
                            <i class="bi bi-box-seam"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cart.php" class="nav-link active">
                            <i class="bi bi-cart3"></i> Cart
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="logout pb-3">
                    <a href="userlogout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-10">
            <?php
                $cart = $_SESSION['cart'] ?? [];
            ?>
            <div class="container mt-4">

<h3>🛒 Shopping Cart</h3>

<?php if (!empty($cart)) { ?>

<table class="table table-bordered bg-white shadow">
<thead class="table-dark">
<tr>
<th>Product</th>
<th>Image</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php 
$grand_total = 0;
foreach ($cart as $id => $item) {
    $total = $item['price'] * $item['qty'];
    $grand_total += $total;
?>

<tr>
<td><?= $item['name']; ?></td>

<td>
<img src="../uploads/<?= $item['image']; ?>" width="80" 
onerror="this.src='../uploads/no-image.png'">

</td>

<td>₹<?= $item['price']; ?></td>

<td>
<form method="POST" action="update-cart.php">
<input type="hidden" name="id" value="<?= $id; ?>">
<input type="number" name="qty" value="<?= $item['qty']; ?>" min="1" class="form-control" style="width:80px;">
<button class="btn btn-sm btn-primary mt-1">Update</button>
</form>
</td>

<td>₹<?= $total; ?></td>

<td>
<a href="remove-cart.php?id=<?= $id; ?>" class="btn btn-danger btn-sm">Remove</a>
</td>

</tr>

<?php } ?>

<tr>
<td colspan="4" class="text-end fw-bold">Grand Total:</td>
<td colspan="2" class="fw-bold text-success">₹<?= $grand_total; ?></td>
</tr>

</tbody>
</table>

<a href="buynow.php?id=<?= array_key_first($cart); ?>" class="btn btn-success">Proceed to Checkout</a>


<?php } else { ?>
<div class="alert alert-warning">Your cart is empty</div>
<?php } ?>

</div>

        </div>
    </div>
</div>
<!--------------------------------Footer------------------------->
<footer class="bg-body-tertiary text-center text-lg-start fixed-bottom">
  <!-- Copyright -->
  <div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2026 Copyright:
    <a class="text-body text-decoration-none" href="#">Ecommerce.com</a>
  </div>
  <!-- Copyright -->
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>