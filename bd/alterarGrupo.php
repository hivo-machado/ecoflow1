<?php 
	include('../conexao.php');

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$link = $_POST['link'];

	$result = mysqli_query($con, "SELECT * FROM xml WHERE id = '$id' ");
	$grupo = mysqli_fetch_object($result);

	if( isset($grupo) ){
		mysqli_query($con, "UPDATE xml SET nome='$nome', link='$link' WHERE id = '$id' ");
		header("Location: alteraGrupo.php?success=Grupo alterado com sucesso.&id_grupo=$id");
	}else{
		header("Location: alteraGrupo.php?error=Grupo não cadastrado.&id_grupo=$id");
	}

 ?>