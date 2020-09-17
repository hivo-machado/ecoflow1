<?php
// class Query{

//     // Conexao com o database e o nome da tabela
//     private $conn;
//     private $table_devices = "lorawan_devices";
//     private $table_unidades = "lorawan_unidades";
//     private $table_idecoflow = "lorawan_idecoflow";
// }
include('../conexao.php');

function query_device($device_addr){

    $result_device = mysqli_query($con, "SELECT modelo, planta FROM lorawan_devices WHERE device_addr = '$device_addr'");
    $i = 0;

    while( $device = mysqli_fetch_object($result_device) ){
        
        $devices[$i]['modelo'] = $device->modelo;
        $devices[$i]['planta'] = $device->planta;
        $i++;
    }

    return $devices;
}

function query_unidades($device_addr){

    $result_unidades = mysqli_query($con, "SELECT nome, medidor, servico FROM lorawan_unidades WHERE device_addr = '$device_addr'");
    $i = 0;

    while( $unidade = mysqli_fetch_object($result_unidades) ){
        
        $unidades[$i]['nome'] = $unidade->nome;
        $unidades[$i]['medidor'] = $unidade->medidor;
        $unidades[$i]['servico'] = $unidade->servico;
        
        $result_idecoflow = mysqli_query($con, "SELECT idecoflow FROM lorawan_idecoflow WHERE device_addr = '$device_addr'");
        
        while( $id = mysqli_fetch_object($result_idecoflow) ){

            $unidades[$i]['idecoflow'] = $id->idecoflow;

        }

        $i++;
    }
    
    return $unidades;
}
?>