<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include("/home/ecofl253/public_html/conexao_pdo.php");
// include("/home/ecofl253/public_html/lorawan/medicoes.php");
// include("/home/ecofl253/public_html/lorawan/bateria.php");
// include("/home/ecofl253/public_html/lorawan/payloadItc.php");
// include("/home/ecofl253/public_html/lorawan/payloadBup.php");

include("/srv/http/ecoflow.net.br/conexao_pdo.php");
include("/srv/http/ecoflow.net.br/lorawan/api/medicoes.php");
include("/srv/http/ecoflow.net.br/lorawan/api/bateria.php");
include("/srv/http/ecoflow.net.br/lorawan/api/payloadItc.php");
include("/srv/http/ecoflow.net.br/lorawan/api/payloadBup.php");

$database = new Database();
$db = $database->getConnection();
  
$medicoes = new Medicoes($db);
$bateria = new Bateria($db);

$json = json_decode(file_get_contents("php://input"));

if($json->type == "uplink"){
    if(
        !empty($json->meta->device_addr) &&
        !empty($json->params->radio->hardware->snr) &&
        !empty($json->params->radio->hardware->rssi) &&
        !empty($json->params->payload)
        ){  
            //idecoflow sendo gerado a partir do device_addr
            $idecoflow = $json->meta->device_addr;

            //Variáveis de qualidade do sinal
            $snr = $json->params->radio->hardware->snr;
            $rssi = $json->params->radio->hardware->rssi;

            //Variáveis de tempo do servidor
            $tempo = date("Y-m-d");
            $hora = date("H:i");

            //Payload decodificado para hexadecimal
            $payload = bin2hex(base64_decode($json->params->payload));
            
            //$leituras = converterItc($payload);
            $leituras = converterBup($payload);

            //Enviar status do dispositivo

            //Enviar medições
            for($i=0; $i < count($leituras); $i++){
                
                $medicoes->idecoflow = $idecoflow."-".$i;
                $medicoes->tempo = $tempo;
                $medicoes->hora = $hora;

                $medicoes->id_planta_fk = $leituras[$i][4];
                $medicoes->nome = $leituras[$i][3];
                $medicoes->servico = $leituras[$i][2];                
                $medicoes->medidor = $leituras[$i][1];
                $medicoes->leitura = $leituras[$i][0];

                if($medicoes->create()){                    
                    http_response_code(201);
                    echo json_encode(array("message" => "Medicao foi importada."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("message" => var_dump($medicoes)));
                }
            }            
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Problema ao importar medicao. Falta informacao."));
        }
} else {
    http_response_code(200);
    echo json_encode(array("message" => "ACK"));
}
?>



