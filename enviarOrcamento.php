<?php 
	$aguafria = $_POST['aguafria'];
	$aguaquente = $_POST['aguaquente'];
	$gas = $_POST['gas'];
	$nomecond = $_POST['nomecond'];
	$numtorres = $_POST['numtorres'];
	$numpavtorre = $_POST['numpavtorre'];
	$numunpav = $_POST['numunpav'];
	$nome = $_POST['nome'];
	$endereco = $_POST['endereco'];
	$cargo = $_POST['cargo'];
	$cidade = $_POST['cidade'];
	$email = $_POST['email'];
	$telfixo = $_POST['telfixo'];
	$telcel = $_POST['telcel'];
	$obs = $_POST['obs'];

	$orcamento = null;

	if(isset($aguafria)){
		$orcamento .= $aguafria;
	}
	if(isset($aguaquente)){
		$orcamento .= ','.$aguaquente;
	}
	if(isset($gas)){
		$orcamento .= ','.$gas;
	}

	$sendemail = 'contato@ecoflow.net.br, admin@ecoflow.net.br';

	//envia e-email com login e senha
	$assunto = "Pré Orçamento";
	$menssagem = "
	Solicitação de pré-orçamento via site ecoflow.<br>
	<br> 
	<strong>Orçamento para: </strong>$orcamento<br> 
	<strong>Nome do Condomínio: </strong>$nomecond<br>
	<strong>Número Total de Torres: </strong>$numtorres<br>
	<strong>Número de Andares por Torre: </strong>$numpavtorre<br>
	<strong>Número de Unidades por Andar: </strong>$numunpav<br>
	<br> 
	<strong>Nome Completo: </strong>$nome<br> 
	<strong>Endereço: </strong>$endereco<br>
	<strong>Cargo/Função: </strong>$cargo<br>
	<strong>Cidade/UF: </strong>$cidade<br>
	<br> 
	<strong>Email: </strong>$email <br> 
	<strong>Telefone Fixo: </strong>$telfixo<br>
	<strong>Telefone Celular: </strong>$telcel<br>
	<strong>Observações Gerais: </strong>$obs<br>
	<br>
	<br>
	<strong>Obs: </strong>Não responter este e-mail.<br>
	Este e-mail foi gerado pelo site ecoflow.net.br por uma solicitação de pré-orçamento.<br>
	";
	$menssagem = wordwrap($menssagem, 70);
	$headers = "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: <noreplay@ecoflow.com>\r\n";
	mail($sendemail, $assunto, $menssagem, $headers);

 ?>