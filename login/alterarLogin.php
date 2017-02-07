<?php 
	include_once('../conexao.php');
	session_start();

	$id = $_SESSION['id'];
	$login = $_POST['login'];

	$login = ucfirst(strtolower($login));
	
	//busca o nome de login
	$result = mysqli_query($con, "SELECT * FROM usuario where login = '$login'");
	$usuario = mysqli_fetch_object($result);
	//Verifica se já não existe um login com mesmo nome
	if( !isset($usuario) ){
		mysqli_query($con, "UPDATE usuario SET login = '$login' where id = '$id' ");
		$_SESSION["login"] = $login;
		header("Location: ../login/alteraConta.php?success=Login alterado com sucesso.");
	}else{
		header("Location: ../login/alteraConta.php?error=Nome de login já existe.");
	}
	

 ?>