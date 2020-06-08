<?php 
	include_once('../conexao.php');
	session_start();

	$nome = $_POST['nome'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$repetirSenha = $_POST['repetirSenha'];
	$grupo = $_POST['grupo'];
	$tipo = $_POST['tipo'];
	$status = $_POST['status'];

	$nome = strtoupper($nome);

	//Confirma-se as senhas são iguais
	if($senha == $repetirSenha){
		//busca por login
		$result = mysqli_query($con, "SELECT * FROM usuario where login = '$login'");
		$usuario = mysqli_fetch_object($result);

		//Verifica se já não existe um login igual
		if( !isset($usuario) ){
			//busca por nome
			$result = mysqli_query($con, "SELECT * FROM usuario where nome = '$nome'");
			$usuario = mysqli_fetch_object($result);

			//Verifica se já não existe um usuario com mesmo nome
			if( !isset($usuario) ){
				if( ($grupo != null)&&($tipo == 'sind') ){
					mysqli_query($con, "INSERT INTO usuario(id_grupo, login, senha, nome, tipo, status) VALUES ('$grupo', '$login', '$senha', '$nome', '$tipo', '$status')");
					header("Location: criaUsuario.php?success=Usuario síndico criado com sucesso.");
				}else if( $tipo == 'admin' ){
					mysqli_query($con, "INSERT INTO usuario(login, senha, nome, tipo, status) VALUES ('$login', '$senha', '$nome', '$tipo', '$status')");
					header("Location: criaUsuario.php?success=Usuario administrador criado com sucesso.");
				}else{
					header("Location: criaUsuario.php?error=Usuario do tipo Síndico precisa de um grupo.");
				}
			}else{
				header("Location: criaUsuario.php?error=Nome já existe.");
			}
		}else{
			header("Location: criaUsuario.php?error=Login já existe.");
		}

	}else{
		header("Location: criaUsuario.php?error=Senhas distintas! confirmar novamente senha");
	}

	


 ?>