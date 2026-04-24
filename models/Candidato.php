<?php
class Candidato {
    private $conn;
    private $table_name = "candidatos";

    public $id;
    public $eleccion_id;
    public $nombre;
    public $apellido;
    public $partido;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (eleccion_id, nombre, apellido, partido) VALUES (:eleccion_id, :nombre, :apellido, :partido)";
        $stmt = $this->conn->prepare($query);

        $this->eleccion_id = htmlspecialchars(strip_tags($this->eleccion_id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->partido = htmlspecialchars(strip_tags($this->partido));

        $stmt->bindParam(":eleccion_id", $this->eleccion_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":partido", $this->partido);

        return $stmt->execute();
    }

    public function leerPorEleccion() {
        $query = "SELECT id, nombre, apellido, partido, eleccion_id FROM " . $this->table_name . " WHERE eleccion_id = :eleccion_id ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $this->eleccion_id = htmlspecialchars(strip_tags($this->eleccion_id));
        $stmt->bindParam(":eleccion_id", $this->eleccion_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
