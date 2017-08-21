<?php 
	//Atividade CRON para verificar se não existe consumo excessivo

	//Conexão com banco de dados
	include_once("/home/ecofl253/public_html/conexao.php");
	include_once("/home/ecofl253/public_html/corpoEmail.php");
	//include('../conexao.php');
	//include('../corpoEmail.php');

	// Tempo de execução maxima do programa 10 min.
	ini_set('max_execution_time',600);

	//Razão pelo consumo medio
	define("RAZAO", 3);

	//E-mail
	//define("EMAIL", "vectoramerico@gmail.com, lucineia@vector.eng.br, v1n1c1u5_1@hotmail.com");
	define("EMAIL", "v1n1c1u5_1@hotmail.com");

	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');


  	//***********************************************************************************************************************
	
	//Data mes atual
  	$tempoAtual = strtotime( date('Y-m-d') );
  	//$tempoAtual = strtotime( '30-06-2017' );
  	$dataAtual =  date_format( date_create( date('Y-m-d', $tempoAtual) ),'Y-m-d' );

  	//Data do dia anterior
	$tempoAnterior = strtotime('-1 day', $tempoAtual);
	$dataDiaAnterior =  date_format( date_create( date('Y-m-d', $tempoAnterior) ),'Y-m-d' );

  	//Data de 1 meses anterior
	$tempoAnterior = strtotime('-1 month', $tempoAtual);
	$dataMesAnterior =  date_format( date_create( date('Y-m-d', $tempoAnterior) ),'Y-m-d' );

	echo "Tempo Atual: ", $dataAtual, " Tempo dia anterior: ", $dataDiaAnterior, " Tempo mes anterior: ", $dataMesAnterior, "<br>";

  	//Pesquisa todos usuario do tipo usuario e ativos
  	$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE tipo = 'usuario' AND status = 'ativo' AND id_unidade IS NOT null");

  	//String com idEcoflow dos alertas
  	$idecoflow = "";
  	$cont = 0;

  	
  	while ($usuario = mysqli_fetch_object($usuarios) ){

		//Primeira Leitura do dia atual
		$unidadeMesAtualSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataAtual' AND servico = '0' ORDER BY tempo DESC, hora ASC LIMIT 1");
  		$unidadeAtual = mysqli_fetch_object($unidadeMesAtualSelect);

  		if($unidadeAtual != null){
  			
			//Leitura do dia anterior
			$unidadeDiaAnteriorSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataDiaAnterior' AND servico = '0' ORDER BY hora ASC LIMIT 1");
	  		$unidadeDiaAnterior = mysqli_fetch_object($unidadeDiaAnteriorSelect);	  		
	  		
	  		if($unidadeDiaAnterior != null){

	  			//Leitura no mes anterior
				$unidadeMesAnteriorSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo <= '$dataMesAnterior' AND servico = '0' ORDER BY tempo DESC, hora ASC LIMIT 1");
		  		$unidadeMesAnterior = mysqli_fetch_object($unidadeMesAnteriorSelect);

		  		//Calcula quantidade de dias *Recalcular caso não exista leitura exatamente no dia
				$segundos = strtotime($unidadeAtual->tempo) - strtotime($unidadeMesAnterior->tempo);
				$dias = floor($segundos / (60 * 60 * 24) );

				//Calcular media de consumo dos ultimos meses
				$consumoMedio = ($unidadeAtual->leitura - $unidadeMesAnterior->leitura) / $dias;

				//Consumo do dia anterior
	  			$consumoDia = $unidadeAtual->leitura - $unidadeDiaAnterior->leitura;


		  		//Alerta de consumo fora do padrão
		  		if($consumoDia > $consumoMedio * RAZAO){

		  			$unidades = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataDiaAnterior' AND servico = '0' ORDER BY hora DESC");

		  			$leituraAnterior = $unidadeAtual->leitura;
		  			$alerta = true;

		  			while ($unidade = mysqli_fetch_object($unidades) ){
		  				$leitura = $unidade->leitura;
		  				$consumo = $leituraAnterior - $leitura;
		  				//echo ' Anterior: ', $leituraAnterior, ' atual: ', $leitura, '<br>';
		  				echo $consumo,'<br>';
		  				$leituraAnterior = $leitura;

		  				if ($consumo == 0) $alerta = false;
		  			}

		  			if($alerta){
		  				//echo 'Consumo dia: ', $consumoDia;
		  				//echo ' - Media: ', $consumoMedio;
		  				echo ' - ID: ', $unidadeMesAnterior->idecoflow;
			  			echo ' - ALERTA';
			  			//vetor com idEcoflow dos alerta de cosumo excessivo
			  			$idecoflow .= $unidadeMesAnterior->idecoflow."<br>";
			  			$cont++;
		  			}

		  		}

	  			echo '<br>';

	  		}

  		}

  	}

  	echo "quantidade alerta: ", $cont;
  	
  	if($idecoflow != ""){
  		//envia e-email
			$assunto = "Vazamento grande";
			$menssagem = $headerEmail."
				<h4>Possível vazamento</h4>
				Data: $dataDiaAnterior<br>
				O sistema verificou um possivel vazamento ou um consumo execessivo dos seguintes idecoflow:<br>
				<br> 
				$idecoflow
				<br>
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail(EMAIL, $assunto, $menssagem, $headers);
  	}

 ?>