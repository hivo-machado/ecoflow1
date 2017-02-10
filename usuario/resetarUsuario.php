<?php 
	//conexão BD
	include_once('../conexao.php');

	//variavel
	$id_usuario = $_POST['id_usuario'];

	$result = mysqli_query($con, "SELECT * FROM usuario WHERE id = '$id_usuario' ");
	$usuario = mysqli_fetch_object($result);

	//verifica se usuario existe
	if( isset($usuario) ) {
		//Se perfil igual a 'usuario' reseta login e senha id_unidade. Senão reseta para id
		if ($usuario->tipo == 'usuario') {
			mysqli_query($con,"UPDATE usuario SET login = '$usuario->id_unidade', senha = '$usuario->id_unidade', email = null, status='ativo' WHERE id = '$id_usuario'");
		}else{
			mysqli_query($con,"UPDATE usuario SET login = '$id_usuario', senha = '$id_usuario', email = null, status='ativo' WHERE id = '$id_usuario'");
		}

		header("Location: alteraUsuario.php?success=Usuário resetado com sucesso.&id_usuario=$id_usuario");	
	}else{
		header("Location: alteraUsuario.php?error=Usuário não existe.&id_usuario=$id_usuario");
	}

 ?>