<?php
class UsuarioController {
    private $db;
    private $usuario;

    public function __construct($db) {
        $this->db = $db;
        $this->usuario = new Usuario($db);
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->correo) && !empty($data->password)) {
            $this->usuario->correo = $data->correo;
            $this->usuario->password = $data->password;

            if($this->usuario->login()) {
                http_response_code(200);
                echo json_encode([
                    "message" => "Login exitoso",
                    "id" => $this->usuario->id,
                    "nombre" => $this->usuario->nombre,
                    "rol" => $this->usuario->rol
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["message" => "Credenciales inválidas"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
        }
    }

    public function registrar() {
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->nombre) && !empty($data->correo) && !empty($data->password)) {
            $this->usuario->nombre = $data->nombre;
            $this->usuario->correo = $data->correo;
            $this->usuario->password = $data->password;

            if($this->usuario->registrar()) {
                http_response_code(201);
                echo json_encode(["message" => "Usuario registrado correctamente"]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "No se pudo registrar al usuario"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
        }
    }
}
?>
