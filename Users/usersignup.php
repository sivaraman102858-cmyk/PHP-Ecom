<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="/ecom/css/usersignup.css" rel="stylesheet">
</head>
<body>
    <div class="signup-card">
    <h3 class="text-center mb-4">Create Account 🚀</h3>

    <form action="usersignup.php" method="POST" onsubmit="return validateForm()">

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="username" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email" name="usermail" required>
        </div>

        <!-- Mobile -->
        <div class="mb-3">
            <label class="form-label">Mobile Number</label>
            <input type="tel" class="form-control" id="mobile" placeholder="Enter mobile number" name="usernumber" pattern="[0-9]{10}" required>
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Create password" name="userpassword" onkeyup="checkStrength()" required>
        </div>

        <small id="strengthMsg" class="d-block mb-3"></small>

        <!-- Confirm Password -->
        <div class="mb-2">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" onkeyup="checkMatch()" required>
        </div>

        <small id="matchMsg" class="d-block mb-3"></small>

        <!-- Button -->
        <button type="submit" class="btn btn-signup w-100 text-white" name="submit">
            Sign Up
        </button>

    </form>
    <p class="text-center mt-4">
        Already have an account? 
        <a href="userlogin.php" class="login-link fw-bold text-decoration-none"> Login </a> Here
    </p>
</div>

<!---------------Php Connection----------------->

<?php
if(isset($_POST['submit']))
                {
                    $Name=$_POST['username'];
                    $Email=$_POST['usermail'];
                    $Mobile=$_POST['usernumber'];
                    $Password=$_POST['userpassword'];

                    $servername="localhost";
                    $username="root";
                    $password="";
                    $dbname="project";

                    $conn=new mysqli($servername,$username,$password,$dbname);

                    if($conn->connect_error)
                        {
                            die("Connection failed:".$conn->connect_error);
                        }

                        $check = "SELECT Email FROM users WHERE Email='$Email'";
                        $result = $conn->query($check);

                        if ($result->num_rows > 0) 
                            {
                                echo "<script>alert('This email is already registered. Please login!');</script>";
                            }
                        else
                            {
                                $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

                        $sql="INSERT INTO users (Name,Email,Mobile,Password)VALUES('".$Name."','".$Email."','".$Mobile."','".$Password."')";
                        if($conn->query($sql) === TRUE)
                            {
                                $mess="Your Account Created successfully..!";
                                echo "<script>
                                alert('$mess');
                                </script>";
                            }
                            else{
                                echo "Error:".$sql."<br>".$conn_error;
                            }
                }
                }
            ?>
<!---------------Php Connection End----------------->

<script>
// Password Strength Checker
function checkStrength() {
    let password = document.getElementById("password").value;
    let strengthMsg = document.getElementById("strengthMsg");

    let strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    let mediumRegex = /(?=.*[A-Za-z])(?=.*[0-9])/;

    if (password.length < 6) {
        strengthMsg.textContent = "Weak Password ❌";
        strengthMsg.className = "weak";
    } 
    else if (strongRegex.test(password)) {
        strengthMsg.textContent = "Strong Password 💪";
        strengthMsg.className = "strong";
    } 
    else if (mediumRegex.test(password)) {
        strengthMsg.textContent = "Medium Password ⚡";
        strengthMsg.className = "medium";
    } 
    else {
        strengthMsg.textContent = "Weak Password ❌";
        strengthMsg.className = "weak";
    }
}

// Confirm Password Match
function checkMatch() {
    let pass = document.getElementById("password").value;
    let confirm = document.getElementById("confirmPassword").value;
    let matchMsg = document.getElementById("matchMsg");

    if (confirm === "") {
        matchMsg.textContent = "";
    } 
    else if (pass === confirm) {
        matchMsg.textContent = "Passwords Match ✅";
        matchMsg.style.color = "#00ff99";
    } 
    else {
        matchMsg.textContent = "Passwords Do Not Match ❌";
        matchMsg.style.color = "#ff4d4d";
    }
}

// Final Validation
function validateForm() {
    let pass = document.getElementById("password").value;
    let confirm = document.getElementById("confirmPassword").value;

    if (pass !== confirm) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>
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