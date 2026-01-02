<?php
session_start();
include "conn.php";

$items = $_SESSION['cart'] ?? [];
$total = 0;

// Handle update/remove
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_id'])) {
        unset($_SESSION['cart'][$_POST['remove_id']]);
        header("Location: cart.php");
        exit;
    }

    if (isset($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $qty) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['qty'] = max(1, intval($qty));
            }
        }
        header("Location: cart.php");
        exit;
    }
}
?>
<?php include "header.php"; ?>

<!-- MAIN CONTENT -->
<div class="main-content container mt-5 mb-5">

    <h2 class="mb-4">Your Cart</h2>

    <?php if ($items): ?>
    <form method="POST" action="cart.php">

        <table class="table table-bordered bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th width="120">Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th width="80">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($items as $id => $item):
                $res = $conn->query("SELECT product_name, price FROM product WHERE product_id='$id'");
                $product = $res->fetch_assoc();
                if (!$product) continue;

                $subtotal = $item['qty'] * $product['price'];
                $total += $subtotal;
            ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="item-checkbox" data-id="<?= $id ?>" checked>
                    </td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td>
                        <input type="number"
                               class="form-control item-qty"
                               data-id="<?= $id ?>"
                               name="qty[<?= $id ?>]"
                               value="<?= $item['qty'] ?>"
                               min="1">
                    </td>
                    <td>₱ <span class="item-price" data-id="<?= $id ?>"><?= $product['price'] ?></span></td>
                    <td>₱ <span class="item-subtotal" data-id="<?= $id ?>"><?= number_format($subtotal,2) ?></span></td>
                    <td class="text-center">
                        <button type="submit" name="remove_id" value="<?= $id ?>" class="btn btn-danger btn-sm">❌</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Total: ₱ <span id="total"><?= number_format($total,2) ?></span></h4>
            <div>
                <a href="checkout.php" class="btn btn-success ms-2">Proceed to Checkout</a>
            </div>
        </div>

    </form>

    <?php else: ?>
    <div style="
        text-align: center; 
        padding: 20px; 
        background-color: #79f0fdd3; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        margin-top: 20px;
        font-size: 16px;
        color: #555;
    ">
        🛒 Your cart is empty.
    </div>
<?php endif; ?>


</div>
<!-- END MAIN CONTENT -->

<?php include "footer.php"; ?>

<script>
function updateTotal() {
    let total = 0;

    document.querySelectorAll('.item-qty').forEach(input => {
        const id = input.dataset.id;
        const qty = parseInt(input.value) || 0;
        const price = parseFloat(document.querySelector(`.item-price[data-id="${id}"]`).textContent);
        const checkbox = document.querySelector(`.item-checkbox[data-id="${id}"]`);

        const subtotal = qty * price;
        document.querySelector(`.item-subtotal[data-id="${id}"]`).textContent = subtotal.toFixed(2);

        if (checkbox.checked) total += subtotal;
    });

    document.getElementById('total').textContent = total.toFixed(2);
}

document.querySelectorAll('.item-qty, .item-checkbox').forEach(el => {
    el.addEventListener('input', updateTotal);
    el.addEventListener('change', updateTotal);
});

updateTotal();
</script>
