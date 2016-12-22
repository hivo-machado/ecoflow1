<?php 
	include_once('../conexao.php');
	include_once('../regexp/regexp.php');
	session_start();

	$id = $_SESSION['idecoflow'];
	$senha = $_POST['senha'];
	$repetirSenha = $_POST['repetirSenha'];
	$senhaAtual = $_POST['senhaAtual'];

	//verifica formato da senha
	if(validaSenha($senha)){
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
			header("Location: ../login/alteraConta.php?error=Senhas Diferentes! confirmar novamente senha");
		}
	}else{
		header("Location: ../login/alteraConta.php?error=Senha inválida! verifique se a senha possui tamanho de 6 a 20 caracteres sem espaço em branco.");
	}

 ?>