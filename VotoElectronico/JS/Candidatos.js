document.querySelector("form").addEventListener("submit", function(e){

e.preventDefault();

let nombre = document.querySelectorAll("input")[0].value;
let apellido = document.querySelectorAll("input")[1].value;
let partido = document.querySelector("select").value;

if(nombre === "" || apellido === ""){
alert("Debe completar todos los campos");
return;
}

alert("Candidato registrado correctamente");

this.reset();

});