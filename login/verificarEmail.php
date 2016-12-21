<?php 
	include_once('../conexao.php');

	$id = $_SESSION['idecoflow'];

	$result = mysqli_query($con, "SELECT * FROM usuario where id = '$id'");
	$usuario = mysqli_fetch_object($result);

	if(!isset($usuario->email)){
		header("Location: ../login/alteraEmail.php?error=Cadastre primeiro o e-mail.");
	}

 ?>