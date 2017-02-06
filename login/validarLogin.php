<?php include_once("../conexao.php") ?>

<?php 
	
	$login  = $_POST['login'];
	$senha  = $_POST['senha'];

	$login = ucfirst(strtolower($login));

	$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'");

	if( $usuario = mysqli_fetch_assoc($resUsuario)){ //Verifica login e senha
		if($usuario["status"] == 'ativo'){ //verifica se usuario e ativo
			// Inicia a sessão com os dados
			session_start();
			$_SESSION["id"] = $usuario["id"];
			$_SESSION["idecoflow"] = $usuario["id_unidade"];
			$_SESSION["login"] = $usuario["login"];
			$_SESSION["nome"] = $usuario["nome"];
			$_SESSION["tipo"] = $usuario["tipo"];
			
			header("Location: ../home/home.php");
		}else{
			header("Location: validaLogin.php?error=Usuario desativado!");	
		}
	}else{
		header("Location: validaLogin.php?error=Usuario e/ou senha inválidos!");
	}
		
?>