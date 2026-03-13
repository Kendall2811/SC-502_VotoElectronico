document.addEventListener("DOMContentLoaded", function(){

fetch("obtener_elecciones.php")
.then(res => res.json())
.then(data => {

const contenedor = document.getElementById("listaElecciones");

contenedor.innerHTML = "";

if(data.length === 0){

contenedor.innerHTML = `
<div class="col-12 text-center">
<h5 class="text-muted">No hay elecciones activas</h5>
</div>
`;

return;

}

data.forEach(eleccion => {

const card = document.createElement("div");

card.className = "col-md-4";

card.innerHTML = `

<div class="card candidate-card shadow text-center">

<div class="card-body">

<i class="bi bi-check2-square fs-1 text-primary"></i>

<h5 class="mt-3">${eleccion.nombre}</h5>

<p class="text-muted">
Inicio: ${eleccion.fecha_inicio}
</p>

<p class="text-muted">
Fin: ${eleccion.fecha_fin}
</p>

<button class="btn btn-primary w-100">
<i class="bi bi-check-circle"></i> Ver candidatos
</button>

</div>

</div>

`;

contenedor.appendChild(card);

});

});

});