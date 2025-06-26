<?php

require_once('dbconfig.inc.php');

if (!isset($_GET['id'])) {
    die("no product id");
}

$product_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("product not found");
}

$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();


header("Location: products.php");
exit();
?>
