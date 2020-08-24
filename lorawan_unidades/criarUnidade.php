<?php 
	include_once('../conexao.php');
	session_start();

    $nome = $_POST['nome'];
    $medidor = $_POST['medidor'];
    $servico = $_POST['servico'];
    $device = $_POST['device'];
    
    
    if($nome != null){
        //Criar novo grupo no banco
        mysqli_query($con, "INSERT INTO lorawan_unidades(nome, medidor, servico, device_addr) VALUES ('$nome', '$medidor', '$servico', '$device')");
        header("Location: criaUnidade.php?success=Unidade criada com sucesso.");
    }
 ?>