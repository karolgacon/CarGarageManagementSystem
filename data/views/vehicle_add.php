<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content">
    <h1 class="mb-4 text-center">Add Vehicle</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <form action="/vehicle_add" method="POST">
        <div class="mb-3">
            <label for="owner_id" class="form-label">Owner</label>
            <select id="owner_id" name="owner_id" class="form-select" required>
                <option value="">Select Owner</option>
                <?php foreach ($owners as $owner): ?>
                    <option value="<?php echo $owner->getId(); ?>">
                        <?php echo $owner->getId() . ' - ' . $owner->getName() . ' ' . $owner->getSurname(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="make" class="form-label">Make</label>
            <select name="make" id="make" class="form-control" required>
                <option value="">Select Make</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <select name="model" id="model" class="form-control" required>
                <option value="">Select Model</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <select id="year" name="year" class="form-select" required>
                <option value="">Select Year</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="engine_capacity" class="form-label">Engine Capacity</label>
            <select id="engine_capacity" name="engine_capacity" class="form-select" required>
                <option value="">Select Engine Capacity</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="vin" class="form-label">VIN</label>
            <input type="text" name="vin" id="vin" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Vehicle</button>
        <a href="/vehicles" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="/data/js/pure.js"></script>
<script src="/data/js/vehicle.js"></script>
</body>
</html>
