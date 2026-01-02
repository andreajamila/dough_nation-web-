<?php
session_start();
include "conn.php";
$cust_id = $_SESSION['cust_id'];

$result = mysqli_query($conn,
    "SELECT * FROM orders WHERE cust_id = '$cust_id' ORDER BY created_at DESC"
);
?>

<h2>Your Orders</h2>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<div class="card mb-3 p-3">
    <p>Order #<?= $row['order_id'] ?></p>
    <p>Pickup: <?= $row['pickup_date'] ?> @ <?= $row['pickup_time'] ?></p>
    <p>Total: ₱<?= number_format($row['total_price'],2) ?></p>
    <p>Status: <strong><?= $row['status'] ?></strong></p>

    <?php if ($row['status'] == 'pending'): ?>
        <a href="cancel_order.php?id=<?= $row['order_id'] ?>"
           class="btn btn-danger btn-sm">Cancel</a>
    <?php endif; ?>
</div>
<?php endwhile; ?>
