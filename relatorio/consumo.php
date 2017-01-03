<?php
	//Retorna string com os dias do mes
	function qtdDias($ano, $mes){
		$str = '[';
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		for($i = 1; $i <= $numDiasMes; $i++){
			$str = $str.$i;
			if($i != $numDiasMes) $str = $str.',';
			else $str = $str.']';
		}
		return $str;
	}	


	//Retorna string com consumo diario de um mês
	function consumoMes($con, $id, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = '['; //String para retonar dias e consumo
		$semLeitura = 0; // contador de dias sem leitura
		$bandeira = false; // flag para começar a contar quanto existir a 1º leitura
		$leituraAnt = 0;

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
					//Verifica se existe leitura do dia anterior
					if($leituraAnt != 0){
						$unidade->leitura;
						$auxDia = $dia - 1;
						$consumo[$auxDia] = $unidade->leitura - $leituraAnt;
						$leituraAnt = $unidade->leitura;
					}else{
						$auxDia = $dia - 1;
						$consumo[$auxDia] = 0;
						$leituraAnt = $unidade->leitura;
					}
				}else{
					$auxConsumo = ($unidade->leitura - $leituraAnt) / ($semLeitura + 1);
					$auxDia = $dia - 1;
					//loop para preenchimento do intervalo de Dias sem leitura
					for($i = $auxDia - $semLeitura; $i < $dia; $i++){
						$consumo[$i] = $auxConsumo;
					}
					$semLeitura = 0;
					$leituraAnt = $unidade->leitura;
				}
				$bandeira = true;
			}else{
				$auxDia = $dia - 1;
				$consumo[$auxDia] = 0;

				// verifica se houve um consumo antes de começar contar
				if($bandeira)$semLeitura++;
			}

		}
		
		//mes seguinte
		$mes++;
		//Caso o mes atual seja 12 pula para o proximo ano
		if($mes == 13){
			$mes = 1;
			$ano++;
		}

		// Converte a data para modelo do banco de dados 
		$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.'01')));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do mes seguinte
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo = '$tempo' ORDER by hora LIMIT 1");
		$unidade = mysqli_fetch_object($result);

		//verifica se existe 1º leitura do mes seguinte
		if(isset($unidade)){
			$consumo[$numDiasMes] = $unidade->leitura - $leituraAnt;
		}else{
			$consumo[$numDiasMes] = 0;
		}
		
		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			$str = $str.$consumo[$i];
		    if($i != $numDiasMes) $str = $str.',';
		    else $str = $str.']';
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
			return  number_format($consumoDoMes, 3, ',', '.').' m³';
		}		
		return 'dia não disponível';
	}


	//Função para cosumo por mes
	function consumoAno($con, $id, $ano){
		$str = '['; // String para retorno dos resultado

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

				//Ultimo dia do mes
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
			$str = $str.$consumo;
            if($mes != 13) $str = $str.',';
            else $str = $str.']';			
		}

		return $str;
	}


	//Função para consumo total do ano
	function consumoTotalAno($con, $id, $ano){

		//Primeira leitura do Ano
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo, hora LIMIT 1");
		$unidadePrimeiro = mysqli_fetch_object($result);

		//Ultima leitura do mes
		$ano++;
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = '0' and tempo like '$ano%' ORDER by tempo, hora LIMIT 1");
		$unidadeUltimo = mysqli_fetch_object($result);

		//Verifica se existe uma leitura no mes
		if( (isset($unidadePrimeiro))&&(isset($unidadeUltimo)) ){
			//calculo do consumo Total do ano
			$consumo = $unidadeUltimo->leitura - $unidadePrimeiro->leitura;
		}else{
			//Data do primeiro dia do ano
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

		return number_format($consumo, 3, ',', '.').' m³';
	}

	//include_once('../conexao.php');
	//echo consumoDia($con, 2222, 2016, 12);
	//echo consumoAno($con, 2222, 2017);
	//echo consumoTotalAno($con, 2222, 2016);

 ?>