document.addEventListener("DOMContentLoaded", async () => {
    // Cargar elecciones
    try {
        const res = await fetch("api.php?controller=Eleccion&action=leer");
        const data = await res.json();
        const select = document.getElementById("selectEleccion");
        
        if (data.records && data.records.length > 0) {
            data.records.forEach(eleccion => {
                const opt = document.createElement("option");
                opt.value = eleccion.id;
                opt.textContent = eleccion.nombre;
                select.appendChild(opt);
            });
        }
    } catch(err) {
        console.error("Error al cargar elecciones", err);
    }
});

document.querySelector("form").addEventListener("submit", async function(e){
    e.preventDefault();

    let nombre = document.querySelectorAll("input")[0].value;
    let apellido = document.querySelectorAll("input")[1].value;
    let partido = document.getElementById("selectPartido").value;
    let eleccion_id = document.getElementById("selectEleccion").value; 

    if(nombre === "" || apellido === "" || eleccion_id === ""){
        alert("Debe completar todos los campos y seleccionar una elección");
        return;
    }

    try {
        const response = await fetch('api.php?controller=Candidato&action=registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                apellido: apellido,
                partido: partido,
                eleccion_id: eleccion_id
            })
        });

        const data = await response.json();

        if(response.ok) {
            alert(data.message || "Candidato registrado correctamente");
            this.reset();
        } else {
            alert(data.message || "Error al registrar candidato");
        }
    } catch(err) {
        console.error(err);
        alert("Error de conexión al servidor");
    }
});