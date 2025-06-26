<?php
session_start();
require_once ('dbconfig.inc.php');

$name = $_GET['name'] ?? '';
$category = $_GET['category'] ?? '';
$maxPrice = $_GET['maxPrice'] ?? '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM products WHERE 1";
$params = [];
if ($name !== '') {
    $sql .= " AND name LIKE :name";
    $params['name'] = "%$name%";
}
if ($category !== '') {
    $sql .= " AND category = :category";
    $params['category'] = $category;
}
if ($maxPrice !== '') {
    $sql .= " AND price <= :maxPrice";
    $params['maxPrice'] = $maxPrice;
}
$sql .= " LIMIT :offset, :limit";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(":$key", $value);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

$countSql = "SELECT COUNT(*) FROM products WHERE 1";
$countParams = [];
if ($name !== '') {
    $countSql .= " AND name LIKE :name";
    $countParams['name'] = "%$name%";
}
if ($category !== '') {
    $countSql .= " AND category = :category";
    $countParams['category'] = $category;
}
if ($maxPrice !== '') {
    $countSql .= " AND price <= :maxPrice";
    $countParams['maxPrice'] = $maxPrice;
}
$countStmt = $pdo->prepare($countSql);
foreach ($countParams as $key => $value) {
    $countStmt->bindValue(":$key", $value);
}
$countStmt->execute();
$totalProducts = $countStmt->fetchColumn();
$totalPages = ceil($totalProducts / $perPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Listing</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="main-header">
    <h1>E-Clothing Store</h1>
</header>

<div class="container">
    <aside class="search-panel">
        <form class="search-form" method="GET">
            <input type="text" name="name" placeholder="Product Name" value="<?= htmlspecialchars($name) ?>">
            <input type="number" name="maxPrice" placeholder="Max Price" value="<?= htmlspecialchars($maxPrice) ?>">
            <select name="category">
                <option value="">All Categories</option>
                <?php
                $categories = ['Shoes', 'T-Shirts', 'Jeans', 'Dungarees', 'Blouses', 'Bags', 'Jackets', 'Activewear', 'Accessories'];
                foreach ($categories as $cat) {
                    $selected = ($cat === $category) ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select>
            <button type="submit">Filter</button>
            <a href="add.php" class="add-product-btn">Add a new product</a>
        </form>
    </aside>

    <main class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img class="product-image" src="images/<?= htmlspecialchars($product['image']) ?>" alt="Product image">
                <div class="product-id">Product #<?= $product['id'] ?></div>
                <div class="tooltip-wrapper">
                    <div tabindex="0" class="product-name"> <?= htmlspecialchars($product['name']) ?> </div>
                    <div class="tooltip">
                        <section>
                            <h2 class="<?= $product['quantity'] <= 5 ? 'low-stock' : 'normal-stock' ?>">
                                Quantity: <?= $product['quantity'] ?>
                            </h2>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                        </section>
                    </div>
                </div>
                <span class="product-category">Category: <?= htmlspecialchars($product['category']) ?> </span>
                <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                <nav class="product-buttons">
                    <a class="add-to-cart-btn" href="addToCart.php?id=<?= $product['id'] ?>">Add to Cart</a>
                    <a class="view-prod-btn" href="view.php?id=<?= $product['id'] ?>">View This Product</a>
                    <a class="edit-product-btn" href="editProduct.php?id=<?= $product['id'] ?>">Edit This Product</a>
                     <a class="view-btn" href="delete.php?id=<?= $product['id'] ?>">Delete This Product</a>
                </nav>
            </div>
        <?php endforeach; ?>

        <nav class="pagination-bar">
            <a class="pagination-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">Previous</a>
            <a class="pagination-btn <?= $page >= $totalPages ? 'disabled' : '' ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Next</a>
        </nav>
    </main>
</div>

<footer class="main-footer">
    <p>&copy; <?= date('Y') ?> E-Clothing Store. All rights reserved.</p>
</footer>
</body>
</html>
