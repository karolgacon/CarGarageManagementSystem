// JavaScript to load content dynamically and manage active menu
function loadContent(page, activeId) {
    const contentContainer = document.getElementById('contentContainer');
    const menuItems = document.querySelectorAll('.sidebar a');

    // Fetch and load content
    fetch(page)
        .then(response => response.text())
        .then(data => {
            contentContainer.innerHTML = data;

            // Update active menu item
            menuItems.forEach(item => item.classList.remove('active'));
            const activeItem = document.getElementById(activeId);
            if (activeItem) activeItem.classList.add('active');
        })
        .catch(error => {
            contentContainer.innerHTML = '<p>Error loading content. Please try again later.</p>';
            console.error('Error:', error);
        });
}
