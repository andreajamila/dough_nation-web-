<?php
include "conn.php";
session_start();

$cust_id = $_SESSION['cust_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$pickup_date = $_POST['pickup_date'];
$pickup_time = $_POST['pickup_time'];
$price = $_POST['price'];

mysqli_query($conn,"INSERT INTO orders (cust_id,pickup_date,pickup_time)
VALUES ('$cust_id','$pickup_date','$pickup_time')");

$order_id = mysqli_insert_id($conn);

$total = $quantity * $price;

mysqli_query($conn,"INSERT INTO order_items (order_id,product_id,quantity,price)
VALUES ('$order_id','$product_id','$quantity','$total')");

mysqli_query($conn,"UPDATE product_inventory
SET stock = stock - $quantity
WHERE product_id = $product_id");

echo json_encode([
    "status"=>"success",
    "message"=>"Order placed successfully"
]);
?>
