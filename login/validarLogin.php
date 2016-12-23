<?php include_once("../conexao.php") ?>

<?php 
	
	$login  = $_POST['login'];
	$senha  = $_POST['senha'];

	$login = ucfirst(strtolower($login));

	$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'");

	$resUsuarioAtivo = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha' and status = 'ativo'");

	if( $usuario = mysqli_fetch_assoc($resUsuario)){
		if($registro = mysqli_fetch_assoc($resUsuarioAtivo)){
			$login = $registro["login"];
			$nome = $registro["nome"];
			$id = $registro["id"];
			$tipo = $registro["tipo"];
			// Inicia a sessão com os dados
			session_start();
			$_SESSION["login"] = $login;
			$_SESSION["nome"] = $nome;
			$_SESSION["idecoflow"] = $id;
			$_SESSION["tipo"] = $tipo;						
			header("Location: ../relatorio/graficoMes.php");
		}else{
			header("Location: validaLogin.php?error=Usuario desativado!");	
		}
	}else{
		header("Location: validaLogin.php?error=Usuario e/ou senha inválidos!");
	}
		
?>