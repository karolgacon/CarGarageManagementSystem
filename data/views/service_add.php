<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/data/css/mainview.css">
</head>
<body>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>
<?php include __DIR__ . '/../partials/topnavbar.php'; ?>
<div class="content">
    <h1 class="mb-4 text-center">Add Service</h1>
    <form action="/service_add" method="POST">
        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Vehicle</label>
            <select id="vehicle_id" name="vehicle_id" class="form-select" required>
                <option value="">Select Vehicle</option>
                <?php foreach ($vehicles as $vehicle): ?>
                    <option value="<?php echo $vehicle->getId(); ?>">
                        <?php echo $vehicle->getMake() . ' ' . $vehicle->getModel(); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" id="description" name="description" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date and Time</label>
            <input type="datetime-local" id="date" name="date" class="form-control"
                   value="<?php echo date('Y-m-d\TH:i'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="cost" class="form-label">Service Cost</label>
            <input type="number" id="cost" name="cost" class="form-control" step="0.01" required>
        </div>
        <div id="parts-container" class="mb-3">
            <label class="form-label">Parts Used</label>
            <div class="row mb-2">
                <div class="col-md-6">
                    <select name="parts[0][part_id]" class="form-select part-select" data-index="0" required>
                        <option value="">Select Part</option>
                        <?php foreach ($inventory as $part): ?>
                            <option value="<?php echo $part->getID(); ?>" data-price="<?php echo $part->getPrice(); ?>">
                                <?php echo $part->getName(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="parts[0][quantity]" class="form-control quantity-input" data-index="0" placeholder="Quantity" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control total-cost-display" data-index="0" placeholder="Total Cost" readonly>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-part">Add Another Part</button>
        <br><br>
        <button type="submit" class="btn btn-success">Add Service</button>
        <a href="/services" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('input', (event) => {
        if (event.target.classList.contains('quantity-input') || event.target.classList.contains('part-select')) {
            const index = event.target.getAttribute('data-index');
            const quantityInput = document.querySelector(`.quantity-input[data-index="${index}"]`);
            const partSelect = document.querySelector(`.part-select[data-index="${index}"]`);
            const totalCostDisplay = document.querySelector(`.total-cost-display[data-index="${index}"]`);

            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(partSelect.options[partSelect.selectedIndex].getAttribute('data-price')) || 0;

            totalCostDisplay.value = (quantity * price).toFixed(2);
        }
    });

    let partIndex = 1;
    document.getElementById('add-part').addEventListener('click', () => {
        const container = document.getElementById('parts-container');
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
        <div class="col-md-6">
            <select name="parts[${partIndex}][part_id]" class="form-select part-select" data-index="${partIndex}" required>
                <option value="">Select Part</option>
                <?php foreach ($inventory as $part): ?>
                    <option value="<?php echo $part->getID(); ?>" data-price="<?php echo $part->getPrice(); ?>">
                        <?php echo $part->getName(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="parts[${partIndex}][quantity]" class="form-control quantity-input" data-index="${partIndex}" placeholder="Quantity" required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control total-cost-display" data-index="${partIndex}" placeholder="Total Cost" readonly>
        </div>
    `;
        container.appendChild(row);
        partIndex++;
    });

</script>
</body>
</html>
