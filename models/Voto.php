<?php
class Voto {
    private $conn;
    private $table_name = "votos";

    public $id;
    public $id_usuario;
    public $id_eleccion;
    public $id_candidato;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function emitir() {
        $queryCheck = "SELECT id FROM " . $this->table_name . " WHERE usuario_id = :usuario_id AND eleccion_id = :eleccion_id";
        $stmtCheck = $this->conn->prepare($queryCheck);

        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->id_eleccion = htmlspecialchars(strip_tags($this->id_eleccion));
        $this->id_candidato = htmlspecialchars(strip_tags($this->id_candidato));

        $stmtCheck->bindParam(":usuario_id", $this->id_usuario);
        $stmtCheck->bindParam(":eleccion_id", $this->id_eleccion);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (usuario_id, eleccion_id, candidato_id) VALUES (:usuario_id, :eleccion_id, :candidato_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $this->id_usuario);
        $stmt->bindParam(":eleccion_id", $this->id_eleccion);
        $stmt->bindParam(":candidato_id", $this->id_candidato);

        return $stmt->execute();
    }

    public function resultados() {
        $query = "SELECT e.nombre AS eleccion, CONCAT(c.nombre, ' ', c.apellido) AS candidato, c.partido AS partido, COUNT(v.id) AS total_votos
                  FROM votos v
                  INNER JOIN elecciones e ON v.eleccion_id = e.id
                  INNER JOIN candidatos c ON v.candidato_id = c.id
                  GROUP BY v.eleccion_id, v.candidato_id
                  ORDER BY e.nombre ASC, total_votos DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
