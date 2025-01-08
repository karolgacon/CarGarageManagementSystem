<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/data/css/mainview.css"> <!-- Ścieżka do zewnętrznego CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h1>Inventory</h1>
        <a href="/inventory_add" class="btn btn-primary mb-3">Add New Item</a>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?php echo $item->getId(); ?></td>
                    <td><?php echo $item->getName(); ?></td>
                    <td><?php echo $item->getCategory(); ?></td>
                    <td><?php echo $item->getQuantity(); ?></td>
                    <td><?php echo $item->getPrice(); ?></td>
                    <td><?php echo $item->getDescription(); ?></td>
                    <td>
                        <a href="/inventory_edit?id=<?php echo $item->getId(); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/inventory_delete?id=<?php echo $item->getId(); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-dark text-light text-center">
    <div class="container">
        <span>© 2025 Garage Master. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
