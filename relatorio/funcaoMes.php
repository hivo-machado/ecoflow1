<?php

	//Retorna string com consumo diario de um mês
	function consumo($con, $id, $ano, $mes, $dia = 1){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		//iniciar variavel
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

		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$id' AND servico = '0' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $unidade = mysqli_fetch_object($result) ){

			//Verifica se existe leitura anterior para calculo
			if($unidadeAnt != null){
				//Caso não exista leitura no começo do intervalo preenche a lista com consumo 0
				if( ($cont == 1)&&($tempoInicio != $unidadeAnt->tempo) ){
					$date1 = date_create($tempoInicio);
					$date2 = date_create(date('Y-m-d',strtotime($unidadeAnt->tempo)));
					$diff = date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$listaData[0] = date('Y-m-d', strtotime('-1 day', strtotime($tempoInicio)));
					for($i = 1; $i <= $dias; $i++){
						$listaConsumo[$i] = 0;
						if($i != 0){
							$data = strtotime($listaData[($i - 1)]);
							$date = strtotime('+1 day', $data);
							$listaData[$i] = date('Y-m-d',$date);
						}
					}
					$cont = $cont + $dias;
				}

				$listaData[$cont] = date('Y-m-d',strtotime($unidadeAnt->tempo)); //lista com datas
				$listaConsumo[$cont] = number_format($unidade->leitura - $unidadeAnt->leitura, 3, '.', ''); //lista de consumo
				if($listaConsumo[$cont] < 0) $listaConsumo[$cont] = 0; //Caso tenha consumo negativo por bug na remota antiga
			
				$dataAnt = strtotime($unidadeAnt->tempo);
				$dateAnt = strtotime('+1 day', $dataAnt);
				$proxDataPre = date('Y-m-d',$dateAnt); //Proxima data prevista

				$data = strtotime($unidade->tempo);
				$proxData = date('Y-m-d',$data);//Proxima data

				if($proxDataPre != $proxData){
					$date1 = date_create($proxDataPre);
					$date2 = date_create($proxData);
					$diff = date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$consumoAux = number_format($listaConsumo[$cont] / ($dias + 1), 3, '.', '');
					for($i = 0; $i <= $dias; $i++){
						$listaConsumo[($cont + $i)] = $consumoAux;
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
		}

		return $cosumo = array($listaConsumo, $listaData);
	}

	//Retorna string com consumo diario de um mês para grafico
	function consumoGrafico($consumo, $ano, $mes){
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

	// Função para consumo total do mês
	function consumoTotal($consumo, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$total = 0; //String para retonar dias e consumo

		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			$total = $total + $consumo[0][$i];
		}
		return $total;
	}

	
 ?>