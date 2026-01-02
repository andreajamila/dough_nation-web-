<?php
session_start();

if (isset($_GET['product_id']) && isset($_SESSION['cart'][$_GET['product_id']])) {
    unset($_SESSION['cart'][$_GET['product_id']]);
}

header("Location: cart.php");
exit;
