<?php
$mysqli = new mysqli("localhost","root","","project");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ecommerce - Guest</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
    <div class="container-fluid">
        <span class="fs-3 fw-bold text-primary">Ecommerce</span>

        <!-- Live Search -->
        <form class="d-flex ms-auto w-50" onsubmit="return false;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                    <i class="bi bi-search"></i>
                </span>
                <input 
                    type="search" 
                    id="searchInput"
                    class="form-control bg-light border-start-0 rounded-end-pill"
                    placeholder="Search products..."
                >
            </div>
        </form>

        <div class="ms-3">
            <a href="userlogin.php" class="btn btn-outline-primary btn-sm">Login</a>
            <a href="register.php" class="btn btn-primary btn-sm">Register</a>
        </div>
    </div>
</nav>

<!-- Product Section -->
<div class="container mt-4">
<div class="row" id="productArea">

<?php
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
                <a href="viewdetails.php?id=<?php echo $ID ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                    View Details
                </a>
                <a href="userlogin.php" class="btn btn-primary btn-sm rounded-pill">
                    Login to Buy
                </a>
            </div>
        </div>
    </div>
</div>

<?php
    }
} else {
    echo '<div class="col-12 text-center py-5">
            <h5>No products available</h5>
          </div>';
}

$mysqli->close();
?>

</div>
</div>

<footer class="bg-light text-center p-3 mt-4">
© 2026 Ecommerce.com
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Live Search Script -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function(){

    let searchValue = this.value;

    fetch("guest_live_search.php?search=" + searchValue)
    .then(response => response.text())
    .then(data => {
        document.getElementById("productArea").innerHTML = data;
    });

});
</script>

</body>
</html>