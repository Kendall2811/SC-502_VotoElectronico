const form = document.querySelector("#formEleccion");

form.addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    try {
        const response = await fetch("guardar_eleccion.php", {
            method: "POST",
            body: formData
        });

        const result = await response.text();

        if (result.trim() === "ok") {
            alert("Elección guardada correctamente");
            form.reset();
        } else {
            alert("Error: " + result);
        }

    } catch (error) {
        alert("Error de conexión: " + error);
    }
});