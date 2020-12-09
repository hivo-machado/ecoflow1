<?php 
	//conexão com BD
	include_once("../conexao.php");

	//Variavel formulario
	$id_modelo = $_POST['id_modelo'];
    $fabricante = $_POST['fabricante'];
    $numero = $_POST['numero'];

    
	if( isset($fabricante,$numero) ){
		
        mysqli_query($con, "UPDATE lorawan_modelos SET fabricante = '$fabricante', quantidade_medidores = '$numero' where  modelo = '$id_modelo'");
        header("Location: alteraModelo.php?success=Alterado com sucesso.&id_modelo=$id_modelo");

	}

 ?>