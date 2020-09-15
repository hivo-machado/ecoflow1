<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include("/home/ecofl253/public_html/conexao_pdo.php");
// include("/home/ecofl253/public_html/api/funcoes/medicoes.php");
// include("/home/ecofl253/public_html/api/funcoes/bateria.php");

include("../conexao_pdo.php");
include("/srv/http/ecoflow.net.br/api/medicoes.php");
include("/srv/http/ecoflow.net.br/api/bateria.php");
  
$database = new Database();
$db = $database->getConnection();
  
$medicoes = new Medicoes($db);
$bateria = new Bateria($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

if($data->type == "uplink"){
    // make sure data is not empty
    if(
        !empty($data->meta->time) &&
        !empty($data->meta->device_addr) &&
        !empty($data->params->payload) 
    ){

        $nome = "itc03";

        $base = bin2hex(base64_decode($data->params->payload));
        $medidor1 = hexdec(substr($base, 10, 8))/1000;
        $medidorEnergia = hexdec(substr($base, 4, 2));
        $leitura = $medidor1;
        $leituraEnergia = $medidorEnergia;

        $medidor = "medidor";
        $idecoflow = 61016;

        $medicoes->idecoflow = $idecoflow;
        $bateria->device_addr = 61016;

        $medicoes->tempo = date("Y-m-d", $data->meta->time);
        $bateria->tempo = date("Y-m-d", $data->meta->time);
        
        $hora = date("H:i", $data->meta->time);
        $hora .= ":00";
        $medicoes->hora = $hora;
        $bateria->hora = $hora;
        
        $medicoes->id_planta_fk = 62;
        $medicoes->nome = $nome;
        $medicoes->medidor = $medidor;
        $medicoes->servico = 0;            

        $medicoes->leitura = $leitura;
        $bateria->nivel_bateria = $leituraEnergia;
        $bateria->snr = $data->params->radio->hardware->snr;
        $bateria->rssi = $data->params->radio->hardware->rssi;
        
        
        // create the product
        if($medicoes->create() && $bateria->createBateria()){
    
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