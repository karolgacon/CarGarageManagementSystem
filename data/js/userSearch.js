document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchUser');
    const userTable = document.getElementById('userTable');

    searchInput.addEventListener('keyup', () => {
        const filter = searchInput.value.toLowerCase();
        const rows = userTable.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            const name = cells[1].textContent.toLowerCase() + ' ' + cells[2].textContent.toLowerCase();
            const email = cells[3].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
