<?php include_once("../conexao.php") ?>

<?php 
	
	$login  = $_POST['login'];
	$senha  = $_POST['senha'];

	$result = mysqli_query($con, "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'") or die("Erro ao pesquisar login" . mysqli_error());

	if($registro = mysqli_fetch_assoc($result)){
		$nome = $registro["nome"];
		$login = $registro["login"];
		$tipo = $registro["tipo"];
		// Inicia a sessão com os dados
		session_start();
		$_SESSION["nome"] = $nome;
		$_SESSION["login"] = $login;
		$_SESSION["tipo"] = $tipo;			
		
		header("Location: ../grafico/grafico.php");
	}else{
		header("Location: login.php?error=Usuario e/ou senha inválidos!");
	}
		
?>