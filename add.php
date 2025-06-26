<?php
require_once('dbconfig.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $rating = $_POST['rating'];

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("File upload error: " . $file['error']);
        }

        $allowedExtensions = ['jpg', 'jpeg'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Only JPEG images are accepted");
        }

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO products (name, category, description, price, quantity, rating) 
                                  VALUES (:name, :category, :description, :price, :quantity, :rating)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':rating', $rating);
            $stmt->execute();

            $productId = $pdo->lastInsertId();
            $imageName = $productId . '.jpeg';

            if (move_uploaded_file($file['tmp_name'], 'images/' . $imageName)) {
                $stmt = $pdo->prepare("UPDATE products SET image = :image WHERE id = :id");
                $stmt->bindParam(':image', $imageName);
                $stmt->bindParam(':id', $productId);
                $stmt->execute();

                $pdo->commit();
                header("Location: products.php");
                exit();
            } else {
                throw new Exception("Error moving uploaded file.");
            }
        } catch (Exception $e) {
            $pdo->rollback();
            die("Error: " . $e->getMessage());
        }
    } else {
        die("Please upload an image.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="main-header">
    <h1>Add New Product</h1>
</header>

<div class="container">
    <aside class="search-panel">
        <a class="add-product-btn" href="products.php">← Back to Products</a>
    </aside>

    <main>
        <section class="add-form-container">
            <form method="POST" enctype="multipart/form-data" action="add.php" class="search-form">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>

                <label for="category">Category:</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="T-Shirts">T-Shirts</option>
                    <option value="Jeans">Jeans</option>
                    <option value="Jackets">Jackets</option>
                    <option value="Activewear">Activewear</option>
                    <option value="Blouses">Blouses</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Bags">Bags</option>
                    <option value="Shoes">Shoes</option>
                    <option value="Dungarees">Dungarees</option>
                </select>

                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" required>

                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" required>

                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" min="1" max="5" required>

                <label for="description">Description:</label>
                <textarea name="description" rows="4" required></textarea>

                <label for="image">Product Photo (JPEG only):</label>
                <input type="file" name="image" accept="image/jpeg" required>

                <input type="submit" value="Insert">
            </form>
        </section>
    </main>
</div>

<footer class="main-footer">
    <p>&copy; 2025 E-Clothing Store | <a href="contact.html">Contact Us</a></p>
</footer>
</body>
</html>
