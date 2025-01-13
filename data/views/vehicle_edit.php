<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content">
    <h1 class="mb-4 text-center">Edit Vehicle</h1>
    <form action="/vehicle_edit" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicle->getId()); ?>">
        <div class="mb-3">
            <label for="owner_id" class="form-label">Owner</label>
            <select id="owner_id" name="owner_id" class="form-select" required>
                <option value="">Select Owner</option>
                <?php foreach ($owners as $owner): ?>
                    <option value="<?php echo $owner->getId(); ?>"
                        <?php echo $owner->getId() == $vehicle->getOwnerId() ? 'selected' : ''; ?>>
                        <?php echo $owner->getId() . ' - ' . $owner->getName() . ' ' . $owner->getSurname(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="make" class="form-label">Make</label>
            <select name="make" id="make" class="form-select" required>
                <option value="<?php echo htmlspecialchars($vehicle->getMake()); ?>"><?php echo htmlspecialchars($vehicle->getMake()); ?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <select name="model" id="model" class="form-select" required>
                <option value="<?php echo htmlspecialchars($vehicle->getModel()); ?>"><?php echo htmlspecialchars($vehicle->getModel()); ?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <select id="year" name="year" class="form-select" required>
                <option value="<?php echo htmlspecialchars($vehicle->getYear()); ?>"><?php echo htmlspecialchars($vehicle->getYear()); ?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="engine_capacity" class="form-label">Engine Capacity</label>
            <select id="engine_capacity" name="engine_capacity" class="form-select" required>
                <option value="<?php echo htmlspecialchars($vehicle->getEngineCapacity()); ?>">
                    <?php echo htmlspecialchars($vehicle->getEngineCapacity()) . ' L'; ?>
                </option>
            </select>
        </div>
        <div class="mb-3">
            <label for="vin" class="form-label">VIN</label>
            <input type="text" name="vin" id="vin" class="form-control"
                   value="<?php echo htmlspecialchars($vehicle->getVin()); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        <a href="/vehicles" class="btn btn-secondary w-100">Cancel</a>
    </form>
</div>
<script src="/data/js/pure.js"></script>
<script src="/data/js/vehicle.js"></script>
</body>
</html>
