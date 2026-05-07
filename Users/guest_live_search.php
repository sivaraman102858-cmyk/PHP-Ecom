<?php
$mysqli = new mysqli("localhost","root","","project");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

if(!empty($search)){
    $stmt = $mysqli->prepare("SELECT * FROM product WHERE Product_name LIKE ?");
    $searchTerm = "%".$search."%";
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM product");
}

$stmt->execute();
$result = $stmt->get_result();

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
            <h5>No products found</h5>
          </div>';
}

$stmt->close();
$mysqli->close();
?>