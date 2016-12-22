<?php 
	include_once('../conexao.php');

	$email = $_POST['email'];

	//busca usuario pelo id e senha
	$result = mysqli_query($con,"SELECT * FROM usuario WHERE email = '$email' ");
	$usuario = mysqli_fetch_object($result);

	if(isset($usuario)){
		$assunto = "Recuperar senha";
		$menssagem = "Nós recuperamos o login e senha para você.<br><br> <strong>Login: </strong>$usuario->login<br> <strong>Senha: </strong>$usuario->senha<br><br>Entre no nosso site Ecoflow: http://ecoflow.esy.es/";
		$menssagem = wordwrap($menssagem, 70);
		$headers = "Content-type: text/html; charset=utf-8\r\n";
		mail($email, $assunto, $menssagem, $headers);
		header("Location: ../login/recuperaSenha.php?success=Senha enviada por e-mail.");
	}else{
		header("Location: ../login/recuperaSenha.php?error=E-mail não cadastrado.");
	}


 ?>