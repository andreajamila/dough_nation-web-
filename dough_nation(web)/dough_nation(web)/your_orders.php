<?php
include "conn.php";
session_start();

if(!isset($_SESSION['cust_id'])){
    header("Location: landing_page.php");
    exit;
}

$cust_id = $_SESSION['cust_id'];

// Only select pending orders
$orders = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE cust_id='$cust_id' AND status='Pending'
    ORDER BY order_id DESC
");

include "header.php";
?>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0;
}

.container {
    width: 95%;
    max-width: 1600px;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    text-align: start;
    margin-bottom: 25px;
}

/* Order Card */
.card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Order Header */
.card .order-header {
    display: flex;
    flex-direction: column;  
    align-items: flex-start;
    margin-bottom: 15px;
}

.card .order-header p {
    margin: 4px 0;
    font-weight: 500;
    color: #333;
    text-align: left;
}

/* Items grid inside order */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 10px;
}

.items-grid .item {
    display: flex;
    flex-direction: column;
    align-items: center; 
    text-align: center;
}

.items-grid img {
    width: 100%;
    max-width: 300px;
    height: 180px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 5px; 
}

.items-grid p {
    margin: 4px 0 2px 0;
    font-weight: 500;
}

.items-grid small {
    color: #555;
    display: block;
    margin-bottom: 5px;
}

/* Buttons */
.card .order-actions { 
    margin-top: 10px; 
    display: flex;
    justify-content: flex-start; 
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    color: #fff;
    text-align: center;
    transition: background 0.2s;
    margin-right: 10px; 
    margin-bottom: 5px; 
}

.btn-warning { background: #ff9800; }
.btn-warning:hover { background: #e68900; }

.btn-danger { background: #f44336; }
.btn-danger:hover { background: #d32f2f; }

.text-center {
    text-align: center;
}
</style>

<div class="container">
    <h2>Your Pending Orders</h2>

    <?php 
    $hasOrders = false;
    while($order = mysqli_fetch_assoc($orders)):
        $hasOrders = true;
    ?>
        <div class="card">
            <div class="order-header">
                <p><strong>Pickup:</strong> <?= $order['pickup_date'] ?> <?= $order['pickup_time'] ?></p>
                <p><strong>Status:</strong> <?= $order['status'] ?></p>
            </div>

            <div class="items-grid">
    <?php
    $items = mysqli_query($conn, "
        SELECT oi.quantity, p.product_name, p.image_url 
        FROM order_items oi
        JOIN product p ON oi.product_id = p.product_id
        WHERE oi.order_id = '{$order['order_id']}'
    ");
    while($item = mysqli_fetch_assoc($items)):
    ?>
        <div class="item">
            <img src="<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
            <p><?= $item['product_name'] ?></p>
            <small>Qty: <?= $item['quantity'] ?></small>
        </div>
    <?php endwhile; ?>
</div>

<div class="order-actions">
    <a href="edit_order.php?id=<?= $order['order_id'] ?>" class="btn btn-warning">Edit Order</a>
    <a href="cancel_order.php?id=<?= $order['order_id'] ?>" class="btn btn-danger"
       onclick="return confirm('Cancel this order?');">Cancel Order</a>
</div>

        </div>
    <?php endwhile; ?>

    <?php if(!$hasOrders): ?>
        <p class="text-center">🛒 You have no pending orders.</p>
    <?php endif; ?>
</div>

<?php include "footer.php"; ?>
