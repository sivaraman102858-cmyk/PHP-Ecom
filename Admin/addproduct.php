<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:adminlogin.php');
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
    <link href="/ecom/css/admindashboard.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">
            <h4 class="text-center text-white py-3">Admin Panel</h4>
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="addproduct.php" class="active"><i class="bi bi-box"></i>Add Products</a>
            <a href="viewproduct.php"><i class="bi bi-box"></i>View Products</a>
            <a href="admin_orders.php"><i class="bi bi-cart"></i> Orders</a>
            <a href="viewusers.php"><i class="bi bi-people"></i> Users</a>
            <a href="adminlogout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">➕ Add New Product</h5>
                </div>

                <div class="card-body">

                    <form action="addproduct.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="product_image" class="form-control" required>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-dark w-100">
                            💾 Save Product
                        </button>
                    </form>

                    <!---------------Php Connection--------------------->
<?php

if(isset($_POST["add_product"]) && !empty($_FILES["product_image"]["name"])) {

$product_name  = $_POST['product_name'];
$price         = $_POST['price'];
$category      = $_POST['category'];
$description   = $_POST['description'];
   
$statusMsg = '';
$targetDir = "../uploads/";
$uniquesavename=time().uniqid(rand());
$fileName = basename($_FILES["product_image"]["name"]);

$Image=$uniquesavename . $fileName;
$targetFilePath = $targetDir . $Image;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);


    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    if(in_array($fileType, $allowTypes))
        {
         $db = mysqli_connect("localhost", "root", "", "project");

     $sql = "INSERT INTO product (Product_name,Product_price,Product_category,Description,Product_image) VALUES ('".$product_name."','".$price."','".$category."','".$description."','".$Image."')";

     mysqli_query($db, $sql);
        if(move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)){

            echo "<script>alert('New record created successfully');</script>";
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

echo $statusMsg;
?>

<!---------------Php Connection End----------------->

                </div>
            </div>

        </div>
    </div>
</div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>