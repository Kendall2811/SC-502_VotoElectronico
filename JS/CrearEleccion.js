const form = document.querySelector("form");

form.addEventListener("submit", function(e){

e.preventDefault();

let nombre = document.querySelector("input[type='text']").value;
let fechas = document.querySelectorAll("input[type='date']");

let inicio = fechas[0].value;
let fin = fechas[1].value;

let elecciones = JSON.parse(localStorage.getItem("elecciones")) || [];

let nuevaEleccion = {
nombre:nombre,
inicio:inicio,
fin:fin,
votos:0
};

elecciones.push(nuevaEleccion);

localStorage.setItem("elecciones",JSON.stringify(elecciones));

alert("Elección creada correctamente");

form.reset();

});