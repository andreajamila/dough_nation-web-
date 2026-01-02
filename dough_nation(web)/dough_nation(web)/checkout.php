<?php
session_start();
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<p>Cart is empty</p>";
    exit;
}
include "header.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-3 text-center">Pickup Details</h4>

                    <form action="place_order.php" method="POST">
                        <label>Pickup Date</label>
                        <input type="date" name="pickup_date" required class="form-control mb-3">

                        <label>Pickup Time</label>
                        <input type="time" name="pickup_time" required class="form-control mb-3">

                        <button type="submit" class="btn btn-primary w-100">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


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
