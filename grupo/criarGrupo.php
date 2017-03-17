<?php 
	include('../conexao.php');

	$nome = $_POST['nome'];
	$link = $_POST['link'];

	$result = mysqli_query($con, "SELECT * FROM xml WHERE link = '$link' ");
	$grupo = mysqli_fetch_object($result);

	if( !isset($grupo) ){
		mysqli_query($con, "INSERT INTO xml(nome, link) VALUES ('$nome', '$link') ");
		header("Location: criaGrupo.php?success=Grupo cadastrado com sucesso.");
	}else{
		header("Location: criaGrupo.php?error=Link já cadastrado.");
	}

 ?>