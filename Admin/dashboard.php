<?php
session_start();

if(!isset($_SESSION['access'])){
    header("Location: adminlogin.php");
    exit();
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
    <link href="/ecom/css/admindashboard.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">
            <h4 class="text-center text-white py-3">Admin Panel</h4>
            <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="addproduct.php"><i class="bi bi-box"></i>Add Products</a>
            <a href="viewproduct.php"><i class="bi bi-box"></i>View Products</a>
            <a href="admin_orders.php"><i class="bi bi-cart"></i> Orders</a>
            <a href="viewusers.php"><i class="bi bi-people"></i> Users</a>
            <a href="adminlogout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">

        <!--------------------------Php Connection--------------------->
        <?php 
$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Database connection failed");
}

// Fetch Recent Orders
$query = mysqli_query($conn, "
    SELECT orders.*, product.Product_name 
    FROM orders 
    LEFT JOIN product ON orders.Product_id = product.id 
    ORDER BY Created_at DESC
");
?>
<?php
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM users"))['total'];

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM product"))['total'];

$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM orders"))['total'];

$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(Total_amount) total FROM orders WHERE Payment_status='Paid'"))['total'];
?>



<!--------------------------Php Connection End--------------------->

            <!-- Top Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Dashboard</h3>
                <span class="fw-bold">Welcome, Admin</span>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Total Orders</h6>
                                <h2 class="text-primary"><?= $totalOrders; ?></h2>
                            </div>
                            <i class="bi bi-cart card-icon text-primary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Products</h6>
                                <h2 class="text-success"><?= $totalProducts; ?></h2>
                            </div>
                            <i class="bi bi-box card-icon text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Users</h6>
                                <h2 class="text-primary"><?= $totalUsers; ?></h2>
                            </div>
                            <i class="bi bi-people card-icon text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Revenue</h6>
                                <h2 class="text-success">₹<?= number_format($totalRevenue); ?></h2>
                            </div>
                            <i class="bi bi-currency-rupee card-icon text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="container mt-5">

    <h3 class="mb-3">📦 Recent Orders (Admin)</h3>

    <table class="table table-bordered table-striped shadow">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total</th>
                <th>Order Status</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($query)) { 
        ?>
            <tr>
                <td><?= $i++; ?></td>

                <td><?= $row['Product_name'] ?? 'Unknown'; ?></td>

                <td><?= $row['Customer_name']; ?></td>

                <td><?= $row['Customer_email']; ?></td>

                <td><?= $row['Customer_address']; ?></td>

                <td class="fw-bold text-success">
                    ₹<?= $row['Total_amount']; ?>
                </td>

                <td>
                    <span class="badge bg-info">
                        <?= $row['Order_Status']; ?>
                    </span>
                </td>

                <td>
                    <span class="badge bg-success">
                        <?= $row['Payment_status']; ?>
                    </span>
                </td>

                <td><?= $row['Payment_method'] ?? 'Not Paid'; ?></td>

                <td><?= $row['Created_at']; ?></td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>


        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>