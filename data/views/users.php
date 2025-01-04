<?php
require_once __DIR__ . '/../../src/repository/UserRepository.php';
$userRepo = new UserRepository();
$users = $userRepo->getAllUsers();
?>

<div class="users-container">
    <h1>Manage Users</h1>
    <table id="users-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Role</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr id="user-<?= $user['user_id'] ?>">
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['surname'] ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <?php if ($user['photo']): ?>
                        <img src="uploads/<?= $user['photo'] ?>" alt="User Photo" width="50">
                    <?php else: ?>
                        No photo
                    <?php endif; ?>
                </td>
                <td>
                    <button class="edit-btn" data-user-id="<?= $user['user_id'] ?>">Edit</button>
                    <button class="delete-btn" data-user-id="<?= $user['user_id'] ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Add New User</h2>
    <form id="add-user-form" enctype="multipart/form-data">
        <label>Email: <input type="email" id="email" name="email" required></label>
        <label>Password: <input type="password" id="password" name="password" required></label>
        <label>Name: <input type="text" id="name" name="name" required></label>
        <label>Surname: <input type="text" id="surname" name="surname" required></label>
        <label>Role:
            <select id="role" name="role">
                <option value="client">Client</option>
                <option value="mechanic">Mechanic</option>
                <option value="admin">Admin</option>
            </select>
        </label>
        <label>Photo: <input type="file" id="photo" name="photo"></label>
        <button type="submit">Add User</button>
    </form>
</div>

<script src="user.js"></script>
