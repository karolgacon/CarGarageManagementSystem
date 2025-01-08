document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.querySelector("form");
    const tableRows = document.querySelectorAll("tbody tr");

    // Event Listener na zmianę w formularzu
    filterForm.addEventListener("input", () => {
        const clientNameInput = filterForm.querySelector('input[name="client_name"]').value.toLowerCase();
        const statusInput = filterForm.querySelector('select[name="status"]').value.toLowerCase();
        const dateInput = filterForm.querySelector('input[name="created_at"]').value;

        tableRows.forEach((row) => {
            const clientName = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
            const status = row.querySelector("td:nth-child(7)").textContent.toLowerCase();
            const createdAt = row.querySelector("td:nth-child(4)").textContent;

            // Filtrowanie po kliencie, statusie i dacie
            const matchesClient = clientName.includes(clientNameInput);
            const matchesStatus = statusInput === "" || status === statusInput;
            const matchesDate = dateInput === "" || createdAt.startsWith(dateInput);

            // Ukrywanie lub pokazywanie wierszy na podstawie filtru
            if (matchesClient && matchesStatus && matchesDate) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
