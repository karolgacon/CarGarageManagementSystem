<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <img src="/public/images/logo.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
        <h5>GARAGE MASTER</h5>
    </div>
    <div class="menu">
        <a href="mainview">Dashboard</a>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="inventory">Inventory</a>
        <?php endif; ?>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="users" class="active">Users</a>
        <?php endif; ?>
        <a href="vehicles">Vehicles</a>
        <a href="services">Services</a>
        <a href="invoices">Invoices</a>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="#">Settings</a>
        <?php endif; ?>
    </div>
</div>
