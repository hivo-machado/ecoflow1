<?php
//Conexão com banco de dados
include_once("../conexao.php");

	$tipo = 'usuario';
	
	//Busca todos os usuarios
	$todosUsuario = mysqli_query($con,"SELECT DISTINCT idecoflow from unidade");

	if(isset($todosUsuario)){
			while ($usuario = mysqli_fetch_object($todosUsuario)) {
				//verifica se usuario não existe
				$selUsuario = mysqli_query($con,"SELECT * from usuario where login = '$usuario->idecoflow' ");
				if(isset($selUsuario)){
					//Insere novo usuario
					mysqli_query($con, "INSERT INTO usuario (login, senha, tipo) VALUES ('$usuario->idecoflow', '$usuario->idecoflow', '$tipo')");
					echo $usuario->idecoflow.'<br>';
				}
			}
	}else{
		echo 'Não exite usuario na unidade';
	}
?>