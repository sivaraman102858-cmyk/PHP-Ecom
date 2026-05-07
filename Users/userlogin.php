<?php  session_start();
if(isset($_SESSION['access'])){
  header('location:dashboard.php');
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
    <link href="/ecom/css/userlogin.css" rel="stylesheet">
</head>
<body>
    <div class="login-card">
    <h3 class="mb-4">Welcome Back 👋</h3>

    <form action="userlogin.php" method="POST">
        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent text-white border-0">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" class="form-control" placeholder="Enter your email" name="usermail" required>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent text-white border-0">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" class="form-control" placeholder="Enter your password" name="userpassword" required>
            </div>
        </div>

        <!-- Remember + Forgot -->
        <div class="d-flex justify-content-end mb-3">
            <a href="#" class="link-text">Forgot password?</a>
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-login w-100 text-white" name="submit">
            Login
        </button>

        <!-- Signup -->
        <p class="text-center mt-4">
            Don’t have an account? <a href="usersignup.php" class="link-text fw-bold">Sign up</a>
        </p>
    </form>
</div>

<!---------------Php Connection----------------->
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $user = $_POST['usermail'];
    $pass = $_POST['userpassword'];

    $sql = "SELECT * FROM users WHERE Email='$user' AND Password='$pass'";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) == 1) {

        $row = mysqli_fetch_assoc($query_run);

        // ✅ Save user session
        $_SESSION['user_email'] = $row['Email'];
        $_SESSION['user_name'] = $row['Name'];

        // Redirect to profile
        $_SESSION['access']=$user;
        header("Location: dashboard.php");
        exit();

    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>


<!---------------Php Connection End----------------->
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