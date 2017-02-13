<?php 
	//conexão com BD
	include_once("../conexao.php");

	//iniciar sessão
	session_start();

	//varivavel POST
	$id_grupo = $_POST['id_grupo'];
	$rua = $_POST['rua'];
	$numero = $_POST['numero'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$uf = $_POST['uf'];
	$cep = $_POST['cep'];
	$telefone = $_POST['telefone'];
	
	if($telefone != null){
		mysqli_query($con, "UPDATE grupo SET rua = '$rua', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$uf', cep = '$cep', telefone = '$telefone' where  id = '$id_grupo'");
		header("Location: alteraGrupo.php?success=Endereço alterado com sucesso.&id_grupo=$id_grupo");
	}else{
		mysqli_query($con, "UPDATE grupo SET rua = '$rua', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$uf', cep = '$cep' where  id = '$id_grupo'");
		header("Location: alteraGrupo.php?success=Endereço alterado com sucesso.&id_grupo=$id_grupo");
	}


 ?>