<?php 
	//Atividade CRON para verificar se não existe consumo excessivo

	//Conexão com banco de dados
	//include_once("/home/ecofl253/public_html/conexao.php");
	//include_once("/home/ecofl253/public_html/corpoEmail.php");
	include('../conexao.php');
	include('../corpoEmail.php');

	// Tempo de execução maxima do programa 10 min.
	ini_set('max_execution_time',600);

	//Razão pelo consumo medio
	define("RAZAO", 3);

	//E-mail
	//define("EMAIL", "vectoramerico@gmail.com, lucineia@vector.eng.br, v1n1c1u5_1@hotmail.com");
	define("EMAIL", "v1n1c1u5_1@hotmail.com");

	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');
	
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

	//echo "Tempo Atual: ", $dataAtual, " Tempo dia anterior: ", $dataDiaAnterior, " Tempo mes anterior: ", $dataMesAnterior, "<br>";

  	//Pesquisa todos usuario do tipo usuario e ativos
  	$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE tipo = 'usuario' AND status = 'ativo' AND id_unidade IS NOT null");

  	//String com idEcoflow dos alertas
  	$idecoflow = "";
  	$cont = 0;

  	/*
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
			$assunto = "Possivel vazamento";
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
  	}*/

  	print_r( consumo($con, 2222, 0, "2017-05-01", "2017-06-30") );

  	//Retorna string com consumo diario de um mês
	function consumo($con, $idecoflow, $servico, $tempoInicio, $tempoFim ){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		//iniciar variavel
		//$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$unidadeAnt  = null; //Unidade anterior
		$cont = 0; //contador de dias
		$listaConsumo = null; //inicializando variavel

		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$idecoflow' AND servico = '$servico' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $unidade = mysqli_fetch_object($result) ){

			//Verifica se existe leitura anterior para calculo
			if($unidadeAnt != null){
				/*
				//Caso não exista leitura no começo do intervalo preenche a lista com consumo 0
				if( ($cont == 0)&&($tempoInicio != $unidadeAnt->tempo) ){
					$date1 = date_create($tempoInicio);
					$date2 = date_create(date('Y-m-d',strtotime($unidadeAnt->tempo)));
					$diff = date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$listaData[0] = date('Y-m-d', strtotime('-1 day', strtotime($tempoInicio)));
					for($i = 0; $i <= $dias; $i++){
						$listaConsumo[$i] = 0;
						if($i != 0){
							$data = strtotime($listaData[($i - 1)]);
							$date = strtotime('+1 day', $data);
							$listaData[$i] = date('Y-m-d',$date);
						}
					}
					$cont = $cont + $dias;
				}*/

				$listaData[$cont] = date('Y-m-d',strtotime($unidadeAnt->tempo)); //adiciona na lista com datas
				$listaConsumo[$cont] = $unidade->leitura - $unidadeAnt->leitura; //adiciona na lista de consumo
				
				//Calcula proxima data baseado na leitura anterior
				$dataAnt = strtotime($unidadeAnt->tempo);
				$dateAnt = strtotime('+1 day', $dataAnt);
				$proxDataPre = date('Y-m-d',$dateAnt); //Proxima data prevista

				//Data da leitura atual
				$data = strtotime($unidade->tempo);
				$proxData = date('Y-m-d',$data);// Data da leitura

				if($proxDataPre != $proxData){
					$date1 = date_create($proxDataPre);
					$date2 = date_create($proxData);
					$diff = date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$consumoAux = number_format($listaConsumo[$cont] / ($dias + 1), 3, '.', '');
					for($i = 0; $i <= $dias; $i++){
						$listaConsumo[($cont + $i)] = $consumoAux; //Adiciona consumo medio no intervalo na lista de consumo
						if($i != 0){
							$data = strtotime($listaData[($cont + $i - 1)]);
							$date = strtotime('+1 day', $data);
							$listaData[($cont + $i)] = date('Y-m-d',$date);//Adiciona data do intervalo na lista com datas
						}
					}
					$cont = $cont + $dias;
				}

				$cont++; // soma +1 contador de dias
			} // Fim do if($unidadeAnt != null)

			$unidadeAnt = $unidade;
		}// Fim do while
		/*
		//Caso não existe mais leitura até fim do intervalo
		if( $listaConsumo != null){
			for($j = $cont; $j <= $numDiasMes; $j++){
				$listaConsumo[$j] = 0;
				$data = strtotime($listaData[($j - 1)]);
				$date = strtotime('+1 day', $data);
				$listaData[$j] = date('Y-m-d',$date);
			}			
		}else{ //caso não exista valor suficiente no SELECT do BD para calcular consumo

			//Iniciando os vetore listaData e listaConsumo
			$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.'01')));
			$dateInicio = date_create($dataInicio);
			$listaData[1] =  date_format($dateInicio, 'Y-m-d');
			$listaConsumo[1] = 0;
			//Preenche a lista toda com consumo 0
			for($j = 2; $j <= $numDiasMes; $j++){
					$listaConsumo[$j] = 0;
					$data = strtotime($listaData[($j - 1)]);
					$date = strtotime('+1 day', $data);
					$listaData[$j] = date('Y-m-d',$date);
			}
		}*/

		//return $cosumo = array($listaConsumo, $listaData);
		return $listaConsumo;
	}//Fim da função

 ?>