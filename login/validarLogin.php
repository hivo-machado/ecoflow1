<?php include_once("../conexao.php") ?>

<?php 
	
	$login  = $_POST['login'];
	$senha  = $_POST['senha'];

	$login = ucfirst(strtolower($login));

	$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'");

	$resUsuarioAtivo = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha' and status = 'ativo'");

	if( $usuario = mysqli_fetch_assoc($resUsuario)){
		if($registro = mysqli_fetch_assoc($resUsuarioAtivo)){
			// Inicia a sessão com os dados
			session_start();
			$_SESSION["id"] = $registro["id"];
			$_SESSION["idecoflow"] = $registro["id_unidade"];
			$_SESSION["login"] = $registro["login"];
			$_SESSION["nome"] = $registro["nome"];
			$_SESSION["tipo"] = $registro["tipo"];			
			header("Location: ../home/home.php");
		}else{
			header("Location: validaLogin.php?error=Usuario desativado!");	
		}
	}else{
		header("Location: validaLogin.php?error=Usuario e/ou senha inválidos!");
	}
		
?>