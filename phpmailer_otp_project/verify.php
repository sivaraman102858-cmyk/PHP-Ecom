
<?php
include 'config.php';
$email=$_GET['email'];

if(isset($_POST['verify'])){
$otp=$_POST['otp'];

$q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND otp='$otp'");

if(mysqli_num_rows($q)>0){
mysqli_query($conn,"UPDATE users SET is_verified=1 WHERE email='$email'");
echo "Email Verified! Login now.";
} else {
echo "Invalid OTP";
}
}
?>

<form method="POST">
<input name="otp" placeholder="Enter OTP" required><br>
<button name="verify">Verify OTP</button>
</form>
