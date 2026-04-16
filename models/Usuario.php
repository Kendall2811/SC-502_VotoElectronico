<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id; // mapped to Id_Usuarios
    public $nombre; // mapped to Nombre
    public $correo; // mapped to email
    public $password;
    public $rol;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT Id_Usuarios as id, Nombre as nombre, password, rol FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $stmt->bindParam(":email", $this->correo);

        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($this->password === $row['password']) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->rol = $row['rol'];
                return true;
            }
        }
        return false;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " SET Nombre=:nombre, email=:email, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password)); 

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->correo);
        $stmt->bindParam(":password", $this->password);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
