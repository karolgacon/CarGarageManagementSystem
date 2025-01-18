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

// Dodawanie nowej części
document.getElementById('add-part').addEventListener('click', () => {
    const container = document.getElementById('parts-container');
    const row = document.createElement('div');
    row.className = 'row mb-2 align-items-center';
    row.innerHTML = `
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
    `;
    container.appendChild(row);
    partIndex++;
});

// Usuwanie wiersza
document.getElementById('parts-container').addEventListener('click', (event) => {
    if (event.target.classList.contains('remove-part')) {
        const button = event.target;
        const row = button.closest('.row');
        row.remove();
    }
});
