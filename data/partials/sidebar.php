<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <img src="/data/img/logo.png" alt="Logo" class="img-fluid" style="max-width: 100px">
        <h5>GARAGE MASTER</h5>
    </div>
    <div class="menu">
        <a href="mainview" class="<?= $_SERVER['REQUEST_URI'] === '/mainview' ? 'active' : '' ?>">Dashboard</a>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="inventory" class="<?= $_SERVER['REQUEST_URI'] === '/inventory' ? 'active' : '' ?>">Inventory</a>
        <?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="users" class="<?= $_SERVER['REQUEST_URI'] === '/users' ? 'active' : '' ?>">Users</a>
        <?php endif; ?>
        <a href="vehicles" class="<?= $_SERVER['REQUEST_URI'] === '/vehicles' ? 'active' : '' ?>">Vehicles</a>
        <a href="services" class="<?= $_SERVER['REQUEST_URI'] === '/services' ? 'active' : '' ?>">Services</a>
        <a href="invoices" class="<?= $_SERVER['REQUEST_URI'] === '/invoices' ? 'active' : '' ?>">Invoices</a>
    </div>
</div>
