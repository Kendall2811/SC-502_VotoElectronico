const form = document.querySelector("form");

form.addEventListener("submit", async function(e){

    e.preventDefault();

    let nombre = document.querySelector("input[type='text']").value;
    // Asumiremos que descripcion no existía en el repo viejo pero lo pide el endpoint, agregaremos un fallback
    let descripcionElement = document.querySelector("textarea") || document.querySelectorAll("input[type='text']")[1];
    let descripcion = descripcionElement ? descripcionElement.value : "Sin descripción";
    
    let fechas = document.querySelectorAll("input[type='date']");

    let inicio = fechas[0].value;
    let fin = fechas[1].value;

    try {
        const response = await fetch('api.php?controller=Eleccion&action=crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                descripcion: descripcion,
                fecha_inicio: inicio,
                fecha_fin: fin
            })
        });

        const data = await response.json();

        if(response.ok) {
            alert(data.message || "Elección creada correctamente");
            form.reset();
        } else {
            alert(data.message || "Error al crear la elección");
        }
    } catch(err) {
        console.error(err);
        alert("Error de conexión al servidor");
    }

});