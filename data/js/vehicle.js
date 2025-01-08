document.addEventListener('DOMContentLoaded', () => {
    const makeSelect = document.getElementById('make');
    const modelSelect = document.getElementById('model');
    const yearSelect = document.getElementById('year');
    const engineCapacitySelect = document.getElementById('engine_capacity');

    // Pobieranie marek
    fetch('https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=&rows=1000')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            const makes = new Set();
            data.records.forEach(record => makes.add(record.fields.make));
            Array.from(makes).sort().forEach(make => {
                const option = document.createElement('option');
                option.value = make;
                option.textContent = make;
                makeSelect.appendChild(option);
            });
        })
        .catch(err => console.error('Failed to load makes:', err));

    // Pobieranie modeli na podstawie wybranej marki
    makeSelect.addEventListener('change', () => {
        const selectedMake = makeSelect.value;
        modelSelect.innerHTML = '<option value="">Select Model</option>';
        yearSelect.innerHTML = '<option value="">Select Year</option>';
        engineCapacitySelect.innerHTML = '<option value="">Select Engine Capacity</option>';

        fetch(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=make:${selectedMake}&rows=1000`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const models = new Set();
                data.records.forEach(record => models.add(record.fields.model));
                Array.from(models).sort().forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            })
            .catch(err => console.error('Failed to load models:', err));
    });

    // Pobieranie lat na podstawie wybranego modelu
    modelSelect.addEventListener('change', () => {
        const selectedModel = modelSelect.value;
        yearSelect.innerHTML = '<option value="">Select Year</option>';
        engineCapacitySelect.innerHTML = '<option value="">Select Engine Capacity</option>';

        fetch(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=model:${selectedModel}&rows=1000`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const years = new Set();
                data.records.forEach(record => years.add(record.fields.year));
                Array.from(years).sort().forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                });
            })
            .catch(err => console.error('Failed to load years:', err));
    });

    // Pobieranie pojemności na podstawie wybranego roku
    yearSelect.addEventListener('change', () => {
        const selectedModel = modelSelect.value;
        const selectedYear = yearSelect.value;
        engineCapacitySelect.innerHTML = '<option value="">Select Engine Capacity</option>';

        fetch(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=model:${selectedModel}+AND+year:${selectedYear}&rows=1000`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const capacities = new Set();
                data.records.forEach(record => capacities.add(record.fields.displ || 'Unknown'));
                Array.from(capacities).sort((a, b) => parseFloat(a) - parseFloat(b)).forEach(capacity => {
                    const option = document.createElement('option');
                    option.value = capacity;
                    option.textContent = `${capacity} L`;
                    engineCapacitySelect.appendChild(option);
                });
            })
            .catch(err => console.error('Failed to load engine capacities:', err));
    });
});

document.getElementById('vehicleSearch').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
