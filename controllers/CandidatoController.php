<?php
class CandidatoController {
    private $db;
    private $candidato;

    public function __construct($db) {
        $this->db = $db;
        $this->candidato = new Candidato($db);
    }

    public function registrar() {
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->nombre) && !empty($data->apellido) && !empty($data->partido) && !empty($data->eleccion_id)) {
            $this->candidato->nombre = $data->nombre;
            $this->candidato->apellido = $data->apellido;
            $this->candidato->partido = $data->partido;
            $this->candidato->eleccion_id = $data->eleccion_id;

            if($this->candidato->registrar()) {
                http_response_code(201);
                echo json_encode(["message" => "Candidato registrado correctamente"]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "No se pudo registrar al candidato"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
        }
    }

    public function leerPorEleccion() {
        $eleccion_id = isset($_GET['eleccion_id']) ? $_GET['eleccion_id'] : '';

        if($eleccion_id) {
            $this->candidato->eleccion_id = $eleccion_id;
            $stmt = $this->candidato->leerPorEleccion();
            $num = $stmt->rowCount();

            if($num > 0) {
                $candidatos_arr = array();
                $candidatos_arr["records"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $candidato_item = array(
                        "id" => $id,
                        "eleccion_id" => $eleccion_id,
                        "nombre" => $nombre,
                        "apellido" => $apellido,
                        "partido" => $partido
                    );
                    array_push($candidatos_arr["records"], $candidato_item);
                }

                http_response_code(200);
                echo json_encode($candidatos_arr);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "No se encontraron candidatos"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Se requiere el ID de la elección"]);
        }
    }
}
?>
