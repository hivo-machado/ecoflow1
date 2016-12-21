<?php 
	include_once('../conexao.php');
	session_start();

	$id = $_SESSION['idecoflow'];
	$login = $_POST['login'];

	mysqli_query($con, "UPDATE usuario SET login = '$login' where id = '$id' ");

	header("Location: ../login/alteraConta.php?success=Login alterado com sucesso.");	
 ?>