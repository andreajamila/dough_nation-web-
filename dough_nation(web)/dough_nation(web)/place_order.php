<?php
session_start();
include "conn.php";

if(!isset($_SESSION['cust_id']) || empty($_SESSION['cart'])){
    header("Location: index.php");
    exit;
}

$cust_id = $_SESSION['cust_id'];
$date = $_POST['pickup_date'] ?? null;
$time = $_POST['pickup_time'] ?? null;

if(!$date || !$time){
    die("Pickup date and time are required.");
}

// Insert order
mysqli_query($conn, "INSERT INTO orders (cust_id, pickup_date, pickup_time, status) VALUES ('$cust_id', '$date', '$time', 'Pending')");
$order_id = mysqli_insert_id($conn);

foreach($_SESSION['cart'] as $pid => $item){
    $qty = $item['qty'];
    $price = $item['product']['price'];   // correct key
    $total = $qty * $price;

    // Insert order item
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$pid', '$qty', '$total')");

    // Update stock
    mysqli_query($conn, "UPDATE product_inventory SET stock = stock - $qty WHERE product_id = '$pid'");
}

// Clear cart
unset($_SESSION['cart']);

header("Location: your_orders.php");
exit;
