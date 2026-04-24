<?php
class Eleccion {
    private $conn;
    private $table_name = "elecciones";

    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->fecha_inicio = htmlspecialchars(strip_tags($this->fecha_inicio));
        $this->fecha_fin = htmlspecialchars(strip_tags($this->fecha_fin));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":fecha_inicio", $this->fecha_inicio);
        $stmt->bindParam(":fecha_fin", $this->fecha_fin);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function leer() {
        $query = "SELECT id_eleccion as id, nombre, fecha_inicio, fecha_fin FROM " . 
        $this->table_name . " WHERE fecha_fin >= CURDATE()";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
