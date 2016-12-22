<?php
	
	//Retorna string com consumo diario de um mês
	function consumoDia($con, $id, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = null; //String para retonar dias e consumo
		$semLeitura = 0; // contador de dias sem leitura
		$bandeira = false; // flag para começar a contar quanto existir a 1º leitura

		//1º dia do mes
		$data = date("Y-m-d",strtotime(str_replace('/','-', $ano.'-'.$mes.'-'.'01')));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do ultimo dia do mes anterior
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo < '$tempo' ORDER by tempo DESC, hora LIMIT 1");
		$unidadeAnt = mysqli_fetch_object($result);

		//Caso não exista 1º leitura do ultimo dia do mes anterior assumi como 0
		if(isset($unidadeAnt)){
			$leituraAnt = $unidadeAnt->leitura;
		}else{
			$leituraAnt = 0;	
		}

		// Loop para calculo consumo do dias do mes
		for ($dia = 1; $dia <= $numDiasMes; $dia++){
			
			// Converte a data para modelo do banco de dados 
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
			$date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d');

			//1º leitura do dia
			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo = '$tempo' ORDER by hora LIMIT 1");
			$unidade = mysqli_fetch_object($result);
			
			//Caso não exista leitura
			if(isset($unidade)){
				if($semLeitura == 0){
					//Caso 1º do ultimo dia do mes anterior não exista consumo 0
					if($leituraAnt != 0){
						$unidade->leitura;
						$consumo[$dia] = $unidade->leitura - $leituraAnt;
						$leituraAnt = $unidade->leitura;
					}else{
						$consumo[$dia] = 0;
						$leituraAnt = $unidade->leitura;
					}
				}else{
					$auxConsumo = ($unidade->leitura - $leituraAnt) / ($semLeitura + 1);
					//loop para preenchimento do intervalo de dias sem leitura
					for($i = $dia - $semLeitura; $i <= $dia; $i++){
						$consumo[$i] = $auxConsumo;
					}
					$semLeitura = 0;
					$leituraAnt = $unidade->leitura;
				}
				$bandeira = true;
			}else{
				$consumo[$dia] = 0;

				// verifica se houve um consumo antes de começar contar
				if($bandeira)$semLeitura++;
			}

		}

		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			$str = $str.'['.$i.','.$consumo[$i].']';
		    if($i != $numDiasMes) $str = $str.',';
		}

		return $str;		
	}


	// Função para consumo total do mês
	function consumoTotalMes($con, $id, $ano, $mes, $dia = 1){

		// Converte a data para modelo do banco de dados 
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do mes
		$resUnidInicio = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo >= '$tempo' ORDER by tempo, hora LIMIT 1");
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
			return  $consumoDoMes;
		}		
		return 'dia não disponível';
	}


	//Função para cosumo por mes
	function consumoAno($con, $id, $ano){
		$str = null; // String para retorno dos resultado

		//Data do primeiro dia do mes
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-01-01')));
		$date = date_create($data);
		$tempoInicio =  date_format($date, 'Y-m-d');

		//Ultimo dia do mes
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

			//Ultimo dia do mes
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
			}else{// caso não encontre uma leitura

				//Data do primeiro dia do mes
				$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$auxMes.'-01')));
				$date = date_create($data);
				$tempo =  date_format($date, 'Y-m-d');

				//Procura ultima leitura mais proxima com menor dia
				$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo <= '$tempo' ORDER by tempo DESC, hora LIMIT 1");
				$unidade = mysqli_fetch_object($result);

				//Senão encontrar uma leitura consumo = 0
				if(isset($unidade)){
					$consumo = $unidade->leitura - $leituraAnt;
				}else{
					$consumo = 0;
				}
			}

			//Concatena os valores de consumo para API de grafico do google
			$str = $str.'['.($mes-1).','.$consumo.']';
            if($mes != 13) $str = $str.',';			
		}

		return $str;
	}


	//Função para consumo total do ano
	function consumoTotalAno($con, $id, $ano){

		//Primeira leitura do Ano
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo, hora LIMIT 1");
		$unidadePrimeiro = mysqli_fetch_object($result);

		//Ultima leitura do mes
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo DESC, hora DESC LIMIT 1");
		$unidadeUltimo = mysqli_fetch_object($result);

		//Verifica se existe uma leitura no mes
		if(isset($unidadePrimeiro)){
			//calculo do consumo Total do ano
			$consumo = $unidadeUltimo->leitura - $unidadePrimeiro->leitura;
		}else{
			$consumo = 'não disponível';
		}

		return $consumo;
	}

	//include_once('../conexao.php');
	//echo consumoDia($con, 2222, 2016, 11);
	//echo consumoAno($con, 2222, 2016);
	//echo consumoTotalAno($con, 2222, 2016);

 ?>