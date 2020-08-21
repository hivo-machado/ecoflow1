<?php 
	include_once('../conexao.php');
	session_start();

    $modelo = $_POST['modelo'];
    $fabricante = $_POST['fabricante'];
    $numero = $_POST['numero'];
    
    if($modelo != null){
        //Criar novo grupo no banco
        mysqli_query($con, "INSERT INTO lorawan_modelos(modelo, fabricante, quantidade_medidores) VALUES ('$modelo', '$fabricante', '$numero')");
        header("Location: criaModelo.php?success=Modelo criado com sucesso.");
    }
 ?>