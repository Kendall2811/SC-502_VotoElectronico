<?php

include("conexion.php");

$sql = "SELECT * FROM elecciones 
WHERE CURDATE() >= fecha_inicio 
AND CURDATE() <= fecha_fin";

$result = $conn->query($sql);

$elecciones = [];

while($row = $result->fetch_assoc()){
$elecciones[] = $row;
}

echo json_encode($elecciones);

$conn->close();

?>