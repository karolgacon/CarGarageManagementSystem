<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accept Service</title>
    <link rel="stylesheet" href="/data/css/pure.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>

<div class="content">
    <h1 class="text-center">Accept Service</h1>
    <form action="/service_accept?id=<?php echo $service['id']; ?>" method="POST">
        <div class="mb-3">
            <label for="cost" class="form-label">Service Cost</label>
            <input type="number" id="cost" name="cost" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Service Date</label>
            <input type="datetime-local" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
        </div>
        <div id="parts-container" class="mb-3">
            <label class="form-label">Parts Used</label>
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="parts[${partIndex}][part_id]" class="form-select part-select" data-index="${partIndex}" required>
                        <option value="">Select Part</option>
                        <?php foreach ($inventory as $part): ?>
                            <option value="<?php echo $part->getID(); ?>" data-price="<?php echo $part->getPrice(); ?>">
                                <?php echo $part->getName(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="parts[${partIndex}][quantity]" class="form-control quantity-input" data-index="${partIndex}" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control total-cost-display" data-index="${partIndex}" placeholder="Total Cost" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="remove-part btn btn-sm btn-danger" data-index="${partIndex}">X</button>
                </div>
            </div>
        </div>
        <button type="button" id="add-part" class="btn btn-secondary">Add Another Part</button>
        <button type="submit" class="btn btn-primary mt-3 w-100">Accept Service</button>
        <a href="/services" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>
<script src="/data/js/services.js"></script>
</body>
</html>
