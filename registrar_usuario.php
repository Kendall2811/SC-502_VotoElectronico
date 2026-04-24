<?php

include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "INSERT INTO usuarios(nombre,correo,password)
VALUES('$nombre','$correo','$password')";

if($conn->query($sql)){
echo "ok";
}else{
echo "error";
}

$conn->close();

?>