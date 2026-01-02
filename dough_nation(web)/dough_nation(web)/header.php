<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['qty'];
    }
}

$userName = $_SESSION['cust_name'] ?? 'User';
$initials = '';
foreach (explode(' ', $userName) as $n) {
    if ($n) $initials .= strtoupper($n[0]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {font-family: Arial; margin:0; background:#f5f5f5;}
        .header {
    background: #222;
    color: white;
    padding: 10px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header a {
    color: white;
    text-decoration: none;
    margin-right: 15px;
}
.header a:hover { color: #ffd700; }
        .cart-icon {color:white; font-size:22px; position:relative; text-decoration:none;}
        .cart-icon:hover {color:#ffd700;}
        .container {padding:30px;}
        .grid {display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px;}
        .card {background:white; padding:15px; border-radius:8px; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
        .card img {width:100%; height:150px; object-fit:cover;}
        .price {color:#28a745; font-weight:bold; margin-bottom:10px;}
        .btn {display:inline-block; padding:8px 12px; background:#007bff; color:white; border-radius:5px; text-decoration:none;}
        .btn:hover {background:#0056b3;}

        /* Avatar dropdown styles */
        .user-dropdown { position: relative; cursor: pointer; }
        .user-avatar {
    width: 35px; height: 35px; border-radius: 50%;
    background-color: #007bff; color: white; 
    display: flex; justify-content: center; align-items: center;
    font-weight: bold; font-size: 14px; text-transform: uppercase;
}
.dropdown-menu {
    display: none; 
    position: absolute; right: 0; top: 45px;
    background: white; border: 1px solid #ddd; border-radius: 5px;
    min-width: 150px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); z-index: 1000;
}
.dropdown-menu a { display: block; padding: 10px 15px; text-decoration: none; color: #333; }
.dropdown-menu a:hover { background: #f5f5f5; }

    </style>
</head>
<body>
    
<div class="header">
    <h2>Dough Nation</h2>

    <div style="display:flex; gap:15px; align-items:center;">
        <a href="index.php">Home</a>
        <a href="your_orders.php">Orders</a>
        <a href="past_orders.php">Past Orders</a>


        <?php if(basename($_SERVER['PHP_SELF']) !== 'cart.php'): ?>
            <a href="cart.php" class="cart-icon">
                🛒 <?= $cartCount ? "($cartCount)" : "" ?>
            </a>
        <?php endif; ?>

        <div class="user-dropdown">
            <div class="user-avatar" onclick="toggleDropdown()"><?= $initials ?></div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="profile.php">Profile</a>
                <a href="logout.php" style="color:red;">Logout</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
// Toggle dropdown menu
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}
// Close dropdown when clicking outside
window.addEventListener('click', function(e){
    const menu = document.getElementById('dropdownMenu');
    if(!e.target.closest('.user-dropdown')) menu.style.display = 'none';
});
</script>