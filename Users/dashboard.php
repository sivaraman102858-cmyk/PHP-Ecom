<?php  
session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecommerce Dashboard</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link href="/ecom/css/userdashboard.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid p-0">
<div class="row container-fluid">

<!-- Sidebar -->
<div class="col-md-2 d-none d-md-block vh-100 sticky-top sidebar">
    <div class="d-flex flex-column p-4 h-100">
        <span class="fs-4 fw-bold text-primary text-center">
            <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
        </span>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="dashboard.php" class="nav-link active"><i class="bi bi-house-door"></i> Home</a></li>
            <li><a href="my_profile.php" class="nav-link"><i class="bi bi-person"></i> My Profile</a></li>
            <li><a href="my_orders.php" class="nav-link"><i class="bi bi-box-seam"></i> Orders</a></li>
            <li><a href="cart.php" class="nav-link"><i class="bi bi-cart3"></i> Cart</a></li>
        </ul>
        <hr>
        <a href="userlogout.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="col-12 col-md-10">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top px-4 py-3">
    <div class="container-fluid">
        <span class="fs-3 fw-bold text-primary">Ecommerce</span>

        <!-- LIVE SEARCH INPUT -->
        <form class="d-flex ms-auto me-3 w-50" onsubmit="return false;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                    <i class="bi bi-search"></i>
                </span>
                <input 
                    type="search" 
                    id="searchInput"
                    class="form-control bg-light border-start-0 rounded-end-pill py-2"
                    placeholder="Search products..."
                >
            </div>
        </form>
    </div>
</nav>

<!-- Products Section -->
<div class="container mt-4">
<div class="row" id="productArea">

<?php
// Initial load - show all products
$mysqli = new mysqli("localhost","root","","project");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM product");

if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $ID = $row["id"];
        $Name = $row["Product_name"];
        $Price = $row["Product_price"];
        $Category = $row["Product_category"];
        $Image = $row["Product_image"];
?>

<div class="col-md-3 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="d-flex justify-content-center p-3">
            <img src="../uploads/<?php echo htmlspecialchars($Image); ?>" 
                 class="card-img-top"
                 style="max-width: 250px; height: 200px; object-fit: contain;">
        </div>

        <div class="card-body text-center">
            <div class="d-flex justify-content-between">
                <h6 class="fw-bold"><?php echo htmlspecialchars($Name); ?></h6>
                <span class="text-primary fw-bold">₹<?php echo htmlspecialchars($Price); ?></span>
            </div>

            <p class="text-muted small text-uppercase">
                <strong>Category:</strong> <?php echo htmlspecialchars($Category); ?>
            </p>

            <div class="d-grid gap-2">
                <a href="buynow.php?id=<?php echo $ID ?>" class="btn btn-primary btn-sm rounded-pill">Buy Now</a>
                <a href="add-to-cart.php?id=<?php echo $ID ?>" class="btn btn-success btn-sm rounded-pill">Add to Cart</a>
                <a href="viewdetails.php?id=<?php echo $ID ?>" class="btn btn-link btn-sm text-decoration-none text-muted">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>

<?php
    }
}
$mysqli->close();
?>

</div>
</div>

</div>
</div>
</div>

<footer class="bg-body-tertiary text-center text-lg-start fixed-bottom">
<div class="text-center p-2 bg-light">
© 2026 Ecommerce.com
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- LIVE SEARCH SCRIPT -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function(){

    let searchValue = this.value;

    fetch("live_search.php?search=" + searchValue)
    .then(response => response.text())
    .then(data => {
        document.getElementById("productArea").innerHTML = data;
    });

});
</script>

</body>
</html>