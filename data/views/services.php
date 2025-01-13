<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content">
    <h1 class="mb-4 text-center">Services</h1>
    <a href="/service_add" class="btn btn-success mb-3">Add Service</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Description</th>
            <th>Date</th>
            <th>Cost</th>
            <th>Total Cost</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo $service['id']; ?></td>
                <td><?php echo $service['make'] . ' ' . $service['model']; ?></td>
                <td><?php echo $service['description']; ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($service['date'])); ?></td>
                <td><?php echo number_format($service['cost'], 2); ?> USD</td>
                <td><?php echo number_format($service['total_cost'], 2); ?> USD</td>
                <td><?php echo ucfirst($service['status']); ?></td>
                <td>
                    <a href="/service_edit?id=<?php echo $service['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="/service_delete?id=<?php echo $service['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</a>
                    <?php if ($service['status'] !== 'completed'): ?>
                        <a href="/service_mark_completed?id=<?php echo $service['id']; ?>" class="btn btn-success btn-sm">Mark as Completed</a>
                    <?php endif; ?>
                </td>
            </tr>
            <!-- Szczegóły części -->
            <?php if (!empty($service['parts'])): ?>
                <tr>
                    <td colspan="8">
                        <strong>Parts Used:</strong>
                        <ul>
                            <?php foreach ($service['parts'] as $part): ?>
                                <li class="ml-4">
                                    <?php echo $part['part_name']; ?> -
                                    Quantity: <?php echo $part['quantity']; ?> -
                                    Cost: <?php echo number_format($part['total_cost'], 2); ?> USD
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<script src="/data/js/pure.js"></script></body>
</html>
