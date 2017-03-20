<?php 
	include_once('../conexao.php');

	$email = $_POST['email'];

	//busca usuario pelo e-mail
	$result = mysqli_query($con,"SELECT * FROM usuario WHERE email = '$email' ");


	if(mysqli_num_rows($result)){

		while( $usuario = mysqli_fetch_object($result) ){

			//envia e-email com login e senha
			$assunto = "Recuperar senha";
			$menssagem = "
			Nós recuperamos o login e senha para você.<br>
			<br> 
			<strong>Login: </strong>$usuario->login<br> 
			<strong>Senha: </strong>$usuario->senha<br>
			<br>
			Entre em nosso site <a href='ecoflow.000webhostapp.com'>Ecoflow</a>
			<br>
			<a href='ecoflow.000webhostapp'>
				<img src='ecoflow.000webhostapp.com/img/ECOFlow.jpg' alt='Logo Ecoflow' height='34.5' width='199'>
			</a>
			";
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.com>\r\n";
			$headers .= "Return-Path: <noreplay@ecoflow.com>\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}
		
		header("Location: ../login/recuperaSenha.php?success=Senha enviada por e-mail.");

	}else{
		header("Location: ../login/recuperaSenha.php?error=E-mail não cadastrado.");
	}




 ?>