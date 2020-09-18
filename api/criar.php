<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

date_default_timezone_set('America/Sao_Paulo');

include("../conexao_pdo.php");
include("leituras.php");
include("payloadBup.php");
include("payloadKhomp.php");
include("query.php");
include("status.php");

$database = new Database();
$db = $database->getConnection();
  
$leituras = new Leituras($db);
$status = new Status($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

if($data->type == "uplink"){
    // make sure data is not empty
    if(
        !empty($data->meta->device_addr) &&
        !empty($data->params->payload) 
    ){
        //variaveis recebidas do radio
        $device_addr = $data->meta->device_addr;
        $rssi = $data->params->radio->hardware->rssi;
        $snr = $data->params->radio->hardware->snr;
        $payload = $data->params->payload;

        //variaveis de tempo e hora
        $tempo = date('Y-m-d');
        $hora = date('H:i');

        //Coletar modelo, planta, nome, medidor, servico
        $device = query_device($device_addr);
        $unidades = query_unidades($device_addr);

        $modelo = $device[0]['modelo'];
        $planta = $device[0]['planta'];
        
        //Converter o payload para pegar as leituras e nivel_bateria baseado no modelo do rádio
        switch ($modelo) {
            case "PLCD.019-006":
                $payloadConvertido = converterBup($payload);
                $k = 4;
                break;
            case "ITC100":
                $payloadConvertido = converterKhomp($payload);
                $k = 1;
                break;
        }
        
        //Montar status para ser enviado
        $status->device_addr = $device_addr;
        $status->tempo = $tempo;
        $status->hora = $hora.":00";
        $status->snr = $snr;
        $status->rssi = $rssi;
        $status->nivel_bateria = $payloadConvertido[0];

        //Montar as leituras para serem enviadas
        for($i = 0; $i < $k; $i++){

            $nome = $unidades[$i]['nome'];;
            $medidor = $unidades[$i]['medidor'];
            $servico = $unidades[$i]['servico'];
            $idecoflow = $unidades[$i]['idecoflow'];

            for($j = 1; $j <= $k; $j++){
                if($medidor = $payloadConvertido[$j][1]){
                    $leitura = $payloadConvertido[$j][1];
                }
            }

            if($servico = 0){
                $hora_fim = $hora.":00";

            }elseif($servico = 1){
                $hora_fim = $hora.":01";

            }elseif($servico = 2){
                $hora_fim = $hora.":02";
            }

            //Montar leitura
            $leituras->idecoflow = $idecoflow;
            $leituras->tempo = $tempo;
            $leituras->hora = $hora_fim;
            $leituras->id_ecoflow_fk = $planta;
            $leituras->nome = $nome;
            $leituras->medidor = $medidor;
            $leituras->servico = $servico;
            $leituras->leitura = $leitura;


            // create the product
            if($leituras->createLeituras() && $status->createStatus()){
        
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