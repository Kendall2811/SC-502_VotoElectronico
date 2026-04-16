<?php
class Voto {
    private $conn;
    private $table_name = "votos";

    public $id_voto;
    public $id_usuario;
    public $id_eleccion;
    public $id_candidato;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function emitir() {
        // Validar que el usuario no haya votado antes en esta misma eleccion
        $queryCheck = "SELECT id_voto FROM " . $this->table_name . " WHERE id_usuario = :id_usuario AND id_eleccion = :id_eleccion";
        $stmtCheck = $this->conn->prepare($queryCheck);
        
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->id_eleccion = htmlspecialchars(strip_tags($this->id_eleccion));
        
        $stmtCheck->bindParam(":id_usuario", $this->id_usuario);
        $stmtCheck->bindParam(":id_eleccion", $this->id_eleccion);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Ya votó
            return false;
        }

        // Emitir voto
        $query = "INSERT INTO " . $this->table_name . " SET id_usuario=:id_usuario, id_eleccion=:id_eleccion, id_candidato=:id_candidato";
        $stmt = $this->conn->prepare($query);

        $this->id_candidato = htmlspecialchars(strip_tags($this->id_candidato));

        $stmt->bindParam(":id_usuario", $this->id_usuario);
        $stmt->bindParam(":id_eleccion", $this->id_eleccion);
        $stmt->bindParam(":id_candidato", $this->id_candidato);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function resultados() {
        // Join con elecciones y candidatos para conocer los nombres en resultados
        $query = "SELECT e.nombre as eleccion, c.nombre as candidato, c.partido as partido, COUNT(v.id_voto) as total_votos 
                  FROM votos v 
                  INNER JOIN elecciones e ON v.id_eleccion = e.id_eleccion 
                  INNER JOIN candidatos c ON v.id_candidato = c.id_candidato 
                  GROUP BY v.id_eleccion, v.id_candidato
                  ORDER BY e.id_eleccion, total_votos DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
