<?php 
	include_once('../conexao.php');
	session_start();

	$id = $_SESSION['idecoflow'];
	$senha = $_POST['senha'];
	$repetirSenha = $_POST['repetirSenha'];
	$senhaAtual = $_POST['senhaAtual'];

	$result = mysqli_query($con,"SELECT * FROM usuario WHERE id = '$id' and senha = '$senhaAtual' ");
	$usuario = mysqli_fetch_object($result);

	if(isset($usuario)){
		if($senha == $repetirSenha){
			mysqli_query($con, "UPDATE usuario SET senha = '$senha' where id = '$id' ");

			header("Location: ../login/alteraConta.php?success=Senha alterado.");
		}else{
			header("Location: ../login/alteraConta.php?error=Senhas Diferentes! confirmar novamente senha");
		}
	}else{
		header("Location: ../login/alteraConta.php?error=Senha inválida!");
	}
 ?>