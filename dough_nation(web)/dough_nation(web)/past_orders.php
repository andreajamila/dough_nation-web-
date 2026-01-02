<?php
include "conn.php";
session_start();

if(!isset($_SESSION['cust_id'])){
    header("Location: landing_page.php");
    exit;
}

$cust_id = $_SESSION['cust_id'];

$orders = mysqli_query($conn,"
    SELECT * FROM orders
    WHERE cust_id='$cust_id'
    AND status != 'Pending'
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

/* Past Order Card */
.card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Order header: Pickup above Status */
.card .order-header {
    display: flex;
    flex-direction: column; /* stack vertically */
    align-items: flex-start; /* left align */
    gap: 5px; /* small space between pickup and status */
    margin-bottom: 15px;
}

.card .order-header p {
    margin: 0;
    font-weight: 500;
    color: #333;
}

/* Items grid */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.items-grid .item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.items-grid img {
    width: 100%;
    max-width: 250px;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 8px;
}

.items-grid p {
    margin: 4px 0 2px 0;
    font-weight: 500;
}

.items-grid small {
    color: #555;
}
</style>

<div class="container">
    <h2>Past Orders</h2>

    <?php while($order = mysqli_fetch_assoc($orders)): ?>
        <div class="card">
            <!-- Pickup above Status -->
            <div class="order-header">
                <p><strong>Pickup:</strong> <?= $order['pickup_date'] ?> <?= $order['pickup_time'] ?></p>
                <p><strong>Status:</strong> <?= $order['status'] ?></p>
            </div>

            <div class="items-grid">
                <?php
                $items = mysqli_query($conn,"
                    SELECT oi.quantity, p.product_name, p.image_url
                    FROM order_items oi
                    JOIN product p ON oi.product_id = p.product_id
                    WHERE oi.order_id='{$order['order_id']}'
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
        </div>
    <?php endwhile; ?>
</div>

<?php include "footer.php"; ?>
