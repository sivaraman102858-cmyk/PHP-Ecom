<?php
$conn = mysqli_connect("localhost", "root", "", "project");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM product WHERE id='$id'"));

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    mysqli_query($conn, "UPDATE product SET 
        Product_name='$name',
        Product_price='$price',
        Description='$desc'
        WHERE id='$id'");

    header("Location: viewproduct.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">
<h2>Edit Product</h2>

<form method="POST">
    <input type="text" name="name" class="form-control mb-2" value="<?= $data['Product_name']; ?>" required>
    <input type="text" name="price" class="form-control mb-2" value="<?= $data['Product_price']; ?>" required>
    <textarea name="description" class="form-control mb-2"><?= $data['Description']; ?></textarea>

    <button name="update" class="btn btn-success">Update Product</button>
</form>
</div>
</body>
</html>