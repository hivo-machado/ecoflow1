<?php 
	include_once('../conexao.php');
	session_start();

    $deviceAddr = $_POST['id'];
    $modelo = $_POST['modelo'];
    $planta = $_POST['planta'];
    
    if($modelo != null){
        //Criar novo grupo no banco
        mysqli_query($con, "INSERT INTO lorawan_devices(device_addr, modelo, planta) VALUES ('$deviceAddr', '$modelo', '$planta')");
        header("Location: criaDevice.php?success=Modelo criado com sucesso.");
    }
 ?>