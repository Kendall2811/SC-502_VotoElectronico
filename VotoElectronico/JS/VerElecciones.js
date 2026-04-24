<<<<<<< Updated upstream
document.addEventListener("DOMContentLoaded", function() {
  const tbody = document.getElementById("eleccionesBody");

  fetch("obtener_elecciones.php")
    .then(response => response.json())
    .then(data => {
      tbody.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="5" class="text-center text-muted">No se encontraron elecciones activas.</td>
          </tr>
        `;
        return;
      }

      data.forEach(eleccion => {
        const estado = calcularEstado(eleccion.fecha_inicio, eleccion.fecha_fin);

        const row = document.createElement("tr");
        row.innerHTML = `
          <th scope="row">${eleccion.id || "-"}</th>
          <td>${eleccion.nombre || "-"}</td>
          <td>${eleccion.fecha_inicio || "-"}</td>
          <td>${eleccion.fecha_fin || "-"}</td>
          <td>${estado}</td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(() => {
      tbody.innerHTML = `
        <tr>
          <td colspan="5" class="text-center text-danger">Error al cargar las elecciones. Intente nuevamente.</td>
        </tr>
      `;
    });

  function calcularEstado(inicio, fin) {
    const hoy = new Date();
    const fechaInicio = new Date(inicio);
    const fechaFin = new Date(fin);

    if (isNaN(fechaInicio) || isNaN(fechaFin)) {
      return "Desconocido";
    }

    if (hoy < fechaInicio) return "No iniciada";
    if (hoy > fechaFin) return "Finalizada";
    return "Activa";
  }
});
=======
document.addEventListener("DOMContentLoaded", function() {
  const tbody = document.getElementById("eleccionesBody");

  fetch("obtener_elecciones.php")
    .then(response => response.json())
    .then(data => {
      tbody.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="5" class="text-center text-muted">No se encontraron elecciones activas.</td>
          </tr>
        `;
        return;
      }

      data.forEach(eleccion => {
        const estado = calcularEstado(eleccion.fecha_inicio, eleccion.fecha_fin);

        const row = document.createElement("tr");
        row.innerHTML = `
          <th scope="row">${eleccion.id || "-"}</th>
          <td>${eleccion.nombre || "-"}</td>
          <td>${eleccion.fecha_inicio || "-"}</td>
          <td>${eleccion.fecha_fin || "-"}</td>
          <td>${estado}</td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(() => {
      tbody.innerHTML = `
        <tr>
          <td colspan="5" class="text-center text-danger">Error al cargar las elecciones. Intente nuevamente.</td>
        </tr>
      `;
    });

  function calcularEstado(inicio, fin) {
    const hoy = new Date();
    const fechaInicio = new Date(inicio);
    const fechaFin = new Date(fin);

    if (isNaN(fechaInicio) || isNaN(fechaFin)) {
      return "Desconocido";
    }

    if (hoy < fechaInicio) return "No iniciada";
    if (hoy > fechaFin) return "Finalizada";
    return "Activa";
  }
});
>>>>>>> Stashed changes
