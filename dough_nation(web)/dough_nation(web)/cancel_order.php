<?php
include "conn.php";

$order_id = $_GET['id'];

// Cancel the order
mysqli_query($conn, "UPDATE orders SET status='Cancelled' WHERE order_id='" . mysqli_real_escape_string($conn, $order_id) . "'");

// Get order items
$items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='" . mysqli_real_escape_string($conn, $order_id) . "'");
while($row = mysqli_fetch_assoc($items)){
    $product_id = mysqli_real_escape_string($conn, $row['product_id']);
    $quantity = (int) $row['quantity']; // ensure quantity is numeric
    mysqli_query($conn, "UPDATE product_inventory
        SET stock = stock + $quantity
        WHERE product_id='$product_id'");
}

header("Location: your_orders.php");
exit;
?>
