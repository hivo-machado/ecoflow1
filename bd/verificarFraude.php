<?php 
	//Atividade CRON para verificar possiveis fraudes de consumo zerado

	//Conexão com banco de dados
	include_once("/home/ecofl253/public_html/conexao.php");
	include_once("/home/ecofl253/public_html/corpoEmail.php");

	//E-mail
	$email = 'none';
	
	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');
	
	//Data atual
  	$tempoAtual = strtotime( date('Y-m-d'));
	
	//Data do dia anterior
	$tempoAnt = strtotime('-1 day', $tempoAtual);
    $dataAnt =  date_format( date_create( date('Y-m-d', $tempoAnt) ),'Y-m-d' );
    
    //Data de uma semana anterior
    $tempo1Sem = strtotime('-1 week', $tempoAtual);
    $data1Sem =  date_format( date_create( date('Y-m-d', $tempo1Sem) ),'Y-m-d' );

    //Data de duas semanas anteriores
    $tempo2Sem = strtotime('-2 week', $tempoAtual);
    $data2Sem =  date_format( date_create( date('Y-m-d', $tempo2Sem) ),'Y-m-d' );

	$arrayFraude = array();
	
	$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE 'status' = 'ativo' AND tipo = 'usuario' ORDER BY nome ASC");
	
	while($usuario = mysqli_fetch_object($usuarios)){
		for($n = 0; $n < 3; $n++){

			if($n = 0){
				$servico = 'ÁGUA';
			}else if($n = 1){
				$servico = 'ÁGUA QUENTE';
			}else if($n = 2){
				$servico = 'GÁS';
			}

			$leituras = mysqli_query($con, "SELECT leitura FROM unidade WHERE tempo = $dataAnt AND servico = $n ORDER BY hora ASC");
			$leitura = mysqli_fetch_object($leituras);

			$leituras1Sem = mysqli_query($con, "SELECT leitura FROM unidade WHERE tempo = $data1Sem AND servico = $n ORDER BY hora ASC");
			$leitura1Sem = mysqli_fetch_object($leituras1Sem);

			$leituras2Sem = mysqli_query($con, "SELECT leitura FROM unidade WHERE tempo = $data2Sem AND servico = $n ORDER BY hora ASC");
			$leitura2Sem = mysqli_fetch_object($leituras2Sem);

			$flag2Sem = $leitura - $leitura2Sem;
			$flag1Sem = $leitura - $leitura1Sem;
			
			if($flag2Sem = 0){
				$arrayFraude[$usuario->nome] = array($servico, 'sem consumo a duas semanas');
			}else if($flag1Sem = 0){
				$arrayFraude[$usuario->nome] = array($servico, 'sem consumo a um semana');
			}
			
		}
	} //while usuarios
 ?>