<?php
require_once('dbconfig.inc.php');
require_once('product.php');

if (!isset($_GET['id'])) {
    die("no product id");
}

$product_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("the product is not found");
}

$product = new Product(
    $row['id'],
    $row['name'],
    $row['category'],
    $row['description'],
    $row['price'],
    $row['rating'],
    $row['image'],
    $row['quantity']
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details - <?php echo htmlspecialchars($row['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="main-header">
        <h1>
            E-Clothing Store 
            <img src="images/store.png" alt="Store" width="42" height="42">
        </h1>
        <nav>
            <a href="products.php" class="pagination-btn">← Back to Products</a>
        </nav>
    </header>

    <div class="view-wrapper">
        <main class="product-details-page">
            <?php echo $product->displayProductPage(); ?>
        </main>
    </div>

    <footer class="main-footer">
        <p>&copy; 2025 E-Clothing Store | <a href="contact.html" style="color: #fff;">Contact Us</a></p>
    </footer>
</body>
</html>
