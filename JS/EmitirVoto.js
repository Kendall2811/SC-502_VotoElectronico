document.addEventListener("DOMContentLoaded", function(){

    async function cargarElecciones() {
        try {
            const res = await fetch("api.php?controller=Eleccion&action=leer");
            const data = await res.json();
            const contenedor = document.getElementById("listaElecciones");
            contenedor.innerHTML = "";

            if(!data.records || data.records.length === 0){
                contenedor.innerHTML = `
                <div class="col-12 text-center">
                    <h5 class="text-muted">No hay elecciones activas</h5>
                </div>`;
                return;
            }

            data.records.forEach(eleccion => {
                const card = document.createElement("div");
                card.className = "col-md-4 mb-3";
                card.innerHTML = `
                    <div class="glass-card glass-hover text-center p-4">
                        <i class="bi bi-box-seam giant-icon text-primary mb-3 d-inline-block"></i>
                        <h4 class="mt-2 text-white fw-bold">${eleccion.nombre}</h4>
                        <p class="text-muted small mb-1">Inicio: <span class="text-white">${eleccion.fecha_inicio}</span></p>
                        <p class="text-muted small">Fin: <span class="text-white">${eleccion.fecha_fin}</span></p>
                        <div id="candidatos-eleccion-${eleccion.id}" class="mb-3 text-start"></div>
                        <button class="btn btn-glass w-100 mt-2" onclick="verCandidatos(${eleccion.id})">
                            <i class="bi bi-people"></i> Cargar Nominados
                        </button>
                    </div>
                `;
                contenedor.appendChild(card);
            });
        } catch(e) {
            console.error(e);
        }
    }

    cargarElecciones();
});

window.verCandidatos = async function(eleccion_id) {
    try {
        const divCandidatos = document.getElementById(`candidatos-eleccion-${eleccion_id}`);
        divCandidatos.innerHTML = "<p>Cargando...</p>";

        const res = await fetch(`api.php?controller=Candidato&action=leerPorEleccion&eleccion_id=${eleccion_id}`);
        const data = await res.json();

        if(!data.records || data.records.length === 0) {
            divCandidatos.innerHTML = "<p class='text-danger'>No hay candidatos</p>";
            return;
        }

        let html = "<ul class='list-group mb-2'>";
        data.records.forEach(c => {
            html += `<li class='list-group-item d-flex justify-content-between align-items-center'>
                        ${c.nombre} (${c.partido})
                        <button class='btn btn-sm btn-success' onclick='votar(${eleccion_id}, ${c.id})'>Votar</button>
                     </li>`;
        });
        html += "</ul>";
        divCandidatos.innerHTML = html;

    } catch(err) {
        console.error(err);
    }
}

window.votar = async function(eleccion_id, candidato_id) {
    const usuario_id = sessionStorage.getItem("userId");
    if(!usuario_id) {
        alert("Debes iniciar sesión para votar.");
        return;
    }

    if(confirm("¿Estás seguro de registrar este voto? No podrás deshacerlo.")) {
        try {
            const res = await fetch("api.php?controller=Voto&action=emitir", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    id_usuario: usuario_id,
                    id_eleccion: eleccion_id,
                    id_candidato: candidato_id
                })
            });
            const data = await res.json();
            if(res.ok) {
                alert("¡Voto registrado con éxito!");
            } else {
                alert(data.message || "Error al emitir el voto.");
            }
        } catch(err) {
            console.error(err);
            alert("Error de conexión al servidor.");
        }
    }
}