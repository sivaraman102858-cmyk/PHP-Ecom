<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:userlogin.php');
}

?>

<?php

$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Database connection failed");
}

// Check login
if (!isset($_SESSION['user_email'])) {
    header("Location: userlogin.php");
    exit();
}

$useremail = $_SESSION['user_email'];

// Fetch user data
$query = mysqli_query($conn, "SELECT * FROM users WHERE Email='$useremail'");
$user = mysqli_fetch_assoc($query);

// Update profile
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];

    $update = mysqli_query($conn, 
        "UPDATE users SET 
            Name='$name', 
            Email='$email', 
            Mobile='$mobile', 
            Address='$address', 
            Pincode='$pincode' 
        WHERE Email='$useremail'"
    );

    if ($update) {
        $_SESSION['user_email'] = $email;
        echo "<script>alert('Profile Updated Successfully'); window.location='my_profile.php';</script>";
    } else {
        echo "<script>alert('Update Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4 col-md-7 mx-auto">

        <h3 class="mb-3 text-center">Edit Profile ✏️</h3>

        <form method="POST">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" 
                       value="<?= $user['Name']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= $user['Email']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" 
                       value="<?= $user['Mobile']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3" required><?= $user['Address']; ?></textarea>
            </div>

            <div class="mb-3">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" 
                       value="<?= $user['Pincode']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-success w-100">
                Update Profile
            </button>

            <a href="my_profile.php" class="btn btn-secondary w-100 mt-2">
                Cancel
            </a>

        </form>

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
</html>
