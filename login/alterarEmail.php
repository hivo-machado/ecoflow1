<?php 
	include_once('../conexao.php');
	session_start();

	$id = $_SESSION['idecoflow'];
	$email = $_POST['email'];
	$confEmail = $_POST['confEmail'];
	$senha = $_POST['senha'];

	$result = mysqli_query($con,"SELECT * FROM usuario WHERE id = '$id' and senha = '$senha' ");
	$usuario = mysqli_fetch_object($result);

	if(isset($usuario)){
		if($email == $confEmail){
			mysqli_query($con, "UPDATE usuario SET email = '$email' where id = '$id' ");

			header("Location: ../login/alteraEmail.php?success=E-mail alterado.");
		}else{
			header("Location: ../login/alteraEmail.php?error=E-mail Diferentes! confirmar novamente e-mail");
		}
	}else{
		header("Location: ../login/alteraEmail.php?error=Senha inválida!");
	}

 ?>