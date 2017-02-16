<?php 
	//Atividade CRON para verificar se todas as torres estão online

	//Conexão com banco de dados
	include_once("../conexao.php");

	//E-mail
	$email = 'v1n1c1u5_1@hotmail.com, v1n3k0@outlook.com';

	//Data atual
  	date_default_timezone_set('UTC');
  	$tempoAtual = strtotime( date('Y-m-d') );

  	//Data de teste
	//$tempoAtual = strtotime('2017-01-05');
	
	//Data do dia anterior
	$tempoAnt = strtotime('-1 day', $tempoAtual);
	$dataAnt =  date_format( date_create( date('Y-m-d', $tempoAnt) ),'Y-m-d' );

	$grupos = mysqli_query($con, "SELECT * FROM grupo");

	while ( $grupo = mysqli_fetch_object($grupos) ) {
		//flag para enviar ou não enviar e-mail
		$flag = false;
		$str = null;

		$str = $str.'<strong>Grupo: '.$grupo->nome.'</strong><br>';
		
		$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$grupo->id'");

		while ( $planta = mysqli_fetch_object($plantas) ) {

			$result = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$planta->idecoflow' AND tempo = '$dataAnt' GROUP BY idecoflow");
			
			if( mysqli_fetch_object($result) ) {
				$str = $str.'Torre: [ON] - '.$planta->nome.'<br>';
			}else{
				$str = $str.'<strong>Torre: [OFF] - '.$planta->nome.'</strong><br>';
				$flag = true;
			}

		}
		
		if($flag){
			//envia e-email
			$assunto = "Torres Offline";
			$menssagem = "
			O sistema verificou torres offline.<br>
			Data: $dataAnt<br>
			<br> 
			$str
			<br>
			Entre em nosso site <a href='ecoflow-gratis.umbler.net'>Ecoflow</a>
			<br>
			";
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}

		echo $menssagem;
		
	}

 ?>