<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Users</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/users_add" class="btn btn-primary">Add New User</a>
            <input type="text" id="searchUser" class="form-control w-50" placeholder="Search users...">
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="userTable">
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->getId(); ?></td>
                    <td><?php echo $user->getName(); ?></td>
                    <td><?php echo $user->getSurname(); ?></td>
                    <td><?php echo $user->getEmail(); ?></td>
                    <td><?php echo ucfirst($user->getRole()); ?></td>
                    <td>
                        <a href="/users_edit?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/users_delete?id=<?php echo $user->getId(); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
<script src="/data/js/userSearch.js"></script>
</body>
</html>
