<?php
session_start();
include "conn.php";

if (!isset($_SESSION['cust_id'])) {
    header("Location: landing_page.php");
    exit;
}

$products = $conn->query("
    SELECT p.product_id, p.product_name, p.price, p.image_url, pi.stock
    FROM product p
    JOIN product_inventory pi ON p.product_id = pi.product_id
")->fetch_all(MYSQLI_ASSOC);

include "header.php";
?>

<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
}

/* Grid for products */
.grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

/* Product card */
.card {
    background: #fff;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 10px;
}

.card h4 {
    margin: 8px 0;
    font-size: 16px;
}

.card .price {
    margin-bottom: 5px;
    font-weight: 500;
}

.card .btn {
    display: inline-block;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 5px;
}

/* Add to Cart button styles */
.btn-add {
    background-color: #007bff;
    color: #fff;
}
.btn-add:hover {
    background-color: #0056b3;
}
.btn-disabled {
    background-color: #888;
    cursor: not-allowed;
}

/* Out of Stock label */
.out-of-stock {
    color: red;
    font-weight: bold;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 1400px) { .grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1100px) { .grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 800px)  { .grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 500px)  { .grid { grid-template-columns: 1fr; } }
</style>

<div class="main-content container mt-4 mb-5">
    <div class="grid">
        <?php foreach($products as $p): ?>
        <div class="card">
            <img src="<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['product_name']) ?>">
            <h4><?= htmlspecialchars($p['product_name']) ?></h4>
            <div class="price">₱<?= number_format($p['price'],2) ?></div>
            <div class="price">Stock: <?= $p['stock'] ?></div>

            <?php if($p['stock'] > 0): ?>
                <a href="add_to_cart.php?id=<?= $p['product_id'] ?>" class="btn btn-add">Add to Cart</a>
            <?php else: ?>
                <div class="out-of-stock">Out of Stock</div>
                <a href="#" class="btn btn-disabled" onclick="return false;">Add to Cart</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "footer.php"; ?>
