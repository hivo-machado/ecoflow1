<?php
	
	//Retorna string com consumo diario de um mês
	function consumoDia($con, $id, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = null; //String para retonar dias e consumo
		$semLeitura = 0; // contador de dias sem leitura
		$bandeira = false; // flag para começar a contar quanto existir a 1º leitura

		//leitura do ultimo dia do mes anterior
		if($mes == 1){
			$numDiaMesAnt = cal_days_in_month(CAL_GREGORIAN, 12, $ano - 1);
			$auxAno = $ano - 1;

			// Converte para data
			$data = date("Y-m-d",strtotime(str_replace('/','-', $auxAno.'-'.'12'.'-'.$numDiaMesAnt)));
		}else{
			$numDiaMesAnt = cal_days_in_month(CAL_GREGORIAN, $mes - 1, $ano);
			$auxMes= $mes - 1;

			// Converte para data
			$data = date("Y-m-d",strtotime(str_replace('/','-', $ano.'-'.$auxMes.'-'.$numDiaMesAnt)));		    
		}

		// Converte a data para modelo do banco de dados
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');

		//1º leitura do ultimo dia do mes anterior
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
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
			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
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
					//loop para preenchimento dos dias sem leitura
					for($i = $dia - $semLeitura; $i <= $dia; $i++){
						$consumo[$i] = $auxConsumo;
					}
					$semLeitura = 0;
					$leituraAnt = $unidade->leitura;
				}
				$bandeira = true;
			}else{
				$consumo[$dia] = 0;
				if($bandeira)$semLeitura++;
			}

		}

		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			if($consumo[$i] == 0){
				$consumo[$i] = 0;
			}
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
		$resUnidInicio = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
		$unidadeInicio = mysqli_fetch_object($resUnidInicio);		

		//Se for dezembro passa para janeiro do proximo ano
		$auxMes = $mes +  1;
		$auxDia = $dia;
		if($auxMes == 13){
			$auxMes = 1;
			$ano ++;
		}

		//loop para ultima leitura do mes seguinde
		do{
			//Se for 1º dia do mes passa para mes anterior
			if($auxDia < 1){
				$auxDia = 31;
				if($auxMes == 1){
					$auxMes = 12;
					$ano --;
				}else{
					$auxMes--;
				}
			}

			// Converte a data para modelo do banco de dados 
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$auxMes.'-'.$auxDia)));
			$date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d');

			//1º leitura do dia
			$resUnidFim = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$auxDia--;
			$unidadeFim = mysqli_fetch_object($resUnidFim);
		}while( (!isset($unidadeFim) )&&($auxMes <= $mes) );

		//Verifica se data inicial existe
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
		
		for($mes = 1; $mes <= 12; $mes++){
			// Converte a data para modelo do banco de dados 
			$data = date("Y-m",strtotime(str_replace('/','-',$ano.'-'.$mes)));
			$date = date_create($data);
			$tempo =  date_format($date, 'Y-m');

			//1º leitura do mes
			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$unidadePrimeiro = mysqli_fetch_object($result);

			//Ultima leitura do mes
			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo DESC LIMIT 1");
			$unidadeUltimo = mysqli_fetch_object($result);
			
			//Verifica se existe uma leitura no mes
			if(isset($unidadePrimeiro)){
				$consumo = $unidadeUltimo->leitura - $unidadePrimeiro->leitura;
			}else{
				$consumo = 0;
			}

			//Concatena os valores de consumo para API de grafico
			$str = $str.'['.$mes.','.$consumo.']';
            if($mes != 12) $str = $str.',';			
		}

		return $str;
	}


	//Função para consumo total do ano
	function consumoTotalAno($con, $id, $ano){

		//Primeira leitura do Ano
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$ano%' ORDER by tempo LIMIT 1");
		$unidadePrimeiro = mysqli_fetch_object($result);

		//Ultima leitura do mes
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$ano%' ORDER by tempo DESC LIMIT 1");
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
	//consumoAno($con, 2222, 2016);
	//echo consumoTotalAno($con, 2222, 2016);

 ?>