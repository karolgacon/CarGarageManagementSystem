document.addEventListener('DOMContentLoaded', () => {
    const addUserForm = document.getElementById('add-user-form');
    const usersTable = document.getElementById('users-table');

    // Add New User
    addUserForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(addUserForm);

        fetch('add_user.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add the new user to the table
                    const newRow = usersTable.querySelector('tbody').insertRow();
                    newRow.id = `user-${data.user_id}`;
                    newRow.innerHTML = `
                    <td>${data.user_id}</td>
                    <td>${data.email}</td>
                    <td>${data.name}</td>
                    <td>${data.surname}</td>
                    <td>${data.role}</td>
                    <td>${data.photo ? `<img src="uploads/${data.photo}" width="50">` : 'No photo'}</td>
                    <td>
                        <button class="edit-btn" data-user-id="${data.user_id}">Edit</button>
                        <button class="delete-btn" data-user-id="${data.user_id}">Delete</button>
                    </td>
                `;
                    // Clear form
                    addUserForm.reset();
                } else {
                    alert('Error adding user');
                }
            });
    });

    // Edit User
    usersTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const userId = e.target.getAttribute('data-user-id');

            fetch(`edit_user.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate form with current user data
                    document.getElementById('email').value = data.email;
                    document.getElementById('name').value = data.name;
                    document.getElementById('surname').value = data.surname;
                    document.getElementById('role').value = data.role;
                    document.getElementById('user-id').value = data.user_id;
                });
        }
    });

    // Delete User
    usersTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-btn')) {
            const userId = e.target.getAttribute('data-user-id');

            fetch('delete_user.php', {
                method: 'POST',
                body: JSON.stringify({ user_id: userId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove user row from table
                        const row = document.getElementById(`user-${userId}`);
                        row.remove();
                    } else {
                        alert('Error deleting user');
                    }
                });
        }
    });
});
