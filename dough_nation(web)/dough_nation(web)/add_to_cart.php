<?php
session_start();
require 'conn.php';

$product_id = $_GET['id'] ?? 0;

// Use the correct column name: product_id
$stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) die("Product not found.");

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty'] += 1;
} else {
    $_SESSION['cart'][$product_id] = [
        'product' => $product,
        'qty' => 1
    ];
}

header('Location: index.php');
exit;
