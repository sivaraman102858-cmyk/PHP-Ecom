
<?php
include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if(isset($_POST['signup'])){
$name=$_POST['name'];
$email=$_POST['email'];
$password=password_hash($_POST['password'], PASSWORD_DEFAULT);
$otp=rand(100000,999999);

$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
if(mysqli_num_rows($check)>0){
$error="Email already exists!";
} else {

mysqli_query($conn,"INSERT INTO users(name,email,password,otp) VALUES('$name','$email','$password','$otp')");

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'YOUR_EMAIL@gmail.com';
$mail->Password = 'APP_PASSWORD';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('YOUR_EMAIL@gmail.com', 'OTP System');
$mail->addAddress($email);
$mail->Subject = "Email OTP Verification";
$mail->Body = "Your OTP Code is: $otp";

$mail->send();

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
