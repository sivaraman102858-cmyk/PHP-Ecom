<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:adminlogin.php');
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
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="addproduct.php"><i class="bi bi-box"></i>Add Products</a>
            <a href="viewproduct.php"><i class="bi bi-box"></i>View Products</a>
            <a href="admin_orders.php" class="active"><i class="bi bi-cart"></i> Orders</a>
            <a href="viewusers.php"><i class="bi bi-people"></i> Users</a>
            <a href="adminlogout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
             <!---------------Php Connection--------------------->
<?php
$conn = mysqli_connect("localhost", "root", "", "project");

$query = mysqli_query($conn,
    "SELECT orders.*, product.product_name 
    FROM orders 
    LEFT JOIN product ON orders.Product_id = product.id 
    ORDER BY orders.Created_at DESC");


// Update order/payment status
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $order_status = $_POST['Order_Status'];
    $payment_status = $_POST['payment_status'];

    mysqli_query($conn, 
        "UPDATE orders SET 
            Order_Status = '$order_status',
            Payment_status = '$payment_status'
        WHERE id = '$id'"
    );
}
?>
                    <!---------------Php Connection End--------------------->
                    <div class="container mt-5">
    <h3 class="mb-3">📦 Admin Orders Panel</h3>

    <table class="table table-bordered table-hover">
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Product</th>
            <th>Total</th>
            <th>Address</th>
            <th>Order Status</th>
            <th>Payment Status</th>
            <th>Payment Method</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php $i=1; while($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $row['Customer_name']; ?></td>
            <td><?= $row['Customer_email']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td>₹<?= $row['Total_amount']; ?></td>
            <td><?= $row['Customer_address']; ?></td>

            <td>
                <span class="badge bg-warning"><?= $row['Order_Status']; ?></span>
            </td>

            <td>
                <span class="badge bg-success"><?= $row['Payment_status']; ?></span>
            </td>

            <td><?= $row['Payment_method']; ?></td>
            <td><?= $row['Created_at']; ?></td>

            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">

                    <select name="Order_Status" class="form-select form-select-sm mb-1">
                        <option <?= $row['Order_Status']=="Pending"?"selected":"" ?>>Pending</option>
                        <option <?= $row['Order_Status']=="Processing"?"selected":"" ?>>Processing</option>
                        <option <?= $row['Order_Status']=="Shipped"?"selected":"" ?>>Shipped</option>
                        <option <?= $row['Order_Status']=="Delivered"?"selected":"" ?>>Delivered</option>
                        <option <?= $row['Order_Status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
                    </select>

                    <select name="payment_status" class="form-select form-select-sm mb-1">
                        <option <?= $row['Payment_status']=="Pending"?"selected":"" ?>>Pending</option>
                        <option <?= $row['Payment_status']=="Paid"?"selected":"" ?>>Paid</option>
                        <option <?= $row['Payment_status']=="Failed"?"selected":"" ?>>Failed</option>
                    </select>

                    <button name="update" class="btn btn-sm btn-success w-100">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>