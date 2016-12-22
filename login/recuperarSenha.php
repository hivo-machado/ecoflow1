<?php 
	include_once('../conexao.php');

	$email = $_POST['email'];

	//busca usuario pelo id e senha
	$result = mysqli_query($con,"SELECT * FROM usuario WHERE email = '$email' ");
	$usuario = mysqli_fetch_object($result);

	if(isset($usuario)){
		$assunto = "Recuperar senha";
		$menssagem = 
		"Login: '$usuario->login'\n
		Senha: '$usuario->senha'\n\n
		Site Ecoflow: http://ecoflow.esy.es/";
		$menssagem = wordwrap($menssagem, 70);
		mail($email, $assunto, $menssagem);
	}


 ?>