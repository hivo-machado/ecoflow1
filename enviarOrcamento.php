<?php 
	$aguafria = $_POST['aguafria'];
	$aguaquente = $_POST['aguaquente'];
	$gas = $_POST['gas'];
	$nomecond = $_POST['nomecond'];
	$numtorres = $_POST['numtorres'];
	$numpavtorre = $_POST['numpavtorre'];
	$numunpav = $_POST['numunpav'];
	$numunidades = $_POST['numunidades'];
	$nome = $_POST['nome'];
	$endereco = $_POST['endereco'];
	$cargo = $_POST['cargo'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$email = $_POST['email'];
	$telfixo = $_POST['telfixo'];
	$telcel = $_POST['telcel'];
	$obs = $_POST['obs'];

	$orcamento = null;

	if(isset($aguafria)){
		$orcamento .= $aguafria;
	}
	if(isset($aguaquente)){
		$orcamento .= ', '.$aguaquente;
	}
	if(isset($gas)){
		$orcamento .= ', '.$gas;
	}

	$sendemail = 'afraniocoli@gmail.com, vectoramerico@gmail.com';

	//envia e-email com login e senha
	$assunto = "Pré Orçamento";
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
			<h4>Pré-Orçamento</h4>
			Solicitação de pré-orçamento via site ecoflow.<br>
			<br> 
			<strong>Orçamento para: </strong>$orcamento<br> 
			<strong>Nome do Condomínio: </strong>$nomecond<br>
			<strong>Número Total de Torres: </strong>$numtorres<br>
			<strong>Número de Andares por Torre: </strong>$numpavtorre<br>
			<strong>Número de Unidades por Andar: </strong>$numunpav<br>
			<strong>Número Total de Unidade: </strong>$numunidades<br>
			<br> 
			<strong>Nome Completo: </strong>$nome<br> 
			<strong>Endereço: </strong>$endereco<br>
			<strong>Cargo/Função: </strong>$cargo<br>
			<strong>Cidade: </strong>$cidade<br>
			<strong>Estado: </strong>$estado<br>
			<br> 
			<strong>Email: </strong>$email <br> 
			<strong>Telefone Fixo: </strong>$telfixo<br>
			<strong>Telefone Celular: </strong>$telcel<br>
			<strong>Observações Gerais: </strong>$obs<br>
			<br>
			<br>
			<strong>Obs:</strong><br>
			Não responter este e-mail.<br>
			Este e-mail foi gerado pelo site ecoflow.net.br por uma solicitação de pré-orçamento.<br>
		</div>
		<div id='contato'>
			<h4>Contato Ecoflow</h4>
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
	mail($sendemail, $assunto, $menssagem, $headers);

 ?>