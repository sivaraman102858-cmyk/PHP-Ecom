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
<!---------------Php Connection----------------->
<?php

$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Database connection failed");
}


$useremail = $_SESSION['user_email'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE Email='$useremail'");
$user = mysqli_fetch_assoc($query);
?>
<!---------------Php Connection End----------------->

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
                        <a href="my_profile.php" class="nav-link active">
                            <i class="bi bi-person"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="my_orders.php" class="nav-link">
                            <i class="bi bi-box-seam"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cart.php" class="nav-link">
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
            <div class="container mt-5">
    <div class="card shadow p-4">

        <h3 class="mb-3">Welcome, <?= $user['Name']; ?> 👋</h3>

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td><?= $user['Name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $user['Email']; ?></td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td><?= $user['Mobile']; ?></td>
            </tr>
            <tr>
    <th>Address</th>
    <td><?= $user['Address']; ?></td>
</tr>
<tr>
    <th>Pincode</th>
    <td><?= $user['Pincode']; ?></td>
</tr>

        </table>

        <div class="mt-3">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="userlogout.php" class="btn btn-danger">Logout</a>
        </div>

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