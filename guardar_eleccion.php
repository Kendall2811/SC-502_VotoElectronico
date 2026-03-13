<?php

include("conexion.php");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "INSERT INTO elecciones (nombre, descripcion, fecha_inicio, fecha_fin)
VALUES ('$nombre','$descripcion','$fecha_inicio','$fecha_fin')";

if($conn->query($sql) === TRUE){
echo "ok";
}else{
echo "error: " . $conn->error;
}

$conn->close();

?>