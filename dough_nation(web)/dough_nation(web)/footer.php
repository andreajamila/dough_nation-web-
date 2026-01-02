<style>
.footer {
    background: #222;
    color: #fff;
    padding: 10px 0;
    font-size: 14px;
}

.footer a {
    color: #ffd700;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

.footer .footer-container {
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 0 15px;
}

.footer .col {
    flex: 1 1 200px;
}

.footer ul {
    list-style: none;
    padding: 0;
    margin: 5px 0 0 0;
    display: flex;
    gap: 15px;
}

.footer hr {
    border-color: #444;
    margin: 8px 0;
}

.footer .text-center {
    text-align: center;
}

.main-content {
    flex: 1; /* pushes footer down */
}

html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    background: #f5f5f5;
}
</style>

<footer class="footer">
    <div class="footer-container">
        <!-- About + Quick Links -->
        <div class="col">
            <h5 class="mb-1">Dough Nation</h5>
            <p class="mb-1">Fresh breads, pastries, and cakes made daily.</p>

            <h6 class="mt-2 mb-1">Quick Links</h6>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="your_orders.php">Orders</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="col">
            <h6 class="mb-1">Contact</h6>
            <p class="mb-1">📍 Dough Nation Bakery</p>
            <p class="mb-1">📞 0912-345-6789</p>
            <p class="mb-0">✉️ doughnation@email.com</p>
        </div>
    </div>

    <hr>
    <p class="text-center mb-0">
        &copy; <?= date('Y') ?> Dough Nation. All rights reserved.
    </p>
</footer>
