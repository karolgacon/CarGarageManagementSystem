document.addEventListener("DOMContentLoaded", () => {
    const makeSelect = document.getElementById("make");
    const modelSelect = document.getElementById("model");

    makeSelect.addEventListener("change", async () => {
        const make = makeSelect.value;
        const response = await fetch(`https://api.api-ninjas.com/v1/cars?make=${make}`, {
            headers: { "X-Api-Key": "your-api-key" }
        });
        const models = await response.json();

        modelSelect.innerHTML = "";
        models.forEach(model => {
            const option = document.createElement("option");
            option.value = model.name;
            option.textContent = model.name;
            modelSelect.appendChild(option);
        });
    });
});
