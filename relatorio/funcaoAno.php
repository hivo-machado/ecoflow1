<?php 

//Função para cosumo por mes
	function consumo($con, $id, $ano){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		
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
	function consumoGrafico($con, $consumo, $ano){
		$str = '['; // String para retorno dos resultado

		//Concatena os valores de consumo para API de grafico do google
		for($i = 1; $i < 13; $i++){
			$str = $str.number_format($consumo[$i], 3, '.', '');
	        if($i != 12) $str = $str.',';
	        else $str = $str.']';
		}

    	return $str;
	}

	//Função para consumo total do ano
	function consumoTotal($consumo){
		$total = 0; //String para retonar dias e consumo

		//Concatena os valores de consumo para API de grafico do google
		for($i = 1; $i < 13; $i++){
			$total = $total + $consumo[$i];
		}
    	return $total;
	}


 ?>