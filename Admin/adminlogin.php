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
    <link href="/ecom/css/adminlogin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card login-card">
                <div class="row g-0">

                    <!-- Left Side -->
                    <div class="col-md-5 left-panel d-flex flex-column justify-content-center text-center">
                        <h1>Hello Admin !</h1>
                        <p>Welcome back 👋  
                           Login to continue your journey 🚀</p>
                    </div>

                    <!-- Right Side -->
                    <div class="col-md-7 right-panel">
                        <h3 class="text-center text-primary mb-4 fw-bold">Admin Login</h3>

                        <form action="adminlogin.php" method="POST">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email Address" name="usermail">
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="userpassword">
                            </div>

                            <div class="d-flex justify-content-end mb-3">

                                <a href="#" class="text-decoration-none">Forgot password?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-login py-2" name="submit">
                                    Login
                                </button>
                            </div>
                        </form>
                        <?php
                    $servername="localhost";
                    $username="root";
                    $password="";
                    $dbname="project";

                    $conn=new mysqli($servername,$username,$password,$dbname);

                    if(!$conn)
                        {
                            die("couldnot connect".mysqli_error());
                        }

                        if(isset($_POST['submit']))
                            {
                                $user=$_POST['usermail'];
                                $pass=$_POST['userpassword'];
                                $sql="SELECT * FROM admin where email='$user' and password='$pass'";
                                $query_run=mysqli_query($conn,$sql);
                                
                                if(mysqli_num_rows($query_run)==1)
                                    {
                                        $_SESSION['access']=$user;
                                        echo "<script>window.open('dashboard.php','_self')</script>";
                                    }
                            else{
                                $iun="Invalid User";
                                echo "<script>
                                alert('$iun');
                                </script>";
                            }
                        }
            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>