<?php 
	include_once('../conexao.php');

	$email = $_POST['email'];

	//busca usuario pelo id e senha
	$result = mysqli_query($con,"SELECT * FROM usuario WHERE email = '$email' ");
	$usuario = mysqli_fetch_object($result);

	if(isset($usuario)){
		$assunto = "Recuperar senha";
		$menssagem = 
		"Login: '$usuario->login'\nSenha: '$usuario->senha'\n\nSite Ecoflow: http://ecoflow.esy.es/";
		$menssagem = wordwrap($menssagem, 70);
		mail($email, $assunto, $menssagem);
		header("Location: ../login/recuperaSenha.php?success=Senha enviada por e-mail.");
	}else{
		header("Location: ../login/recuperaSenha.php?error=E-mail não cadastrado.");
	}


 ?>