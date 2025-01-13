<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"><!-- FullCalendar CSS -->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h1>Edit Item</h1>
        <form action="/inventory_edit?id=<?php echo $item->getId(); ?>" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($item->getName()); ?>" required>
                <div class="invalid-feedback">Name is required.</div>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category:</label>
                <input type="text" id="category" name="category" class="form-control" value="<?php echo htmlspecialchars($item->getCategory()); ?>" required>
                <div class="invalid-feedback">Category is required.</div>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo htmlspecialchars($item->getQuantity()); ?>" min="1" required>
                <div class="invalid-feedback">Quantity must be at least 1.</div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($item->getPrice()); ?>" min="0" step="0.01" required>
                <div class="invalid-feedback">Price must be at least 0.</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($item->getDescription()); ?></textarea>
            </div>
            <div class="d-flex flex-column gap-3">
                <button type="submit" class="btn btn-success w-100">Save Changes</button>
                <a href="/inventory" class="btn btn-secondary w-100">Cancel</a>
            </div>
        </form>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-dark text-light text-center">
    <div class="container">
        <span>© 2025 Garage Master. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/data/js/formValidation.js"></script>
</body>
</html>
