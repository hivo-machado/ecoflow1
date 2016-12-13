<?php	
	//Retorna consumo diario de um mês

	function consumoDia($con, $mes, $ano, $id){

		$numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
		if($mes == 1){
			$numDiaMesAnt = cal_days_in_month(CAL_GREGORIAN, 12, $ano - 1);
			$tempo = '$ano-1'.'-'.'12'.'-'.$numDiaMesAnt;
		}else{
			$numDiaMesAnt = cal_days_in_month(CAL_GREGORIAN, $mes - 1, $ano);
			$tempo = $ano.'-'.'$mes-1'.'-'.$numDiaMesAnt;
		}

		//Leitura do ultimo dia do mes anterior
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
		$unidadeAnt = mysqli_fetch_object($result);
		//Caso não exista leitura anterior
		if(isset($unidadeAnt)){
			$leituraAnt = $unidadeAnt->leitura;
		}else{
			$leituraAnt = 0;					
		}

		$str = null;
		// Loop para calculo consumo do dia
		for ($dia = 1; $dia <= $numDiaMes; $dia++){			
			
			$tempo = $ano.'-'.$mes.'-'.$dia;

			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$unidade = mysqli_fetch_object($result);
			//Caso não exista leitura o consumo 0
			if(isset($unidade)){
				if($leituraAnt != 0){
					$consumo = $unidade->leitura - $leituraAnt;
					$leituraAnt = $unidade->leitura;
				}else{
					$consumo = 0;
					$leituraAnt = $unidade->leitura;
				} 
			}else{
				$consumo = 0;
				$leituraAnt = 0;
			}

			$str = $str.'['.$dia.','.$consumo.']';
            if($dia != 31) $str = $str.',';
		}
		return $str;		
	}

 ?>