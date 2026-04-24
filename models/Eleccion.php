<?php
class Eleccion {
    private $conn;
    private $table_name = "elecciones";

    public $id;
    public $nombre;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, fecha_inicio, fecha_fin) VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion ?? ''));
        $this->fecha_inicio = htmlspecialchars(strip_tags($this->fecha_inicio));
        $this->fecha_fin = htmlspecialchars(strip_tags($this->fecha_fin));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":fecha_inicio", $this->fecha_inicio);
        $stmt->bindParam(":fecha_fin", $this->fecha_fin);

        return $stmt->execute();
    }

    public function leer() {
        $query = "SELECT id, nombre, descripcion, fecha_inicio, fecha_fin FROM " . $this->table_name . " ORDER BY fecha_inicio DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
