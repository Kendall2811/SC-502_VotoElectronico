const tabla = document.getElementById("tablaResultados");

let elecciones = JSON.parse(localStorage.getItem("elecciones")) || [];

function mostrarResultados(){

tabla.innerHTML = "";

elecciones.forEach(eleccion=>{

let fila = document.createElement("tr");

fila.innerHTML = `

<td>${eleccion.nombre}</td>
<td>${eleccion.votos}</td>

`;

tabla.appendChild(fila);

});

}

mostrarResultados();