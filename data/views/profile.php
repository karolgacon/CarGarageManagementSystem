<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<!-- Main Content -->
<div class="content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h1 class="text-center mb-4">Profile</h1>
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="<?php echo $photo; ?>" alt="Profile Photo" class="rounded-circle" style="width: 150px; height: 150px;">
                <h3 class="mt-3"><?php echo htmlspecialchars($loggedInUser->getName()) . ' ' . htmlspecialchars($loggedInUser->getSurname()); ?></h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($loggedInUser->getEmail()); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($loggedInUser->getRole()); ?></p>
            </div>
        </div>
        <div class="text-center">
            <a href="/users_edit?id=<?php echo $loggedInUser->getId(); ?>" class="btn btn-primary">Edit Profile</a>
            <a href="/mainview" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-auto py-3 bg-dark text-light text-center">
    <div class="container">
        <span>© 2025 Garage Master. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
