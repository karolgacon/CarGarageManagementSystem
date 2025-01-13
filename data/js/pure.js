document.addEventListener('DOMContentLoaded', () => {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');

    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', () => {
            const tooltipText = el.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'my-tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);

            const rect = el.getBoundingClientRect();
            tooltip.style.top = (rect.top - 30) + 'px';
            tooltip.style.left = (rect.left) + 'px';
        });

        el.addEventListener('mouseleave', () => {
            const tooltip = document.querySelector('.my-tooltip');
            if (tooltip) tooltip.remove();
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const dropdownToggle = document.getElementById('profileDropdown');
    const dropdownMenu = document.getElementById('profileDropdownMenu');

    if (dropdownToggle && dropdownMenu) {
        // Kliknięcie w avatar/nick przełącza widoczność menu
        dropdownToggle.addEventListener('click', (event) => {
            event.preventDefault(); // zapobiega przeładowaniu strony w razie href="#"
            dropdownMenu.classList.toggle('show');
        });

        // Kliknięcie poza menu chowa dropdown
        document.addEventListener('click', (event) => {
            const isClickInside = dropdownToggle.contains(event.target) ||
                dropdownMenu.contains(event.target);
            if (!isClickInside) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
});
