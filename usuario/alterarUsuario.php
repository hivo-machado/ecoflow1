<?php 
	//Conexão com BD
	include_once('../conexao.php');

	//varivael
	$id_usuario = $_POST['id_usuario'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$repetirSenha = $_POST['repetirSenha'];

	//Confirma senhas iguais
	if($senha == $repetirSenha){
		mysqli_query($con, "UPDATE usuario SET login = '$login', senha = '$senha' where id = '$id_usuario' ");
		header("Location: alteraUsuario.php?success=Usuário alterado com sucesso.&id_usuario=$id_usuario");
	}else{
		header("Location: alteraUsuario.php?error=Senhas distintas! confirmar novamente senha&id_usuario=$id_usuario");
	}
 ?>