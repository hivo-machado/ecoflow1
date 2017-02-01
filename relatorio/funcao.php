<?php

	//Retorna string com consumo diario de um mês
	function consumoMes($con, $id, $ano, $mes, $dia = 1){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$unidadeAnt  = null; //Unidade anterior
		$cont = 1; //contador de dias
		$listaConsumo = null; //inicializando variavel

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');

		//Data de Fim do intervalo
		$dateFim = $dateInicio;
		$dateFim->add(new DateInterval("P1M")); // Soma um mes
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

		//Seleciona as leituras com tempo menor que 02:00:00 de cada dia no invtervalo
		$result = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$id' AND hora < '01:59:59' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' ORDER BY tempo");
		
		//Percorre todos os resultado do SELECT
		while( $unidade = mysqli_fetch_object($result) ){
			//Verifica se existe leitura anterior para calculo
			if($unidadeAnt != null){
				$listaData[$cont] = date('Y-m-d',strtotime($unidadeAnt->tempo)); //lista com datas
				$listaConsumo[$cont] = number_format($unidade->leitura - $unidadeAnt->leitura, 3, '.', ''); //lista de consumo
				if($listaConsumo[$cont] < 0) $listaConsumo[$cont] = 0; //Caso tenha consumo negativo por bug na remota antiga
			
				$dataAnt = strtotime($unidadeAnt->tempo);
				$dateAnt = strtotime('+1 day', $dataAnt);
				$proxDataPre = date('Y-m-d',$dateAnt); //Proxima data prevista

				$data = strtotime($unidade->tempo);
				$proxData = date('Y-m-d',$data);//Proxima data

				if($proxDataPre != $proxData){
					$date1=date_create($proxDataPre);
					$date2=date_create($proxData);
					$diff=date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$consumoAux = $listaConsumo[$cont] / ($dias + 1);
					for($i = 0; $i <= $dias; $i++){
						$listaConsumo[($cont + $i)] = $consumoAux;
						//dia
						if($i != 0){
							$data = strtotime($listaData[($cont + $i - 1)]);
							$date = strtotime('+1 day', $data);
							$listaData[($cont + $i)] = date('Y-m-d',$date);
						}
					}
					$cont = $cont + $dias;
				}

				$cont++; // soma +1 contador de dias
			}

			$unidadeAnt = $unidade;
		}


		if( $listaConsumo != null){
			for($j = $cont; $j <= $numDiasMes; $j++){
				$listaConsumo[$j] = 0;
				$data = strtotime($listaData[($j - 1)]);
				$date = strtotime('+1 day', $data);
				$listaData[$j] = date('Y-m-d',$date);
			}			
		}else{
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
		}

		return $cosumo = array($listaConsumo, $listaData);
	}

	//Retorna string com consumo diario de um mês para grafico
	function consumoMesGrafico($consumo, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = '['; //String para retonar dias e consumo

		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			$str = $str.number_format($consumo[0][$i], 3, '.', '');
		    if($i != $numDiasMes ) $str = $str.',';
		}
		$str = $str.']';
		return $str;
	}

	//Retorna string com os dias do mes
	function qtdDias($consumo, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = '['; //String para retonar dias e consumo
		
		for($i = 1; $i <= $numDiasMes; $i++){
			$str = $str.date('d',strtotime($consumo[1][$i]) );
			if($i != $numDiasMes) $str = $str.',';
		}
		$str = $str.']';
		return $str;
	}

	//include_once('../conexao.php');
	//print_r(consumoMes($con, 2222, 2017, 01, 01) );
	//echo qtdDias(consumoMes($con, 2222, 2016, 12, 05), 2016, 12);
	//echo consumoMesGrafico( consumoMes($con, 2222, 2016, 12, 05), 2016, 12);

	// Função para consumo total do mês
	function consumoTotalMes($con, $id, $ano, $mes, $dia = 1){

		// Converte a data para modelo do banco de dados 
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do mes
		$resUnidInicio = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo >= '$tempo' ORDER by tempo, hora LIMIT 1");
		$unidadeInicio = mysqli_fetch_object($resUnidInicio);		

		//Se for 13 passa para janeiro do proximo ano
		$auxMes = $mes +  1;
		if($auxMes == 13){
			$auxMes = 1;
			$ano ++;
		}

		// Converte a data para modelo do banco de dados 
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$auxMes.'-'.$dia)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do mes seguinte
		$resUnidFim = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo <= '$tempo' ORDER by tempo DESC, hora LIMIT 1");
		$unidadeFim = mysqli_fetch_object($resUnidFim);

		//Verifica se data inicial e final existe
		if( (isset($unidadeInicio) )&&(isset($unidadeFim)) ){
			$LeituraInicio = $unidadeInicio->leitura;
			$leituraFim = $unidadeFim->leitura;
			$consumoDoMes = $leituraFim - $LeituraInicio;
			return  number_format($consumoDoMes, 3, '.', ',').' m³';
		}		
		return 'não disponível';
	}


	//Função para cosumo por mes
	function consumoAno($con, $id, $ano){

		//Data do primeiro dia do mes
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-01')));
		$date = date_create($data);
		$tempoInicio =  date_format($date, 'Y-m-d');

		//Data do ultimo dia do mes
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, 01, $ano);
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-'.$numDiasMes)));
		$date = date_create($data);
		$tempoFim =  date_format($date, 'Y-m-d');

		//Primeira leitura de Janeiro
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo, hora LIMIT 1");
		$unidade = mysqli_fetch_object($result);

		if( isset($unidade)){
			$leituraAnt = $unidade->leitura;
		}else{
			$leituraAnt = 0;
		}
		
		$cont = 1; // contador do mes

		for($mes = 2; $mes <= 13; $mes++){
			$auxMes = $mes;

			//Se for 13 passa para janeiro do proximo ano
			if($auxMes == 13){
				$auxMes = 1;
				$ano ++;
			}

			//Data do primeiro dia do mes
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$auxMes.'-01')));
			$date = date_create($data);
			$tempoInicio =  date_format($date, 'Y-m-d');

			//Data do ultimo dia do mes
			$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $auxMes, $ano);
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$auxMes.'-'.$numDiasMes)));
			$date = date_create($data);
			$tempoFim =  date_format($date, 'Y-m-d');

			//Primeira leitura do mes
			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo, hora LIMIT 1");
			$unidade = mysqli_fetch_object($result);
			
			//Verifica se existe uma leitura no mes
			if( isset($unidade) ){
				//Caso leitura anterior = 0 o consumo = 0
				if($leituraAnt == 0){
					$consumo = 0;
					$leituraAnt = $unidade->leitura;
				}else{
					$consumo = $unidade->leitura - $leituraAnt;
					$leituraAnt = $unidade->leitura;
				}
			}else{// caso não encontre uma leitura procura ultima leitura do mes

				if($auxMes != 1){
					$aux2Mes = $auxMes - 1;
				}else{
					$aux2Mes = 12;
				}

				//Data do primeiro dia do mes
				$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$aux2Mes.'-01')));
				$date = date_create($data);
				$tempoInicio =  date_format($date, 'Y-m-d');

				//Data do ultimo dia do mes
				$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $aux2Mes, $ano);
				$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$aux2Mes.'-'.$numDiasMes)));
				$date = date_create($data);
				$tempoFim =  date_format($date, 'Y-m-d');

				//Procura ultima leitura do mes atual
				$resUltimo = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo DESC, hora DESC LIMIT 1");
				$unidadeUltimo = mysqli_fetch_object($resUltimo);

				//Senão encontrar uma leitura consumo = 0
				if(isset($unidadeUltimo)){
					$consumo = $unidadeUltimo->leitura - $leituraAnt;
					$leituraAnt = 0;
				}else{
					$consumo = 0;
				}
			}

			//Concatena os valores de consumo para API de grafico do google
			$consumos[$cont] = number_format($consumo, 3, '.', '');
			$cont++;	
		}

		return $consumos;
	}

	//Função para cosumo por mes para desenho do grafico
	function consumoAnoGrafico($con, $id, $ano){
		$str = '['; // String para retorno dos resultado

		$consumo = consumoAno($con, $id, $ano);

		//Concatena os valores de consumo para API de grafico do google
		for($i = 1; $i < 13; $i++){
			$str = $str.number_format($consumo[$i], 3, '.', '');
	        if($i != 12) $str = $str.',';
	        else $str = $str.']';
		}

    	return $str;
	}


	//Função para consumo total do ano
	function consumoTotalAno($con, $id, $ano){

		//Primeira leitura do Ano
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo, hora LIMIT 1");
		$unidadePrimeiro = mysqli_fetch_object($result);

		//Ultima leitura do ano
		$ano++;
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo, hora LIMIT 1");
		$unidadeUltimo = mysqli_fetch_object($result);

		//Verifica se existe uma leitura no mes
		if( (isset($unidadePrimeiro))&&(isset($unidadeUltimo)) ){
			//calculo do consumo Total do ano
			$consumo = $unidadeUltimo->leitura - $unidadePrimeiro->leitura;
		}else{
			//Data do primeiro dia do ano seguinte
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-01')));
			$date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d');

			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo <= '$tempo' ORDER by tempo DESC, hora DESC LIMIT 1");
			$unidadeUltimo = mysqli_fetch_object($result);

			if(isset($unidadeUltimo)){
				$consumo = $unidadeUltimo->leitura - $unidadePrimeiro->leitura;
			}else{
				return 'não disponível';
			}
		}

		return number_format($consumo, 3, '.', ',').' m³';
	}

	//Chamada de funções para teste

	//include_once('../conexao.php');
	//print_r(consumoMes($con, 2222, 2017, 01));
	//echo consumoMesGrafico($con, 2222, 2017, 01);
	//print_r( consumoAno($con, 2222, 2017) );
	//echo consumoAnoGrafico($con, 2222, 2017);
	//echo consumoTotalAno($con, 2222, 2016);

 ?>