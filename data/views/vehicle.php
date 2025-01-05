<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles</title>
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<div class="content">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <h1 class="mb-4 text-center">Vehicles</h1>
    <a href="/vehicle_add" class="btn btn-primary mb-3">Add New Vehicle</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Owner</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>VIN</th>
            <th>Engine Capacity</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?php echo htmlspecialchars($vehicle->getId()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getOwnerId()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getMake()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getModel()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getYear()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getVin()); ?></td>
                <td><?php echo htmlspecialchars($vehicle->getEngineCapacity()); ?></td>
                <td>
                    <a href="/vehicle_edit?id=<?php echo $vehicle->getId(); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/vehicle_delete?id=<?php echo $vehicle->getId(); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
