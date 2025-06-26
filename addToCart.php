<?php
session_start();
require_once('dbconfig.inc.php');

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<h2>Product not found.</h2>";
        echo '<a href="products.php" class="button">Back to Products</a>';
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1 class="cart-heading">Your Shopping Cart</h1>
    <table class="cart-table">
        <tr>
            <th>Title</th>
            <th>Price ($)</th>
            <th>Quantity</th>
            <th>Subtotal ($)</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $item): 
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($subtotal, 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="cart-total">
            <td colspan="3">Total</td>
            <td><?= number_format($total, 2) ?></td>
        </tr>
    </table>

    <a href="products.php" class="button">Continue Shopping</a>
</body>
</html>
