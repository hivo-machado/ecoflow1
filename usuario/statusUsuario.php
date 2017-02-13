<?php 
	//conexão BD
	include_once('../conexao.php');

	//variavel
	$id_usuario = $_POST['id_usuario'];
	$status = $_POST['status'];
	
	$result = mysqli_query($con, "SELECT * FROM usuario WHERE id = '$id_usuario' ");
	$usuario = mysqli_fetch_object($result);

	//verifica se usuario existe
	if( isset($usuario) ) {
		mysqli_query($con,"UPDATE usuario SET status = '$status' WHERE id = '$id_usuario'");

		header("Location: alteraUsuario.php?success=Usuário $status.&id_usuario=$id_usuario");	
	}else{
		header("Location: alteraUsuario.php?error=Usuário não existe.&id_usuario=$id_usuario");
	}
 ?>