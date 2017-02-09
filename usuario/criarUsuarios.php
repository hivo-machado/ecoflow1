<?php
//Conexão com banco de dados
include_once("../conexao.php");

	$tipo = 'usuario';
	$status = 'ativo';
	
	//Busca todos os usuarios
	$todosUsuario = mysqli_query($con,"SELECT DISTINCT un.idecoflow, un.nome, gr.id FROM unidade un, planta pl, grupo gr WHERE un.id_planta_fk = pl.idecoflow AND pl.id_grupo_fk = gr.id");

	if(isset($todosUsuario)){
		while ($usuario = mysqli_fetch_object($todosUsuario)) {
			//verifica se usuario não existe
			$resUsuario = mysqli_query($con,"SELECT * from usuario where login = '$usuario->idecoflow' ");
			$objUsuario = mysqli_fetch_object($resUsuario);
			if(!isset($objUsuario)){
				//Insere novo usuario
				mysqli_query($con, "INSERT INTO usuario( id_unidade, id_grupo, login, senha, nome, tipo, status) VALUES ('$usuario->idecoflow', '$usuario->id', '$usuario->idecoflow', '$usuario->idecoflow', '$usuario->nome', '$tipo', '$status')");
			}
		}
		header("Location: criaUsuario.php?success=Usuarios criados com sucessos.");
	}else{
		header("Location: criaUsuario.php?error=Não exite usuario para inserir");
	}
?>