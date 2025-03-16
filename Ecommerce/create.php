<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    $sql = "INSERT INTO products (name, price, quantity, description) VALUES ('$name', '$price', '$quantity', '$description')";
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
    <title>Add Product</title>
</head>

<body>
    <h2>Add New Product</h2>
    <form method="post">
        <label>Name:</label> <input type="text" name="name" required><br>
        <label>Price:</label> <input type="number" step="0.01" name="price" required><br>
        <label>Quantity:</label> <input type="number" name="quantity" required><br>
        <label>Description:</label> <textarea name="description"></textarea><br>
        <input type="submit" value="Add Product">
    </form>
</body>

</html>