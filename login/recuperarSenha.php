<?php 
	include_once('../conexao.php');

	$email = $_POST['email'];

	//busca usuario pelo e-mail
	$result = mysqli_query($con,"SELECT * FROM usuario WHERE email = '$email' ");


	if(mysqli_num_rows($result)){

		while( $usuario = mysqli_fetch_object($result) ){

			//envia e-email com login e senha
			$assunto = "Recuperar senha";
			$menssagem = "
			<!DOCTYPE html>
			<html>
			<head>
				<title>E-mail</title>
				<style type='text/css' media='screen'>
					body{
						background-color: #f6f6f6;
						color: #1d1d1d;
						font-family: 'Times New Roman', Times, serif;
					}
					h3{
						margin: 0px 0px 0px 20px;
						font-family: Arial, Helvetica, sans-serif;
						color: #00a6d3;
					}
					h4{
						margin: 8px 0px 8px 0px;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 16px;
					}
					strong{
						font-family: Arial, Helvetica, sans-serif;
					}
					#titulo{
						padding: 10px;
					}
					#conteudo{
						margin: 15px 30px 15px 40px;
						font-size: 14px;
					}
					#contato{
						border-top: 1px solid #1d1d1d;
						margin: 20px 25px 0px 25px;
						padding-top: 5px;
						font-size: 13px;
					}
				</style>
			</head>
			<body>
				<div id='titulo'>
					<a href='www.ecoflow.net.br'>
						<img src='http://www.ecoflow.net.br/images/logonovo.png' alt='Logo Ecoflow' >
					</a>
					<h3>Economia de água e gás</h3>
				</div>
				<div id='conteudo'>
					<h4>Recuperar Senha</h4>
					Nós recuperamos o login e senha para você.<br>
					<br>
					<strong>Login:</strong> 2222<!--$usuario->login--><br> 
					<strong>Senha:</strong> 2222<!--$usuario->senha--><br>
				</div>
				<div id='contato'>
					<strong>Contato Ecoflow</strong><br>
					<br>
					<strong>Tel.:</strong> (35) 3622-7522<br>
					<strong>Cel.:</strong> (35) 98875-8875<br>
					<strong>E-mail:</strong> <a href='mailto:contato@ecoflow.net.br'>contato@ecoflow.net.br</a><br>
					<strong>Site:</strong> <a href='www.ecoflow.net.br'>Ecoflow</a>
				</div>				
			</body>
			</html>
			";
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}
		
		header("Location: ../login/recuperaSenha.php?success=Senha enviada por e-mail.");

	}else{
		header("Location: ../login/recuperaSenha.php?error=E-mail não cadastrado.");
	}




 ?>