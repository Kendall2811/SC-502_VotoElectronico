<?php
class VotoController {
    private $db;
    private $voto;

    public function __construct($db) {
        $this->db = $db;
        $this->voto = new Voto($db);
    }

    public function emitir() {
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->id_usuario) && !empty($data->id_eleccion) && !empty($data->id_candidato)) {
            $this->voto->id_usuario = $data->id_usuario;
            $this->voto->id_eleccion = $data->id_eleccion;
            $this->voto->id_candidato = $data->id_candidato;

            if($this->voto->emitir()) {
                http_response_code(201);
                echo json_encode(["message" => "Voto emitido correctamente"]);
            } else {
                http_response_code(403);
                echo json_encode(["message" => "El usuario ya ha votado en esta elección o ocurrió un error."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para emitir el voto"]);
        }
    }

    public function resultados() {
        $stmt = $this->voto->resultados();
        $num = $stmt->rowCount();

        if($num > 0) {
            $resultados_arr = array();
            $resultados_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $resultado_item = array(
                    "eleccion" => $eleccion,
                    "candidato" => $candidato,
                    "partido" => $partido,
                    "votos" => $total_votos
                );
                array_push($resultados_arr["records"], $resultado_item);
            }

            http_response_code(200);
            echo json_encode($resultados_arr);
        } else {
            http_response_code(200);
            echo json_encode(["records" => []]);
        }
    }
}
?>
