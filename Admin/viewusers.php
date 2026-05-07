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
            <a href="admin_orders.php"><i class="bi bi-cart"></i> Orders</a>
            <a href="viewusers.php" class="active"><i class="bi bi-people"></i> Users</a>
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

// Fetch all users
$query = mysqli_query($conn, "
    SELECT * FROM users 
    ORDER BY id DESC
");
?>

<!--------------------------Php Connection End--------------------->
<div class="container mt-5">

    <h3 class="mb-3">👤 All Users</h3>

    <table class="table table-bordered table-striped shadow">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Created Date</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($query)) { 
        ?>
            <tr>
                <td><?= $i++; ?></td>

                <td><?= $row['Name']; ?></td>

                <td><?= $row['Email']; ?></td>

                <td><?= $row['Mobile']; ?></td>

                <td><?= $row['Address'] ?? 'N/A'; ?></td>

                <td><?= $row['Created_at'] ?? 'N/A'; ?></td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>