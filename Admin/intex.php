<?php
session_start();

if(!isset($_SESSION['access'])){
    header("Location: adminlogin.php");
    exit();
}
?>

<h2>Admin Home</h2>
<a href="dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
