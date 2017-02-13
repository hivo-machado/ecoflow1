<?php 
	//conexão com BD
	include_once("../conexao.php");

	//Variavel formulario
	$id_grupo = $_POST['id_grupo'];
	$status = $_POST['status'];
	
	$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$id_grupo' ");
	$usuario = mysqli_fetch_object($result);

	//verifica se usuario existe
	if( isset($usuario) ) {
		mysqli_query($con,"UPDATE usuario SET status = '$status' WHERE id_grupo = '$id_grupo'");

		header("Location: alteraGrupo.php?success=Usuários $status.&id_grupo=$id_grupo");	
	}else{
		header("Location: alteraGrupo.php?error=Grupo não existe.&id_grupo=$id_grupo");
	}
 ?>