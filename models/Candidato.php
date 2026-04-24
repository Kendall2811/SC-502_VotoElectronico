<?php
class Candidato {
    private $conn;
    private $table_name = "candidatos";

    public $id; // mapped to id_candidato
    public $eleccion_id; // mapped to id_eleccion
    public $nombre;
    public $apellido;
    public $partido;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET id_eleccion=:id_eleccion, nombre=:nombre, apellido=:apellido, partido=:partido";

        $stmt = $this->conn->prepare($query);

        $this->eleccion_id = htmlspecialchars(strip_tags($this->eleccion_id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->partido = htmlspecialchars(strip_tags($this->partido));

        $stmt->bindParam(":id_eleccion", $this->eleccion_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":partido", $this->partido);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function leerPorEleccion() {
        $query = "SELECT id_candidato as id, nombre, apellido, partido, id_eleccion as eleccion_id FROM " . $this->table_name . " WHERE id_eleccion = :id_eleccion";
        $stmt = $this->conn->prepare($query);
        $this->eleccion_id = htmlspecialchars(strip_tags($this->eleccion_id));
        $stmt->bindParam(":id_eleccion", $this->eleccion_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
