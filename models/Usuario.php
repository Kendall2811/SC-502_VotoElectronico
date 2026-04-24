<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $correo;
    public $password;
    public $rol = "votante";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT id, nombre, correo, password FROM " . $this->table_name . " WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $stmt->bindParam(":correo", $this->correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($this->password === $row['password']) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->rol = "votante";
                return true;
            }
        }
        return false;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, correo, password) VALUES (:nombre, :correo, :password)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":password", $this->password);

        return $stmt->execute();
    }
}
?>
