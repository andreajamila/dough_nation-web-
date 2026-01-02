<?php
include "conn.php";
session_start();

if(!isset($_SESSION['cust_id'])){
    header("Location: landing_page.php");
    exit;
}

$order_id = $_GET['id'] ?? null;
if(!$order_id){
    header("Location: your_orders.php");
    exit;
}

// Fetch order
$order = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM orders WHERE order_id='$order_id' AND status='Pending'"
));

if(!$order){
    die("Order cannot be edited.");
}

// Update quantities
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    foreach($_POST['qty'] as $item_id => $qty){
        $qty = max(1, intval($qty));

        mysqli_query($conn,"
            UPDATE order_items 
            SET quantity='$qty'
            WHERE id='$item_id'
        ");
    }
    header("Location: your_orders.php");
    exit;
}

// Fetch order items
$items = mysqli_query($conn,"
    SELECT oi.id, oi.quantity, p.product_name, p.image_url
    FROM order_items oi
    JOIN product p ON oi.product_id = p.product_id
    WHERE oi.order_id='$order_id'
");
?>

<?php
// Assume $order_id and $items are already fetched from DB
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Order #<?= $order_id ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}
h2 {
    margin-bottom: 30px;
}
.item-card {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}
.item-card:hover {
    transform: translateY(-3px);
}
.item-card img {
    height: 120px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 10px;
}
.item-name {
    font-weight: bold;
    margin-bottom: 5px;
}
.quantity-input {
    width: 70px;
    margin: 0 auto;
}
.btn-group {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
}
</style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Edit Order</h2>

    <form method="POST">
        <div class="row g-3">
        <?php while($item = mysqli_fetch_assoc($items)): ?>
            <div class="col-6 col-md-3">
                <div class="item-card text-center">
                    <img src="<?= $item['image_url'] ?>" class="img-fluid rounded">
                    <p class="item-name"><?= htmlspecialchars($item['product_name']) ?></p>
                    <input type="number" 
                           name="qty[<?= $item['id'] ?>]" 
                           value="<?= $item['quantity'] ?>" 
                           min="1"
                           class="form-control quantity-input text-center">
                </div>
            </div>
        <?php endwhile; ?>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="your_orders.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

</body>
</html>
