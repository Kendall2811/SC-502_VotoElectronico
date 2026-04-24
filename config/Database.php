<?php
class Database {
    private $host = "localhost";
    private $db_name = "votaciones";
    private $username = "root";
    private $password = "";
    public $conn;
    public $errorMessage;

    public function getConnection() {
        $this->conn = null;
        $this->errorMessage = null;

        try {
            // Se utiliza PDO para mejorar la seguridad frente a SQL Injections.
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
            // Habilitar excepciones para los errores de la DB
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            $this->errorMessage = $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
