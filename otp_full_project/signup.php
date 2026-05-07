
<?php
$conn = mysqli_connect("localhost", "root", "", "sivaraman");

if(isset($_POST['signup'])){
$name=$_POST['name'];
$email=$_POST['email'];
$pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
$otp=rand(100000,999999);

$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
if(mysqli_num_rows($check)>0){
$error="Email already exists";
} else {
mysqli_query($conn,"INSERT INTO users(name,email,password,otp) VALUES('$name','$email','$pass','$otp')");
mail($email,"OTP Verification","Your OTP: $otp");
header("Location: verify.php?email=$email");
exit;
}
}
?>
<form method="POST">
<input name="name" placeholder="Name" required><br>
<input name="email" type="email" placeholder="Email" required><br>
<input name="password" type="password" placeholder="Password" required><br>
<button name="signup">Signup</button>
</form>
<?php if(isset($error)) echo $error; ?>
