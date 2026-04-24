<?php

include("conexion.php");

$sql = "SELECT * FROM elecciones WHERE fecha_fin >= CURDATE()";

$result = $conn->query($sql);

$elecciones = [];

while($row = $result->fetch_assoc()){
$elecciones[] = $row;
}

echo json_encode($elecciones);

$conn->close();

?>