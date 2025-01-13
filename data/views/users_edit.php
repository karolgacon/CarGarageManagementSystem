<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h1 class="mb-4">Edit user: <?php echo $user->getName()." ".$user->getSurname(); ?></h1>
        <form action="/users_edit?id=<?php echo $user->getId(); ?>" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
                <div class="invalid-feedback">Email is required.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
                <div class="form-text">Leave blank to keep the current password.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">First Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user->getName()); ?>" required>
                <div class="invalid-feedback">First name is required.</div>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Last Name:</label>
                <input type="text" id="surname" name="surname" class="form-control" value="<?php echo htmlspecialchars($user->getSurname()); ?>" required>
                <div class="invalid-feedback">Last name is required.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="user" <?php echo $user->getRole() === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user->getRole() === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
                <div class="invalid-feedback">Role is required.</div>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile Photo:</label>
                <input type="file" id="photo" name="photo" class="form-control">
                <?php if ($user->getPhoto()): ?>
                    <div class="form-text">Current photo: <img src="<?php echo $user->getPhoto(); ?>" alt="Current Photo" class="img-thumbnail" style="width: 50px; height: 50px;"></div>
                    <input type="hidden" name="current_photo" value="<?php echo $user->getPhoto(); ?>">
                <?php endif; ?>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success w-100">Save Changes</button>
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


<script src="/data/js/pure.js"></script>
<script src="/data/js/formValidation.js"></script>
</body>
</html>
