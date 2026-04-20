<?php
$conn = new mysqli("localhost", "root", "", "Votaciones");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "INSERT INTO elecciones (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $fecha_inicio, $fecha_fin);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>