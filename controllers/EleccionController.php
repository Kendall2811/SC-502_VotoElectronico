<?php
class EleccionController {
    private $db;
    private $eleccion;

    public function __construct($db) {
        $this->db = $db;
        $this->eleccion = new Eleccion($db);
    }

    public function crear() {
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->nombre) && !empty($data->fecha_inicio) && !empty($data->fecha_fin)) {
            $this->eleccion->nombre = $data->nombre;
            $this->eleccion->fecha_inicio = $data->fecha_inicio;
            $this->eleccion->fecha_fin = $data->fecha_fin;

            if($this->eleccion->crear()) {
                http_response_code(201);
                echo json_encode(["message" => "Elección creada correctamente"]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "No se pudo crear la elección"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
        }
    }

    public function leer() {
        $stmt = $this->eleccion->leer();
        $num = $stmt->rowCount();

        if($num > 0) {
            $elecciones_arr = array();
            $elecciones_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $eleccion_item = array(
                    "id" => $id,
                    "nombre" => $nombre,
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_fin" => $fecha_fin
                );
                array_push($elecciones_arr["records"], $eleccion_item);
            }

            http_response_code(200);
            echo json_encode($elecciones_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No se encontraron elecciones"]);
        }
    }
}
?>
