<?php 
	include_once('../conexao.php');
	session_start();

	$id = $_SESSION['id'];
	$senha = $_POST['senhaNova'];
	$repetirSenha = $_POST['repetirSenha'];
	$senhaAtual = $_POST['senha'];

	//Confirma senhas iguais
	if($senha == $repetirSenha){
		//busca usuario pelo id e senha
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE id = '$id' and senha = '$senhaAtual' ");
		$usuario = mysqli_fetch_object($result);
		//valida a senha
		if(isset($usuario)){
			mysqli_query($con, "UPDATE usuario SET senha = '$senha' where id = '$id' ");

			header("Location: ../login/alteraConta.php?success=Senha alterado.");
		}else{
			header("Location: ../login/alteraConta.php?error=Senha inválida!");
		}
	}else{
		header("Location: ../login/alteraConta.php?error=Senhas distintas! confirmar novamente senha");
	}
	

?>