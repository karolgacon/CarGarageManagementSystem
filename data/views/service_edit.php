<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content">
    <h1 class="mb-4 text-center">Edit Service</h1>
    <form action="/service_edit" method="POST">
        <input type="hidden" name="id" value="<?php echo $service['id']; ?>">

        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Vehicle</label>
            <select id="vehicle_id" name="vehicle_id" class="form-select" required>
                <?php foreach ($vehicles as $vehicle): ?>
                    <option value="<?php echo $vehicle->getId(); ?>"
                        <?php echo $service['vehicle_id'] == $vehicle->getId() ? 'selected' : ''; ?>>
                        <?php echo $vehicle->getMake() . ' ' . $vehicle->getModel(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" id="description" name="description" class="form-control"
                   value="<?php echo $service['description']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date and Time</label>
            <input type="datetime-local" id="date" name="date" class="form-control"
                   value="<?php echo isset($service['date']) ? date('Y-m-d\TH:i', strtotime($service['date'])) : date('Y-m-d\TH:i'); ?>" required>
        </div>

        <div class="mb-3">
            <label for="cost" class="form-label">Cost</label>
            <input type="number" id="cost" name="cost" class="form-control"
                   value="<?php echo $service['cost']; ?>" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="pending" <?php echo $service['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="in_progress" <?php echo $service['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="completed" <?php echo $service['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="/services" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="/data/js/pure.js"></script>
</body>
</html>
