<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service History</title>
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>

<div class="content">
<div class="container mt-4">
    <h1>Service History for <?php echo htmlspecialchars($vehicle->getMake() . ' ' . $vehicle->getModel()); ?></h1>

    <div class="table-responsive mt-4">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Service ID</th>
                <th>Description</th>
                <th>Date</th>
                <th>Cost</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['id']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td><?php echo htmlspecialchars($service['date']); ?></td>
                        <td><?php echo number_format($service['cost'], 2); ?></td>
                        <td><?php echo htmlspecialchars($service['status']); ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No service history found for this vehicle.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>


    <a href="/vehicles" class="btn btn-secondary">Back to Vehicles</a>
</div>
</div>

<footer class="footer mt-auto py-3 bg-dark text-light text-center">
    <div class="container">
        <span>© 2025 Garage Master. All Rights Reserved.</span>
    </div>
</footer>

<script src="/data/js/pure.js"></script>
</body>
</html>
