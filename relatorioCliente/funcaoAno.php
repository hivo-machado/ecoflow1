<?php 

	//Função para cosumo por mes
	function consumo($con, $nome, $servico, $ano){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Data do primeiro dia do mes
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-01')));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');

		//Data do ultimo dia do mes
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, 01, $ano);
		$dataFim = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-'.$numDiasMes)));
		$dateFim = date_create($dataFim);
		$tempoFim =  date_format($dateFim, 'Y-m-d');

		//Seleciona usuario pelo nome para procurar ID
		$result = mysqli_query($con, "SELECT * FROM unidade WHERE nome = '$nome' LIMIT 1");
		$usuario = mysqli_fetch_object($result);

		//Primeira leitura do Ano (Janeiro)
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$usuario->idecoflow' and servico = '$servico' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo, hora LIMIT 1");
		$unidade = mysqli_fetch_object($result);

		//Verifica se existe uma leitura caso não exista consumo é 0
		if( isset($unidade)){
			$leituraAnt = $unidade->leitura;
		}else{
			$leituraAnt = 0;
		}

		//loop para os proximo 12 meses(até o mes de janeiro do proximo ano)
		for ($i=1; $i <= 12; $i++) {

			//Primeiro dia do proximo mes
			$dateInicio->add(new DateInterval("P1M")); // Soma um mes
			$tempoInicio =  date_format($dateInicio, 'Y-m-d'); // Formato de data para BD

			//Ultimo dia do proximo mes
			$dateFim->add(new DateInterval("P1M")); // Soma um mes
			$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$usuario->idecoflow' and servico = '$servico' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo, hora LIMIT 1");
			$unidade = mysqli_fetch_object($result);

			//Verifica se existe uma leitura
			if( isset($unidade) ){
				//Caso leitura anterior = 0 o consumo = 0
				if($leituraAnt == 0){
					$consumo = 0;
					$leituraAnt = $unidade->leitura;
				}else{
					$consumo = $unidade->leitura - $leituraAnt;
					if($consumo < 0 ) $consumo = 0; //Consumo negativo será igual a zero
					$leituraAnt = $unidade->leitura;
				}
			}else{// caso não encontre uma leitura procura ultima leitura do mes

				//Primeiro dia do mes anterior
				$dateInicio->sub(new DateInterval("P1M")); // Subtrai um mes
				$tempoInicio =  date_format($dateInicio, 'Y-m-d'); // Formato de data para BD

				//Ultimo dia do mes anterior
				$dateFim->sub(new DateInterval("P1M")); // subtrai um mes
				$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

				//Procura ultima leitura do mes aanterior
				$resUltimo = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$usuario->idecoflow' and servico = '$servico' and tempo BETWEEN '$tempoInicio' and '$tempoFim' ORDER by tempo DESC, hora ASC LIMIT 1");
				$unidadeUltimo = mysqli_fetch_object($resUltimo);

				//Senão encontrar uma leitura consumo = 0
				if(isset($unidadeUltimo)){
					$consumo = $unidadeUltimo->leitura - $leituraAnt;
					if($consumo < 0 ) $consumo = 0; //Consumo negativo será igual a zero
					$leituraAnt = 0;
				}else{
					$consumo = 0;
				}

				//Primeiro dia do proximo mes (retorna a contagem do loop)
				$dateInicio->add(new DateInterval("P1M")); // Soma um mes
				$tempoInicio =  date_format($dateInicio, 'Y-m-d'); // Formato de data para BD

				//Ultimo dia do proximo mes (retorna a contagem do loop)
				$dateFim->add(new DateInterval("P1M")); // Soma um mes
				$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD
			}

			//Armazena o resultado no vetor
			$consumos[$i] = number_format($consumo, 3, '.', '');
		}

		return $consumos;
	}

	//Função para cosumo por mes para desenho do grafico
	function consumoGrafico($con, $consumo, $ano){
		$str = '['; // String para retorno dos resultado

		//Concatena os valores de consumo para API de grafico do google
		for($i = 1; $i < 13; $i++){
			$str .= number_format($consumo[$i], 3, '.', '');
	        if($i != 12) $str .= ',';
	        else $str .= ']';
		}

    	return $str;
	}

	//Função para consumo total do ano
	function consumoTotal($consumo){
		$total = 0; //String para retonar dias e consumo

		//Somo todos os valores
		for($i = 1; $i < 13; $i++){
			$total += $consumo[$i];
		}
    	return $total;
	}

 ?>