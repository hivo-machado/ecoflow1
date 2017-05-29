<?php 
	include_once("../conexao.php");


	if (!isset($_SESSION)) {
		session_start();
	}else{
		session_unset();
		session_destroy();
		session_start();
	}

	
	$login  = $_POST['login'];
	$senha  = $_POST['senha'];

	$login = ucfirst(strtolower($login));

	$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'");

	if( $usuario = mysqli_fetch_assoc($resUsuario)){ //Verifica login e senha
		if($usuario["status"] == 'ativo'){ //verifica se usuario e ativo
			// Inicia a sessão com os dados
			session_start();
			$_SESSION["id"] = $usuario["id"];
			$_SESSION["id_unidade"] = $usuario["id_unidade"];
			$_SESSION["id_grupo"] = $usuario["id_grupo"];
			$_SESSION["login"] = $usuario["login"];
			$_SESSION["nome"] = $usuario["nome"];
			$_SESSION["tipo"] = $usuario["tipo"];
			
			if($usuario["tipo"] != 'admin'){
				header("Location: ../home/home.php");
			}else{
				header("Location: ../home/homeAdmin.php");
			}
		}else{
			header("Location: validaLogin.php?error=Usuario desativado!");	
		}
	}else{
		header("Location: validaLogin.php?error=Usuario e/ou senha inválidos!");
	}
		
?>