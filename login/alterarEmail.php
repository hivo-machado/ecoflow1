<?php 
	include_once('../conexao.php');
	include_once('../regexp/regexp.php');
	session_start();

	$id = $_SESSION['idecoflow'];
	$email = $_POST['email'];
	$confEmail = $_POST['confEmail'];
	$senha = $_POST['senha'];


	//valida formatação do e-mail
	if(validaEmail($email)){
		//verifica e-mails são iguais
		if($email == $confEmail){
			//busca usuario pelo id e senha
			$result = mysqli_query($con,"SELECT * FROM usuario WHERE id = '$id' and senha = '$senha' ");
			$usuario = mysqli_fetch_object($result);
			//valida senha
			if(isset($usuario)){
						mysqli_query($con, "UPDATE usuario SET email = '$email' where id = '$id' ");
						header("Location: ../login/alteraEmail.php?success=E-mail atualizado com sucesso.");
			}else{
				header("Location: ../login/alteraEmail.php?error=Senha inválida!");
			}
		}else{
			header("Location: ../login/alteraEmail.php?error=E-mail Diferentes! confirmar novamente e-mail.");
		}
	}else{
		header("Location: ../login/alteraEmail.php?error=E-mail invalido. $valida");
	}

 ?>