<?php
//Conexão com banco de dados
include_once("../conexao.php");

	$tipo = 'usuario';
	$status = 'ativo';
	
	//Busca todos os usuarios
	$Usuarios = mysqli_query($con,"SELECT DISTINCT un.idecoflow, un.nome, gr.id grupo, pl.idecoflow planta FROM unidade un, planta pl, grupo gr WHERE un.id_planta_fk = pl.idecoflow AND pl.id_grupo_fk = gr.id");

	if(mysqli_num_rows($Usuarios)){
		while ($usuario = mysqli_fetch_object($Usuarios)) {
			//verifica se usuario não existe
			$resUsuario = mysqli_query($con,"SELECT * from usuario where id_unidade = '$usuario->idecoflow' ");
			$objUsuario = mysqli_fetch_object($resUsuario);
			if(!isset($objUsuario)){
				//Insere novo usuario
				mysqli_query($con, "INSERT INTO usuario( id_unidade, id_planta, id_grupo, login, senha, nome, tipo, status) VALUES ('$usuario->idecoflow', '$usuario->planta', '$usuario->grupo', '$usuario->idecoflow', '$usuario->idecoflow', '$usuario->nome', '$tipo', '$status')");
			}
		}
		header("Location: criaUsuario.php?success=Usuarios criados com sucessos.");
	}else{
		header("Location: criaUsuario.php?error=Não exite usuário para inserir");
	}
?>