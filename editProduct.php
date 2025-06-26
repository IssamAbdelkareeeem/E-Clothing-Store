<?php
require_once('dbconfig.inc.php');
require_once('product.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE products SET name = :name, price = :price, quantity = :quantity, description = :description WHERE id = :id");
    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':quantity' => $quantity,
        ':description' => $description,
        ':id' => $id
    ]);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedExtensions = ['jpg', 'jpeg'];
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $image_path = "images/$id.jpeg";
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $stmt = $pdo->prepare("UPDATE products SET image = :image WHERE id = :id");
                $stmt->execute([':image' => "$id.jpeg", ':id' => $id]);
            } else {
                die("Error uploading image.");
            }
        } else {
            die("Only JPEG images are accepted.");
        }
    }

    echo "<p>Product updated successfully. <a href='products.php'>Back to Products</a></p>";
    exit;
}

if (!isset($_GET['id'])) {
    die("No product ID provided.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="containerEdit">
    <h1>Edit Product</h1>
    <form method="POST" action="editProduct.php" enctype="multipart/form-data" class="product-form">
        <div class="form-group">
            <label>Product ID:</label>
            <input type="text" value="<?= $row['id']; ?>" disabled>
            <input type="hidden" name="id" value="<?= $row['id']; ?>">
        </div>

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Category:</label>
            <input type="text" value="<?= htmlspecialchars($row['category']); ?>" disabled>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" value="<?= $row['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="<?= $row['quantity']; ?>" required>
        </div>

        <div class="form-group">
            <label>Rating:</label>
            <input type="number" value="<?= $row['rating']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" rows="6" required><?= htmlspecialchars($row['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Product Photo (JPEG):</label>
            <input type="file" name="image" accept="image/jpeg">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
