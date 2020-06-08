<?php
include_once('corpoEmail.php');





$orcamento = null;

if(isset($_POST['aguafria']) ){
	$orcamento .= $_POST['aguafria'];
}
if(isset($_POST['aguaquente']) ){
	$orcamento .= ', '.$_POST['aguaquente'];
}
if(isset($_POST['gas']) ){
	$orcamento .= ', '.$_POST['gas'];
}

$nomecond = $_POST['nomecond'];
$numtorres = $_POST['numtorres'];
$numunidades = $_POST['numunidades'];
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$cargo = $_POST['cargo'];
$email = $_POST['email'];
$telcel = $_POST['telcel'];

//pego os dados enviados pelo formulario
$nome_from = "Ecoflow";
//$email_to = "vinicius.eh@outlook.com";
$email_to = 'afraniocoli@gmail.com, vectoramerico@gmail.com';
$assunto = "Pré-Orçamento";
$email_from = "noreplay@ecoflow.net.br";
$mensagem = $headerEmail."
	<h4>Pré-Orçamento</h4>
	Solicitação de pré-orçamento via site ecoflow.<br>
	<br> 
	<strong>Orçamento para: </strong>$orcamento<br> 
	<strong>Nome do Condomínio: </strong>$nomecond<br>
	<strong>Número Total de Torres: </strong>$numtorres<br>
	<strong>Número Total de Unidade: </strong>$numunidades<br>
	<strong>Cargo/Função: </strong>$cargo<br>
	<br> 
	<strong>Nome Completo: </strong>$nome<br> 
	<strong>Email: </strong>$email <br> 
	<strong>Telefone Celular: </strong>$telcel<br>
	<br>
	<br>
	<strong>Obs:</strong><br>
	Não responter este e-mail.<br>
	Este e-mail foi gerado pelo site ecoflow.net.br por uma solicitação de pré-orçamento.<br>
".$footerEmail;

$mensagem = wordwrap( $mensagem, 50);

//Verifica se existe anexo
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){

	// Array com as extensões permitidas
	$_UP['extensoes'] = array('jpg', 'png', 'jpeg', 'gif');

	// Faz a verificação da extensão do arquivo
	$tmpNome = explode('.', $_FILES['arquivo']['name']);
	$extensao = strtolower(end($tmpNome));
	if (array_search($extensao, $_UP['extensoes']) === false) {
		echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou jpeg";
		exit;
	}

	$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb");
	$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"]));
	$anexo = base64_encode($anexo);
	fclose($fp);
	$anexo = chunk_split($anexo);
	$boundary = "XYZ-" . date("dmYis") . "-ZYX";
	$mens = "--$boundary\n";
	$mens .= "Content-Transfer-Encoding: 8bits\n";
	$mens .= "Content-Type: text/html; charset=\"utf-8\"\n\n"; //plain
	$mens .= "$mensagem\n";
	$mens .= "--$boundary\n";
	$mens .= "Content-Type: ".$arquivo["type"]."\n";
	$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n";
	$mens .= "Content-Transfer-Encoding: base64\n\n";
	$mens .= "$anexo\n";
	$mens .= "--$boundary--\r\n";
	$headers = "MIME-Version: 1.0\n";
	$headers .= "From: \"$nome_from\" <$email_from>\r\n";
	$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
	$headers .= "$boundary\n";
	//envio o email com o anexo
	mail($email_to,$assunto,$mens,$headers);
	echo"Email enviado com Sucesso!";
}
//se não tiver anexo
else{
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: \"$nome_from\" <$email_from>\r\n";
	//envia o email sem anexo
	mail($email_to,$assunto,$mensagem, $headers);
	echo"Email enviado com Sucesso!";
}

?>