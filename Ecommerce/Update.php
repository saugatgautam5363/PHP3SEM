<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    $sql = "UPDATE products SET name='$name', price='$price', quantity='$quantity', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <h2>Edit Product</h2>
    <form method="post">
        <label>Name:</label> <input type="text" name="name" value="<?= $product['name'] ?>" required><br>
        <label>Price:</label> <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"
            required><br>
        <label>Quantity:</label> <input type="number" name="quantity" value="<?= $product['quantity'] ?>" required><br>
        <label>Description:</label> <textarea name="description"><?= $product['description'] ?></textarea><br>
        <input type="submit" value="Update Product">
    </form>
</body>

</html>