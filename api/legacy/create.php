<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("/home/ecofl253/public_html/conexao_pdo.php");
include("/home/ecofl253/public_html/lorawan/medicoes.php");

  
$database = new Database();
$db = $database->getConnection();
  
$medicoes = new Medicoes($db);
$bateria = new Bateria($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

if($data->type == "uplink"){
    // make sure data is not empty
    if(
        !empty($data->meta->device_addr) &&
        !empty($data->params->radio->hardware->snr) &&
        !empty($data->params->radio->hardware->rssi) &&
        !empty($data->params->payload) 
    ){
        $nome = array("lora01", "lora02", "lora03", "lora04");

        $base = bin2hex(base64_decode($data->params->payload));
        $medidor1 = hexdec(substr($base, 4, 8));
        $medidor2 = hexdec(substr($base, 14, 8));
        $medidor3 = hexdec(substr($base, 24, 8));
        $medidor4 = hexdec(substr($base, 32, 8));
        $leitura = array($medidor1, $medidor2, $medidor3, $medidor4);

        $medidor = array("medidor1", "medidor2", "medidor3", "medidor4");
        $idecoflow = array(61010, 61011, 61012, 61013);

        for($i = 0; $i < 4; $i++){
            // set product property values

            //$medicoes->idecoflow = hex2bin($data->meta->device_addr);

            $medicoes->idecoflow = $idecoflow[$i];

            $medicoes->tempo = date("Y-m-d", $data->meta->time);
            $hora = date("H:i", $data->meta->time);
            $hora .= ":00";
            $medicoes->hora = $hora;

            $medicoes->id_planta_fk = 61;
            //$medicoes->nome = "lora01";
            $medicoes->nome = $nome[$i];
            //$medicoes->medidor = "medidor1";
            $medicoes->medidor = $medidor[$i];
            $medicoes->servico = 0;            

            //$medicoes->leitura = $base2;
            $medicoes->leitura = $leitura[$i];
        
        
            // create the product
            if($medicoes->create()){
        
                // set response code - 201 created
                http_response_code(201);
        
                // tell the user
                echo json_encode(array("message" => "Medicao foi importada."));
            }
        
            // if unable to create the product, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(200);
        
                // tell the user
                echo json_encode(array("message" => "Problema ao importar medicao."));
            }
        }        
    }
    
    // tell the user data is incomplete
    else{
    
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
    echo json_encode(array("message" => "Problema ao importar medicao. Falta informacao."));
    }
} else {
    http_response_code(200);
    echo json_encode(array("message" => "ACK"));
}
?>