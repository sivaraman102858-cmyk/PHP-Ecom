
<?php
$conn = mysqli_connect("localhost", "root", "", "sivaraman");

if(isset($_POST['login'])){
$email=$_POST['email'];
$pass=$_POST['password'];

$q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$user=mysqli_fetch_assoc($q);

if($user && password_verify($pass,$user['password'])){
if($user['is_verified']==0) die("Verify Email First");
echo "Login Success";
} else echo "Login Failed";
}
?>
<form method="POST">
<input name="email" type="email" placeholder="Email" required><br>
<input name="password" type="password" placeholder="Password" required><br>
<button name="login">Login</button>
</form>
