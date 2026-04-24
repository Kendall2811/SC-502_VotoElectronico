document.addEventListener("DOMContentLoaded", function(){

    const tabla = document.getElementById("tablaResultados");
    // Also clear static rows from HTML if any exists
    tabla.innerHTML = "";

    async function mostrarResultados() {
        try {
            const res = await fetch("api.php?controller=Voto&action=resultados");
            const text = await res.text();
            let data;

            try {
                data = JSON.parse(text);
            } catch (parseError) {
                console.error("Respuesta no JSON en resultados:", text);
                tabla.innerHTML = "<tr><td colspan='2' class='text-danger'>Error del servidor al cargar resultados.</td></tr>";
                return;
            }

            if(!data.records || data.records.length === 0) {
                tabla.innerHTML = "<tr><td colspan='2' class='text-center text-muted'>Aún no hay resultados de votos.</td></tr>";
                return;
            }

            data.records.forEach(resultado => {
                let fila = document.createElement("tr");

                // resultado object has: eleccion, candidato, partido, votos
                fila.innerHTML = `
                    <td>
                        <strong>${resultado.candidato} (${resultado.partido})</strong><br/>
                        <small class="text-white">${resultado.eleccion}</small>
                    </td>
                    <td class="align-middle fw-bold text-primary fs-5">
                        ${resultado.votos}
                    </td>
                `;
                tabla.appendChild(fila);
            });

        } catch(err) {
            console.error("Error cargando resultados", err);
            tabla.innerHTML = "<tr><td colspan='2' class='text-danger'>Error de red al cargar resultados.</td></tr>";
        }
    }

    mostrarResultados();
});