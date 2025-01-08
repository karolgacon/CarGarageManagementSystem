<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <?php if (!empty($messages)): ?>
            <div class="alert alert-danger">
                <?php foreach ($messages as $message): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <h1 class="mb-4">Add New User</h1>
        <form action="/users_add" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Email is required.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Password is required.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">First Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <div class="invalid-feedback">First name is required.</div>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Last Name:</label>
                <input type="text" id="surname" name="surname" class="form-control" required>
                <div class="invalid-feedback">Last name is required.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
                <div class="invalid-feedback">Role is required.</div>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile Photo:</label>
                <input type="file" id="photo" name="photo" class="form-control">
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary w-100">Add User</button>
                <a href="/users" class="btn btn-secondary w-100">Cancel</a>
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
